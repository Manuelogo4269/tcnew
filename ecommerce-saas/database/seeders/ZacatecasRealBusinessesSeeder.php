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
        // 1. Delete all existing tenants and their domains
        $existingTenants = Tenant::all();
        foreach ($existingTenants as $t) {
            try {
                $t->domains()->delete();
                $t->delete();
            } catch (\Throwable $e) {
                // Ignore if already deleted
            }
        }

        // Clean up leftover sqlite files in database/ matching tenant_*.sqlite
        $sqliteFiles = File::glob(database_path('tenant_*.sqlite'));
        foreach ($sqliteFiles as $file) {
            @unlink($file);
        }

        // 2. Definition of the Single New Business: D & R CONCEPTOS (@conceptos.7)
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
                        'products' => [
                            [
                                'name' => 'Gargantilla Chapa de Oro 14K con Circonia Solitaria',
                                'slug' => 'gargantilla-oro-14k-solitaria',
                                'description' => 'Cadena de tejido fino con dije de circonia corte brillante, hipoalergénica con baño protector.',
                                'price' => 480.00,
                                'stock' => 35,
                                'image_url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Aretes Huggies Doble Aro con Incrustaciones Brillantes',
                                'slug' => 'aretes-huggies-doble-aro',
                                'description' => 'Aretes pequeños tipo huggie con cierre de clic y micro pavé de circonias.',
                                'price' => 320.00,
                                'stock' => 50,
                                'image_url' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Brazalete Eslabón Veneciano Ajustable con Dijes',
                                'slug' => 'brazalete-eslabon-veneciano',
                                'description' => 'Pulsera ajustable para cualquier muñeca con eslabones pulidos de alto brillo.',
                                'price' => 450.00,
                                'stock' => 40,
                                'image_url' => 'https://images.unsplash.com/photo-1611591475871-70bf89366113?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Anillo Ajustable Twist en Plata Fina y Oro',
                                'slug' => 'anillo-ajustable-twist-oro',
                                'description' => 'Anillo de diseño cruzado entrelazado, adaptable a cualquier medida con acabado espejado.',
                                'price' => 390.00,
                                'stock' => 30,
                                'image_url' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Set de Cadenas Layering con Medalla Minimalista',
                                'slug' => 'set-cadenas-layering-medalla',
                                'description' => 'Dúo de collares combinados para escote en tendencia, look moderno y sofisticado.',
                                'price' => 550.00,
                                'stock' => 25,
                                'image_url' => 'https://images.unsplash.com/photo-1599643477877-530eb83abc8e?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Ropa & Tendencia 👗',
                        'slug' => 'ropa-y-tendencia',
                        'description' => 'Prendas de temporada, vestidos satinados, sastrería femenina y tops en tendencia.',
                        'products' => [
                            [
                                'name' => 'Vestido Midi Satinado con Espalda Abierta',
                                'slug' => 'vestido-midi-satinado-espalda-abierta',
                                'description' => 'Vestido en satín sedoso con caída fluida, escote drapeado y tirantes ajustables cruzados.',
                                'price' => 890.00,
                                'stock' => 20,
                                'image_url' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Conjunto Sastreado Blazer Crop & Pantalón Wide Leg',
                                'slug' => 'conjunto-blazer-crop-wide-leg',
                                'description' => 'Set de dos piezas en mezcla de lino de verano con corte estructurado contemporáneo.',
                                'price' => 1290.00,
                                'stock' => 15,
                                'image_url' => 'https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Top Elegante Cuello Halter en Lino Suave',
                                'slug' => 'top-cuello-halter-lino-suave',
                                'description' => 'Top sin mangas de silueta favorecedora ideal para combinar con faldas y palazzos.',
                                'price' => 450.00,
                                'stock' => 35,
                                'image_url' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Falda Plisada de Tiro Alto Color Champaña',
                                'slug' => 'falda-plisada-tiro-alto-champana',
                                'description' => 'Falda midi con pretina elástica y tejido satinado plisado con movimiento espectacular.',
                                'price' => 580.00,
                                'stock' => 25,
                                'image_url' => 'https://images.unsplash.com/photo-1583496661160-fb5886a0aaaa?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Calzado & Tacones 👠',
                        'slug' => 'calzado-y-tacones',
                        'description' => 'Zapatillas de tacón, mules destalonados y sandalias de plataforma confort.',
                        'products' => [
                            [
                                'name' => 'Zapatillas de Tacón Fino y Tira Minimalista',
                                'slug' => 'zapatillas-tacon-fino-tira-minimalista',
                                'description' => 'Tacón de 8 cm con plantilla acojinada y pulsera al tobillo para máxima seguridad.',
                                'price' => 850.00,
                                'stock' => 25,
                                'image_url' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Mules en Punta con Herraje Metálico Joya',
                                'slug' => 'mules-punta-herraje-joya',
                                'description' => 'Zapato plano destalonado en piel sintética suave con hebilla decorativa brillante.',
                                'price' => 780.00,
                                'stock' => 30,
                                'image_url' => 'https://images.unsplash.com/photo-1535043934128-cf0b28d52f95?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Sandalias de Plataforma en Tonos Neutros',
                                'slug' => 'sandalias-plataforma-tonos-neutros',
                                'description' => 'Plataforma ligera de 6 cm con correas suaves para caminar cómodo por Zacatecas Centro.',
                                'price' => 690.00,
                                'stock' => 20,
                                'image_url' => 'https://images.unsplash.com/photo-1562273138-f46be4ebdf33?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Bolsos & Complementos 👜',
                        'slug' => 'bolsos-y-complementos',
                        'description' => 'Bolsos crossbody, clutches de noche y carteras en tonos neutros.',
                        'products' => [
                            [
                                'name' => 'Bolso Bandolera Acolchado con Cadena Dorada',
                                'slug' => 'bolso-bandolera-acolchado-cadena-dorada',
                                'description' => 'Diseño acolchado con solapa magnética, compartimento interior con cremallera y herrajes dorados.',
                                'price' => 680.00,
                                'stock' => 20,
                                'image_url' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Clutch de Mano Rígido para Noche y Eventos',
                                'slug' => 'clutch-mano-rigido-noche',
                                'description' => 'Bolso de fiesta con textura nacarada y broche metálico superior, incluye cadena opcional.',
                                'price' => 540.00,
                                'stock' => 15,
                                'image_url' => 'https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // 3. Create Tenant and Populate Isolated Database
        foreach ($businesses as $biz) {
            $tenantId = $biz['id'];

            // Create Tenant
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
                    $tenant->createDomain($dom);
                } catch (\Throwable $e) {}
            }

            // Seed Tenant Isolated DB
            $tenant->run(function () use ($biz) {
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

                // Populate Categories & Products
                foreach ($biz['categories'] as $catData) {
                    $category = Category::updateOrCreate(
                        ['slug' => $catData['slug']],
                        [
                            'name' => $catData['name'],
                            'description' => $catData['description'],
                        ]
                    );

                    foreach ($catData['products'] as $prodData) {
                        Product::updateOrCreate(
                            ['slug' => $prodData['slug']],
                            [
                                'category_id' => $category->id,
                                'name' => $prodData['name'],
                                'description' => $prodData['description'],
                                'price' => $prodData['price'],
                                'stock' => $prodData['stock'] ?? 30,
                                'image_url' => $prodData['image_url'],
                                'is_active' => true,
                            ]
                        );
                    }
                }
            });
        }

        // 4. Clear all relevant caches
        \Illuminate\Support\Facades\Cache::flush();
    }
}
