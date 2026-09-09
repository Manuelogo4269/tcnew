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
                // Ignore if db file already removed
            }
        }

        // Clean up leftover sqlite files in database/ matching tenant_*.sqlite
        $sqliteFiles = File::glob(database_path('tenant_*.sqlite'));
        foreach ($sqliteFiles as $file) {
            @unlink($file);
        }

        // 2. Definition of 6 Real Iconic Businesses in Zacatecas Centro
        $businesses = [
            [
                'id' => 'acropolis',
                'store_name' => 'Café Acrópolis',
                'business_category' => 'Bebidas y Alimentos',
                'plan_name' => 'Corporativo',
                'billing_cycle' => 'annual',
                'subscription_amount' => 852.00,
                'tagline' => 'La cafetería y galería de arte más emblemática de Zacatecas desde 1943.',
                'address' => 'Av. Hidalgo s/n, esq. Plazuela Goitia (Portal de Rosales), Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Portal de Rosales',
                'city' => 'Zacatecas',
                'latitude' => 22.77265,
                'longitude' => -102.57315,
                'maps_url' => 'https://maps.google.com/?q=22.77265,-102.57315',
                'opening_hours' => 'Lunes a Domingo: 8:00 AM - 10:30 PM',
                'location_reference' => 'Junto al Mercado González Ortega y frente al Teatro Calderón',
                'primary_color' => '#8b1e1e',
                'secondary_color' => '#fbf8f3',
                'logo_url' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=1200&q=80',
                'hero_title' => "Café Acrópolis\nTradición y Arte desde 1943",
                'hero_subtitle' => 'Un espacio histórico en el corazón de Zacatecas donde convergen el aroma del mejor café de altura, gastronomía típica y obras de arte universales.',
                'announcement_text' => '☕ ¡Visítanos en Portal de Rosales frente al Teatro Calderón! Desayunos tradicionales todos los días.',
                'contact_email' => 'contacto@cafeacropolis.com.mx',
                'whatsapp_number' => '+52 492 922 1284',
                'facebook_url' => 'https://www.facebook.com/cafeacropoliszacatecas/',
                'instagram_url' => 'https://www.instagram.com/cafeacropolis/',
                'official_website_url' => 'https://www.cafeacropolis.com.mx',
                'admin_name' => 'Gerencia Café Acrópolis',
                'admin_email' => 'admin@acropolis.com',
                'categories' => [
                    [
                        'name' => 'Café de Altura y Bebidas Especiales',
                        'slug' => 'cafe-y-bebidas',
                        'description' => 'Granos selectos tostados artesanalmente para preparaciones frías y calientes.',
                        'products' => [
                            [
                                'name' => 'Café Americano Selección Acrópolis',
                                'slug' => 'cafe-americano-seleccion-acropolis',
                                'description' => 'Mezcla exclusiva de café arábica con notas a chocolate y avellana tostada.',
                                'price' => 48.00,
                                'stock' => 100,
                                'image_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Capuchino Especial con Cajeta Envinada de Jerez',
                                'slug' => 'capuchino-cajeta-jerez',
                                'description' => 'Espresso doble, leche vaporizada y dulce de cajeta zacatecana con toque de canela.',
                                'price' => 72.00,
                                'stock' => 80,
                                'image_url' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Chocolate Caliente Artesanal a la Francesa',
                                'slug' => 'chocolate-caliente-artesanal',
                                'description' => 'Elaborado con cacao criollo mexicano y leche entera con espuma cremosa.',
                                'price' => 65.00,
                                'stock' => 50,
                                'image_url' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Repostería Fina y Postres Típicos',
                        'slug' => 'reposteria-fina',
                        'description' => 'Pasteles y recetas tradicionales zacatecanas horneadas a diario.',
                        'products' => [
                            [
                                'name' => 'Pastel Tradicional de Guayaba con Queso Zacatecano',
                                'slug' => 'pastel-guayaba-queso',
                                'description' => 'El postre insignia de Acrópolis: mermelada de guayaba de Jalpa y queso crema sedoso.',
                                'price' => 85.00,
                                'stock' => 40,
                                'image_url' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Tarta Rústica de Frutos Rojos y Canela',
                                'slug' => 'tarta-rustica-frutos-rojos',
                                'description' => 'Masa quebrada de mantequilla rellena de zarzamora, fresa y arándano fresco.',
                                'price' => 80.00,
                                'stock' => 35,
                                'image_url' => 'https://images.unsplash.com/photo-1519915028121-7d3463d20b13?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Gastronomía Típica y Almuerzos',
                        'slug' => 'gastronomia-tipica',
                        'description' => 'Platillos con sazón colonial y recetas centenarias.',
                        'products' => [
                            [
                                'name' => 'Enchiladas Zacatecanas al Estilo Don Said',
                                'slug' => 'enchiladas-zacatecanas-don-said',
                                'description' => 'Tortillas bañadas en salsa de chile poblano con nata y rellenas de lomo de cerdo.',
                                'price' => 165.00,
                                'stock' => 60,
                                'image_url' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Omelette Minero con Champiñones y Queso Oaxaca',
                                'slug' => 'omelette-minero',
                                'description' => 'Acompañado de frijoles refritos criollos y totopos de maíz caseros.',
                                'price' => 135.00,
                                'stock' => 45,
                                'image_url' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                ],
            ],

            [
                'id' => 'donajulia',
                'store_name' => 'Gorditas Doña Julia',
                'business_category' => 'Bebidas y Alimentos',
                'plan_name' => 'Crecimiento',
                'billing_cycle' => 'monthly',
                'subscription_amount' => 39.00,
                'tagline' => 'El sabor auténtico de Zacatecas: gorditas hechas a mano con guisados al comal.',
                'address' => 'Av. Hidalgo #409, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Av. Hidalgo',
                'city' => 'Zacatecas',
                'latitude' => 22.77380,
                'longitude' => -102.57300,
                'maps_url' => 'https://maps.google.com/?q=22.77380,-102.57300',
                'opening_hours' => 'Lunes a Domingo: 7:30 AM - 7:00 PM',
                'location_reference' => 'Sobre Av. Hidalgo a unos pasos del Callejón de la Palma',
                'primary_color' => '#d9531e',
                'secondary_color' => '#fff9f2',
                'logo_url' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80',
                'hero_title' => "Gorditas Doña Julia\nSabor de Tradición Zacatecana",
                'hero_subtitle' => 'El referente gastronómico de Zacatecas Centro. Gorditas de maíz recién salidas del comal rellenas de auténticos guisados típicos.',
                'announcement_text' => '🌮 ¡Gorditas de Asado de Boda y Chicharrón recién hechecitas! Servicio para comer aquí o para llevar.',
                'contact_email' => 'pedidos@gorditasdonajulia.com.mx',
                'whatsapp_number' => '+52 492 922 8392',
                'facebook_url' => 'https://www.facebook.com/GorditasDonaJulia/',
                'instagram_url' => 'https://www.instagram.com/gorditasdonajulia/',
                'official_website_url' => 'https://www.gorditasdonajulia.com.mx',
                'admin_name' => 'Administrador Gorditas Doña Julia',
                'admin_email' => 'admin@donajulia.com',
                'categories' => [
                    [
                        'name' => 'Gorditas Típicas al Comal',
                        'slug' => 'gorditas-comal',
                        'description' => 'Masa de maíz criollo cocida a la plancha y rellena generosamente.',
                        'products' => [
                            [
                                'name' => 'Gordita de Asado de Boda Zacatecano',
                                'slug' => 'gordita-asado-de-boda',
                                'description' => 'Carne de cerdo suave en adobo tradicional con chocolate, naranja y chiles secos.',
                                'price' => 35.00,
                                'stock' => 150,
                                'image_url' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Gordita de Chicharrón Prensado en Salsa Roja',
                                'slug' => 'gordita-chicharron-prensado',
                                'description' => 'Chicharrón de cerdo sazonado a fuego lento en salsa martajada de jitomate y serrano.',
                                'price' => 35.00,
                                'stock' => 120,
                                'image_url' => 'https://images.unsplash.com/photo-1613514785940-daed07799d9b?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Gordita de Deshebrada con Chile Pasilla',
                                'slug' => 'gordita-deshebrada-pasilla',
                                'description' => 'Fina falda de res deshebrada cocinada con cebolla y chile pasilla aromatizado.',
                                'price' => 35.00,
                                'stock' => 100,
                                'image_url' => 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Gordita de Frijoles Refritos con Queso y Rajas',
                                'slug' => 'gordita-frijoles-queso-rajas',
                                'description' => 'Frijol bayo refrito en manteca con queso fresco de rancho y rajas poblanas.',
                                'price' => 32.00,
                                'stock' => 80,
                                'image_url' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Paquetes Especiales y Bebidas',
                        'slug' => 'paquetes-y-bebidas',
                        'description' => 'Combos completos para disfrutar en familia o en la oficina.',
                        'products' => [
                            [
                                'name' => 'Paquete Zacatecano (5 Gorditas Surtidas + Agua Fresca)',
                                'slug' => 'paquete-zacatecano-5-gorditas',
                                'description' => 'Elige tus 5 guisados favoritos acompañado de 1 litro de agua fresca natural.',
                                'price' => 195.00,
                                'stock' => 60,
                                'image_url' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Agua Fresca Natural de Horchata con Canela 1L',
                                'slug' => 'agua-horchata-canela',
                                'description' => 'Preparada con arroz, leche condensada, vainilla y canela molida.',
                                'price' => 45.00,
                                'stock' => 90,
                                'image_url' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                ],
            ],

            [
                'id' => 'rosadeplata',
                'store_name' => 'Platería Rosa de Plata',
                'business_category' => 'Moda y Lujo',
                'plan_name' => 'Corporativo',
                'billing_cycle' => 'annual',
                'subscription_amount' => 852.00,
                'tagline' => 'Joyería fina en plata ley .925 cincelada a mano por maestros plateros de Zacatecas.',
                'address' => 'Av. Hidalgo #615, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Centro Histórico',
                'city' => 'Zacatecas',
                'latitude' => 22.77490,
                'longitude' => -102.57270,
                'maps_url' => 'https://maps.google.com/?q=22.77490,-102.57270',
                'opening_hours' => 'Lunes a Sábado: 10:00 AM - 8:30 PM, Domingo: 11:00 AM - 6:00 PM',
                'location_reference' => 'Frente a la majestuosa Catedral Basílica de Zacatecas',
                'primary_color' => '#233246',
                'secondary_color' => '#f5f7fa',
                'logo_url' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=1200&q=80',
                'hero_title' => "Plata Ley .925 de Zacatecas\nHerencia y Alta Orfebrería",
                'hero_subtitle' => 'Piezas exclusivas con certificado de autenticidad inspiradas en la arquitectura barroca y cantera rosa de nuestra ciudad.',
                'announcement_text' => '💍 Envíos asegurados a todo México y garantía de por vida en pulido de plata ley .925.',
                'contact_email' => 'joyas@platarealzacatecas.mx',
                'whatsapp_number' => '+52 492 922 4580',
                'facebook_url' => 'https://www.facebook.com/PlataRealZacatecas/',
                'instagram_url' => 'https://www.instagram.com/platarealzacatecas/',
                'official_website_url' => 'https://www.platarealzacatecas.mx',
                'admin_name' => 'Gerencia Rosa de Plata',
                'admin_email' => 'admin@rosadeplata.com',
                'categories' => [
                    [
                        'name' => 'Dijes y Collares Coloniales',
                        'slug' => 'dijes-y-collares',
                        'description' => 'Diseños emblemáticos inspirados en monumentos y símbolos zacatecanos.',
                        'products' => [
                            [
                                'name' => 'Dije Catedral Basílica en Plata Ley .925',
                                'slug' => 'dije-catedral-basilica-plata',
                                'description' => 'Relieve minucioso de la fachada barroca con cadena de eslabones incluida.',
                                'price' => 490.00,
                                'stock' => 40,
                                'image_url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Collar Filigrana San Cristóbal en Plata Pura',
                                'slug' => 'collar-filigrana-san-cristobal',
                                'description' => 'Tejido de hilos finos de plata oxidada al estilo colonial del siglo XVIII.',
                                'price' => 850.00,
                                'stock' => 25,
                                'image_url' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Anillos y Pulseras de Autor',
                        'slug' => 'anillos-y-pulseras',
                        'description' => 'Joyería moderna forjada con precisión por plateros zacatecanos.',
                        'products' => [
                            [
                                'name' => 'Anillo Rosa de Plata con Circonia Fina',
                                'slug' => 'anillo-rosa-de-plata-circonia',
                                'description' => 'Forma de pétalos de rosa con piedra circonia cúbica corte diamante.',
                                'price' => 680.00,
                                'stock' => 30,
                                'image_url' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Pulsera Escalonada de Plata Maciza Barrenada',
                                'slug' => 'pulsera-escalonada-plata-maciza',
                                'description' => 'Acabado espejo de alta durabilidad con cierre de caja reforzado de seguridad.',
                                'price' => 1250.00,
                                'stock' => 18,
                                'image_url' => 'https://images.unsplash.com/photo-1611591477983-9b98ec3a9f0e?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Mancuernillas de Plata Escudo Histórico de Zacatecas',
                                'slug' => 'mancuernillas-plata-escudo-zacatecas',
                                'description' => 'Detalle de lujo para camisas de vestir con grabado en bajo relieve del escudo real.',
                                'price' => 790.00,
                                'stock' => 22,
                                'image_url' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                ],
            ],

            [
                'id' => 'elserranito',
                'store_name' => 'Dulces Típicos El Serranito',
                'business_category' => 'Hogar y Decoración',
                'plan_name' => 'Crecimiento',
                'billing_cycle' => 'annual',
                'subscription_amount' => 372.00,
                'tagline' => 'Tradición dulce zacatecana: quesos de tuna, ates, cajetas de Jerez y recuerdos.',
                'address' => 'Calle Tacuba #142, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Calle Tacuba',
                'city' => 'Zacatecas',
                'latitude' => 22.77290,
                'longitude' => -102.57245,
                'maps_url' => 'https://maps.google.com/?q=22.77290,-102.57245',
                'opening_hours' => 'Lunes a Domingo: 9:00 AM - 9:00 PM',
                'location_reference' => 'Andador peatonal Tacuba, a media cuadra de Plazuela Goitia',
                'primary_color' => '#a3411a',
                'secondary_color' => '#fff8ed',
                'logo_url' => 'https://images.unsplash.com/photo-1582293041079-7814c2f12063?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1534432182912-63863115e106?auto=format&fit=crop&w=1200&q=80',
                'hero_title' => "Dulces Típicos El Serranito\nEl Dulce Encanto de Zacatecas",
                'hero_subtitle' => 'Elaboración 100% artesanal con recetas campiranas de ates de guayaba, queso de tuna cardona, cajetas al vino y artesanías de cantera rosa.',
                'announcement_text' => '🍬 Canastas típicas para regalo y pedidos especiales de dulces zacatecanos.',
                'contact_email' => 'ventas@dulceselserranito.com',
                'whatsapp_number' => '+52 492 922 1735',
                'facebook_url' => 'https://www.facebook.com/DulcesElSerranitoZac/',
                'instagram_url' => 'https://www.instagram.com/dulcestipicoselserranito/',
                'official_website_url' => 'https://www.dulceselserranito.com',
                'admin_name' => 'Encargado El Serranito',
                'admin_email' => 'admin@elserranito.com',
                'categories' => [
                    [
                        'name' => 'Dulces de Tuna y Frutas Regionales',
                        'slug' => 'dulces-de-tuna',
                        'description' => 'Tradición del semidesierto zacatecano concentrada al cobre.',
                        'products' => [
                            [
                                'name' => 'Queso de Tuna Tradicional de Nochtli 500g',
                                'slug' => 'queso-de-tuna-500g',
                                'description' => 'Dulce natural de jugo de tuna cardona roja cocido lentamente hasta espesar.',
                                'price' => 120.00,
                                'stock' => 80,
                                'image_url' => 'https://images.unsplash.com/photo-1582293041079-7814c2f12063?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Bloque de Ate de Guayaba Artesanal con Nueces 1kg',
                                'slug' => 'ate-guayaba-con-nuez-1kg',
                                'description' => 'Elaborado con guayabas del cañón de Juchipila y nuez pecana troceada.',
                                'price' => 95.00,
                                'stock' => 110,
                                'image_url' => 'https://images.unsplash.com/photo-1576618148400-f54bed99fcfd?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Cajetas de Jerez y Charamuscas',
                        'slug' => 'cajetas-y-charamuscas',
                        'description' => 'Repostería y dulces conmemorativos de los pueblos mágicos.',
                        'products' => [
                            [
                                'name' => 'Cajeta Envinada Tradicional de Jerez 600g',
                                'slug' => 'cajeta-envinada-jerez-600g',
                                'description' => 'Leche de cabra fresca quemada en cazo de cobre con ron añejo de caña.',
                                'price' => 140.00,
                                'stock' => 65,
                                'image_url' => 'https://images.unsplash.com/photo-1587314168485-3236d6710814?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Charamuscas Zacatecanas de Piloncillo y Coco',
                                'slug' => 'charamuscas-piloncillo-coco',
                                'description' => 'Figuras retorcidas a mano en caramelo de piloncillo espolvoreadas con coco tostado.',
                                'price' => 75.00,
                                'stock' => 90,
                                'image_url' => 'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Canasta Típica Surtida de Dulces Regionales',
                                'slug' => 'canasta-tipica-surtida-dulces',
                                'description' => 'Canasta tejida de mimbre con alfajores, rollos de guayaba, tamarindos y jamoncillos.',
                                'price' => 260.00,
                                'stock' => 45,
                                'image_url' => 'https://images.unsplash.com/photo-1534432182912-63863115e106?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                ],
            ],

            [
                'id' => 'quinceletras',
                'store_name' => 'Las Quince Letras',
                'business_category' => 'Bebidas y Alimentos',
                'plan_name' => 'Emprendedor',
                'billing_cycle' => 'monthly',
                'subscription_amount' => 19.00,
                'tagline' => 'La cantina más legendaria de Zacatecas desde 1906. Maestros del mezcal artesanal.',
                'address' => 'Calle Mártires de Chicago #309, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Av. Juárez',
                'city' => 'Zacatecas',
                'latitude' => 22.77120,
                'longitude' => -102.57410,
                'maps_url' => 'https://maps.google.com/?q=22.77120,-102.57410',
                'opening_hours' => 'Lunes a Sábado: 1:00 PM - 10:30 PM',
                'location_reference' => 'Esquina emblemática de Calle Mártires de Chicago y San Antonio',
                'primary_color' => '#1a4329',
                'secondary_color' => '#f6f9f5',
                'logo_url' => 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1514933651103-005eec06c04b?auto=format&fit=crop&w=1200&q=80',
                'hero_title' => "Cantina Las Quince Letras\n120 Años de Tradición Mezcalera",
                'hero_subtitle' => 'Fundada en 1906, el templo del mezcal zacatecano y el punto de encuentro bohemio por excelencia en el centro histórico.',
                'announcement_text' => '🥃 Catas guiadas de mezcal silvestre y botellas conmemorativas para coleccionistas.',
                'contact_email' => 'cantina@lasquinceletras.com',
                'whatsapp_number' => '+52 492 922 2541',
                'facebook_url' => 'https://www.facebook.com/LasQuinceLetrasZacatecas/',
                'instagram_url' => 'https://www.instagram.com/lasquinceletraszac/',
                'official_website_url' => 'https://www.lasquinceletras.com',
                'admin_name' => 'Cantinero Mayor Las Quince Letras',
                'admin_email' => 'admin@quinceletras.com',
                'categories' => [
                    [
                        'name' => 'Mezcales Zacatecanos de Autor',
                        'slug' => 'mezcales-artesanales',
                        'description' => 'Destilados de maguey Tequilana Weber y Salmiana elaborados en palenques locales.',
                        'products' => [
                            [
                                'name' => 'Botella Mezcal Tradicional Maguey Tequilana 750ml',
                                'slug' => 'mezcal-tradicional-750ml',
                                'description' => 'Destilado en alambique de cobre, notas terrosas y ahumadas características.',
                                'price' => 420.00,
                                'stock' => 50,
                                'image_url' => 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Mezcal Silvestre Reposado en Roble Blanco 750ml',
                                'slug' => 'mezcal-silvestre-reposado',
                                'description' => 'Madurado 8 meses en barrica, suavidad al paladar y tonos de vainilla y cedro.',
                                'price' => 560.00,
                                'stock' => 35,
                                'image_url' => 'https://images.unsplash.com/photo-1569529465841-dfecdab7503b?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Licor Artesanal de Agave y Frutas del Semidesierto 500ml',
                                'slug' => 'licor-artesanal-agave',
                                'description' => 'Maceración de frutos rojos zacatecanos y maguey cocido.',
                                'price' => 290.00,
                                'stock' => 40,
                                'image_url' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Souvenirs Cantineros y Botanas',
                        'slug' => 'souvenirs-y-botanas',
                        'description' => 'Artículos de colección de la cantina más antigua de Zacatecas.',
                        'products' => [
                            [
                                'name' => 'Jarrito Cantinero de Barro Las Quince Letras',
                                'slug' => 'jarrito-cantinero-barro',
                                'description' => 'Jarrito conmemorativo esmaltado ideal para degustar mezcal con rodaja de naranja.',
                                'price' => 110.00,
                                'stock' => 120,
                                'image_url' => 'https://images.unsplash.com/photo-1514933651103-005eec06c04b?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Sal de Gusano de Maguey con Chiles Zacatecanos 150g',
                                'slug' => 'sal-de-gusano-150g',
                                'description' => 'Sal artesanal marina molida con gusano de maguey y chiles secos tostados.',
                                'price' => 85.00,
                                'stock' => 70,
                                'image_url' => 'https://images.unsplash.com/photo-1532336414038-cf19250c5757?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                ],
            ],

            [
                'id' => 'libreriaandrea',
                'store_name' => 'Librería André-a',
                'business_category' => 'Tecnología y Gadgets',
                'plan_name' => 'Emprendedor',
                'billing_cycle' => 'annual',
                'subscription_amount' => 180.00,
                'tagline' => 'Libros de historia colonial de Zacatecas, novela, poesía, arte y papelería fina.',
                'address' => 'Calle Fernando Villalpando #403, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Calle Tacuba',
                'city' => 'Zacatecas',
                'latitude' => 22.77180,
                'longitude' => -102.57350,
                'maps_url' => 'https://maps.google.com/?q=22.77180,-102.57350',
                'opening_hours' => 'Lunes a Sábado: 9:30 AM - 8:00 PM',
                'location_reference' => 'Frente a la Rectoría de la UAZ y a pasos del Teatro Calderón',
                'primary_color' => '#293c52',
                'secondary_color' => '#f8fafc',
                'logo_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80',
                'hero_title' => "Librería & Espacio André-a\nCultura y Letras en el Centro",
                'hero_subtitle' => 'El rincón de los amantes de la lectura, ediciones especiales sobre Zacatecas virreinal, literatura universal y cuadernos de piel hechos a mano.',
                'announcement_text' => '📚 Novedades editoriales semanales y títulos de autores zacatecanos.',
                'contact_email' => 'libros@libreriaandrea.com',
                'whatsapp_number' => '+52 492 922 6814',
                'facebook_url' => 'https://www.facebook.com/libreriaandreazac/',
                'instagram_url' => 'https://www.instagram.com/libreria_andrea_zac/',
                'official_website_url' => 'https://www.libreriaandrea.com',
                'admin_name' => 'Librero Mayor André-a',
                'admin_email' => 'admin@libreriaandrea.com',
                'categories' => [
                    [
                        'name' => 'Historia y Literatura de Zacatecas',
                        'slug' => 'historia-zacatecas',
                        'description' => 'Obras de investigación histórica, crónicas de minas y poetas zacatecanos.',
                        'products' => [
                            [
                                'name' => 'Libro: Historia de las Minas y Cantera Colonial de Zacatecas',
                                'slug' => 'libro-historia-minas-cantera',
                                'description' => 'Tomo encuadernado de lujo con planos cartográficos y fotografías históricas.',
                                'price' => 380.00,
                                'stock' => 25,
                                'image_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Edición Ilustrada: La Suave Patria de Ramón López Velarde',
                                'slug' => 'libro-la-suave-patria-ilustrada',
                                'description' => 'Obra cumbre de la poesía mexicana con ilustraciones de artistas zacatecanos.',
                                'price' => 290.00,
                                'stock' => 40,
                                'image_url' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Encuadernación y Papelería de Autor',
                        'slug' => 'encuadernacion-y-papeleria',
                        'description' => 'Cuadernos, libretas de viaje y accesorios de escritura artesanal.',
                        'products' => [
                            [
                                'name' => 'Libreta Artesanal Encuadernada en Piel 200 Hojas',
                                'slug' => 'libreta-artesanal-piel-200h',
                                'description' => 'Papel de algodón libre de ácido cosido a mano con cubierta de cuero vacuno.',
                                'price' => 220.00,
                                'stock' => 45,
                                'image_url' => 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Pluma Fuente Estilográfica de Madera de Ébano',
                                'slug' => 'pluma-fuente-madera-ebano',
                                'description' => 'Pumilla de acero pulido trazo medio con convertidor de tinta incluido.',
                                'price' => 340.00,
                                'stock' => 30,
                                'image_url' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?auto=format&fit=crop&w=700&q=80',
                            ],
                            [
                                'name' => 'Mapa Histórico Ilustrado de la Noble Ciudad de Zacatecas',
                                'slug' => 'mapa-historico-ilustrado-zacatecas',
                                'description' => 'Lámina litográfica de alta calidad lista para enmarcar con vistas del siglo XIX.',
                                'price' => 450.00,
                                'stock' => 20,
                                'image_url' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=700&q=80',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // 3. Create Each Tenant and Populate Its Database
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

            // Assign Domains
            $tenant->createDomain($tenantId);
            $tenant->createDomain("{$tenantId}.atelier-zacatecas.onrender.com");
            $tenant->createDomain("{$tenantId}.localhost");
            $tenant->createDomain("{$tenantId}.192.168.0.128.nip.io");

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
                        'font_family' => 'Plus Jakarta Sans',
                        'hero_title' => $biz['hero_title'],
                        'hero_subtitle' => $biz['hero_subtitle'],
                        'hero_button_text' => 'Explorar Menú y Catálogo',
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
                        'footer_text' => '© ' . date('Y') . ' ' . $biz['store_name'] . ' · Centro Histórico de Zacatecas, Zac.',
                    ]
                );

                // Create Multiple Users for each Business (Admin, Gerente, Caja, Ventas)
                $storeUsers = [
                    [
                        'email' => $biz['admin_email'],
                        'name' => $biz['admin_name'],
                        'role_desc' => 'Administrador General',
                    ],
                    [
                        'email' => "gerente@{$biz['id']}.com",
                        'name' => "Gerente Operativo · {$biz['store_name']}",
                        'role_desc' => 'Gerencia de Sucursal',
                    ],
                    [
                        'email' => "caja@{$biz['id']}.com",
                        'name' => "Cajero(a) Principal · {$biz['store_name']}",
                        'role_desc' => 'Caja y Cobros',
                    ],
                    [
                        'email' => "ventas@{$biz['id']}.com",
                        'name' => "Asesor(a) Comercial · {$biz['store_name']}",
                        'role_desc' => 'Atención al Cliente y Mostrador',
                    ],
                ];

                foreach ($storeUsers as $u) {
                    TenantUser::updateOrCreate(
                        ['email' => $u['email']],
                        [
                            'name' => $u['name'],
                            'password' => Hash::make('password'),
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
                                'stock' => $prodData['stock'] ?? 50,
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
