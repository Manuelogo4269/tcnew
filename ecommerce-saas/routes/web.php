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
        Route::get('/tienda/{tenant}', function (string $tenantId) {
            $tenant = findTenantBySlugOrDomain($tenantId);
            if (!$tenant) {
                abort(404, 'Tienda no encontrada.');
            }

            tenancy()->initialize($tenant);

            $user = \Illuminate\Support\Facades\Auth::guard('web')->user();
            $hasFacebookKeys = !empty(config('services.facebook.client_id')) && !empty(config('services.facebook.client_secret'));

            $settings = \App\Models\StoreSetting::first();
            $storeName = $settings?->store_name ?? str($tenant->id)->replace(['-', '_'], ' ')->title()->toString();
            $categories = \App\Models\Category::withCount('products')->get();
            $products = \App\Models\Product::where('is_active', true)->with('category')->latest()->get();
            $featuredProducts = $products->take(8);

            $cachedStores = \Illuminate\Support\Facades\Cache::remember('platform_official_stores_list', 120, function () {
                return tenancy()->central(function () {
                    return \App\Models\Tenant::with('domains')->get()->map(function ($t) {
                        $sName = null;
                        try {
                            $sName = $t->run(fn () => \App\Models\StoreSetting::value('store_name'));
                        } catch (\Throwable $e) {}

                        return [
                            'id' => (string) $t->id,
                            'name' => $sName ?: str($t->id)->replace(['-', '_'], ' ')->title()->toString(),
                            'url' => url("/tienda/{$t->id}"),
                        ];
                    })->toArray();
                });
            });

            $officialStores = array_map(function ($store) use ($tenant) {
                $store['is_current'] = strtolower((string)$store['id']) === strtolower($tenant->id);
                return $store;
            }, (array) $cachedStores);

            $layoutBlocks = $settings ? $settings->getEffectiveLayoutBlocks() : \App\Models\StoreSetting::defaultLayoutBlocks();

            $confirmedOrder = null;
            $paymentResult = request('payment_result');
            $stripeSessionId = request('session_id');
            $folio = request('folio');

            if ($paymentResult === 'stripe_success' && $stripeSessionId && $folio) {
                $order = \App\Models\Order::where('folio', $folio)
                    ->orWhere('stripe_session_id', $stripeSessionId)
                    ->first();

                if ($order) {
                    $secretKey = $settings?->stripe_secret_key ?: config('services.stripe.secret');
                    if ($secretKey) {
                        try {
                            $sessionCheck = \Illuminate\Support\Facades\Http::withToken($secretKey)
                                ->get("https://api.stripe.com/v1/checkout/sessions/{$stripeSessionId}");
                            if ($sessionCheck->successful() && $sessionCheck->json('payment_status') === 'paid') {
                                $order->update([
                                    'payment_status' => 'paid',
                                    'status' => 'confirmed',
                                    'stripe_payment_intent_id' => $sessionCheck->json('payment_intent'),
                                ]);
                            }
                        } catch (\Throwable $e) {}
                    } else {
                        $order->update([
                            'payment_status' => 'paid',
                            'status' => 'confirmed',
                        ]);
                    }
                    $confirmedOrder = $order->load('items');
                }
            }

            return view('tenant.store', compact('storeName', 'tenantId', 'settings', 'categories', 'products', 'featuredProducts', 'officialStores', 'user', 'hasFacebookKeys', 'layoutBlocks', 'confirmedOrder', 'paymentResult'));
        })->name('central.tenant.store');

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

Route::get('/tienda/{tenant}', function (string $tenantId) {
    $tenant = findTenantBySlugOrDomain($tenantId);
    if (!$tenant) {
        abort(404, 'Tienda no encontrada.');
    }

    tenancy()->initialize($tenant);

    $user = \Illuminate\Support\Facades\Auth::guard('web')->user();
    $hasFacebookKeys = !empty(config('services.facebook.client_id')) && !empty(config('services.facebook.client_secret'));

    $settings = \App\Models\StoreSetting::first();
    $storeName = $settings?->store_name ?? str($tenant->id)->replace(['-', '_'], ' ')->title()->toString();
    $categories = \App\Models\Category::withCount('products')->get();
    $products = \App\Models\Product::where('is_active', true)->with('category')->latest()->get();
    $featuredProducts = $products->take(8);

    $cachedStores = \Illuminate\Support\Facades\Cache::remember('platform_official_stores_list', 120, function () {
        return tenancy()->central(function () {
            return \App\Models\Tenant::with('domains')->get()->map(function ($t) {
                $sName = null;
                try {
                    $sName = $t->run(fn () => \App\Models\StoreSetting::value('store_name'));
                } catch (\Throwable $e) {}

                return [
                    'id' => (string) $t->id,
                    'name' => $sName ?: str($t->id)->replace(['-', '_'], ' ')->title()->toString(),
                    'url' => url("/tienda/{$t->id}"),
                ];
            })->toArray();
        });
    });

    $officialStores = array_map(function ($store) use ($tenant) {
        $store['is_current'] = strtolower((string)$store['id']) === strtolower($tenant->id);
        return $store;
    }, (array) $cachedStores);

    $layoutBlocks = $settings ? $settings->getEffectiveLayoutBlocks() : \App\Models\StoreSetting::defaultLayoutBlocks();

    $confirmedOrder = null;
    $paymentResult = request('payment_result');
    $stripeSessionId = request('session_id');
    $folio = request('folio');

    if ($paymentResult === 'stripe_success' && $stripeSessionId && $folio) {
        $order = \App\Models\Order::where('folio', $folio)
            ->orWhere('stripe_session_id', $stripeSessionId)
            ->first();

        if ($order) {
            $secretKey = $settings?->stripe_secret_key ?: config('services.stripe.secret');
            if ($secretKey) {
                try {
                    $sessionCheck = \Illuminate\Support\Facades\Http::withToken($secretKey)
                        ->get("https://api.stripe.com/v1/checkout/sessions/{$stripeSessionId}");
                    if ($sessionCheck->successful() && $sessionCheck->json('payment_status') === 'paid') {
                        $order->update([
                            'payment_status' => 'paid',
                            'status' => 'confirmed',
                            'stripe_payment_intent_id' => $sessionCheck->json('payment_intent'),
                        ]);
                    }
                } catch (\Throwable $e) {}
            } else {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                ]);
            }
            $confirmedOrder = $order->load('items');
        }
    }

    return view('tenant.store', compact('storeName', 'tenantId', 'settings', 'categories', 'products', 'featuredProducts', 'officialStores', 'user', 'hasFacebookKeys', 'layoutBlocks', 'confirmedOrder', 'paymentResult'));
});


