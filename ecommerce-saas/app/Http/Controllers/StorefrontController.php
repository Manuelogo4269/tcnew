<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class StorefrontController extends Controller
{
    /**
     * Display the standalone website for a tenant business.
     */
    public function show($tenant = null, $request = null)
    {
        if ($tenant instanceof Request) {
            $request = $tenant;
            $tenant = null;
        }

        $request = $request ?? request();
        $targetTenant = $tenant ?? request()->route('tenant') ?? (string) tenant('id');

        $tenantModel = findTenantBySlugOrDomain((string) $targetTenant);
        if (!$tenantModel) {
            abort(404, 'Página de empresa no encontrada.');
        }

        $tenantId = (string) $tenantModel->id;

        // Check active subscription
        $isAdmin = (session('tenant_admin_tenant_id') === $tenantId) || auth()->guard('tenant')->check();
        if (!$tenantModel->hasActiveSubscription() && !$isAdmin) {
            $settings = null;
            try {
                $settings = $tenantModel->run(fn () => StoreSetting::first());
            } catch (\Throwable $e) {}
            $storeName = $settings?->store_name ?? str($tenantId)->replace(['-', '_'], ' ')->title()->toString();
            $tenant = $tenantModel;
            return response()->view('tenant.subscription_inactive', compact('tenantModel', 'tenant', 'settings', 'storeName'), 402);
        }

        tenancy()->initialize($tenantModel);

        $user = Auth::guard('web')->user();
        $hasFacebookKeys = !empty(config('services.facebook.client_id')) && !empty(config('services.facebook.client_secret'));

        $settings = StoreSetting::first();
        $storeName = $settings?->store_name ?? str($tenantId)->replace(['-', '_'], ' ')->title()->toString();
        
        // Auto-seed starter catalog if store is newly created and completely empty
        $productCount = Product::count();
        if ($productCount === 0) {
            try {
                if (class_exists(\Database\Seeders\TenantStoreExpansionSeeder::class)) {
                    (new \Database\Seeders\TenantStoreExpansionSeeder())->run();
                }
            } catch (\Throwable $e) {}
        }

        $categories = Category::withCount('products')->get();
        $products = Product::where('is_active', true)->with('category')->latest()->get();
        $featuredProducts = $products->take(8);

        // Official stores network across the platform (cached)
        $cachedStores = Cache::remember('platform_official_stores_list', 120, function () {
            return tenancy()->central(function () {
                return Tenant::with('domains')->get()->map(function ($t) {
                    $sName = null;
                    try {
                        $sName = $t->run(fn () => StoreSetting::value('store_name'));
                    } catch (\Throwable $e) {}

                    return [
                        'id' => (string) $t->id,
                        'name' => $sName ?: str($t->id)->replace(['-', '_'], ' ')->title()->toString(),
                        'url' => url("/{$t->id}"),
                    ];
                })->toArray();
            });
        });

        $officialStores = array_map(function ($store) use ($tenantId) {
            $store['is_current'] = strtolower((string)$store['id']) === strtolower($tenantId);
            return $store;
        }, (array) $cachedStores);

        $layoutBlocks = $settings ? $settings->getEffectiveLayoutBlocks() : StoreSetting::defaultLayoutBlocks();

        // Handle Stripe Return Flow if applicable
        $confirmedOrder = null;
        $paymentResult = $request->query('payment_result');
        $stripeSessionId = $request->query('session_id');
        $folio = $request->query('folio');

        if ($paymentResult === 'stripe_success' && $stripeSessionId && $folio) {
            $order = Order::where('folio', $folio)
                ->orWhere('stripe_session_id', $stripeSessionId)
                ->first();

            if ($order) {
                $secretKey = $settings?->stripe_secret_key ?: config('services.stripe.secret');
                if ($secretKey) {
                    try {
                        $sessionCheck = Http::withToken($secretKey)
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

        $companyDirectUrl = url("/{$tenantId}");

        return view('tenant.store', compact(
            'storeName',
            'tenantId',
            'settings',
            'categories',
            'products',
            'featuredProducts',
            'officialStores',
            'user',
            'hasFacebookKeys',
            'layoutBlocks',
            'confirmedOrder',
            'paymentResult',
            'companyDirectUrl'
        ));
    }
}
