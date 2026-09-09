<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TenantStoreExpansionSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            [
                'name' => 'Bolsos y Marroquinería',
                'slug' => 'bolsos-marroquineria',
                'description' => 'Piezas artesanales elaboradas con pieles seleccionadas y herrajes de latón macizo.',
            ],
            [
                'name' => 'Relojería y Cronógrafos',
                'slug' => 'relojeria-cronografos',
                'description' => 'Mecanismos de precisión suiza con cristal de zafiro y diseño contemporáneo.',
            ],
            [
                'name' => 'Joyería y Accesorios Finos',
                'slug' => 'joyeria-accesorios',
                'description' => 'Metales preciosos y piedras naturales trabajadas a mano por maestros orfebres.',
            ],
            [
                'name' => 'Moda y Alta Costura',
                'slug' => 'moda-alta-costura',
                'description' => 'Prendas confeccionadas con lino italiano, seda y lana virgen de origen ético.',
            ],
            [
                'name' => 'Hogar y Diseño de Interiores',
                'slug' => 'hogar-diseno',
                'description' => 'Objetos escultóricos y funcionales para crear espacios de serenidad y calidez.',
            ],
            [
                'name' => 'Fragancias y Cuidado Personal',
                'slug' => 'fragancias-cuidado',
                'description' => 'Extractos botánicos puros, notas amaderadas y aromas evocadores de autor.',
            ],
            [
                'name' => 'Audio y Tecnología Minimalista',
                'slug' => 'audio-tecnologia',
                'description' => 'Equipos acústicos de alta fidelidad con acabados en madera noble y aluminio cepillado.',
            ],
            [
                'name' => 'Colección Gourmet y Vinos',
                'slug' => 'coleccion-gourmet',
                'description' => 'Selección de aceites de oliva de cosecha temprana, tés puros e infusiones de origen.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $categories[$cData['slug']] = Category::updateOrCreate(
                ['slug' => $cData['slug']],
                $cData
            );
        }

        $productsData = [
            [
                'name' => 'Bolso Nómada de Cuero Artesanal',
                'slug' => 'bolso-nomada-cuero',
                'description' => 'Confeccionado a mano en curtición vegetal de grano entero. Compartimento acolchado para portátil de 15 y correa de hombro ajustable.',
 'price' => 189.00,
 'stock' => 45,
 'is_active' => true,
 'category_id' => $categories['bolsos-marroquineria']->id,
 'image_url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Cronógrafo Suizo Minimalista',
 'slug' => 'cronografo-suizo-minimalista',
 'description' => 'Movimiento automático de 28 rubíes, caja de acero inoxidable quirúrgico 316L y correa de cuero italiano envejecido.',
 'price' => 450.00,
 'stock' => 30,
 'is_active' => true,
 'category_id' => $categories['relojeria-cronografos']->id,
 'image_url' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Lámpara Escultórica de Cerámica Nórdica',
 'slug' => 'lampara-escultorica-ceramica',
 'description' => 'Modelada al torno en gres volcánico con pantalla de lino natural. Difunde una luz cálida y envolvente ideal para salas o dormitorios.',
 'price' => 125.00,
 'stock' => 24,
 'is_active' => true,
 'category_id' => $categories['hogar-diseno']->id,
 'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Auriculares Bluetooth Studio Wood & Steel',
 'slug' => 'auriculares-bluetooth-wood-steel',
 'description' => 'Drivers de berilio de 40mm, almohadillas de espuma viscoelástica y copas en madera maciza de nogal con cancelación activa de ruido.',
 'price' => 280.00,
 'stock' => 35,
 'is_active' => true,
 'category_id' => $categories['audio-tecnologia']->id,
 'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Chaqueta Safari de Lino Italiano',
 'slug' => 'chaqueta-safari-lino',
 'description' => 'Tejida con lino 100% transpirable de Normandía con cuatro bolsillos de fuelle y cinturón entallado. Elegancia informal sin esfuerzo.',
 'price' => 220.00,
 'stock' => 40,
 'is_active' => true,
 'category_id' => $categories['moda-alta-costura']->id,
 'image_url' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Set de Velas Aromáticas Botánicas',
 'slug' => 'set-velas-aromaticas-botanicas',
 'description' => 'Cera de soja biodegradable con mecha de algodón y esencias de cedro blanco, ámbar gris y corteza de higuera silvestre.',
 'price' => 68.00,
 'stock' => 60,
 'is_active' => true,
 'category_id' => $categories['fragancias-cuidado']->id,
 'image_url' => 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Anillo Solitario en Oro de 18k',
 'slug' => 'anillo-solitario-oro-18k',
 'description' => 'Banda pulida de oro amarillo reciclado con engaste bisel de zafiro blanco natural. Una joya discreta y luminosa.',
 'price' => 650.00,
 'stock' => 15,
 'is_active' => true,
 'category_id' => $categories['joyeria-accesorios']->id,
 'image_url' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Zapatillas Urbanas de Cuero Blanco',
 'slug' => 'zapatillas-urbanas-cuero-blanco',
 'description' => 'Suela de caucho natural cosida a mano, forro interior en piel transpirable y plantilla ergonómica de espuma viscoelástica.',
 'price' => 160.00,
 'stock' => 50,
 'is_active' => true,
 'category_id' => $categories['moda-alta-costura']->id,
 'image_url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Gafas de Sol Polarizadas de Carey',
 'slug' => 'gafas-sol-polarizadas-carey',
 'description' => 'Montura de acetato de celulosa japonés fresado a mano con lentes minerales polarizadas UV400 resistentes a arañazos.',
 'price' => 140.00,
 'stock' => 38,
 'is_active' => true,
 'category_id' => $categories['joyeria-accesorios']->id,
 'image_url' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Mochila Ejecutiva Impermeable',
 'slug' => 'mochila-ejecutiva-impermeable',
 'description' => 'Lona encerada técnica repelente al agua, cremalleras YKK termoselladas y respaldo acolchado con flujo de aire.',
 'price' => 175.00,
 'stock' => 42,
 'is_active' => true,
 'category_id' => $categories['bolsos-marroquineria']->id,
 'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Difusor Ultrasónico de Cerámica Mate',
 'slug' => 'difusor-ultrasonico-ceramica',
 'description' => 'Carcasa de cerámica esmaltada con base de madera. Vaporización fría por ultrasonidos con apagado automático y luz ambiental suave.',
 'price' => 85.00,
 'stock' => 55,
 'is_active' => true,
 'category_id' => $categories['fragancias-cuidado']->id,
 'image_url' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Altavoz Portátil Hi-Fi de Nogal',
 'slug' => 'altavoz-portatil-hifi-nogal',
 'description' => 'Batería de 20 horas de autonomía, conectividad Bluetooth 5.3 aptX HD y chasis de madera de nogal para resonancia pura.',
 'price' => 320.00,
 'stock' => 28,
 'is_active' => true,
 'category_id' => $categories['audio-tecnologia']->id,
 'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Bufanda de Cashmere Escocesa',
 'slug' => 'bufanda-cashmere-escocesa',
 'description' => '100% fibra de cashmere peinada en hilaturas tradicionales de Escocia. Calidez ligera y tacto inigualable con flecos terminados a mano.',
 'price' => 110.00,
 'stock' => 45,
 'is_active' => true,
 'category_id' => $categories['moda-alta-costura']->id,
 'image_url' => 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Pluma Estilográfica Lacada en Negro',
 'slug' => 'pluma-estilografica-lacada',
 'description' => 'Cuerpo de latón con laca china multicapa y plumín de oro de 14k bañado en rodio. Fluidez de escritura impecable.',
 'price' => 195.00,
 'stock' => 20,
 'is_active' => true,
 'category_id' => $categories['joyeria-accesorios']->id,
 'image_url' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Set de Cuchillos de Chef Acero Damasco',
 'slug' => 'set-cuchillos-damasco-chef',
 'description' => 'Hoja forjada de 67 capas de acero Damasco con núcleo VG-10 y mango ergonómico de madera de olivo curada.',
 'price' => 340.00,
 'stock' => 18,
 'is_active' => true,
 'category_id' => $categories['hogar-diseno']->id,
 'image_url' => 'https://images.unsplash.com/photo-1593618998160-e34014e67546?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Perfume de Autor Ámbar & Vetiver',
 'slug' => 'perfume-autor-ambar-vetiver',
 'description' => 'Eau de Parfum 100ml. Salida especiada de cardamomo, corazón terroso de vetiver de Haití y fondo profundo de ámbar gris.',
 'price' => 155.00,
 'stock' => 50,
 'is_active' => true,
 'category_id' => $categories['fragancias-cuidado']->id,
 'image_url' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Cartera Tarjetero Slim RFID',
 'slug' => 'cartera-tarjetero-slim-rfid',
 'description' => 'Diseño ultrafino para hasta 8 tarjetas y billetes doblados con blindaje de protección contra clonación inalámbrica.',
 'price' => 55.00,
 'stock' => 80,
 'is_active' => true,
 'category_id' => $categories['bolsos-marroquineria']->id,
 'image_url' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Manta de Lana Merino Tejida a Mano',
 'slug' => 'manta-lana-merino-tejida',
 'description' => 'Punto grueso en lana merino 100% natural sin teñir. Suave, acogedora y termorreguladora para salón o pie de cama.',
 'price' => 145.00,
 'stock' => 25,
 'is_active' => true,
 'category_id' => $categories['hogar-diseno']->id,
 'image_url' => 'https://images.unsplash.com/photo-1580301762395-21ce84d00bc6?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Teclado Mecánico Retro Inalámbrico',
 'slug' => 'teclado-mecanico-retro-inalambrico',
 'description' => 'Teclas redondas estilo máquina de escribir clásica con switches táctiles Gateron Brown, retroiluminación cálida y chasis de aluminio.',
 'price' => 210.00,
 'stock' => 32,
 'is_active' => true,
 'category_id' => $categories['audio-tecnologia']->id,
 'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
 ],
 [
 'name' => 'Kit Gourmet de Aceites de Oliva Virgen Extra',
 'slug' => 'kit-gourmet-aceites-oliva',
 'description' => 'Cofre degustación con tres botellas de 500ml de monovarietales Picual, Arbequina y Hojiblanca de cosecha temprana en frío.',
 'price' => 78.00,
 'stock' => 65,
 'is_active' => true,
 'category_id' => $categories['coleccion-gourmet']->id,
 'image_url' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?auto=format&fit=crop&w=800&q=80',
 ],
 ];

        foreach ($productsData as $pData) {
            Product::updateOrCreate(
                ['slug' => $pData['slug']],
                $pData
            );
        }
    }
}
