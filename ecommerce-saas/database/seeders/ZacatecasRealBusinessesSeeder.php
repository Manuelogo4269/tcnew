<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ZacatecasRealBusinessesSeeder extends Seeder
{
    public function run(): void
    {
        // List of previous sample product slugs to clean up so the user has an empty/clean catalog
        $sampleSlugs = [
            'gargantilla-oro-14k-solitaria',
            'aretes-huggies-doble-aro',
            'brazalete-eslabon-veneciano',
            'anillo-ajustable-twist-oro',
            'set-cadenas-layering-medalla',
            'vestido-midi-satinado-espalda-abierta',
            'conjunto-blazer-crop-wide-leg',
            'top-cuello-halter-lino-suave',
            'falda-plisada-tiro-alto-champana',
            'zapatillas-tacon-fino-tira-minimalista',
            'mules-punta-herraje-joya',
            'sandalias-plataforma-tonos-neutros',
            'bolso-bandolera-acolchado-cadena-dorada',
            'clutch-mano-rigido-noche',
            'collar-choker-eslabones-oro-18k',
        ];

        // 1. Definition of the Single Real Business: D & R CONCEPTOS (@conceptos.7)
        $businesses = [
            [
                'id' => 'conceptos7',
                'store_name' => 'D & R CONCEPTOS',
                'business_category' => 'Moda y Lujo',
                'plan_name' => 'Corporativo',
                'billing_cycle' => 'annual',
                'subscription_amount' => 850.00,
                'tagline' => 'Joyería y Accesorios ✨ · Ropa y Calzado 👠 · Zacatecas Centro',
                'address' => 'Calle Tacuba #124, Centro Histórico, Zacatecas, Zac., C.P. 98000',
                'neighborhood_zone' => 'Calle Tacuba',
                'city' => 'Zacatecas',
                'latitude' => 22.7735,
                'longitude' => -102.5721,
                'maps_url' => 'https://maps.google.com/?q=22.7735,-102.5721',
                'opening_hours' => 'Lunes a Sábado: 10:30 AM - 8:30 PM',
                'location_reference' => 'En el corredor comercial de Calle Tacuba, a media cuadra de Plaza Bicentenario y Catedral',
                'primary_color' => '#b78a38',
                'secondary_color' => '#faf8f5',
                'logo_url' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "D & R CONCEPTOS\nJoyería, Ropa y Calzado",
                'hero_subtitle' => 'Tu boutique de moda en el Centro de Zacatecas. Piezas exclusivas de joyería fina, colecciones de temporada y calzado para elevar cada uno de tus looks.',
                'announcement_text' => '✨ ¡Nueva Colección 2026 en D & R CONCEPTOS! Joyería, accesorios, ropa y calzado en Zacatecas Centro · Envíos a todo el país ✨',
                'contact_email' => 'contacto@conceptos7.com',
                'whatsapp_number' => '+52 492 145 7890',
                'facebook_url' => 'https://www.facebook.com/conceptos7zacatecas/',
                'instagram_url' => 'https://www.instagram.com/conceptos.7/',
                'official_website_url' => 'https://www.instagram.com/conceptos.7/',
                'admin_name' => 'Administrador D & R CONCEPTOS',
                'admin_email' => 'admin@conceptos7.com',
                'layout_blocks' => [
                    [
                        'type' => 'banner_carousel',
                        'is_visible' => true,
                        'title' => 'Colección 2026',
                        'data' => [
                            'eyebrow' => 'Boutique Zacatecas',
                            'title' => "D & R CONCEPTOS\nJoyería, Ropa y Calzado",
                            'subtitle' => 'Piezas exclusivas seleccionadas para realzar tu estilo y elegancia en cada ocasión.',
                            'btn_text' => 'Explorar Colección',
                            'btn_link' => '#catalogo',
                        ],
                    ],
                    [
                        'type' => 'trust_bar',
                        'is_visible' => true,
                        'title' => 'Beneficios de Compra',
                        'data' => [
                            'item1' => 'Envíos en Zacatecas y Todo México',
                            'item2' => 'Garantía en Joyería y Ropa',
                            'item3' => 'Pagos 100% Protegidos',
                            'item4' => 'Atención Personalizada por WhatsApp',
                        ],
                    ],
                    [
                        'type' => 'flash_deals',
                        'is_visible' => true,
                        'title' => 'Ofertas Relámpago en Joyería & Calzado',
                        'data' => [
                            'eyebrow' => '¡Precios de Lanzamiento!',
                            'title' => 'Descuentos de Temporada D & R',
                            'subtitle' => 'Aprovecha hasta 25% de descuento en piezas seleccionadas antes de que termine el temporizador.',
                            'discount_badge' => '25% OFF',
                            'hours_duration' => 8,
                            'btn_text' => 'Aprovechar Descuento',
                        ],
                    ],
                    [
                        'type' => 'categories',
                        'is_visible' => true,
                        'title' => 'Explorar por Colección',
                        'data' => [
                            'eyebrow' => 'Nuestras Categorías',
                        ],
                    ],
                    [
                        'type' => 'featured_products',
                        'is_visible' => true,
                        'title' => 'Los Más Deseados de la Semana',
                        'data' => [
                            'eyebrow' => 'Tendencias D & R',
                            'limit' => 8,
                        ],
                    ],
                    [
                        'type' => 'full_catalog',
                        'is_visible' => true,
                        'title' => 'Catálogo Completo',
                        'data' => [
                            'eyebrow' => 'Colección Disponible',
                        ],
                    ],
                    [
                        'type' => 'about_story',
                        'is_visible' => true,
                        'title' => 'Nuestra Historia - D & R CONCEPTOS',
                        'data' => [
                            'eyebrow' => 'Pasión por el Detalle',
                            'title' => 'Diseño, Brillo y Estilo en Zacatecas',
                            'content' => 'En D & R CONCEPTOS (@conceptos.7) creemos que cada mujer merece brillar con piezas que resalten su personalidad. Nacimos en el corazón de Zacatecas con la ilusión de reunir en un solo lugar la mejor joyería, calzado cómodo y elegante, y prendas en tendencia seleccionadas con amor.',
                            'image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=800&q=80',
                            'badge' => 'Boutique Zacatecana',
                        ],
                    ],
                    [
                        'type' => 'map_location',
                        'is_visible' => true,
                        'title' => 'Visita Nuestra Sucursal en Zacatecas Centro',
                        'data' => [
                            'eyebrow' => 'Punto de Encuentro',
                            'title' => 'Calle Tacuba, Centro Histórico',
                            'note' => 'Pasa a probarte tus prendas y accesorios favoritos. Estamos a media cuadra de Plaza Bicentenario y Catedral.',
                        ],
                    ],
                    [
                        'type' => 'testimonials',
                        'is_visible' => true,
                        'title' => 'Lo que dicen nuestras clientas',
                        'data' => [
                            'eyebrow' => 'Opiniones Verificadas',
                        ],
                    ],
                    [
                        'type' => 'contact_box',
                        'is_visible' => true,
                        'title' => '¿Tienes dudas sobre tallas o existencias?',
                        'data' => [
                            'eyebrow' => 'Atención Directa',
                            'subtitle' => 'Contáctanos directamente por WhatsApp o DM en Instagram para asesoría personalizada al instante.',
                        ],
                    ],
                ],
                'categories' => [
                    [
                        'name' => 'Joyería y Accesorio ✨',
                        'slug' => 'joyeria-y-accesorios',
                        'description' => 'Gargantillas, aretes, pulseras y anillos en chapa de oro 14K y plata fina.',
                    ],
                    [
                        'name' => 'Ropa & Tendencia 👗',
                        'slug' => 'ropa-y-tendencia',
                        'description' => 'Prendas de temporada, vestidos satinados, sastrería femenina y tops en tendencia.',
                    ],
                    [
                        'name' => 'Calzado & Tacones 👠',
                        'slug' => 'calzado-y-tacones',
                        'description' => 'Zapatillas de tacón, mules destalonados y sandalias de plataforma confort.',
                    ],
                    [
                        'name' => 'Bolsos & Complementos 👜',
                        'slug' => 'bolsos-y-complementos',
                        'description' => 'Bolsos crossbody, clutches de noche y carteras en tonos neutros.',
                    ],
                ],
            ],
        ];

        // 2. Create Tenant if not exists, and Configure Isolated Database
        foreach ($businesses as $biz) {
            $tenantId = $biz['id'];

            // Find or Create Tenant (do NOT overwrite or wipe)
            $tenant = Tenant::find($tenantId);
            if (! $tenant) {
                $tenant = Tenant::create([
                    'id' => $tenantId,
                    'plan_name' => $biz['plan_name'],
                    'billing_cycle' => $biz['billing_cycle'],
                    'subscription_status' => 'active',
                    'subscription_amount' => $biz['subscription_amount'],
                    'subscription_ends_at' => now()->addYear(),
                    'address' => $biz['address'],
                    'neighborhood_zone' => $biz['neighborhood_zone'],
                    'city' => $biz['city'],
                    'latitude' => $biz['latitude'],
                    'longitude' => $biz['longitude'],
                    'maps_url' => $biz['maps_url'],
                    'opening_hours' => $biz['opening_hours'],
                    'location_reference' => $biz['location_reference'],
                ]);
            }

            // Assign Domains (standard + aliases)
            $domains = [
                $tenantId,
                "{$tenantId}.localhost",
                "{$tenantId}.atelier-zacatecas.onrender.com",
                "{$tenantId}.192.168.0.128.nip.io",
                'conceptos',
                'conceptos.localhost',
                'conceptos.atelier-zacatecas.onrender.com',
                'conceptos-7',
                'conceptos-7.localhost',
                'conceptos-7.atelier-zacatecas.onrender.com',
            ];

            foreach (array_unique($domains) as $dom) {
                try {
                    if (! $tenant->domains()->where('domain', $dom)->exists()) {
                        $tenant->createDomain($dom);
                    }
                } catch (\Throwable $e) {}
            }

            // Seed Tenant Isolated DB
            $tenant->run(function () use ($biz, $sampleSlugs) {
                // Ensure StoreSetting
                StoreSetting::updateOrCreate(
                    ['id' => 1],
                    [
                        'store_name' => $biz['store_name'],
                        'business_category' => $biz['business_category'],
                        'tagline' => $biz['tagline'],
                        'logo_url' => $biz['logo_url'],
                        'banner_url' => $biz['banner_url'],
                        'primary_color' => $biz['primary_color'],
                        'secondary_color' => $biz['secondary_color'],
                        'font_family' => 'DM Sans',
                        'hero_title' => $biz['hero_title'],
                        'hero_subtitle' => $biz['hero_subtitle'],
                        'hero_button_text' => 'Explorar Colección',
                        'show_announcement' => true,
                        'announcement_text' => $biz['announcement_text'],
                        'whatsapp_number' => $biz['whatsapp_number'],
                        'facebook_url' => $biz['facebook_url'],
                        'instagram_url' => $biz['instagram_url'],
                        'official_website_url' => $biz['official_website_url'],
                        'address' => $biz['address'],
                        'neighborhood_zone' => $biz['neighborhood_zone'],
                        'city' => $biz['city'],
                        'latitude' => $biz['latitude'],
                        'longitude' => $biz['longitude'],
                        'maps_url' => $biz['maps_url'],
                        'opening_hours' => $biz['opening_hours'],
                        'location_reference' => $biz['location_reference'],
                        'contact_email' => $biz['contact_email'],
                        'footer_text' => '© ' . date('Y') . ' ' . $biz['store_name'] . ' (@conceptos.7) · Zacatecas Centro, Zac.',
                        'layout_blocks' => $biz['layout_blocks'],
                    ]
                );

                // Create Admin & Staff Users
                $storeUsers = [
                    [
                        'email' => $biz['admin_email'],
                        'name' => $biz['admin_name'],
                        'password' => 'password123',
                    ],
                    [
                        'email' => 'gerencia@conceptos7.com',
                        'name' => 'Gerencia Boutique D & R',
                        'password' => 'password123',
                    ],
                    [
                        'email' => 'ventas@conceptos7.com',
                        'name' => 'Asesora de Estilo y Ventas D & R',
                        'password' => 'password123',
                    ],
                ];

                foreach ($storeUsers as $u) {
                    TenantUser::updateOrCreate(
                        ['email' => $u['email']],
                        [
                            'name' => $u['name'],
                            'password' => Hash::make($u['password']),
                            'customer_account_id' => null,
                        ]
                    );
                }

                // Populate Categories only (NO dummy products; store starts clean for user to add products)
                foreach ($biz['categories'] as $catData) {
                    Category::firstOrCreate(
                        ['slug' => $catData['slug']],
                        [
                            'name' => $catData['name'],
                            'description' => $catData['description'] ?? null,
                        ]
                    );
                }

                // Delete any previous sample products so user has a clean catalog
                Product::whereIn('slug', $sampleSlugs)->delete();
            });
        }

        // 4. Clear all relevant caches
        \Illuminate\Support\Facades\Cache::flush();
    }
}
