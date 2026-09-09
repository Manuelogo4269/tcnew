<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomerAccount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MobileStoreController extends Controller
{
    /**
     * List all stores registered in the SaaS.
     */
    public function index()
    {
        $stores = Tenant::with('domains')->get()->map(function (Tenant $tenant) {
            $settings = $tenant->run(fn () => StoreSetting::first());

            return [
                'id' => $tenant->id,
                'name' => $settings?->store_name ?? str($tenant->id)->replace(['-', '_'], ' ')->title()->toString(),
                'tagline' => $settings?->tagline,
                'domains' => $tenant->domains->pluck('domain')->values(),
                'logo_url' => $settings?->logo_url,
                'banner_url' => $settings?->banner_url,
                'primary_color' => $settings?->primary_color ?? '#d96b45',
                'secondary_color' => $settings?->secondary_color ?? '#f4efe7',
                'font_family' => $settings?->font_family ?? 'DM Sans',
                'whatsapp_number' => $settings?->whatsapp_number,
            ];
        });

        return response()->json($stores);
    }

    /**
     * Get store settings and branding.
     */
    public function settings(string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () {
            $settings = StoreSetting::first();

            return response()->json([
                'tenant_id' => tenant('id'),
                'store_name' => $settings?->store_name ?? str(tenant('id'))->replace(['-', '_'], ' ')->title()->toString(),
                'tagline' => $settings?->tagline,
                'logo_url' => $settings?->logo_url,
                'banner_url' => $settings?->banner_url,
                'primary_color' => $settings?->primary_color ?? '#d96b45',
                'secondary_color' => $settings?->secondary_color ?? '#f4efe7',
                'font_family' => $settings?->font_family ?? 'DM Sans',
                'hero_title' => $settings?->hero_title,
                'hero_subtitle' => $settings?->hero_subtitle,
                'show_announcement' => $settings?->show_announcement ?? true,
                'announcement_text' => $settings?->announcement_text,
                'contact_email' => $settings?->contact_email,
                'whatsapp_number' => $settings?->whatsapp_number,
                'instagram_url' => $settings?->instagram_url,
                'facebook_url' => $settings?->facebook_url,
            ]);
        });
    }

    /**
     * List categories of a store.
     */
    public function categories(string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () {
            $categories = Category::query()
                ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
                ->get();

            return response()->json($categories);
        });
    }

    /**
     * List products of a store (with category filter and search).
     */
    public function products(Request $request, string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($request) {
            $query = Product::query()
                ->where('is_active', true)
                ->with('category:id,name,slug');

            if ($request->filled('category')) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->input('category'))
                      ->orWhere('id', $request->input('category'));
                });
            }

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $paginated = $query->latest()->paginate(20);

            return response()->json($paginated);
        });
    }

    /**
     * Get product details.
     */
    public function showProduct(string $tenant, string $product)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($product) {
            $record = Product::query()
                ->where('is_active', true)
                ->where(function ($q) use ($product) {
                    $q->where('id', $product)->orWhere('slug', $product);
                })
                ->with('category')
                ->firstOrFail();

            return response()->json($record);
        });
    }

    /**
     * Join/link global mobile account to tenant store.
     */
    public function join(Request $request, string $tenant)
    {
        /** @var CustomerAccount $account */
        $account = $request->user();
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($account) {
            $user = TenantUser::firstOrCreate(
                ['customer_account_id' => (string) $account->id],
                [
                    'name' => $account->name,
                    'email' => $account->email,
                    'password' => Str::random(64),
                ]
            );

            return response()->json([
                'message' => 'Cuenta vinculada a la tienda con éxito.',
                'store' => tenant('id'),
                'user' => $user,
            ]);
        });
    }

    /**
     * Create an order from the mobile app.
     */
    public function createOrder(Request $request, string $tenant)
    {
        $validated = $request->validate([
            'shipping_address' => ['required', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        /** @var CustomerAccount $account */
        $account = $request->user();
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($account, $validated) {
            // Find or associate the customer inside this tenant database
            $tenantUser = TenantUser::firstOrCreate(
                ['customer_account_id' => (string) $account->id],
                [
                    'name' => $account->name,
                    'email' => $account->email,
                    'password' => Str::random(64),
                ]
            );

            // Fetch products and verify stock and prices from DB directly
            $productIds = collect($validated['items'])->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->where('is_active', true)->get()->keyBy('id');

            if ($products->count() !== count($productIds)) {
                throw ValidationException::withMessages([
                    'items' => ['Uno o más productos seleccionados no están disponibles.'],
                ]);
            }

            $order = DB::transaction(function () use ($tenantUser, $validated, $products) {
                $totalAmount = 0;
                $orderItemsData = [];

                foreach ($validated['items'] as $item) {
                    $product = $products->get($item['product_id']);
                    $quantity = (int) $item['quantity'];

                    if ($product->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'items' => ["Stock insuficiente para '{$product->name}'."],
                        ]);
                    }

                    $subtotal = $product->price * $quantity;
                    $totalAmount += $subtotal;

                    // Reduce stock
                    $product->decrement('stock', $quantity);

                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ];
                }

                $order = Order::create([
                    'user_id' => $tenantUser->id,
                    'status' => 'pending',
                    'total_amount' => $totalAmount,
                    'shipping_address' => $validated['shipping_address'],
                ]);

                foreach ($orderItemsData as $itemData) {
                    $order->items()->create($itemData);
                }

                return $order->load('items.product');
            });

            return response()->json([
                'message' => 'Pedido creado exitosamente.',
                'order' => $order,
            ], 201);
        });
    }

    /**
     * Get order history for the current mobile customer in this store.
     */
    public function orders(Request $request, string $tenant)
    {
        /** @var CustomerAccount $account */
        $account = $request->user();
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($account) {
            $tenantUser = TenantUser::where('customer_account_id', (string) $account->id)->first();

            if (! $tenantUser) {
                return response()->json(['data' => []]);
            }

            $orders = Order::where('user_id', $tenantUser->id)
                ->with('items.product:id,name,image_url')
                ->latest()
                ->paginate(15);

            return response()->json($orders);
        });
    }

    /**
     * Get details of a single order.
     */
    public function showOrder(Request $request, string $tenant, int $orderId)
    {
        /** @var CustomerAccount $account */
        $account = $request->user();
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($account, $orderId) {
            $tenantUser = TenantUser::where('customer_account_id', (string) $account->id)->firstOrFail();

            $order = Order::where('user_id', $tenantUser->id)
                ->where('id', $orderId)
                ->with('items.product')
                ->firstOrFail();

            return response()->json($order);
        });
    }
}
