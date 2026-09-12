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

        $tenants = Tenant::with('domains')->where('id', 'not like', 'test%')->get();
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
                        'tagline' => $settings?->tagline ?? 'Comercio verificado en Zacatecas Centro.',
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
                                ->orWhere('slug', 'like', "%{$searchQuery}%")
                                ->orWhereHas('category', function ($cq) use ($searchQuery, $searchNormalized) {
                                    $cq->where('name', 'like', "%{$searchQuery}%")
                                        ->orWhere('slug', 'like', "%{$searchQuery}%");
                                    if ($searchNormalized !== '') {
                                        $cq->orWhere('slug', 'like', "%{$searchNormalized}%");
                                    }
                                });
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

        // Dynamic company ratings and reviews count from Review model
        foreach ($businesses as &$b) {
            $companyRevs = \App\Models\Review::forCompany($b['id'])->approved()->get();
            if ($companyRevs->isNotEmpty()) {
                $b['rating'] = round($companyRevs->avg('rating'), 1);
                $b['reviews_count'] = $companyRevs->count();
            }
        }
        unset($b);

        // Compile Most Visited Products across all iconic stores
        $allProductsList = [];
        foreach ($businesses as $b) {
            foreach ($b['sample_products'] as $p) {
                $pSlug = $p['slug'] ?? \Illuminate\Support\Str::slug($p['name']);
                $revs = \App\Models\Review::forProduct($pSlug)->approved()->get();
                $avgRating = $revs->isNotEmpty() ? round($revs->avg('rating'), 1) : 5.0;
                $revCount = $revs->isNotEmpty() ? $revs->count() : match($p['store_id'] ?? $b['id']) {
                    'acropolis' => 38,
                    'donajulia' => 45,
                    'rosadeplata' => 29,
                    'elserranito' => 24,
                    'quinceletras' => 52,
                    'libreriaandrea' => 19,
                    default => 15,
                };
                $visits = match($p['store_id'] ?? $b['id']) {
                    'acropolis' => 1420,
                    'donajulia' => 1350,
                    'rosadeplata' => 980,
                    'elserranito' => 840,
                    'quinceletras' => 910,
                    'libreriaandrea' => 670,
                    default => 450,
                };

                $allProductsList[] = [
                    'id' => (string) $p['id'],
                    'slug' => $pSlug,
                    'name' => $p['name'],
                    'price' => (float) $p['price'],
                    'image_url' => $p['image_url'],
                    'description' => $p['description'],
                    'stock' => $p['stock'] ?? 15,
                    'url' => $p['url'],
                    'store_id' => $b['id'],
                    'store_name' => $b['store_name'],
                    'store_url' => $b['store_url'],
                    'store_logo' => $b['logo_url'] ?? '',
                    'store_category' => $b['business_category'],
                    'address' => $b['address'],
                    'hours' => $b['opening_hours'],
                    'whatsapp' => $b['whatsapp_number'] ?? '',
                    'maps_url' => $b['maps_url'] ?? '',
                    'visits_count' => $visits,
                    'rating' => $avgRating,
                    'reviews_count' => $revCount,
                ];
            }
        }

        // Sort by visits descending
        usort($allProductsList, fn($a, $b) => $b['visits_count'] <=> $a['visits_count']);
        $mostVisitedProducts = array_slice($allProductsList, 0, 8);

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
            'mostVisitedProducts' => $mostVisitedProducts,
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

        // 2. Assign primary and production domains
        $tenant->createDomain($subdomain);
        $tenant->createDomain("{$subdomain}.atelier-zacatecas.onrender.com");
        $tenant->createDomain("{$subdomain}.localhost");

        // 3. Initialize isolated database and populate initial settings & admin user
        $tenant->run(function () use ($validated, $subdomain) {
            // Set custom brand settings
            \App\Models\StoreSetting::updateOrCreate(
                ['id' => 1],
                [
                    'store_name' => $validated['company_name'],
                    'business_category' => $validated['business_category'] ?? 'Comercio General',
                    'contact_email' => $validated['owner_email'],
                    'tagline' => 'Comercio verificado en Zacatecas Centro.',
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

        $storeUrl = url("/tienda/{$subdomain}");
        $adminUrl = url("/tienda/{$subdomain}/admin");

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

        $tenants = Tenant::with('domains')->where('id', 'not like', 'test%')->get();
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
                            ->orWhere('slug', 'like', "%{$q}%")
                            ->orWhereHas('category', function ($cq) use ($q, $searchNormalized) {
                                $cq->where('name', 'like', "%{$q}%")
                                    ->orWhere('slug', 'like', "%{$q}%");
                                if ($searchNormalized !== '') {
                                    $cq->orWhere('slug', 'like', "%{$searchNormalized}%");
                                }
                            });
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
     * Resolve store URL dynamically based on current host/server (Render, domain or IP)
     */
    protected function resolveStoreUrl($tenant, Request $request): string
    {
        return url("/tienda/{$tenant->id}");
    }

    /**
     * Create a new enterprise story
     */
    public function createStory(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'nullable|string|max:80',
            'store_name' => 'required|string|max:120',
            'store_logo' => 'nullable|string|max:1000',
            'caption' => 'nullable|string|max:500',
            'media_url' => 'nullable|string|max:1000',
            'media_file' => 'nullable|image|max:10240',
            'cta_text' => 'nullable|string|max:80',
            'cta_url' => 'nullable|string|max:1000',
            'whatsapp_number' => 'nullable|string|max:30',
            'duration_seconds' => 'nullable|integer|min:3|max:30',
        ]);

        $mediaUrl = $validated['media_url'] ?? null;
        if ($request->hasFile('media_file')) {
            $file = $request->file('media_file');
            $filename = 'story_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/stories');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            $mediaUrl = url('uploads/stories/' . $filename);
        }

        if (empty($mediaUrl)) {
            $mediaUrl = 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=800&q=80';
        }

        $story = \App\Models\Story::create([
            'tenant_id' => $validated['tenant_id'] ?? null,
            'store_name' => $validated['store_name'],
            'store_logo' => $validated['store_logo'] ?? null,
            'media_url' => $mediaUrl,
            'caption' => $validated['caption'] ?? null,
            'cta_text' => $validated['cta_text'] ?? 'Ver Tienda',
            'cta_url' => $validated['cta_url'] ?? (!empty($validated['tenant_id']) ? url('/tienda/' . $validated['tenant_id']) : url('/')),
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'duration_seconds' => (int) ($validated['duration_seconds'] ?? 5),
            'views_count' => 1,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Historia publicada exitosamente!',
            'story' => [
                'id' => (string) $story->id,
                'tenant_id' => $story->tenant_id,
                'store_name' => $story->store_name,
                'store_logo' => $story->store_logo,
                'media_url' => $story->media_url,
                'caption' => $story->caption,
                'cta_text' => $story->cta_text,
                'cta_url' => $story->cta_url,
                'whatsapp_number' => $story->whatsapp_number,
                'views_count' => $story->views_count,
                'duration_seconds' => $story->duration_seconds,
                'time_ago' => 'Justo ahora',
            ],
        ]);
    }

    /**
     * Increment story views count
     */
    public function viewStory(string $id)
    {
        $story = \App\Models\Story::find($id);
        if ($story) {
            $story->increment('views_count');
            return response()->json(['success' => true, 'views_count' => $story->views_count]);
        }
        return response()->json(['success' => false, 'message' => 'Story not found'], 404);
    }

    /**
     * Get reviews for a company or product
     */
    public function getReviews(Request $request)
    {
        $type = $request->input('type'); // 'company' or 'product'
        $id = $request->input('id');

        if (!$type || !$id) {
            return response()->json(['success' => false, 'message' => 'Faltan parámetros type o id.'], 400);
        }

        $reviews = \App\Models\Review::where('reviewable_type', $type)
            ->where('reviewable_id', $id)
            ->approved()
            ->latest()
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'author_name' => $r->author_name,
                'rating' => (int) $r->rating,
                'comment' => $r->comment,
                'verified_purchase' => (bool) $r->verified_purchase,
                'time_ago' => $r->created_at ? $r->created_at->diffForHumans(null, true) : 'Reciente',
                'created_at_fmt' => $r->created_at ? $r->created_at->format('d/m/Y') : '',
            ]);

        $avg = $reviews->isNotEmpty() ? round($reviews->avg('rating'), 1) : 5.0;

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'count' => $reviews->count(),
            'average_rating' => $avg,
        ]);
    }

    /**
     * Store a new 1-5 star review & comment
     */
    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'reviewable_type' => 'required|string|in:company,product',
            'reviewable_id' => 'required|string|max:120',
            'rating' => 'required|integer|min:1|max:5',
            'author_name' => 'required|string|min:2|max:80',
            'comment' => 'required|string|min:4|max:1000',
        ], [
            'rating.min' => 'La calificación mínima es de 1 estrella.',
            'rating.max' => 'La calificación máxima es de 5 estrellas.',
            'author_name.required' => 'Por favor ingresa tu nombre.',
            'comment.min' => 'El comentario debe tener al menos 4 caracteres.',
        ]);

        $review = \App\Models\Review::create([
            'reviewable_type' => $validated['reviewable_type'],
            'reviewable_id' => $validated['reviewable_id'],
            'rating' => (int) $validated['rating'],
            'author_name' => strip_tags(trim($validated['author_name'])),
            'comment' => strip_tags(trim($validated['comment'])),
            'verified_purchase' => true,
            'is_approved' => true,
        ]);

        $allRevs = \App\Models\Review::where('reviewable_type', $validated['reviewable_type'])
            ->where('reviewable_id', $validated['reviewable_id'])
            ->approved()
            ->get();

        $newAvg = round($allRevs->avg('rating'), 1);
        $newCount = $allRevs->count();

        return response()->json([
            'success' => true,
            'message' => '¡Muchas gracias por tu reseña y calificación!',
            'review' => [
                'id' => $review->id,
                'author_name' => $review->author_name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'verified_purchase' => true,
                'time_ago' => 'Justo ahora',
                'created_at_fmt' => now()->format('d/m/Y'),
            ],
            'average_rating' => $newAvg,
            'reviews_count' => $newCount,
        ]);
    }

    public function showPlans(Request $request)
    {
        $subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)->orderBy('sort_order')->get();
        return view('central.plans', compact('subscriptionPlans'));
    }

    /**
     * Proxy to OSRM pedestrian street-by-street routing for Zacatecas Centro Histórico.
     */
    public function getWalkingRoute(Request $request)
    {
        $coords = trim((string) $request->query('coords', ''));
        if (empty($coords)) {
            return response()->json(['code' => 'InvalidCoords', 'message' => 'Parámetro coords requerido.'], 400);
        }

        // Cache successful routes for 30 minutes for blazing speed and zero redundant external calls
        $cacheKey = 'walking_route_osrm_' . md5($coords);
        $result = \Illuminate\Support\Facades\Cache::remember($cacheKey, 1800, function () use ($coords) {
            $url = "https://router.project-osrm.org/route/v1/walking/{$coords}?overview=full&geometries=geojson";
            try {
                $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->withHeaders([
                        'User-Agent' => 'AtelierZacatecas-Marketplace/2.0 (recorrido-centro@atelierzacatecas.com)',
                        'Accept' => 'application/json',
                    ])
                    ->timeout(6)
                    ->get($url);

                if ($response->successful()) {
                    $json = $response->json();
                    if (($json['code'] ?? '') === 'Ok') {
                        return $json;
                    }
                }
            } catch (\Throwable $e) {
                // Ignore and return fallback
            }

            return null;
        });

        if ($result) {
            return response()->json($result);
        }

        return response()->json(['code' => 'Fallback', 'message' => 'No se pudo trazar la ruta por calles en este momento.'], 200);
    }
}

