<?php

use App\Http\Controllers\CentralAuthController;
use App\Http\Controllers\CentralPortalController;
use Illuminate\Support\Facades\Route;

$reqHost = isset($_SERVER['HTTP_HOST']) ? explode(':', $_SERVER['HTTP_HOST'])[0] : 'localhost';
$centralDomains = array_values(array_unique(array_filter([
    'localhost',
    '127.0.0.1',
    '192.168.0.128',
    '192.168.0.128.nip.io',
    $reqHost,
])));

foreach ($centralDomains as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', [CentralPortalController::class, 'index'])->name('central.home');
        Route::get('/planes', function () {
            return redirect()->to('/#planes');
        })->name('central.plans');
        Route::post('/rentar-tienda', [CentralPortalController::class, 'registerTenant'])->name('central.rent.tenant');
        Route::get('/api/global-search', [CentralPortalController::class, 'apiSearch'])->name('central.api.search');
        Route::get('/api/reviews', [CentralPortalController::class, 'getReviews'])->name('central.api.reviews.index');
        Route::post('/api/reviews', [CentralPortalController::class, 'storeReview'])->name('central.api.reviews.store');

        // Direct Mobile / LAN Storefront Route (No custom DNS required on mobile devices)
        Route::get('/tienda/{tenant}', function (string $tenantId) {
            $tenant = \App\Models\Tenant::where('id', $tenantId)->orWhereRaw('LOWER(id) = ?', [strtolower($tenantId)])->first();
            if (!$tenant) {
                abort(404, 'Tienda no encontrada.');
            }

            tenancy()->initialize($tenant);

            $settings = \App\Models\StoreSetting::first();
            $storeName = $settings?->store_name ?? str($tenantId)->replace(['-', '_'], ' ')->title()->toString();
            $categories = \App\Models\Category::withCount('products')->get();
            $products = \App\Models\Product::where('is_active', true)->with('category')->latest()->get();
            $featuredProducts = $products->take(8);

            $cachedStores = \Illuminate\Support\Facades\Cache::remember('platform_official_stores_list', 120, function () {
                return tenancy()->central(function () {
                    return \App\Models\Tenant::with('domains')->get()->map(function ($t) {
                        return [
                            'id' => (string) $t->id,
                            'name' => str($t->id)->replace(['-', '_'], ' ')->title()->toString(),
                            'url' => url("/tienda/{$t->id}"),
                        ];
                    })->toArray();
                });
            });

            $officialStores = array_map(function ($store) use ($tenantId) {
                $store['is_current'] = strtolower((string)$store['id']) === strtolower($tenantId);
                return $store;
            }, (array) $cachedStores);

            return view('tenant.store', compact('storeName', 'tenantId', 'settings', 'categories', 'products', 'featuredProducts', 'officialStores'));
        })->name('central.tenant.store');

        Route::post('/api/tienda/{tenant}/checkout', [\App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('central.tenant.checkout');

        Route::get('/login', [CentralAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [CentralAuthController::class, 'login'])->name('login.submit');
        Route::post('/register', [CentralAuthController::class, 'register'])->name('register.submit');

        // Google OAuth Routes (Laravel Socialite)
        Route::get('/auth/google', [CentralAuthController::class, 'redirectToGoogle'])->name('auth.google');
        Route::get('/auth/google/callback', [CentralAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

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

