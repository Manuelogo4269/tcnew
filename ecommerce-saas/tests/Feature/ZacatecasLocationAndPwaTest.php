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
        $tenant = Tenant::find('conceptos7');
        if (!$tenant) {
            $this->markTestSkipped('Tenant conceptos7 does not exist.');
        }

        $response = $this->get('http://conceptos7.localhost/');
        $response->assertStatus(200);

        // Verify location information in modal / storefront
        $response->assertSee('Sucursal Zacatecas Centro');
        $response->assertSee('Calle Tacuba');
        $response->assertSee('Google Maps');

        // Verify WhatsApp integration includes physical address & maps URL
        $response->assertSee('Sucursal / Recogida en Zacatecas Centro');
        $response->assertSee('Ubicación en Google Maps');
    }

    public function test_direct_tienda_route_with_database_session_and_cache(): void
    {
        $tenant = Tenant::find('conceptos7');
        if (!$tenant) {
            $this->markTestSkipped('Tenant conceptos7 does not exist.');
        }

        // Enforce database session to test production behavior
        config(['session.driver' => 'database']);

        $response = $this->get('/tienda/conceptos7');
        $response->assertStatus(200);
        $response->assertSee('D & R CONCEPTOS');
        $response->assertSee('conceptos7');
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

    public function test_pwa_return_home_buttons_and_navigation_controls_are_present(): void
    {
        // 1. Central Portal Navigation Controls
        $portalResponse = $this->get('http://localhost/');
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('mobileBottomNav');
        $portalResponse->assertSee('bnavFeed');
        $portalResponse->assertSee('goToPortalHome');
        $portalResponse->assertSee('Volver al Inicio de Zacatecas');

        // 2. Tenant Storefront Return to Home Controls
        $storeResponse = $this->get('/tienda/conceptos7');
        $storeResponse->assertStatus(200);
        $storeResponse->assertSee('btnHeaderBackPortal');
        $storeResponse->assertSee('Inicio Zacatecas');
        $storeResponse->assertSee('pwaFloatingBottomBar');
        $storeResponse->assertSee('pwaFabHomeBtn');
        $storeResponse->assertSee('Volver al Inicio del Portal');
        $storeResponse->assertSee('initPwaHistoryGuard');
    }
}

