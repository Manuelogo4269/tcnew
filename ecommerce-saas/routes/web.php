<?php

use App\Http\Controllers\CentralAuthController;
use App\Http\Controllers\CentralPortalController;
use Illuminate\Support\Facades\Route;

$centralDomains = (array) config('tenancy.central_domains', [
    'localhost',
    '127.0.0.1',
    '192.168.0.128',
    '192.168.0.128.nip.io',
    '127.0.0.1.nip.io',
    'atelier-zacatecas.onrender.com',
]);

if (!function_exists('findTenantBySlugOrDomain')) {
    function findTenantBySlugOrDomain(string $tenantId): ?\App\Models\Tenant
    {
        $tenant = \App\Models\Tenant::where('id', $tenantId)
            ->orWhereRaw('LOWER(id) = ?', [strtolower($tenantId)])
            ->orWhereHas('domains', fn ($q) => $q->where('domain', $tenantId)->orWhere('domain', strtolower($tenantId)))
            ->first();

        if (!$tenant) {
            $cleanId = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $tenantId));
            if ($cleanId !== '') {
                $tenant = \App\Models\Tenant::all()->first(function ($t) use ($cleanId) {
                    return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $t->id)) === $cleanId;
                });
            }
        }

        return $tenant;
    }
}

foreach ($centralDomains as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', [CentralPortalController::class, 'index'])->name('central.home');
        Route::get('/planes', [CentralPortalController::class, 'showPlans'])->name('central.plans');
        Route::get('/pwa', function () {
            return response()->file(public_path('pwa.html'));
        })->name('central.pwa');
        Route::get('/app', function () {
            return response()->file(public_path('pwa.html'));
        })->name('central.app');
        Route::post('/rentar-tienda', [CentralPortalController::class, 'registerTenant'])->name('central.rent.tenant');
        Route::get('/api/global-search', [CentralPortalController::class, 'apiSearch'])->name('central.api.search');
        Route::get('/api/reviews', [CentralPortalController::class, 'getReviews'])->name('central.api.reviews.index');
        Route::post('/api/reviews', [CentralPortalController::class, 'storeReview'])->name('central.api.reviews.store');
        Route::get('/api/walking-route', [CentralPortalController::class, 'getWalkingRoute'])->name('central.api.walking_route');
        Route::get('/api/system-diag', function () {
            $logFile = storage_path('logs/laravel.log');
            $logContent = file_exists($logFile) ? file_get_contents($logFile) : 'No log file found.';
            $lastLog = substr($logContent, -25000);

            $writeTestPublic = false;
            $writeTestError = null;
            try {
                \Illuminate\Support\Facades\Storage::disk('public')->put('products/test_diag.txt', 'test');
                $writeTestPublic = \Illuminate\Support\Facades\Storage::disk('public')->exists('products/test_diag.txt');
            } catch (\Throwable $e) {
                $writeTestError = $e->getMessage();
            }

            return response()->json([
                'db_driver' => \Illuminate\Support\Facades\DB::connection()->getDriverName(),
                'db_database' => \Illuminate\Support\Facades\DB::connection()->getDatabaseName(),
                'template_tenant_connection' => config('tenancy.database.template_tenant_connection'),
                'php_upload_max_filesize' => ini_get('upload_max_filesize'),
                'php_post_max_size' => ini_get('post_max_size'),
                'php_memory_limit' => ini_get('memory_limit'),
                'write_test_public' => $writeTestPublic,
                'write_test_error' => $writeTestError,
                'last_log' => $lastLog,
            ]);
        });

        // Direct Mobile / LAN Storefront Route (No custom DNS required on mobile devices)
        Route::get('/tienda/{tenant}', [\App\Http\Controllers\StorefrontController::class, 'show'])->name('central.tenant.store');

        // Direct Company Standalone Page (e.g. /conceptos7, /acropolis) without entering the central app
        Route::get('/{tenant}', [\App\Http\Controllers\StorefrontController::class, 'show'])
            ->where('tenant', '^(?!planes|rentar-tienda|login|register|logout|manifest\.json|sw\.js|offline\.html|tenant-admin|admin|api|tienda|auth|storage|livewire|telescope).*$')
            ->name('central.tenant.direct');

        // Universal Path-Based Store Management Route (No DNS setup required)
        Route::get('/tienda/{tenant}/admin', function (string $tenantId) {
            $tenant = findTenantBySlugOrDomain($tenantId);
            if (!$tenant) {
                abort(404, 'Tienda no encontrada.');
            }

            tenancy()->initialize($tenant);
            session(['tenant_admin_tenant_id' => $tenant->id]);
            cookie()->queue(cookie('tenant_admin_tenant_id', $tenant->id, 60 * 24 * 30));

            $adminUser = \App\Models\TenantUser::whereNull('customer_account_id')->first();
            if ($adminUser) {
                auth()->guard('tenant')->login($adminUser, true);
            }

            return redirect("/tenant-admin?tenant={$tenant->id}");
        })->name('central.tenant.admin');

        Route::post('/api/tienda/{tenant}/checkout', [\App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('central.tenant.checkout');

        // Services, Staff, Appointments & Memberships
        Route::get('/api/tienda/{tenant}/services', [\App\Http\Controllers\AppointmentController::class, 'services'])->name('central.tenant.services');
        Route::get('/api/tienda/{tenant}/staff', [\App\Http\Controllers\AppointmentController::class, 'staff'])->name('central.tenant.staff');
        Route::get('/api/tienda/{tenant}/appointments/available-slots', [\App\Http\Controllers\AppointmentController::class, 'availableSlots'])->name('central.tenant.appointments.slots');
        Route::post('/api/tienda/{tenant}/appointments', [\App\Http\Controllers\AppointmentController::class, 'book'])->name('central.tenant.appointments.book');
        Route::get('/api/tienda/{tenant}/appointments/my-appointments', [\App\Http\Controllers\AppointmentController::class, 'myAppointments'])->name('central.tenant.appointments.my');
        Route::get('/api/tienda/{tenant}/memberships/plans', [\App\Http\Controllers\AppointmentController::class, 'membershipPlans'])->name('central.tenant.memberships.plans');
        Route::get('/api/tienda/{tenant}/memberships/my-card', [\App\Http\Controllers\AppointmentController::class, 'myMembership'])->name('central.tenant.memberships.card');
        Route::post('/api/tienda/{tenant}/push/subscribe', [\App\Http\Controllers\AppointmentController::class, 'subscribePush'])->name('central.tenant.push.subscribe');
        Route::post('/api/tienda/{tenant}/push/send-test', [\App\Http\Controllers\AppointmentController::class, 'sendTestPush'])->name('central.tenant.push.test');

        Route::post('/api/tienda/{tenant}/layout', function (string $tenantId, \Illuminate\Http\Request $request) {
            $tenant = findTenantBySlugOrDomain($tenantId);
            if (!$tenant) {
                return response()->json(['success' => false, 'message' => 'Tienda no encontrada.'], 404);
            }

            $validated = $request->validate([
                'layout_blocks' => 'required|array',
                'layout_blocks.*.type' => 'required|string',
                'layout_blocks.*.is_visible' => 'nullable|boolean',
            ]);

            $tenant->run(function () use ($validated) {
                $settings = \App\Models\StoreSetting::first();
                if ($settings) {
                    $settings->layout_blocks = $validated['layout_blocks'];
                    $settings->save();
                }
            });

            return response()->json([
                'success' => true,
                'message' => '¡Diseño y orden de bloques actualizado con éxito!',
            ]);
        })->name('central.tenant.layout.update');

        Route::get('/login', [CentralAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [CentralAuthController::class, 'login'])->name('login.submit');
        Route::post('/register', [CentralAuthController::class, 'register'])->name('register.submit');

        // Google OAuth Routes (Laravel Socialite)
        Route::get('/auth/google', [CentralAuthController::class, 'redirectToGoogle'])->name('auth.google');
        Route::get('/auth/google/callback', [CentralAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
        Route::post('/auth/google/token', [CentralAuthController::class, 'handleGoogleToken'])->name('auth.google.token');

        // Facebook OAuth Routes (Laravel Socialite)
        Route::get('/auth/facebook', [CentralAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
        Route::get('/auth/facebook/callback', [CentralAuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

        // Social Authentication Direct Handler
        Route::post('/auth/social/login', [CentralAuthController::class, 'socialLogin'])->name('auth.social.login');

        Route::match(['get', 'post'], '/logout', [CentralAuthController::class, 'logout'])->name('logout');

        // PWA Routes for Central
        Route::get('/manifest.json', function () {
            return response(file_get_contents(public_path('manifest.json')), 200, [
                'Content-Type' => 'application/manifest+json',
                'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        })->name('central.pwa.manifest');

        Route::get('/sw.js', function () {
            return response(file_get_contents(public_path('sw.js')), 200, [
                'Content-Type' => 'application/javascript',
                'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'Service-Worker-Allowed' => '/',
            ]);
        })->name('central.pwa.sw');
    });
}

// Global fallback for PWA manifest & sw.js when accessed without domain match
Route::get('/manifest.json', function () {
    return response(file_get_contents(public_path('manifest.json')), 200, [
        'Content-Type' => 'application/manifest+json',
        'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
});

Route::get('/sw.js', function () {
    return response(file_get_contents(public_path('sw.js')), 200, [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
        'Service-Worker-Allowed' => '/',
    ]);
});

Route::get('/offline.html', function () {
    return response(file_get_contents(public_path('offline.html')), 200, [
        'Content-Type' => 'text/html; charset=UTF-8',
        'Cache-Control' => 'no-cache',
    ]);
});

Route::post('/api/tienda/{tenant}/checkout', [\App\Http\Controllers\CheckoutController::class, 'processCheckout']);

Route::post('/api/tienda/{tenant}/layout', function (string $tenantId, \Illuminate\Http\Request $request) {
    $tenant = findTenantBySlugOrDomain($tenantId);
    if (!$tenant) {
        return response()->json(['success' => false, 'message' => 'Tienda no encontrada.'], 404);
    }

    $validated = $request->validate([
        'layout_blocks' => 'required|array',
        'layout_blocks.*.type' => 'required|string',
        'layout_blocks.*.is_visible' => 'nullable|boolean',
    ]);

    $tenant->run(function () use ($validated) {
        $settings = \App\Models\StoreSetting::first();
        if ($settings) {
            $settings->layout_blocks = $validated['layout_blocks'];
            $settings->save();
        }
    });

    return response()->json([
        'success' => true,
        'message' => '¡Diseño y orden de bloques actualizado con éxito!',
    ]);
});

Route::get('/tienda/{tenant}/admin', function (string $tenantId) {
    $tenant = findTenantBySlugOrDomain($tenantId);
    if (!$tenant) {
        abort(404, 'Tienda no encontrada.');
    }

    tenancy()->initialize($tenant);
    session(['tenant_admin_tenant_id' => $tenant->id]);
    cookie()->queue(cookie('tenant_admin_tenant_id', $tenant->id, 60 * 24 * 30));

    $adminUser = \App\Models\TenantUser::whereNull('customer_account_id')->first();
    if ($adminUser) {
        auth()->guard('tenant')->login($adminUser, true);
    }

    return redirect("/tenant-admin?tenant={$tenant->id}");
});

Route::get('/tienda/{tenant}', [\App\Http\Controllers\StorefrontController::class, 'show']);



