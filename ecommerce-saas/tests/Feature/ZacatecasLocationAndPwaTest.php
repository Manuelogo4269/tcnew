<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Tests\TestCase;

class ZacatecasLocationAndPwaTest extends TestCase
{
    public function test_pwa_manifest_is_accessible_and_valid(): void
    {
        $response = $this->get('/manifest.json');
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertIsArray($json);
        $this->assertStringContainsString('Zacatecas', $json['name']);
        $this->assertEquals('standalone', $json['display']);
        $this->assertNotEmpty($json['icons']);
    }

    public function test_pwa_service_worker_is_accessible(): void
    {
        $response = $this->get('/sw.js');
        $response->assertStatus(200);
        $this->assertStringContainsString('CACHE_NAME', $response->getContent());
        $this->assertStringContainsString('atelier-zacatecas', $response->getContent());
    }

    public function test_central_portal_displays_zacatecas_centro_and_pwa(): void
    {
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);

        // Verify Zacatecas Centro elements
        $response->assertSee('Zacatecas Centro Histórico');
        $response->assertSee('Tiendas Cercanas');
        $response->assertSee('zacatecasMap');
        $response->assertSee('btnGpsProximity');
        $response->assertSee('Activar Mi Ubicación (GPS)');

        // Verify PWA installation bar
        $response->assertSee('pwaInstallBar');
        $response->assertSee('Instala la App de Tiendas de Zacatecas Centro');
    }

    public function test_tenant_storefront_displays_zacatecas_location_and_whatsapp_details(): void
    {
        $tenant = Tenant::find('acropolis');
        if (!$tenant) {
            $this->markTestSkipped('Tenant acropolis does not exist.');
        }

        $response = $this->get('http://acropolis.localhost/');
        $response->assertStatus(200);

        // Verify location information in modal / storefront
        $response->assertSee('Sucursal Zacatecas Centro');
        $response->assertSee('Av. Hidalgo');
        $response->assertSee('Google Maps');

        // Verify WhatsApp integration includes physical address & maps URL
        $response->assertSee('Sucursal / Recogida en Zacatecas Centro');
        $response->assertSee('Ubicación en Google Maps');
    }

    public function test_direct_tienda_route_with_database_session_and_cache(): void
    {
        $tenant = Tenant::find('acropolis');
        if (!$tenant) {
            $this->markTestSkipped('Tenant acropolis does not exist.');
        }

        // Enforce database session to test production behavior
        config(['session.driver' => 'database']);

        $response = $this->get('/tienda/acropolis');
        $response->assertStatus(200);
        $response->assertSee('Café Acrópolis');
        $response->assertSee('acropolis');
    }

    public function test_logo_and_pwa_icons_are_accessible_and_rendered_properly(): void
    {
        // Central portal should reference app-icons/icon.svg
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);
        $response->assertSee('/app-icons/icon.svg');

        // Check that app-icons are physically present in public path
        $this->assertFileExists(public_path('app-icons/icon.svg'));
        $this->assertFileExists(public_path('app-icons/icon-192.png'));
        $this->assertFileExists(public_path('app-icons/icon-512.png'));
    }
}

