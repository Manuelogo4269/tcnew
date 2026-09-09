<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentralPortalController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = trim((string) $request->input('q', ''));
        $selectedCategory = trim((string) $request->input('categoria', 'all'));
        $user = Auth::guard('web')->user();

        $tenants = Tenant::with('domains')->get();
        $cacheKey = 'central_portal_businesses_list_' . md5($request->getHost() . ':' . $request->getPort());
        $businesses = \Illuminate\Support\Facades\Cache::remember($cacheKey, 60, function () use ($tenants, $request) {
            $list = [];
            foreach ($tenants as $t) {
                $storeUrl = $this->resolveStoreUrl($t, $request);

                $tenantData = $t->run(function () use ($t, $storeUrl) {
                    $settings = \App\Models\StoreSetting::first();
                    $productsCount = \App\Models\Product::where('is_active', true)->count();
                    $categoriesCount = \App\Models\Category::count();
                    $sampleProducts = \App\Models\Product::where('is_active', true)
                        ->latest()
                        ->take(3)
                        ->get()
                        ->map(fn ($p) => [
                            'id' => (string) $p->id,
                            'store_id' => (string) $t->id,
                            'store_name' => $settings?->store_name ?? str($t->id)->replace(['-', '_'], ' ')->title()->toString(),
                            'name' => $p->name,
                            'price' => (float) $p->price,
                            'image_url' => $p->image_url,
                            'slug' => $p->slug,
                            'description' => $p->description,
                            'stock' => (int) $p->stock,
                            'url' => str_contains($storeUrl, '?') ? "{$storeUrl}&producto={$p->slug}" : "{$storeUrl}/?producto={$p->slug}",
                        ]);

                    return [
                        'id' => $t->id,
                        'store_name' => $settings?->store_name ?? str($t->id)->replace(['-', '_'], ' ')->title()->toString(),
                        'business_category' => $settings?->business_category ?? 'Comercio General',
                        'tagline' => $settings?->tagline ?? 'Tienda oficial verificada en la plataforma.',
                        'logo_url' => $settings?->logo_url,
                        'primary_color' => $settings?->primary_color ?? '#d96b45',
                        'secondary_color' => $settings?->secondary_color ?? '#f4efe7',
                        'official_website_url' => $settings?->official_website_url,
                        'facebook_url' => $settings?->facebook_url,
                        'instagram_url' => $settings?->instagram_url,
                        'address' => $settings?->address ?? $t->address ?? 'Centro Histórico, Zacatecas, Zac.',
                        'neighborhood_zone' => $settings?->neighborhood_zone ?? $t->neighborhood_zone ?? 'Centro Histórico',
                        'city' => $settings?->city ?? $t->city ?? 'Zacatecas',
                        'latitude' => (float) ($settings?->latitude ?? $t->latitude ?? 22.7753),
                        'longitude' => (float) ($settings?->longitude ?? $t->longitude ?? -102.5724),
                        'maps_url' => $settings?->maps_url ?? $t->maps_url ?? 'https://maps.google.com/?q=22.7753,-102.5724',
                        'opening_hours' => $settings?->opening_hours ?? $t->opening_hours ?? 'Lunes a Sábado: 10:00 AM - 8:30 PM',
                        'location_reference' => $settings?->location_reference ?? $t->location_reference ?? 'Zona Centro de Zacatecas',
                        'whatsapp_number' => $settings?->whatsapp_number,
                        'products_count' => $productsCount,
                        'categories_count' => $categoriesCount,
                        'sample_products' => $sampleProducts,
                        'store_url' => $storeUrl,
                        'rating' => match($t->id) {
                            'acropolis' => 4.9,
                            'donajulia' => 4.9,
                            'rosadeplata' => 4.8,
                            'elserranito' => 4.8,
                            'quinceletras' => 4.9,
                            'libreriaandrea' => 4.8,
                            default => 4.8,
                        },
                        'reviews_count' => match($t->id) {
                            'acropolis' => 425,
                            'donajulia' => 512,
                            'rosadeplata' => 194,
                            'elserranito' => 288,
                            'quinceletras' => 640,
                            'libreriaandrea' => 145,
                            default => 120,
                        },
                        'tradition_badge' => match($t->id) {
                            'acropolis' => 'Tradición de más de 80 años',
                            'donajulia' => 'Gorditas emblemáticas del centro',
                            'rosadeplata' => 'Plata pura Ley .925 garantizada',
                            'elserranito' => 'Nieves artesanales tradicionales',
                            'quinceletras' => 'Museo y cantina histórica zacatecana',
                            'libreriaandrea' => 'Librería cultural zacatecana',
                            default => 'Comercio certificado del centro',
                        },
                    ];
                });

                $list[] = $tenantData;
            }
            return $list;
        });

        $searchResults = [];
        if ($searchQuery !== '') {
            foreach ($tenants as $t) {
                $storeUrl = $this->resolveStoreUrl($t, $request);

                $matchedProducts = $t->run(function () use ($t, $storeUrl, $searchQuery) {
                    $settings = \App\Models\StoreSetting::first();
                    $searchNormalized = str($searchQuery)->ascii()->slug()->toString();
                    return \App\Models\Product::where('is_active', true)
                        ->where(function ($query) use ($searchQuery, $searchNormalized) {
                            $query->where('name', 'like', "%{$searchQuery}%")
                                ->orWhere('description', 'like', "%{$searchQuery}%")
                                ->orWhere('slug', 'like', "%{$searchQuery}%");
                            if ($searchNormalized !== '') {
                                $query->orWhere('slug', 'like', "%{$searchNormalized}%");
                            }
                        })
                        ->with('category')
                        ->get()
                        ->map(fn ($p) => [
                            'id' => $p->id,
                            'name' => $p->name,
                            'slug' => $p->slug,
                            'price' => (float) $p->price,
                            'stock' => (int) $p->stock,
                            'description' => $p->description,
                            'image_url' => $p->image_url,
                            'category_name' => $p->category?->name ?? 'General',
                            'store_id' => $t->id,
                            'store_name' => $settings?->store_name ?? str($t->id)->title()->toString(),
                            'store_category' => $settings?->business_category ?? 'Comercio General',
                            'store_color' => $settings?->primary_color ?? '#d96b45',
                            'store_url' => str_contains($storeUrl, '?') ? "{$storeUrl}&producto={$p->slug}" : "{$storeUrl}/?producto={$p->slug}",
                        ])
                        ->toArray();
                });

                if (!empty($matchedProducts)) {
                    $searchResults = array_merge($searchResults, $matchedProducts);
                }
            }
        }

        // Available Business Categories
        $businessCategories = collect($businesses)
            ->pluck('business_category')
            ->unique()
            ->values()
            ->toArray();

        // Filter businesses if a category is selected
        $filteredBusinesses = $businesses;
        if ($selectedCategory !== 'all') {
            $filteredBusinesses = array_values(array_filter($businesses, function ($b) use ($selectedCategory) {
                return strtolower($b['business_category']) === strtolower($selectedCategory);
            }));
        }

        $subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)->orderBy('sort_order')->get();
        $hasGoogleKeys = !empty(config('services.google.client_id')) && !empty(config('services.google.client_secret'));
        $hasFacebookKeys = !empty(config('services.facebook.client_id')) && !empty(config('services.facebook.client_secret'));

        return view('central.home', [
            'businesses' => $filteredBusinesses,
            'allBusinesses' => $businesses,
            'businessCategories' => $businessCategories,
            'searchResults' => $searchResults,
            'searchQuery' => $searchQuery,
            'selectedCategory' => $selectedCategory,
            'subscriptionPlans' => $subscriptionPlans,
            'user' => $user,
            'hasGoogleKeys' => $hasGoogleKeys,
            'hasFacebookKeys' => $hasFacebookKeys,
        ]);
    }

    public function registerTenant(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:100',
            'subdomain' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[a-z0-9-]+$/',
                'unique:central.tenants,id',
            ],
            'plan_slug' => 'required|string|exists:central.subscription_plans,slug',
            'billing_cycle' => 'required|in:monthly,annual',
            'owner_name' => 'required|string|max:100',
            'owner_email' => 'required|email|max:150',
            'owner_password' => 'required|string|min:6',
            'business_category' => 'nullable|string|max:80',
        ], [
            'subdomain.regex' => 'El subdominio solo puede contener letras minúsculas, números y guiones.',
            'subdomain.unique' => 'Ese subdominio ya está registrado por otra empresa. Por favor elige otro.',
            'owner_password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $plan = \App\Models\SubscriptionPlan::where('slug', $validated['plan_slug'])->firstOrFail();
        $subdomain = strtolower(trim($validated['subdomain']));
        $amount = $validated['billing_cycle'] === 'annual' ? (float) $plan->annual_total : (float) $plan->monthly_price;
        $cleanPlanName = str_replace('Plan ', '', $plan->name);

        // 1. Create Tenant in central database
        $tenant = Tenant::create([
            'id' => $subdomain,
            'plan_name' => $cleanPlanName,
            'billing_cycle' => $validated['billing_cycle'],
            'subscription_status' => 'active',
            'subscription_amount' => $amount,
            'subscription_ends_at' => $validated['billing_cycle'] === 'annual' ? now()->addYear() : now()->addMonth(),
            'address' => 'Av. Hidalgo #305, Centro Histórico, Zacatecas, Zac., CP 98000',
            'neighborhood_zone' => 'Centro Histórico',
            'city' => 'Zacatecas',
            'latitude' => 22.7753,
            'longitude' => -102.5724,
            'maps_url' => 'https://maps.google.com/?q=22.7753,-102.5724',
            'opening_hours' => 'Lunes a Sábado: 10:00 AM - 8:30 PM',
            'location_reference' => 'Zona Centro de Zacatecas',
        ]);

        // 2. Assign primary and localhost domains
        $tenant->createDomain($subdomain);
        $tenant->createDomain("{$subdomain}.localhost");

        // 3. Initialize isolated database and populate initial settings & admin user
        $tenant->run(function () use ($validated, $subdomain) {
            // Seed base catalog structure
            (new \Database\Seeders\TenantSeeder())->run();

            // Set custom brand settings
            \App\Models\StoreSetting::updateOrCreate(
                ['id' => 1],
                [
                    'store_name' => $validated['company_name'],
                    'business_category' => $validated['business_category'] ?? 'Comercio General',
                    'contact_email' => $validated['owner_email'],
                    'tagline' => 'Tienda oficial verificada en la plataforma.',
                    'address' => 'Av. Hidalgo #305, Centro Histórico, Zacatecas, Zac., CP 98000',
                    'neighborhood_zone' => 'Centro Histórico',
                    'city' => 'Zacatecas',
                    'latitude' => 22.7753,
                    'longitude' => -102.5724,
                    'maps_url' => 'https://maps.google.com/?q=22.7753,-102.5724',
                    'opening_hours' => 'Lunes a Sábado: 10:00 AM - 8:30 PM',
                    'location_reference' => 'Zona Centro de Zacatecas',
                ]
            );

            // Create or update Tenant administrator
            \App\Models\TenantUser::updateOrCreate(
                ['email' => $validated['owner_email']],
                [
                    'name' => $validated['owner_name'],
                    'password' => \Illuminate\Support\Facades\Hash::make($validated['owner_password']),
                ]
            );
        });

        // 4. Flush cached businesses so the new enterprise appears instantly
        \Illuminate\Support\Facades\Cache::forget('central_portal_businesses_list');
        \Illuminate\Support\Facades\Cache::forget('platform_official_stores_list');

        $storeUrl = "http://{$subdomain}.localhost:8000";
        $adminUrl = "http://{$subdomain}.localhost:8000/tenant-admin/login";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "¡Felicitaciones! La tienda {$validated['company_name']} ha sido creada exitosamente con el {$plan->name}.",
                'subdomain' => $subdomain,
                'store_url' => $storeUrl,
                'admin_url' => $adminUrl,
                'plan_name' => $plan->name,
                'billing_cycle' => $validated['billing_cycle'] === 'annual' ? 'Anual (-20%)' : 'Mensual',
                'owner_email' => $validated['owner_email'],
            ]);
        }

        return redirect()->back()->with('success_store_created', [
            'name' => $validated['company_name'],
            'subdomain' => $subdomain,
            'store_url' => $storeUrl,
            'admin_url' => $adminUrl,
            'plan_name' => $plan->name,
            'billing_cycle' => $validated['billing_cycle'] === 'annual' ? 'Anual (-20%)' : 'Mensual',
            'owner_email' => $validated['owner_email'],
        ]);
    }

    public function apiSearch(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        if ($q === '') {
            return response()->json(['results' => [], 'count' => 0]);
        }

        $tenants = Tenant::with('domains')->get();
        $results = [];

        foreach ($tenants as $t) {
            $storeUrl = $this->resolveStoreUrl($t, $request);

            $tenantMatches = $t->run(function () use ($t, $storeUrl, $q) {
                $settings = \App\Models\StoreSetting::first();
                $searchNormalized = str($q)->ascii()->slug()->toString();
                return \App\Models\Product::where('is_active', true)
                    ->where(function ($query) use ($q, $searchNormalized) {
                        $query->where('name', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%")
                            ->orWhere('slug', 'like', "%{$q}%");
                        if ($searchNormalized !== '') {
                            $query->orWhere('slug', 'like', "%{$searchNormalized}%");
                        }
                    })
                    ->with('category')
                    ->take(6)
                    ->get()
                    ->map(fn ($p) => [
                        'id' => $p->id,
                        'name' => $p->name,
                        'price' => (float) $p->price,
                        'image_url' => $p->image_url,
                        'category_name' => $p->category?->name ?? 'General',
                        'store_id' => $t->id,
                        'store_name' => $settings?->store_name ?? str($t->id)->title()->toString(),
                        'store_color' => $settings?->primary_color ?? '#d96b45',
                        'url' => str_contains($storeUrl, '?') ? "{$storeUrl}&producto={$p->slug}" : "{$storeUrl}/?producto={$p->slug}",
                    ]);
            });

            $results = array_merge($results, $tenantMatches->toArray());
        }

        return response()->json([
            'results' => $results,
            'count' => count($results),
            'query' => $q,
        ]);
    }

    /**
     * Resolve store URL dynamically based on client connection (Localhost, IP, or wildcard nip.io)
     */
    protected function resolveStoreUrl($tenant, Request $request): string
    {
        $reqHost = $request->getHost();
        $port = $request->getPort();
        $portStr = ($port && !in_array($port, [80, 443])) ? ":{$port}" : "";

        // If client connects via nip.io (e.g. 192.168.0.128.nip.io)
        if (str_ends_with($reqHost, '.nip.io')) {
            $baseNip = str_starts_with($reqHost, '192.168.') ? $reqHost : '192.168.0.128.nip.io';
            return "http://{$tenant->id}.{$baseNip}{$portStr}";
        }

        // If client connects via explicit localhost
        if ($reqHost === 'localhost' || str_ends_with($reqHost, '.localhost') || $reqHost === '127.0.0.1') {
            $primaryDomain = $tenant->domains->first()?->domain ?? $tenant->id;
            $host = str_contains($primaryDomain, '.') ? $primaryDomain : "{$primaryDomain}.localhost";
            return "http://{$host}{$portStr}";
        }

        // For all mobile networks, LAN IP (e.g. 192.168.0.128), and HTTPS tunnels (e.g. Cloudflare / Ngrok):
        return url("/tienda/{$tenant->id}");
    }
}
