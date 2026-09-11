<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by TenancyServiceProvider with tenant domain identification.
|
*/

foreach (['{tenant}.localhost', '{tenant}.127.0.0.1.nip.io', '{tenant}.192.168.0.128.nip.io', '{tenant}.atelier-zacatecas.onrender.com'] as $domainPattern) {
    Route::domain($domainPattern)->middleware([
        'web',
        InitializeTenancyBySubdomain::class,
        PreventAccessFromCentralDomains::class,
    ])->group(function () {
    Route::get('/', function () {
        $tenantId = (string) tenant('id');
        $user = \Illuminate\Support\Facades\Auth::guard('web')->user();
        $hasFacebookKeys = !empty(config('services.facebook.client_id')) && !empty(config('services.facebook.client_secret'));
        $settings = StoreSetting::first();
        $storeName = $settings?->store_name ?? str($tenantId)->replace(['-', '_'], ' ')->title()->toString();
        $categories = Category::withCount('products')->get();
        $products = Product::where('is_active', true)->with('category')->latest()->get();
        $featuredProducts = $products->take(8);

        // Fetch official businesses across the platform from central DB (cached)
        $cachedStores = \Illuminate\Support\Facades\Cache::remember('platform_official_stores_list', 120, function () {
            return tenancy()->central(function () {
                return \App\Models\Tenant::with('domains')->get()->map(function ($t) {
                    $url = url("/tienda/{$t->id}");

                    return [
                        'id' => (string) $t->id,
                        'name' => str($t->id)->replace(['-', '_'], ' ')->title()->toString(),
                        'url' => $url,
                    ];
                })->toArray();
            });
        });

        $officialStores = array_map(function ($store) use ($tenantId) {
            $store['is_current'] = strtolower((string)$store['id']) === strtolower($tenantId);
            return $store;
        }, (array) $cachedStores);

        $layoutBlocks = $settings ? $settings->getEffectiveLayoutBlocks() : StoreSetting::defaultLayoutBlocks();

        return view('tenant.store', compact('storeName', 'tenantId', 'settings', 'categories', 'products', 'featuredProducts', 'officialStores', 'user', 'hasFacebookKeys', 'layoutBlocks'));
    });

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
});
}

