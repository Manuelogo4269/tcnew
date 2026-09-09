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

foreach (['{tenant}.localhost', '{tenant}.192.168.0.128.nip.io'] as $domainPattern) {
    Route::domain($domainPattern)->middleware([
        'web',
        InitializeTenancyBySubdomain::class,
        PreventAccessFromCentralDomains::class,
    ])->group(function () {
    Route::get('/', function () {
        $tenantId = (string) tenant('id');
        $settings = StoreSetting::first();
        $storeName = $settings?->store_name ?? str($tenantId)->replace(['-', '_'], ' ')->title()->toString();
        $categories = Category::withCount('products')->get();
        $products = Product::where('is_active', true)->with('category')->latest()->get();
        $featuredProducts = $products->take(8);

        // Fetch official businesses across the platform from central DB (cached)
        $cachedStores = \Illuminate\Support\Facades\Cache::remember('platform_official_stores_list', 120, function () {
            return tenancy()->central(function () {
                return \App\Models\Tenant::with('domains')->get()->map(function ($t) {
                    $primaryDomain = $t->domains->first()?->domain ?? $t->id;
                    $host = str_contains($primaryDomain, '.') ? $primaryDomain : "{$primaryDomain}.localhost";
                    $url = "http://{$host}:8000";

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

        return view('tenant.store', compact('storeName', 'tenantId', 'settings', 'categories', 'products', 'featuredProducts', 'officialStores'));
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
});
}

