<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tenantId = tenant('id');
        if ($tenantId !== 'conceptos7') {
            return;
        }

        // 1. Update Store Branding with official Instagram Profile & Logo
        $settings = StoreSetting::first();
        if ($settings) {
            $logoTextFile = database_path('data/conceptos_logo.txt');
            $logoData = null;
            if (file_exists($logoTextFile)) {
                $logoData = trim(file_get_contents($logoTextFile));
            } elseif (file_exists(storage_path('app/public/logos/conceptos7_logo.jpg'))) {
                $logoData = 'data:image/jpeg;base64,' . base64_encode(file_get_contents(storage_path('app/public/logos/conceptos7_logo.jpg')));
            }

            if ($logoData && str_starts_with($logoData, 'data:image')) {
                $logoDiskPath = storage_path('app/public/logos/conceptos7_logo.jpg');
                if (!file_exists($logoDiskPath)) {
                    @mkdir(dirname($logoDiskPath), 0777, true);
                    $parts = explode(',', $logoData, 2);
                    if (count($parts) === 2) {
                        @file_put_contents($logoDiskPath, base64_decode($parts[1]));
                    }
                }
            }

            $updateData = [
                'store_name' => 'D & R CONCEPTOS',
                'description' => '📍 Zacatecas Centro | Joyería y Accesorio ✨ | Ropa y calzado 👠 | Atención personalizada',
                'business_category' => '👗 Moda, Lujo & Accesorios',
            ];

            if ($logoData) {
                $updateData['logo_url'] = 'logos/conceptos7_logo.jpg';
                $updateData['logo_data'] = $logoData;
            }

            $settings->update($updateData);
        }

        // 2. Load Instagram products data
        $jsonPath = database_path('data/conceptos_products.json');
        if (!file_exists($jsonPath)) {
            return;
        }

        $items = json_decode(file_get_contents($jsonPath), true);
        if (empty($items)) {
            return;
        }

        // 3. Category for fashion & trend
        $category = Category::firstOrCreate(
            ['slug' => 'ropa-tendencia'],
            [
                'name' => 'Ropa & Tendencia 👗',
                'description' => 'Colección exclusiva de prendas y tendencias de temporada',
            ]
        );

        // 4. Create or update each product
        foreach ($items as $item) {
            $imageData = $item['image_data'] ?? null;
            if (empty($imageData) && !empty($item['image_url'])) {
                $localPath = storage_path('app/public/' . ltrim($item['image_url'], '/'));
                if (file_exists($localPath)) {
                    $imageData = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($localPath));
                }
            }

            if (!empty($imageData) && !empty($item['image_url']) && str_starts_with($imageData, 'data:image')) {
                $diskPath = storage_path('app/public/' . ltrim($item['image_url'], '/'));
                if (!file_exists($diskPath)) {
                    @mkdir(dirname($diskPath), 0777, true);
                    $parts = explode(',', $imageData, 2);
                    if (count($parts) === 2) {
                        @file_put_contents($diskPath, base64_decode($parts[1]));
                    }
                }
            }

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'image_url' => $item['image_url'],
                    'image_data' => $imageData,
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tenantId = tenant('id');
        if ($tenantId !== 'conceptos7') {
            return;
        }

        $jsonPath = database_path('data/conceptos_products.json');
        if (file_exists($jsonPath)) {
            $items = json_decode(file_get_contents($jsonPath), true);
            $slugs = array_column($items, 'slug');
            Product::whereIn('slug', $slugs)->delete();
        }
    }
};
