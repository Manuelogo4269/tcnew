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
    protected ?array $savedBlocks = null;

    protected function setUp(): void
    {
        parent::setUp();

        $tenant = Tenant::firstOrCreate(
            ['id' => 'conceptos7'],
            ['plan_name' => 'Corporativo']
        );

        tenancy()->initialize($tenant);

        $settings = StoreSetting::first();
        if ($settings) {
            $this->savedBlocks = $settings->layout_blocks;
            $settings->layout_blocks = null;
            $settings->save();
        }

        // Ensure a product exists
        $cat = Category::firstOrCreate(
            ['slug' => 'joyeria-y-accesorio'],
            ['name' => 'Joyería y Accesorio ✨']
        );

        Product::firstOrCreate(
            ['slug' => 'collar-choker-eslabones-oro-18k'],
            [
                'category_id' => $cat->id,
                'name' => 'Collar Choker de Eslabones en Baño de Oro 18K',
                'description' => 'Collar gargantilla moderno',
                'price' => 690.00,
                'stock' => 15,
                'is_active' => true,
            ]
        );

        tenancy()->end();
    }

    protected function tearDown(): void
    {
        if (Tenant::find('conceptos7')) {
            tenancy()->initialize('conceptos7');
            $settings = StoreSetting::first();
            if ($settings) {
                $settings->layout_blocks = $this->savedBlocks;
                $settings->save();
            }
            Product::where('slug', 'collar-choker-eslabones-oro-18k')->delete();
            tenancy()->end();
        }

        parent::tearDown();
    }

    public function test_default_modular_storefront_renders_all_sections(): void
    {
        $response = $this->get('/tienda/conceptos7');
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
        $tenant = Tenant::find('conceptos7');
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

        $response = $this->get('/tienda/conceptos7');
        $response->assertStatus(200);
        $response->assertDontSee('<section class="flash-deals-section"', false);
        $response->assertDontSee('⏳ La oferta finaliza en:');
        $response->assertSee('<section class="hero-carousel-container"', false);
    }

    public function test_reordering_sections_changes_rendered_order(): void
    {
        $tenant = Tenant::find('conceptos7');
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

        $response = $this->get('/tienda/conceptos7');
        $response->assertStatus(200);

        $content = $response->getContent();
        $flashPos = strpos($content, '<section class="flash-deals-section"');
        $heroPos = strpos($content, '<section class="hero-carousel-container"');

        $this->assertNotFalse($flashPos, 'flash-deals-section tag should be present in body');
        $this->assertNotFalse($heroPos, 'hero-carousel-container tag should be present in body');
        $this->assertTrue($flashPos < $heroPos, 'flash-deals-section must appear BEFORE hero-carousel-container in body');
        $response->assertSee('SUPER OFERTA EXCLUSIVA');
    }

    public function test_live_modular_editor_is_rendered_for_tenant_admin(): void
    {
        $response = $this->withSession(['tenant_admin_tenant_id' => 'conceptos7'])
            ->get('/tienda/conceptos7');

        $response->assertStatus(200);
        $response->assertSee('liveModularEditorApp');
        $response->assertSee('Personalizar Diseño');
        $response->assertSee('Constructor Visual');
        $response->assertSee('saveLiveLayoutChanges');
    }

    public function test_api_updates_store_layout_blocks(): void
    {
        $tenant = Tenant::find('conceptos7');
        $this->assertNotNull($tenant);

        $newBlocks = [
            [
                'type' => 'flash_deals',
                'is_visible' => true,
                'title' => 'Ofertas desde API',
            ],
            [
                'type' => 'categories',
                'is_visible' => false,
                'title' => 'Categorías Ocultas',
            ],
        ];

        $response = $this->postJson('/api/tienda/conceptos7/layout', [
            'layout_blocks' => $newBlocks,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $saved = $tenant->run(fn () => StoreSetting::first()->layout_blocks);
        $this->assertCount(2, $saved);
        $this->assertEquals('flash_deals', $saved[0]['type']);
        $this->assertFalse($saved[1]['is_visible']);
    }
}
