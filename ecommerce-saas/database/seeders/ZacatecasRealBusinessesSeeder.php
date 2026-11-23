<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ZacatecasRealBusinessesSeeder extends Seeder
{
    public function run(): void
    {
        $businesses = [
            // 1. D & R CONCEPTOS
            [
                'id' => 'conceptos7',
                'store_name' => 'D & R CONCEPTOS',
                'business_category' => 'Moda y Lujo',
                'plan_name' => 'Corporativo',
                'billing_cycle' => 'annual',
                'subscription_amount' => 850.00,
       'tagline'=>'Joyería y Accesorios · Ropa y Calzado · Zacatecas Centro',
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
       'announcement_text'=>'¡Nueva Colección 2026 en D & R CONCEPTOS! Joyería, accesorios, ropa y calzado en Zacatecas Centro · Envíos a todo el país',
                'contact_email' => 'contacto@conceptos7.com',
                'whatsapp_number' => '+52 492 145 7890',
                'facebook_url' => 'https://www.facebook.com/conceptos7zacatecas/',
                'instagram_url' => 'https://www.instagram.com/conceptos.7/',
                'official_website_url' => 'https://www.instagram.com/conceptos.7/',
                'admin_name' => 'Administrador D & R CONCEPTOS',
                'admin_email' => 'admin@conceptos7.com',
                'categories' => [
          ['name'=>'Joyería y Accesorios','slug'=>'joyeria-y-accesorios','description'=>'Gargantillas, aretes, pulseras y anillos en chapa de oro 14K y plata fina.'],
          ['name'=>'Ropa & Tendencia','slug'=>'ropa-tendencia','description'=>'Prendas de temporada, vestidos satinados y sastrería femenina.'],
          ['name'=>'Calzado & Tacones','slug'=>'calzado-y-tacones','description'=>'Zapatillas de tacón, mules destalonados y sandalias de plataforma confort.'],
          ['name'=>'Bolsos & Complementos','slug'=>'bolsos-y-complementos','description'=>'Bolsos crossbody, clutches de noche y carteras en tonos neutros.'],
                ],
                'products' => [
                    [
           'name'=>'Gargantilla Oro 14K Solitaria con Circonia',
                        'slug' => 'gargantilla-oro-14k-solitaria',
                        'category_slug' => 'joyeria-y-accesorios',
                        'price' => 450.00,
                        'description' => 'Gargantilla fina con baño de oro 14K hipoalergénica con dije de circonia corte brillante.',
                        'image_url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Vestido Midi Satinado Espalda Cruzada',
                        'slug' => 'vestido-midi-satinado-espalda-cruzada',
                        'category_slug' => 'ropa-tendencia',
                        'price' => 750.00,
                        'description' => 'Elegante vestido en satín fluido de caída impecable, ideal para eventos especiales en Zacatecas.',
                        'image_url' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Mules de Punta Fina con Herraje Joya',
                        'slug' => 'mules-punta-fina-herraje-joya',
                        'category_slug' => 'calzado-y-tacones',
                        'price' => 790.00,
                        'description' => 'Calzado mule destalonado con tacón kitten cómodo y detalle de pedrería fina en el empeine.',
                        'image_url' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Bolso Bandolera Acolchado con Cadena Dorada',
                        'slug' => 'bolso-bandolera-acolchado-cadena-dorada',
                        'category_slug' => 'bolsos-y-complementos',
                        'price' => 820.00,
                        'description' => 'Bolso estructurado en piel sintética suave con textura acolchada geométrica y correa de cadena.',
                        'image_url' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 2. CAFÉ ACRÓPOLIS
            [
                'id' => 'acropolis',
                'store_name' => 'Café Acrópolis',
                'business_category' => 'Cafeterías y Alimentos',
                'plan_name' => 'Corporativo',
                'billing_cycle' => 'annual',
                'subscription_amount' => 950.00,
       'tagline'=>'Tradición desde 1943 frente a la Catedral. Café turco, pays artesanales y gastronomía zacatecana.',
                'address' => 'Av. Hidalgo y Plazuela Candelario Huízar #1, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Catedral / Plaza de Armas',
                'city' => 'Zacatecas',
                'latitude' => 22.7758,
                'longitude' => -102.5723,
                'maps_url' => 'https://maps.google.com/?q=22.7758,-102.5723',
                'opening_hours' => 'Lunes a Domingo: 8:00 AM - 10:30 PM',
                'location_reference' => 'A un costado de la Catedral Basílica de Zacatecas, frente al Mercado González Ortega',
                'primary_color' => '#8b4513',
                'secondary_color' => '#faf6f0',
                'logo_url' => 'https://images.unsplash.com/photo-1559496417-e7f25cb247f3?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Café Acrópolis\nTradición y Cultura Zacatecana",
                'hero_subtitle' => 'El punto de encuentro más icónico de Zacatecas desde 1943. Saborea nuestro legendario café turco y repostería artesanal.',
       'announcement_text'=>'Disfruta del auténtico Café Acrópolis en el Centro de Zacatecas o haz tu pedido para llevar',
                'contact_email' => 'contacto@cafeacropolis.mx',
                'whatsapp_number' => '+52 492 922 1284',
                'facebook_url' => 'https://www.facebook.com/cafeacropoliszacatecas/',
                'instagram_url' => 'https://www.instagram.com/cafeacropoliszac/',
                'official_website_url' => 'https://cafeacropolis.mx',
                'admin_name' => 'Gerencia Café Acrópolis',
                'admin_email' => 'admin@acropolis.com',
                'categories' => [
          ['name'=>'Café de Especialidad','slug'=>'cafe-de-especialidad','description'=>'Granos selectos tostados artesanalmente y métodos de extracción tradicionales.'],
          ['name'=>'Repostería Fina','slug'=>'reposteria-fina','description'=>'Pays horneados diariamente con recetas secretas de la casa.'],
          ['name'=>'Desayunos Mineros','slug'=>'desayunos-mineros','description'=>'Especialidades culinarias tradicionales de Zacatecas.'],
                ],
                'products' => [
                    [
           'name'=>'Café Turco Acrópolis Tradicional',
                        'slug' => 'cafe-turco-acropolis-tradicional',
                        'category_slug' => 'cafe-de-especialidad',
                        'price' => 65.00,
                        'description' => 'Preparado en cezve de cobre sobre arena caliente con cardamomo y café molido extrafino.',
                        'image_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Pay de Queso con Zarzamora de la Casa',
                        'slug' => 'pay-de-queso-con-zarzamora',
                        'category_slug' => 'reposteria-fina',
                        'price' => 85.00,
                        'description' => 'El pay más famoso de Zacatecas, con base crocante de mantequilla y mermelada casera de zarzamora.',
                        'image_url' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Desayuno Minero Zacatecano',
                        'slug' => 'desayuno-minero-zacatecano',
                        'category_slug' => 'desayunos-mineros',
                        'price' => 160.00,
                        'description' => 'Huevos al gusto montados sobre gorditas con asado de boda zacatecano, frijoles refritos y queso fresco.',
                        'image_url' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Bolsa 1/2 Kg Café de Altura Acrópolis Molido',
                        'slug' => 'bolsa-medio-kilo-cafe-acropolis',
                        'category_slug' => 'cafe-de-especialidad',
                        'price' => 195.00,
                        'description' => 'Mezcla especial de granos arábica de altura con tueste medio, notas achocolatadas y acidez equilibrada.',
                        'image_url' => 'https://images.unsplash.com/photo-1587734195503-904fca47e0e9?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 3. PLATERÍA CANTERA REAL / ROSA DE PLATA
            [
                'id' => 'rosadeplata',
                'store_name' => 'Platería Rosa de Plata',
                'business_category' => 'Joyería y Plata .925',
                'plan_name' => 'Crecimiento',
                'billing_cycle' => 'annual',
                'subscription_amount' => 750.00,
       'tagline'=>'Plata pura Ley .925 certificada, filigrana jerezana y orfebrería tradicional zacatecana.',
                'address' => 'Av. Hidalgo #305, Portal de Rosales, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Portal de Rosales',
                'city' => 'Zacatecas',
                'latitude' => 22.7748,
                'longitude' => -102.5732,
                'maps_url' => 'https://maps.google.com/?q=22.7748,-102.5732',
                'opening_hours' => 'Lunes a Sábado: 10:00 AM - 8:30 PM | Domingo: 11:00 AM - 6:00 PM',
                'location_reference' => 'Frente al Teatro Fernando Calderón en el Portal de Rosales',
                'primary_color' => '#334155',
                'secondary_color' => '#f8fafc',
                'logo_url' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Platería Rosa de Plata\nOrfebrería Fina Ley .925",
                'hero_subtitle' => 'La más distinguida tradición platera de Zacatecas. Joyas elaboradas con metales preciosos extraídos de las minas zacatecanas.',
       'announcement_text'=>'Certificado de autenticidad en cada pieza de plata Ley .925 · Envíos garantizados',
                'contact_email' => 'ventas@rosadeplata.mx',
                'whatsapp_number' => '+52 492 924 5510',
                'facebook_url' => 'https://www.facebook.com/rosadeplatazac/',
                'instagram_url' => 'https://www.instagram.com/rosadeplatazac/',
                'official_website_url' => 'https://rosadeplata.mx',
                'admin_name' => 'Maestro Platero Rosa de Plata',
                'admin_email' => 'admin@rosadeplata.com',
                'categories' => [
          ['name'=>'Arracadas Jerezanas','slug'=>'arracadas-jerezanas','description'=>'La joya zacatecana por excelencia en filigrana fina.'],
          ['name'=>'Dijes & Cantera','slug'=>'dijes-y-cantera','description'=>'Combinación única de plata y cantera rosa de Zacatecas.'],
          ['name'=>'Anillos & Solitarios','slug'=>'anillos-y-solitarios','description'=>'Piezas con engastes artesanales y pulido espejo.'],
                ],
                'products' => [
                    [
           'name'=>'Arracadas Jerezanas Tradicionales Plata .925',
                        'slug' => 'arracadas-jerezanas-tradicionales',
                        'category_slug' => 'arracadas-jerezanas',
                        'price' => 680.00,
                        'description' => 'Diseño colonial jerezano elaborado completamente a mano con filigrana de plata maciza.',
                        'image_url' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Dije Cantera Rosa con Marco de Plata .925',
                        'slug' => 'dije-cantera-rosa-plata-925',
                        'category_slug' => 'dijes-y-cantera',
                        'price' => 490.00,
                        'description' => 'Auténtica cantera rosa extraída del cerro de la Bufa montada sobre bisel de plata pulida.',
                        'image_url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Anillo Solitario Circonia Suiza Plata .925',
                        'slug' => 'anillo-solitario-circonia-suiza',
                        'category_slug' => 'anillos-y-solitarios',
                        'price' => 420.00,
                        'description' => 'Elegante argolla de plata esterlina con circonia corte corazón de máxima refracción.',
                        'image_url' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Pulsera Filigrana Zacatecana Tejida',
                        'slug' => 'pulsera-filigrana-zacatecana',
                        'category_slug' => 'arracadas-jerezanas',
                        'price' => 850.00,
                        'description' => 'Tejido minucioso en hilos de plata fina con broche de seguridad grabado.',
                        'image_url' => 'https://images.unsplash.com/photo-1611591475879-c5c8a32b2e04?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 4. GORDITAS Y DULCES DOÑA JULIA
            [
                'id' => 'donajulia',
                'store_name' => 'Gorditas y Dulces Doña Julia',
                'business_category' => 'Dulces Típicos y Alimentos',
                'plan_name' => 'Crecimiento',
                'billing_cycle' => 'annual',
                'subscription_amount' => 750.00,
       'tagline'=>'El sabor más tradicional de Zacatecas. Gorditas al comal recién hechas y dulces típicos de leche y guayaba.',
                'address' => 'Calle Tacuba #112, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Plazuela Goitia / Tacuba',
                'city' => 'Zacatecas',
                'latitude' => 22.7738,
                'longitude' => -102.5719,
                'maps_url' => 'https://maps.google.com/?q=22.7738,-102.5719',
                'opening_hours' => 'Lunes a Domingo: 8:30 AM - 9:00 PM',
                'location_reference' => 'A pasos del Mercado González Ortega y Plazuela Goitia',
                'primary_color' => '#c2410c',
                'secondary_color' => '#fffaf5',
                'logo_url' => 'https://images.unsplash.com/photo-1582293041079-7814c2f12063?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Doña Julia\nGorditas de Comal & Dulces Típicos",
                'hero_subtitle' => 'Una parada obligada en el Centro de Zacatecas. Gorditas calientitas rellenas de guisados tradicionales y los mejores ates de la región.',
       'announcement_text'=>'¡Prueba las famosas gorditas de deshebrada y los jamoncillos con nuez de Doña Julia!',
                'contact_email' => 'pedidos@donajulia.mx',
                'whatsapp_number' => '+52 492 922 8412',
                'facebook_url' => 'https://www.facebook.com/donajuliazacatecas/',
                'instagram_url' => 'https://www.instagram.com/donajulia_zac/',
                'official_website_url' => 'https://donajulia.mx',
                'admin_name' => 'Doña Julia Administración',
                'admin_email' => 'admin@donajulia.com',
                'categories' => [
          ['name'=>'Gorditas de Comal','slug'=>'gorditas-de-comal','description'=>'Masa de maíz criollo cocida al comal con guisados caseros.'],
          ['name'=>'Dulces Típicos Zacatecanos','slug'=>'dulces-tipicos','description'=>'Jamoncillos, rollos de guayaba, charamuscas y cajetas.'],
          ['name'=>'Aguas Frescas','slug'=>'aguas-frescas','description'=>'Bebidas naturales tradicionales preparadas al momento.'],
                ],
                'products' => [
                    [
           'name'=>'Paquete 4 Gorditas de Guisado Tradicional',
                        'slug' => 'paquete-4-gorditas-guisado',
                        'category_slug' => 'gorditas-de-comal',
                        'price' => 110.00,
                        'description' => 'Elige entre chicharrón prensado, deshebrada en salsa roja, frijoles con queso o rajas con crema.',
                        'image_url' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Rollo de Guayaba Relleno de Cajeta y Nuez',
                        'slug' => 'rollo-guayaba-relleno-cajeta',
                        'category_slug' => 'dulces-tipicos',
                        'price' => 85.00,
                        'description' => 'Ate natural de guayaba de Jalpa enrollado con cajeta de leche de cabra y trozos de nuez pecana.',
                        'image_url' => 'https://images.unsplash.com/photo-1587314168485-3236d6710814?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Jamoncillo de Leche Tradicional con Nuez',
                        'slug' => 'jamoncillo-leche-con-nuez',
                        'category_slug' => 'dulces-tipicos',
                        'price' => 65.00,
                        'description' => 'Dulce suave de leche quemada cocido a fuego lento en cazo de cobre y decorado con mitades de nuez.',
                        'image_url' => 'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Canasta Surtida Dulces Típicos Zacatecanos',
                        'slug' => 'canasta-surtida-dulces-tipicos',
                        'category_slug' => 'dulces-tipicos',
                        'price' => 280.00,
                        'description' => 'Selección de 12 piezas de los dulces más representativos en canasta tejida artesanal.',
                        'image_url' => 'https://images.unsplash.com/photo-1582293041079-7814c2f12063?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 5. NIEVES ARTESANALES EL SERRANITO
            [
                'id' => 'elserranito',
                'store_name' => 'Nieves Artesanales El Serranito',
                'business_category' => 'Cafeterías y Alimentos',
                'plan_name' => 'Emprendedor',
                'billing_cycle' => 'annual',
                'subscription_amount' => 550.00,
       'tagline'=>'Nieves de garrafa artesanales con recetas centenarias de Jerez y Zacatecas. Frutas 100% naturales.',
                'address' => 'Av. Hidalgo #208, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Portal de Rosales',
                'city' => 'Zacatecas',
                'latitude' => 22.7744,
                'longitude' => -102.5729,
                'maps_url' => 'https://maps.google.com/?q=22.7744,-102.5729',
                'opening_hours' => 'Lunes a Domingo: 11:00 AM - 9:00 PM',
                'location_reference' => 'En el pasaje peatonal junto al Portal de Rosales',
                'primary_color' => '#0d9488',
                'secondary_color' => '#f0fdfa',
                'logo_url' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Nieves El Serranito\nSabor de Garrafa Tradicional",
                'hero_subtitle' => 'Elaboradas a mano en barricas de madera con hielo y sal de grano, con la mejor fruta de la región.',
       'announcement_text'=>'¡Nieve de ciruela jerezana y pasta de almendra disponibles hoy!',
                'contact_email' => 'contacto@elserranito.com',
                'whatsapp_number' => '+52 492 925 1102',
                'facebook_url' => 'https://www.facebook.com/nieveselserranito/',
                'instagram_url' => 'https://www.instagram.com/elserranito_zac/',
                'official_website_url' => 'https://elserranito.com',
                'admin_name' => 'Admin El Serranito',
                'admin_email' => 'admin@elserranito.com',
                'categories' => [
          ['name'=>'Nieves de Garrafa de Fruta','slug'=>'nieves-de-fruta','description'=>'Elaboradas con fruta fresca sin conservadores.'],
          ['name'=>'Nieves Cremosas de Especialidad','slug'=>'nieves-cremosas','description'=>'Recetas con leche entera, canela, nuez y vainilla natural.'],
                ],
                'products' => [
                    [
           'name'=>'Nieve Tradicional de Ciruela Jerezana',
                        'slug' => 'nieve-tradicional-ciruela-jerezana',
                        'category_slug' => 'nieves-de-fruta',
                        'price' => 55.00,
                        'description' => 'Receta original con pulpa de ciruela amarilla madura cosechada en los huertos de Jerez.',
                        'image_url' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Nieve de Pasta de Almendra y Leche',
                        'slug' => 'nieve-pasta-almendra-leche',
                        'category_slug' => 'nieves-cremosas',
                        'price' => 60.00,
                        'description' => 'Cremosa nieve elaborada con pasta fina de almendras tostadas y canela en rama.',
                        'image_url' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Litro Familiar Nieve de Tuna Roja',
                        'slug' => 'litro-familiar-nieve-tuna-roja',
                        'category_slug' => 'nieves-de-fruta',
                        'price' => 160.00,
                        'description' => 'Empaque térmico para llevar de 1 litro de fresca nieve de tuna roja del semidesierto zacatecano.',
                        'image_url' => 'https://images.unsplash.com/photo-1497034825429-c343d7c6a68f?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 6. CANTINA MUSEO LAS QUINCE LETRAS
            [
                'id' => 'quinceletras',
                'store_name' => 'Cantina Museo Las Quince Letras',
                'business_category' => 'Vinos y Licores',
                'plan_name' => 'Corporativo',
                'billing_cycle' => 'annual',
                'subscription_amount' => 850.00,
       'tagline'=>'Desde 1906. Más de un siglo de historia minera, galería de arte y la mejor selección de mezcales de Zacatecas.',
                'address' => 'Calle Mártires de Tacubaya #301, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'San Agustín / Tacubaya',
                'city' => 'Zacatecas',
                'latitude' => 22.7728,
                'longitude' => -102.5741,
                'maps_url' => 'https://maps.google.com/?q=22.7728,-102.5741',
                'opening_hours' => 'Lunes a Sábado: 1:00 PM - 11:00 PM',
                'location_reference' => 'Frente al Templo de San Agustín y Plazuela del Refugio',
                'primary_color' => '#9a3412',
                'secondary_color' => '#faf5f0',
                'logo_url' => 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Las Quince Letras\nHistoria, Arte y Mezcal Zacatecano",
                'hero_subtitle' => 'Fundada en 1906, es la cantina museo más emblemática del estado. Adquiere mezcales de colección y souvenirs conmemorativos.',
       'announcement_text'=>'Botellas de mezcal artesanal zacatecano conmemorativo con entrega directa',
                'contact_email' => 'contacto@lasquinceletras.com',
                'whatsapp_number' => '+52 492 922 4190',
                'facebook_url' => 'https://www.facebook.com/lasquinceletraszac/',
                'instagram_url' => 'https://www.instagram.com/lasquinceletras/',
                'official_website_url' => 'https://lasquinceletras.com',
                'admin_name' => 'Admin Las Quince Letras',
                'admin_email' => 'admin@quinceletras.com',
                'categories' => [
          ['name'=>'Mezcales de Origen Zacatecano','slug'=>'mezcales-zacatecanos','description'=>'Agaves salmiana y tequilana de Jalpa, Huitzila y Pinos.'],
          ['name'=>'Souvenirs Conmemorativos','slug'=>'souvenirs-historicos','description'=>'Objetos de colección conmemorando más de 115 años de historia.'],
                ],
                'products' => [
                    [
           'name'=>'Mezcal Real de Jalpa Joven 750ml',
                        'slug' => 'mezcal-real-de-jalpa-joven',
                        'category_slug' => 'mezcales-zacatecanos',
                        'price' => 580.00,
                        'description' => 'Destilado en alambique de cobre tradicional con notas herbales y ahumado suave.',
                        'image_url' => 'https://images.unsplash.com/photo-1569529465841-dfecdab7503b?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Mezcal Mala Noche Reposado en Barrica',
                        'slug' => 'mezcal-mala-noche-reposado',
                        'category_slug' => 'mezcales-zacatecanos',
                        'price' => 720.00,
                        'description' => 'Madurado 9 meses en barricas de roble blanco americano, con notas de vainilla y caramelo tostado.',
                        'image_url' => 'https://images.unsplash.com/photo-1563227812-0ea4c22e6cc8?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Tarro de Cerámica Conmemorativo 1906',
                        'slug' => 'tarro-ceramica-conmemorativo-1906',
                        'category_slug' => 'souvenirs-historicos',
                        'price' => 180.00,
                        'description' => 'Pieza de colección en barro vidriado con el escudo histórico de la cantina.',
                        'image_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 7. LIBRERÍA & GALERÍA ANDREA
            [
                'id' => 'libreriaandrea',
                'store_name' => 'Librería & Galería Andrea',
                'business_category' => 'Cultura y Libros',
                'plan_name' => 'Emprendedor',
                'billing_cycle' => 'annual',
                'subscription_amount' => 550.00,
       'tagline'=>'El rincón literario y artístico de Zacatecas. Poesía zacatecana, historia de la minería, novela y arte local.',
                'address' => 'Calle Allende #108, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Calle Allende',
                'city' => 'Zacatecas',
                'latitude' => 22.7733,
                'longitude' => -102.5727,
                'maps_url' => 'https://maps.google.com/?q=22.7733,-102.5727',
                'opening_hours' => 'Lunes a Sábado: 10:00 AM - 8:00 PM',
                'location_reference' => 'A media cuadra de Plazuela Goitia y Teatro Calderón',
                'primary_color' => '#475569',
                'secondary_color' => '#f8fafc',
                'logo_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1507842229452-78d108520b22?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Librería Andrea\nLetras, Arte & Coleccionismo",
                'hero_subtitle' => 'Obras de poetas e historiadores zacatecanos, narrativa universal y grabados artísticos sobre la ciudad.',
       'announcement_text'=>'Nuevos títulos sobre historia y leyendas coloniales de Zacatecas',
                'contact_email' => 'libros@libreriaandrea.mx',
                'whatsapp_number' => '+52 492 923 7741',
                'facebook_url' => 'https://www.facebook.com/libreriaandreazac/',
                'instagram_url' => 'https://www.instagram.com/libreriaandrea_zac/',
                'official_website_url' => 'https://libreriaandrea.mx',
                'admin_name' => 'Admin Librería Andrea',
                'admin_email' => 'admin@libreriaandrea.com',
                'categories' => [
          ['name'=>'Historia y Leyendas de Zacatecas','slug'=>'historia-zacatecana','description'=>'Textos fundamentales de cronistas e historiadores locales.'],
          ['name'=>'Poesía y Letras Mexicanas','slug'=>'poesia-mexicana','description'=>'Obras de Ramón López Velarde, Roberto Cabral del Hoyo y más.'],
          ['name'=>'Grabados y Papelería Fina','slug'=>'grabados-artisticos','description'=>'Ilustraciones en tinta y libretas encuadernadas artesanalmente.'],
                ],
                'products' => [
                    [
           'name'=>'La Suave Patria - Ramón López Velarde (Edición de Lujo)',
                        'slug' => 'la-suave-patria-ramon-lopez-velarde',
                        'category_slug' => 'poesia-mexicana',
                        'price' => 280.00,
                        'description' => 'Edición conmemorativa pasta dura con notas críticas y reproducciones facsimilares del manuscrito.',
                        'image_url' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Libro Leyendas y Misterios del Zacatecas Colonial',
                        'slug' => 'leyendas-y-misterios-zacatecas',
                        'category_slug' => 'historia-zacatecana',
                        'price' => 320.00,
                        'description' => 'Recopilación ilustrada de las historias más fascinantes de callejones, casonas y minas de la ciudad.',
                        'image_url' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Grabado Artístico Catedral de Zacatecas en Tinta',
                        'slug' => 'grabado-artistico-catedral-zacatecas',
                        'category_slug' => 'grabados-artisticos',
                        'price' => 450.00,
                        'description' => 'Litografía sobre papel de algodón hecha por grabadores locales del taller Julio Ruelas.',
                        'image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 8. MEZCALERÍA & BOTICA LA MINA
            [
                'id' => 'mezcaleria-la-mina',
                'store_name' => 'Mezcalería & Botica La Mina',
                'business_category' => 'Vinos y Licores',
                'plan_name' => 'Crecimiento',
                'billing_cycle' => 'annual',
                'subscription_amount' => 750.00,
       'tagline'=>'Boutique de mezcales de origen zacatecano: Jalpa, Juchipila y Pinos. Sales de gusano y miel de agave pura.',
                'address' => 'Callejón de Quijano #104, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Plazuela Miguel Auza',
                'city' => 'Zacatecas',
                'latitude' => 22.7742,
                'longitude' => -102.5708,
                'maps_url' => 'https://maps.google.com/?q=22.7742,-102.5708',
                'opening_hours' => 'Martes a Domingo: 2:00 PM - 10:30 PM',
                'location_reference' => 'En el corredor bohemio junto a la Plazuela Miguel Auza',
                'primary_color' => '#166534',
                'secondary_color' => '#f0fdf4',
                'logo_url' => 'https://images.unsplash.com/photo-1569529465841-dfecdab7503b?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Botica La Mina\nMezcales de Selección Especial",
                'hero_subtitle' => 'Destilados de pequeños maestros mezcaleros de la sierra zacatecana.',
       'announcement_text'=>'Mezcales silvestres de agave Salmiana con denominación de origen Zacatecas',
                'contact_email' => 'botica@mezcalerialamina.mx',
                'whatsapp_number' => '+52 492 112 3344',
                'facebook_url' => 'https://www.facebook.com/mezcalerialamina/',
                'instagram_url' => 'https://www.instagram.com/mezcalerialamina/',
                'official_website_url' => 'https://mezcalerialamina.mx',
                'admin_name' => 'Admin La Mina',
                'admin_email' => 'admin@mezcalerialamina.com',
                'categories' => [
          ['name'=>'Mezcales Silvestres','slug'=>'mezcales-silvestres','description'=>'Agaves que crecen de manera silvestre en el semidesierto.'],
          ['name'=>'Sales y Botanas de Cata','slug'=>'sales-de-cata','description'=>'Sales de gusano de maguey y chapulines con chiles secos.'],
                ],
                'products' => [
                    [
           'name'=>'Mezcal La Mina Silvestre Salmiana 750ml',
                        'slug' => 'mezcal-la-mina-silvestre-salmiana',
                        'category_slug' => 'mezcales-silvestres',
                        'price' => 620.00,
                        'description' => 'Agave salmiana silvestre cocido bajo tierra en horno cónico de piedra volcánica.',
                        'image_url' => 'https://images.unsplash.com/photo-1569529465841-dfecdab7503b?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Mezcal Edición Especial de Pechuga',
                        'slug' => 'mezcal-edicion-especial-pechuga',
                        'category_slug' => 'mezcales-silvestres',
                        'price' => 950.00,
                        'description' => 'Tercera destilación con frutas criollas zacatecanas (manzana, tejocote y pasas) y pechuga.',
                        'image_url' => 'https://images.unsplash.com/photo-1563227812-0ea4c22e6cc8?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Frasco Sal de Chinicuil y Chile Cascabel',
                        'slug' => 'sal-de-chinicuil-chile-cascabel',
                        'category_slug' => 'sales-de-cata',
                        'price' => 120.00,
                        'description' => 'El acompañante perfecto para degustar un buen mezcal zacatecano con rodajas de naranja.',
                        'image_url' => 'https://images.unsplash.com/photo-1514733670139-4d87a1941d55?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 9. ARTESANÍAS Y ARTE WIXÁRIKA CASA ZACATECAS
            [
                'id' => 'arte-wixarika',
                'store_name' => 'Artesanías y Arte Wixárika Casa Zacatecas',
                'business_category' => 'Artesanías y Cultura',
                'plan_name' => 'Crecimiento',
                'billing_cycle' => 'annual',
                'subscription_amount' => 750.00,
       'tagline'=>'Arte sagrado Wixárika (Huichol) elaborado por maestros artesanos, cantera rosa labrada y rebozos tradicionales.',
                'address' => 'Calle Fernando Villalpando #402, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Villalpando / Centro',
                'city' => 'Zacatecas',
                'latitude' => 22.7725,
                'longitude' => -102.5739,
                'maps_url' => 'https://maps.google.com/?q=22.7725,-102.5739',
                'opening_hours' => 'Lunes a Sábado: 10:00 AM - 8:00 PM',
                'location_reference' => 'A dos cuadras del Congreso del Estado y Palacio de Justicia',
                'primary_color' => '#0369a1',
                'secondary_color' => '#f0f9ff',
                'logo_url' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1528459801416-a9e53bbf4e17?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Casa Zacatecas\nArte Sagrado Wixárika & Cantera",
                'hero_subtitle' => 'Piezas únicas impregnadas de cosmovisión, chaquira de vidrio y labrado artesanal zacatecano.',
       'announcement_text'=>'Piezas únicas de colección certificadas directamente por familias de artesanos',
                'contact_email' => 'artesanias@casazacatecas.mx',
                'whatsapp_number' => '+52 492 188 5620',
                'facebook_url' => 'https://www.facebook.com/casazacatecasartesanias/',
                'instagram_url' => 'https://www.instagram.com/casazacatecas_arte/',
                'official_website_url' => 'https://casazacatecas.mx',
                'admin_name' => 'Admin Casa Zacatecas',
                'admin_email' => 'admin@artewixarika.com',
                'categories' => [
          ['name'=>'Arte en Chaquira Checa','slug'=>'arte-en-chaquira','description'=>'Figuras sagradas recubiertas con cera de campeche y chaquira brillante.'],
          ['name'=>'Cantera Rosa Labrada','slug'=>'cantera-rosa-labrada','description'=>'Esculturas y objetos decorativos en la emblemática piedra de Zacatecas.'],
                ],
                'products' => [
                    [
           'name'=>'Pulsera Wixárika Sagrada Chaquira Checa',
                        'slug' => 'pulsera-wixarika-sagrada-chaquira',
                        'category_slug' => 'arte-en-chaquira',
                        'price' => 220.00,
                        'description' => 'Tejida en telar de cintura con motivos de peyote sagrado y flores de la sierra.',
                        'image_url' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Cuadro Ojo de Dios de Protección 40x40 cm',
                        'slug' => 'cuadro-ojo-de-dios-proteccion',
                        'category_slug' => 'arte-en-chaquira',
                        'price' => 680.00,
                        'description' => 'Técnica de estambre pegado sobre madera con los cuatro rumbos cósmicos wixárikas.',
                        'image_url' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Set 4 Portavasos Cantera Rosa Labrada',
                        'slug' => 'set-4-portavasos-cantera-rosa',
                        'category_slug' => 'cantera-rosa-labrada',
                        'price' => 360.00,
                        'description' => 'Tallados a mano con bajorrelieves inspirados en la fachada barroca de la Catedral de Zacatecas.',
                        'image_url' => 'https://images.unsplash.com/photo-1523779917675-b6ed3a42a561?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],

            // 10. CHOCOLATERÍA Y TOSTADOR MINA DE CIELO
            [
                'id' => 'mina-de-cielo',
                'store_name' => 'Chocolatería y Tostador Mina de Cielo',
                'business_category' => 'Cafeterías y Alimentos',
                'plan_name' => 'Emprendedor',
                'billing_cycle' => 'annual',
                'subscription_amount' => 550.00,
       'tagline'=>'Chocolate de metate 100% artesanal zacatecano, bombones de mezcal y café de altura tostado al punto.',
                'address' => 'Calle Juan de Tolosa #822, Centro Histórico, Zacatecas, Zac.',
                'neighborhood_zone' => 'Juan de Tolosa / Fuente de los Conquistadores',
                'city' => 'Zacatecas',
                'latitude' => 22.7772,
                'longitude' => -102.5714,
                'maps_url' => 'https://maps.google.com/?q=22.7772,-102.5714',
                'opening_hours' => 'Lunes a Sábado: 9:00 AM - 9:00 PM',
                'location_reference' => 'Subiendo por Juan de Tolosa, frente a la Fuente de los Conquistadores',
                'primary_color' => '#6b21a8',
                'secondary_color' => '#faf5ff',
                'logo_url' => 'https://images.unsplash.com/photo-1548907040-4baa42d10919?auto=format&fit=crop&w=300&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1481391319762-47dff72954d9?auto=format&fit=crop&w=1400&q=80',
                'hero_title' => "Mina de Cielo\nCacao de Metate & Café Tostado",
                'hero_subtitle' => 'El dulce legado minero convertido en tabletas de chocolate puro, trufas con mezcal y aromático café de altura.',
       'announcement_text'=>'Tabletas de chocolate con canela de metate y bombones de mezcal recién hechos',
                'contact_email' => 'hola@minadecielo.com',
                'whatsapp_number' => '+52 492 103 9922',
                'facebook_url' => 'https://www.facebook.com/minadecielozac/',
                'instagram_url' => 'https://www.instagram.com/minadecielo_chocolates/',
                'official_website_url' => 'https://minadecielo.com',
                'admin_name' => 'Admin Mina de Cielo',
                'admin_email' => 'admin@minadecielo.com',
                'categories' => [
          ['name'=>'Chocolate de Metate','slug'=>'chocolate-de-metate','description'=>'Molido en piedra volcánica con canela criolla y azúcar mascabado.'],
          ['name'=>'Bombones & Trufas','slug'=>'bombones-y-trufas','description'=>'Rellenos de licores zacatecanos, guayaba y cajeta.'],
                ],
                'products' => [
                    [
           'name'=>'Barra Chocolate de Metate 70% Cacao con Canela',
                        'slug' => 'barra-chocolate-metate-70-cacao',
                        'category_slug' => 'chocolate-de-metate',
                        'price' => 95.00,
                        'description' => 'Tableta tradicional de grano de cacao tostado a leña y molido en metate de cantera.',
                        'image_url' => 'https://images.unsplash.com/photo-1548907040-4baa42d10919?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Caja de 6 Bombones Rellenos de Mezcal Zacatecano',
                        'slug' => 'caja-6-bombones-mezcal-zacatecano',
                        'category_slug' => 'bombones-y-trufas',
                        'price' => 160.00,
                        'description' => 'Ganache suave infusionada con mezcal de agave salmiana de Pinos, Zacatecas.',
                        'image_url' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
           'name'=>'Frasco Grageas de Café de Altura con Chocolate',
                        'slug' => 'grageas-cafe-altura-con-chocolate',
                        'category_slug' => 'chocolate-de-metate',
                        'price' => 85.00,
                        'description' => 'Granos de café arábica crocantes bañados en doble capa de chocolate amargo.',
                        'image_url' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?auto=format&fit=crop&w=600&q=80',
                    ],
                ],
            ],
        ];

        // 2. Loop through each Iconic Business: Create Tenant, Domains, StoreSettings & Products
        foreach ($businesses as $biz) {
            try {
                $tenantId = $biz['id'];

            // Find or Create Central Tenant record
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
            } else {
                $tenant->update([
                    'plan_name' => $biz['plan_name'],
                    'billing_cycle' => $biz['billing_cycle'],
                    'subscription_status' => 'active',
                    'subscription_amount' => $biz['subscription_amount'],
                    'subscription_ends_at' => now()->addYears(2),
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

            // Assign standard subdomains and aliases
            $domains = [
                $tenantId,
                "{$tenantId}.localhost",
                "{$tenantId}.atelier-zacatecas.onrender.com",
            ];

            foreach ($domains as $dom) {
                try {
                    if (! $tenant->domains()->where('domain', $dom)->exists()) {
                        $tenant->createDomain($dom);
                    }
                } catch (\Throwable $e) {}
            }

            // Seed Tenant Isolated DB (StoreSetting, User, Categories, Products)
            $tenant->run(function () use ($biz) {
                StoreSetting::updateOrCreate(
                    ['id' => 1],
                    [
                        'store_name' => $biz['store_name'],
                        'business_category' => $biz['business_category'],
           'tagline'=> $biz['tagline'],
                        'logo_url' => $biz['logo_url'],
                        'banner_url' => $biz['banner_url'],
                        'primary_color' => $biz['primary_color'],
                        'secondary_color' => $biz['secondary_color'],
                        'font_family' => 'DM Sans',
                        'hero_title' => $biz['hero_title'],
                        'hero_subtitle' => $biz['hero_subtitle'],
                        'hero_button_text' => 'Explorar Colección',
                        'show_announcement' => true,
           'announcement_text'=> $biz['announcement_text'],
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
                        'footer_text' => '© ' . date('Y') . ' ' . $biz['store_name'] . ' · Zacatecas Centro, Zac.',
                    ]
                );

                TenantUser::updateOrCreate(
                    ['email' => $biz['admin_email']],
                    [
           'name'=> $biz['admin_name'],
                        'password' => Hash::make('password123'),
                        'customer_account_id' => null,
                    ]
                );

                // Populate Categories
                $catMap = [];
                foreach ($biz['categories'] as $catData) {
                    $cat = Category::updateOrCreate(
                        ['slug' => $catData['slug']],
                        [
             'name'=> $catData['name'],
                            'description' => $catData['description'] ?? null,
                        ]
                    );
                    $catMap[$catData['slug']] = $cat;
                }

                // Populate Products
                if (!empty($biz['products'])) {
                    foreach ($biz['products'] as $prod) {
                        $catId = isset($catMap[$prod['category_slug']]) ? $catMap[$prod['category_slug']]->id : (Category::first()?->id ?? 1);
                        Product::updateOrCreate(
                            ['slug' => $prod['slug']],
                            [
                                'category_id' => $catId,
               'name'=> $prod['name'],
                                'description' => $prod['description'],
                                'price' => $prod['price'],
                                'stock' => 25,
                                'image_url' => $prod['image_url'],
                                'is_active' => true,
                            ]
                        );
                    }
                }
            });
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Seeder error for {$biz['id']}: " . $e->getMessage());
            }
        }

        // 3. Clear all central and tenant caches
        \Illuminate\Support\Facades\Cache::flush();
    }
}
