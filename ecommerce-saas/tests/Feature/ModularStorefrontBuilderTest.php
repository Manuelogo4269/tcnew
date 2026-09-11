<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModularStorefrontBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Create or get tenant
        $tenant = Tenant::firstOrCreate(
            ['id' => 'acropolis'],
            ['tenancy_admin_email' => 'admin@acropolis.test']
        );

        tenancy()->initialize($tenant);

        $settings = StoreSetting::first();
        if ($settings) {
            $settings->layout_blocks = null;
            $settings->save();
        }

        // Ensure a product exists
        $cat = Category::firstOrCreate(
            ['slug' => 'artesanias'],
            ['name' => 'Artesanías Zacatecas']
        );

        Product::firstOrCreate(
            ['slug' => 'plata-zacatecana'],
            [
                'category_id' => $cat->id,
                'name' => 'Dije de Cantera y Plata',
                'description' => 'Joya zacatecana artesanal',
                'price' => 450.00,
                'stock' => 15,
                'is_active' => true,
            ]
        );

        tenancy()->end();
    }

    protected function tearDown(): void
    {
        tenancy()->initialize('acropolis');
        $settings = StoreSetting::first();
        if ($settings) {
            $settings->layout_blocks = null;
            $settings->save();
        }
        tenancy()->end();

        parent::tearDown();
    }

    public function test_default_modular_storefront_renders_all_sections(): void
    {
        $response = $this->get('/tienda/acropolis');
        $response->assertStatus(200);

        // Check that default sections exist in body
        $response->assertSee('<section class="hero-carousel-container"', false);
        $response->assertSee('<section class="trust-bar">', false);
        $response->assertSee('<section class="flash-deals-section"', false);
        $response->assertSee('id="categorias"', false);
        $response->assertSee('id="catalogo"', false);
        $response->assertSee('⏳ La oferta finaliza en:');
    }

    public function test_hiding_a_section_removes_it_from_storefront(): void
    {
        $tenant = Tenant::find('acropolis');
        tenancy()->initialize($tenant);

        $settings = StoreSetting::first();
        if (!$settings) {
            $settings = StoreSetting::create(['store_name' => 'Café Acrópolis']);
        }

        // Set layout blocks with flash_deals hidden
        $blocks = StoreSetting::defaultLayoutBlocks();
        foreach ($blocks as &$b) {
            if ($b['type'] === 'flash_deals') {
                $b['is_visible'] = false;
            }
        }
        unset($b);

        $settings->layout_blocks = $blocks;
        $settings->save();
        tenancy()->end();

        $response = $this->get('/tienda/acropolis');
        $response->assertStatus(200);
        $response->assertDontSee('<section class="flash-deals-section"', false);
        $response->assertDontSee('⏳ La oferta finaliza en:');
        $response->assertSee('<section class="hero-carousel-container"', false);
    }

    public function test_reordering_sections_changes_rendered_order(): void
    {
        $tenant = Tenant::find('acropolis');
        tenancy()->initialize($tenant);

        $settings = StoreSetting::first();

        // Custom order: flash_deals FIRST, then banner_carousel
        $customBlocks = [
            [
                'type' => 'flash_deals',
                'is_visible' => true,
                'title' => 'SUPER OFERTA EXCLUSIVA',
                'data' => [
                    'eyebrow' => 'Oferta Especial Test',
                    'title' => 'SUPER OFERTA EXCLUSIVA',
                    'subtitle' => 'Subtítulo personalizado para test de orden',
                ],
            ],
            [
                'type' => 'banner_carousel',
                'is_visible' => true,
                'title' => 'Carrusel Secundario',
                'data' => [
                    'title' => 'Banner después de ofertas',
                ],
            ],
            [
                'type' => 'full_catalog',
                'is_visible' => true,
                'title' => 'Catálogo Test',
                'data' => [],
            ],
        ];

        $settings->layout_blocks = $customBlocks;
        $settings->save();
        tenancy()->end();

        $response = $this->get('/tienda/acropolis');
        $response->assertStatus(200);

        $content = $response->getContent();
        $flashPos = strpos($content, '<section class="flash-deals-section"');
        $heroPos = strpos($content, '<section class="hero-carousel-container"');

        $this->assertNotFalse($flashPos, 'flash-deals-section tag should be present in body');
        $this->assertNotFalse($heroPos, 'hero-carousel-container tag should be present in body');
        $this->assertTrue($flashPos < $heroPos, 'flash-deals-section must appear BEFORE hero-carousel-container in body');
        $response->assertSee('SUPER OFERTA EXCLUSIVA');
    }
}
