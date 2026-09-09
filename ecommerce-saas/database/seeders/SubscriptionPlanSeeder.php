<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Plan Emprendedor',
                'slug' => 'emprendedor',
                'badge' => null,
                'tagline' => 'La solución perfecta para pequeños negocios, boutiques y artesanos que desean digitalizarse.',
                'monthly_price' => 19.00,
                'annual_price_per_month' => 15.00,
                'annual_discount_percentage' => 21,
                'currency' => 'USD',
                'product_limit' => 50,
                'has_custom_domain' => false,
                'has_priority_support' => false,
                'has_analytics' => false,
                'has_api_access' => false,
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
                'features' => [
                    'Catálogo de hasta 50 productos activos',
                    'Enlace exclusivo (atelier-zacatecas.onrender.com/tienda/tunegocio)',
                    'Panel de administración privado y autónomo',
                    '0% comisión por ventas generadas',
                    'Personalización de colores de marca y logotipo',
                    'Diseño responsivo optimizado para compras móviles',
                    'Soporte estándar por correo electrónico',
                ],
            ],
            [
                'name' => 'Plan Crecimiento',
                'slug' => 'crecimiento',
                'badge' => 'Más Popular',
                'tagline' => 'Diseñado para empresas y marcas en expansión que buscan máxima presencia y acelerar sus ventas.',
                'monthly_price' => 39.00,
                'annual_price_per_month' => 31.00,
                'annual_discount_percentage' => 20,
                'currency' => 'USD',
                'product_limit' => null,
                'has_custom_domain' => true,
                'has_priority_support' => true,
                'has_analytics' => true,
                'has_api_access' => false,
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
                'features' => [
                    'Productos y categorías totalmente ILIMITADOS',
                    'Subdominio + soporte para dominio web personalizado',
                    'Panel de control avanzado con analíticas de pedidos',
                    'Personalización completa de diseño: colores, fuentes y banners',
                    'Botones de enlace a sitio web oficial y WhatsApp comercial',
                    'Búsqueda global y carruseles interactivos de catálogo',
                    '0% de comisión por transacción',
                    'Soporte prioritario 24/7 por chat y WhatsApp',
                ],
            ],
            [
                'name' => 'Plan Corporativo',
                'slug' => 'corporativo',
                'badge' => 'Empresas Líderes',
                'tagline' => 'Infraestructura de alto rendimiento y asesoría dedicada para marcas consolidadas y cadenas.',
                'monthly_price' => 89.00,
                'annual_price_per_month' => 71.00,
                'annual_discount_percentage' => 20,
                'currency' => 'USD',
                'product_limit' => null,
                'has_custom_domain' => true,
                'has_priority_support' => true,
                'has_analytics' => true,
                'has_api_access' => true,
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
                'features' => [
                    'Todo lo del Plan Crecimiento incluido',
                    'Base de datos aislada con motor WAL de máxima velocidad',
                    'Múltiples cuentas de administradores con roles de usuario',
                    'API REST para integración con ERP, facturación o POS',
                    'Onboarding VIP: migración y carga asistida de productos',
                    'Posicionamiento preferencial en el Directorio Global',
                    'Gestor de cuenta y soporte telefónico exclusivo 24/7',
                ],
            ],
        ];

        foreach ($plans as $data) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
