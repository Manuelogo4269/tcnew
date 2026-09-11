<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        Review::truncate();

        $reviews = [
            // --- REVIEWS FOR COMPANY (conceptos7) ---
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'conceptos7',
                'author_name' => 'Sofía Montes de Oca',
                'rating' => 5,
                'comment' => '¡Mi tienda favorita en el Centro de Zacatecas! La joyería tiene una calidad divina y los vestidos son únicos. El empaque súper fino para regalo.',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(2),
            ],
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'conceptos7',
                'author_name' => 'Valeria Cárdenas',
                'rating' => 5,
                'comment' => 'Excelente atención personalizada por WhatsApp y en su boutique de Tacuba. Compré un set de gargantilla y aretes, ¡no se manchan y brillan hermoso!',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(4),
            ],
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'conceptos7',
                'author_name' => 'Mariana Treviño',
                'rating' => 5,
                'comment' => 'Los tacones son comodísimos y la ropa tiene un corte y tela espectacular. Además el envío llegó al día siguiente.',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(6),
            ],
            [
                'reviewable_type' => 'company',
                'reviewable_id' => 'conceptos7',
                'author_name' => 'Fernanda Pacheco',
                'rating' => 4,
                'comment' => 'Diseños muy en tendencia estilo aesthetic y de fiesta. Cada semana tienen novedades en su Instagram @conceptos.7.',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(9),
            ],

            // --- REVIEWS FOR PRODUCTS ---
            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'collar-choker-eslabones-oro-18k',
                'author_name' => 'Brenda S.',
                'rating' => 5,
                'comment' => 'El baño en oro de 18k luce súper elegante y pesado, de altísima calidad. Ha resistido perfume sin perder nada de brillo.',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(2),
            ],
            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'collar-choker-eslabones-oro-18k',
                'author_name' => 'Lucía Alatorre',
                'rating' => 5,
                'comment' => 'Precioso choker, resalta cualquier outfit formal o casual.',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(5),
            ],
            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'vestido-midi-satinado-espalda-abierta',
                'author_name' => 'Rebeca M.',
                'rating' => 5,
                'comment' => 'La caída del satín es perfecta y el detalle de la espalda estiliza muchísimo. Lo usé para una boda en Zacatecas y recibí mil halagos.',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(3),
            ],
            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'tacones-stiletto-punta-triangular',
                'author_name' => 'Patricia N.',
                'rating' => 5,
                'comment' => 'Tacones elegantes y con plantilla acolchada. No cansan nada y el tacón delgado luce sofisticado.',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(4),
            ],
            [
                'reviewable_type' => 'product',
                'reviewable_id' => 'bolso-tote-estructurado-ecocuero',
                'author_name' => 'Mtra. Laura Bañuelos',
                'rating' => 5,
                'comment' => 'Acabado y costuras de primera, el tamaño es ideal para llevar todo el día.',
                'verified_purchase' => true,
                'is_approved' => true,
                'created_at' => now()->subDays(7),
            ],
        ];

        foreach ($reviews as $rev) {
            Review::create($rev);
        }
    }
}