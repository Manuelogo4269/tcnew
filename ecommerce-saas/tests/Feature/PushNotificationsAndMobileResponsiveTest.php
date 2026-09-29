<?php

namespace Tests\Feature;

use App\Models\PushSubscription;
use App\Models\Tenant;
use Tests\TestCase;

class PushNotificationsAndMobileResponsiveTest extends TestCase
{
    protected string $tenantId = 'conceptos7';

    public function test_push_subscription_endpoint_registers_device(): void
    {
        $response = $this->postJson("/api/tienda/{$this->tenantId}/push/subscribe", [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/sample-token-123456789',
            'public_key' => 'sample-p256dh-key',
            'auth_token' => 'sample-auth-secret',
            'user_identifier' => 'cliente.movil@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $tenant = Tenant::findOrFail($this->tenantId);
        $tenant->run(function () {
            $this->assertDatabaseHas('push_subscriptions', [
                'endpoint' => 'https://fcm.googleapis.com/fcm/send/sample-token-123456789',
                'user_identifier' => 'cliente.movil@example.com',
            ]);
        });
    }

    public function test_send_test_push_trigger_returns_payload(): void
    {
        $response = $this->postJson("/api/tienda/{$this->tenantId}/push/send-test");
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'message',
                'subscribers_count',
                'payload' => ['title', 'body', 'icon']
            ]);
    }

    public function test_storefront_renders_appointments_memberships_and_non_overlapping_mobile_ui(): void
    {
        $response = $this->get("/tienda/{$this->tenantId}");
        $response->assertStatus(200);

        // 1. Appointments & Membership modal triggers
        $response->assertSee('openAppointmentsModal()', false);
        $response->assertSee('openMembershipsModal()', false);
        $response->assertSee('Agendar Cita', false);
        $response->assertSee('Membresía', false);

        // 2. Modals are included in DOM
        $response->assertSee('id="apptModal"', false);
        $response->assertSee('id="membModal"', false);
        $response->assertSee('id="pushPermissionPill"', false);

        // 3. Mobile CSS safety offsets to guarantee no overlaps
        $response->assertSee('pwa-floating-bottom-bar', false);
        $response->assertSee('whatsapp-float', false);
        $response->assertSee('btn-floating-visual-editor', false);
        $response->assertSee('bottom: calc(76px + env(safe-area-inset-bottom, 0px))', false);
        $response->assertSee('bottom: calc(134px + env(safe-area-inset-bottom, 0px))', false);
    }
}
