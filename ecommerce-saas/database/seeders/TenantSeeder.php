<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CustomerAccount;
use App\Models\Order;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\TenantUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = tenant('id') ?? 'empresa1';
        $storeName = str($tenantId)->replace(['-', '_'], ' ')->title()->toString();

        // 1. Tenant Admin User
        $adminEmail = "admin@{$tenantId}.com";
        TenantUser::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => "Admin {$storeName}",
                'password' => Hash::make('password'),
            ]
        );

        // 2. Store Settings
        StoreSetting::updateOrCreate(
            ['id' => 1],
            [
                'store_name' => "{$storeName} Boutique",
                'contact_email' => "hola@{$tenantId}.com",
                'primary_color' => '#d96b45',
                'logo_url' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?auto=format&fit=crop&w=150&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80',
                'address' => 'Av. Hidalgo #305, Centro Histórico, Zacatecas, Zac., CP 98000',
                'neighborhood_zone' => 'Centro Histórico (Av. Hidalgo)',
                'city' => 'Zacatecas',
                'latitude' => 22.7748,
                'longitude' => -102.5732,
                'maps_url' => 'https://maps.google.com/?q=22.7748,-102.5732',
                'opening_hours' => 'Lunes a Sábado: 10:00 AM - 8:30 PM',
                'location_reference' => 'Frente al Portal de Rosales, Centro de Zacatecas',
            ]
        );

        // 3. Categories
        $catFashion = Category::firstOrCreate(
            ['slug' => 'ropa-accesorios'],
            ['name' => 'Ropa y Accesorios', 'description' => 'Prendas con materiales de alta calidad y diseño atemporal.']
        );

        $catHome = Category::firstOrCreate(
            ['slug' => 'hogar-decoracion'],
            ['name' => 'Hogar y Decoración', 'description' => 'Objetos conscientes para crear espacios serenos y funcionales.']
        );

        $catTech = Category::firstOrCreate(
            ['slug' => 'tecnologia-accesorios'],
            ['name' => 'Tecnología Minimalista', 'description' => 'Dispositivos y accesorios que integran simplicidad y potencia.']
        );

        // 4. Products
        $productsData = [
            [
                'category_id' => $catFashion->id,
                'name' => 'Bolso Nómada de Cuero',
                'slug' => 'bolso-nomada-cuero',
                'description' => 'Elaborado en cuero curtido vegetal con compartimentos dedicados para portátil y esenciales.',
                'price' => 129.00,
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=700&q=85',
                'is_active' => true,
            ],
            [
                'category_id' => $catFashion->id,
                'name' => 'Zapatillas Lino Crudo',
                'slug' => 'zapatillas-lino-crudo',
                'description' => 'Calzado artesanal en lino natural y suela de caucho reciclado para un andar ultraligero.',
                'price' => 89.00,
                'stock' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=700&q=85',
                'is_active' => true,
            ],
            [
                'category_id' => $catHome->id,
                'name' => 'Jarrón de Cerámica Arena',
                'slug' => 'jarron-ceramica-arena',
                'description' => 'Moldeado a mano en gres con textura mineral mate. Ideal para arreglos florales secos.',
                'price' => 48.00,
                'stock' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1523779917675-b6ed3a42a561?auto=format&fit=crop&w=700&q=85',
                'is_active' => true,
            ],
            [
                'category_id' => $catHome->id,
                'name' => 'Set de Posavasos Mármol',
                'slug' => 'set-posavasos-marmol',
                'description' => 'Cuatro piezas pulidas en mármol macizo con base de corcho protectora.',
                'price' => 34.50,
                'stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1579656381226-5fc0f0100c3b?auto=format&fit=crop&w=700&q=85',
                'is_active' => true,
            ],
            [
                'category_id' => $catTech->id,
                'name' => 'Cargador Inalámbrico Nogal',
                'slug' => 'cargador-inalambrico-nogal',
                'description' => 'Base de carga rápida inalámbrica revestida en madera noble maciza de nogal.',
                'price' => 59.99,
                'stock' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1586816879360-004f5b0c51e3?auto=format&fit=crop&w=700&q=85',
                'is_active' => true,
            ],
        ];

        foreach ($productsData as $prod) {
            Product::firstOrCreate(
                ['slug' => $prod['slug']],
                $prod
            );
        }

        // 5. Link Global Customer (Juan Pérez) if exists in Central DB
        $globalCustomer = CustomerAccount::where('email', 'juan@gmail.com')->first();
        if ($globalCustomer) {
            $customer = TenantUser::firstOrCreate(
                ['customer_account_id' => (string) $globalCustomer->id],
                [
                    'name' => $globalCustomer->name,
                    'email' => $globalCustomer->email,
                    'password' => Hash::make(Str::random(32)),
                ]
            );

            // 6. Sample Order for Juan
            $firstProduct = Product::first();
            if ($firstProduct && Order::where('user_id', $customer->id)->count() === 0) {
                $order = Order::create([
                    'user_id' => $customer->id,
                    'status' => 'processing',
                    'total_amount' => $firstProduct->price,
                    'shipping_address' => 'Av. Principal #456, Depto 2B, Ciudad de México',
                ]);

                $order->items()->create([
                    'product_id' => $firstProduct->id,
                    'quantity' => 1,
                    'price' => $firstProduct->price,
                ]);
            }
        }
    }
}
