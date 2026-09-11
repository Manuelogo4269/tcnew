<?php

namespace Tests\Feature;

use App\Models\StoreSetting;
use App\Models\Tenant;
use Tests\TestCase;

class StoreCustomizationTest extends TestCase
{
    public function test_tenant_design_customization_renders_on_storefront_and_api(): void
    {
        $tenant = Tenant::findOrFail('acropolis');

        // 1. Customize design, colors, font, and WhatsApp in tenant DB
        $tenant->run(function () {
            StoreSetting::updateOrCreate(
                ['id' => 1],
                [
                    'store_name' => 'Café Acrópolis Vanguardia',
                    'tagline' => 'Diseño Exclusivo y Café',
                    'primary_color' => '#2563eb',
                    'secondary_color' => '#f8fafc',
                    'font_family' => 'Inter',
                    'banner_url' => 'https://images.unsplash.com/test-banner.jpg',
                    'hero_title' => 'Colección Futura 2026',
                    'hero_subtitle' => 'Descubre las tendencias que definen el estilo moderno.',
                    'hero_button_text' => 'Comprar Ahora',
                    'show_announcement' => true,
                    'announcement_text' => '¡Envío express gratis por tiempo limitado!',
                    'whatsapp_number' => '+52 55 9876 5432',
                    'instagram_url' => 'https://instagram.com/acropolismoda',
                ]
            );
        });

        // 2. Verify Storefront (HTML) dynamically displays these colors and fonts
        $response = $this->get('http://acropolis.localhost/');
        $response->assertStatus(200);
        $response->assertSee('Café Acrópolis Vanguardia');
        $response->assertSee('Diseño Exclusivo y Café');
        $response->assertSee('--accent: #2563eb;', false);
        $response->assertSee('--paper: #f8fafc;', false);
        $response->assertSee("'Inter', sans-serif", false);
        $response->assertSee('Colección Futura 2026');
        $response->assertSee('Comprar Ahora');
        $response->assertSee('¡Envío express gratis por tiempo limitado!');
        $response->assertSee('wa.me/525598765432', false);
        $response->assertSee('instagram.com/acropolismoda', false);

        // 3. Verify Mobile API settings endpoint returns full design tokens
        $apiResponse = $this->getJson('/api/stores/acropolis/settings');
        $apiResponse->assertStatus(200)
            ->assertJson([
                'store_name' => 'Café Acrópolis Vanguardia',
                'tagline' => 'Diseño Exclusivo y Café',
                'primary_color' => '#2563eb',
                'secondary_color' => '#f8fafc',
                'font_family' => 'Inter',
                'hero_title' => 'Colección Futura 2026',
                'whatsapp_number' => '+52 55 9876 5432',
            ]);

        // 4. Verify Tenant Admin Panel (/tenant-admin) dynamically adopts the tenant brand color (#2563eb)
        $adminUser = $tenant->run(fn () => \App\Models\TenantUser::where('email', 'admin@acropolis.com')->first());
        $adminResponse = $this->actingAs($adminUser, 'tenant')
            ->get('http://acropolis.localhost/tenant-admin');
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('--tenant-brand-primary: #2563eb;', false);
    }

    public function test_storefront_renders_categories_filter_product_modal_and_official_business_links(): void
    {
        $tenant = Tenant::findOrFail('acropolis');

        $tenant->run(function () {
            StoreSetting::updateOrCreate(
                ['id' => 1],
                [
                    'official_website_url' => 'https://www.cafeacropolis.com.mx',
                ]
            );
        });

        $response = $this->get('http://acropolis.localhost/');
        $response->assertStatus(200);

        // 1. Verify Business Redirect Buttons & Links (Official website is omitted for customers)
        $response->assertDontSee('Sitio Web ↗');
        $response->assertDontSee('https://www.cafeacropolis.com.mx', false);
        $response->assertSee('Red de Tiendas ▾');
        $response->assertSee('Directorio de Negocios');
        $response->assertSee('/tienda/donajulia', false);
        $response->assertSee('/tienda/rosadeplata', false);

        // 2. Verify Category Carousel & Interactive Filter Pills
        $response->assertSee('Explorar por Categoría');
        $response->assertSee('id="categoryPills"', false);
        $response->assertSee('cat-pill', false);
        $response->assertSee('selectCategory', false);
        $response->assertSee('active-cat', false);

        // 3. Verify Enriched Product Detail Modal & Actions
        $response->assertSee('id="productDetailModal"', false);
        $response->assertSee('id="modalSku"', false);
        $response->assertSee('id="modalStock"', false);
        $response->assertSee('id="modalQtyDisplay"', false);
        $response->assertSee('id="modalSubtotal"', false);
        $response->assertSee('specs-grid', false);
        $response->assertSee('btn-whatsapp-order', false);
        $response->assertSee('id="modalRelatedGrid"', false);
        $response->assertSee('copyProductDirectLink', false);
    }
}
