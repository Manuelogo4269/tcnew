<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        if (Review::count() > 0) {
            return;
        }

        $reviews = [
            // --- REVIEWS FOR COMPANIES ---
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'acropolis',
                'author_name' => 'Sofía Montes de Oca',
                'rating' => 5,
                'comment' => 'El café de grano es espectacular y el ambiente rodeado de obras de arte es inigualable en todo Zacatecas. Excelente servicio frente a la Catedral.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(2),
            ],
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'acropolis',
                'author_name' => 'Dr. Carlos Romo',
                'rating' => 5,
                'comment' => 'La tartaleta de higo y el café capuchino son parada obligatoria siempre que visito el Centro Histórico. Gran tradición zacatecana.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(5),
            ],
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'acropolis',
                'author_name' => 'Lucía Alatorre',
                'rating' => 4,
                'comment' => 'Muy buen café y pastelería fina. A veces se llena por las mañanas pero la atención siempre es muy cálida.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(8),
            ],

            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'donajulia',
                'author_name' => 'Mariana Treviño',
                'rating' => 5,
                'comment' => 'Las mejores gorditas de asado de boda y chicharrón prensado de todo el estado. Calientitas y recién salidas del comal.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(1),
            ],
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'donajulia',
                'author_name' => 'Arq. Héctor Gallegos',
                'rating' => 5,
                'comment' => 'Sabor zacatecano auténtico desde hace décadas. La masa de maíz y el sazón del asado de boda son inigualables.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(4),
            ],

            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'rosadeplata',
                'author_name' => 'Valeria Cárdenas',
                'rating' => 5,
                'comment' => 'Compré un dije de la Catedral en plata pura Ley .925 y la finura de la filigrana es impresionante. Viene con certificado de autenticidad.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(3),
            ],
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'rosadeplata',
                'author_name' => 'Ing. Fernando Varela',
                'rating' => 5,
                'comment' => 'Joyería de plata de alta gama a precios muy justos de taller zacatecano. El envío fue súper rápido y el empaque muy elegante.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(6),
            ],

            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'elserranito',
                'author_name' => 'Fernanda Pacheco',
                'rating' => 5,
                'comment' => 'Los jamoncillos de leche y la cajeta quemada son deliciosos. Es el mejor lugar para comprar los recuerdos de dulce típicos de Zacatecas.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(3),
            ],

            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'quinceletras',
                'author_name' => 'Javier Morales',
                'rating' => 5,
                'comment' => 'Un museo viviente con más de 115 años de historia. El mezcal artesanal zacatecano reposado y el ambiente son de visita obligada.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(7),
            ],

            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'libreriaandrea',
                'author_name' => 'Mtra. Laura Bañuelos',
                'rating' => 5,
                'comment' => 'Excelente catálogo sobre la historia minera de Zacatecas y poesía de Ramón López Velarde. Una joya cultural en el Centro.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(10),
            ],

            // --- REVIEWS FOR PRODUCTS ---
            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'cafe-americano-seleccion-acropolis',
                'author_name' => 'Gustavo A.',
                'rating' => 5,
                'comment' => 'Aroma tostado impecable con notas de cacao y avellana. Sin duda el mejor café americano del Centro Histórico.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(2),
            ],
            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'cafe-americano-seleccion-acropolis',
                'author_name' => 'Patricia N.',
                'rating' => 5,
                'comment' => 'Muy balanceado, nada ácido y con cuerpo perfecto. Ideal para iniciar la mañana caminando por la Avenida Hidalgo.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(5),
            ],

            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'gordita-de-asado-de-boda-zacatecano',
                'author_name' => 'Ernesto Díaz',
                'rating' => 5,
                'comment' => 'El asado de boda tiene ese sabor tradicional con chile ancho y chocolate que solo las cocineras de Doña Julia logran.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(1),
            ],
            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'gordita-de-asado-de-boda-zacatecano',
                'author_name' => 'Brenda S.',
                'rating' => 5,
                'comment' => 'Relleno muy generoso y la masa de maíz gruesa y doradita en el comal. Deliciosas.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(3),
            ],

            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'dije-catedral-basilica-en-plata-ley-925',
                'author_name' => 'Rebeca M.',
                'rating' => 5,
                'comment' => 'El detalle de las torres barrocas en plata es una obra de arte miniatura. Me encantó el brillo y la cadena incluida.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(4),
            ],

            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'nieve-artesanal-de-garrafa-tres-sabores',
                'author_name' => 'Samuel V.',
                'rating' => 5,
                'comment' => 'La nieve de vainilla con tuna y limón es súper refrescante para las tardes calurosas del Centro.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(2),
            ],

            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'mezcal-artesanal-reposado-zacatecano-750ml',
                'author_name' => 'Mauricio K.',
                'rating' => 5,
                'comment' => 'Notas ahumadas suaves y madera de roble bien lograda. 100% maguey salmiana zacatecano.',
                'verified_purchase' => true,
                'created_at' => now()->subDays(6),
            ],
        ];

        foreach ($reviews as $rev) {
            Review::create($rev);
        }
    }
}