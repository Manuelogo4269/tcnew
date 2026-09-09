<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        // Don't duplicate if already seeded
        if (Story::count() > 0) {
            return;
        }

        $stories = [
            // Café Acrópolis (2 slides)
            [
                'tenant_id' => 'acropolis',
                'store_name' => 'Café Acrópolis',
                'store_logo' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=800&q=80',
                'caption' => '☕ Café de especialidad recién tostado frente a la Catedral. ¡Ven a probar nuestro capuchino artesanal de cantera!',
                'cta_text' => 'Ver Menú de Cafetería',
                'cta_url' => '/tienda/acropolis',
                'whatsapp_number' => '4929221155',
                'views_count' => 312,
                'duration_seconds' => 5,
                'is_active' => true,
            ],
            [
                'tenant_id' => 'acropolis',
                'store_name' => 'Café Acrópolis',
                'store_logo' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80',
                'caption' => '🍰 Tartaleta artesanal de higo y nuez zacatecana disponible hoy en vitrina. Acompaña tu tarde en el Centro Histórico.',
                'cta_text' => 'Pedir por WhatsApp',
                'cta_url' => '/tienda/acropolis',
                'whatsapp_number' => '4929221155',
                'views_count' => 245,
                'duration_seconds' => 5,
                'is_active' => true,
            ],

            // Gorditas Doña Julia (2 slides)
            [
                'tenant_id' => 'donajulia',
                'store_name' => 'Gorditas Doña Julia',
                'store_logo' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=800&q=80',
                'caption' => '🌮 ¡Gorditas recién saliditas del comal! Asado de boda, deshebrada en salsa verde y chicharrón prensado.',
                'cta_text' => 'Ordenar Gorditas',
                'cta_url' => '/tienda/donajulia',
                'whatsapp_number' => '4929240890',
                'views_count' => 489,
                'duration_seconds' => 5,
                'is_active' => true,
            ],
            [
                'tenant_id' => 'donajulia',
                'store_name' => 'Gorditas Doña Julia',
                'store_logo' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80',
                'caption' => '🌶️ Tradición zacatecana desde hace más de 40 años. Visítanos a unos pasos de la Plazuela Goitia.',
                'cta_text' => 'Ver Sucursal y Menú',
                'cta_url' => '/tienda/donajulia',
                'whatsapp_number' => '4929240890',
                'views_count' => 380,
                'duration_seconds' => 5,
                'is_active' => true,
            ],

            // Rosa de Plata (2 slides)
            [
                'tenant_id' => 'rosadeplata',
                'store_name' => 'Platería Rosa de Plata',
                'store_logo' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=800&q=80',
                'caption' => '💎 Dije Catedral Basílica elaborado en Plata Pura Ley .925 por maestros orfebres de Zacatecas. Envío gratis a todo México.',
                'cta_text' => 'Ver Joyería en Plata',
                'cta_url' => '/tienda/rosadeplata',
                'whatsapp_number' => '4921123456',
                'views_count' => 610,
                'duration_seconds' => 5,
                'is_active' => true,
            ],
            [
                'tenant_id' => 'rosadeplata',
                'store_name' => 'Platería Rosa de Plata',
                'store_logo' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1611591475825-798835825547?auto=format&fit=crop&w=800&q=80',
                'caption' => '✨ Aretes filigrana en plata colonial. Cada pieza incluye certificado de autenticidad y estuche de regalo.',
                'cta_text' => 'Preguntar por WhatsApp',
                'cta_url' => '/tienda/rosadeplata',
                'whatsapp_number' => '4921123456',
                'views_count' => 432,
                'duration_seconds' => 5,
                'is_active' => true,
            ],

            // Dulcería El Serranito
            [
                'tenant_id' => 'elserranito',
                'store_name' => 'Dulces El Serranito',
                'store_logo' => 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1582058091505-f87a2e55a40f?auto=format&fit=crop&w=800&q=80',
                'caption' => '🍬 Dulces típicos zacatecanos: cajeta de leche quemada, ates de guayaba y jamoncillos de leche recién preparados.',
                'cta_text' => 'Ver Dulces Típicos',
                'cta_url' => '/tienda/elserranito',
                'whatsapp_number' => '4929227744',
                'views_count' => 298,
                'duration_seconds' => 5,
                'is_active' => true,
            ],

            // Las Quince Letras
            [
                'tenant_id' => 'quinceletras',
                'store_name' => 'Cantina Las Quince Letras',
                'store_logo' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=800&q=80',
                'caption' => '🍷 Mezcal artesanal reposado zacatecano con sal de gusano y rodajas de naranja. El museo-cantina más icónico desde 1906.',
                'cta_text' => 'Conocer Las Quince Letras',
                'cta_url' => '/tienda/quinceletras',
                'whatsapp_number' => '4929221234',
                'views_count' => 740,
                'duration_seconds' => 5,
                'is_active' => true,
            ],

            // Librería André-a
            [
                'tenant_id' => 'libreriaandrea',
                'store_name' => 'Librería André-a',
                'store_logo' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=160&q=80',
                'media_url' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80',
                'caption' => '📚 Poesía de Ramón López Velarde y novedades editoriales sobre la historia minera de Zacatecas. ¡Visita nuestro rincón literario!',
                'cta_text' => 'Explorar Libros',
                'cta_url' => '/tienda/libreriaandrea',
                'whatsapp_number' => '4929229876',
                'views_count' => 195,
                'duration_seconds' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($stories as $storyData) {
            Story::create($storyData);
        }
    }
}