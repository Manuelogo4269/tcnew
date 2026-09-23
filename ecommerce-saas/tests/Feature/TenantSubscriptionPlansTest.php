<?php

namespace Tests\Feature;

use App\Models\SubscriptionPlan;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TenantSubscriptionPlansTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\SubscriptionPlanSeeder::class);
    }

    public function test_central_portal_displays_subscription_plans_and_pricing(): void
    {
        // 1. Central Portal Home links to /planes
        $portalResponse = $this->withServerVariables(['HTTP_HOST' => 'localhost:8000'])
            ->get('/');
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('/planes');

        // 2. Dedicated /planes page displays all subscription plans and pricing
        $response = $this->withServerVariables(['HTTP_HOST' => 'localhost:8000'])
            ->get('/planes');

        $response->assertStatus(200);
        $response->assertSee('Planes de Renta para Empresas');
        $response->assertSee('Plan Emprendedor');
        $response->assertSee('Plan Crecimiento');
        $response->assertSee('Plan Corporativo');
        $response->assertSee('Facturación Mensual');
        $response->assertSee('Facturación Anual');
        $response->assertSee('Renta tu Tienda Virtual');
    }

    public function test_new_tenant_can_be_rented_and_registered_with_plan(): void
    {
        $testSubdomain = 'testb2b' . time();

        $postData = [
            'company_name' => 'Boutique Alta Costura',
            'subdomain' => $testSubdomain,
            'plan_slug' => 'crecimiento',
            'billing_cycle' => 'annual',
            'owner_name' => 'Elena Rostova',
            'owner_email' => "admin@{$testSubdomain}.com",
            'owner_password' => 'secret123',
            'business_category' => 'Moda y Lujo',
        ];

        $response = $this->withServerVariables(['HTTP_HOST' => 'localhost:8000'])
            ->postJson('/rentar-tienda', $postData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'subdomain' => $testSubdomain,
                'plan_name' => 'Plan Crecimiento',
                'billing_cycle' => 'Anual (-20%)',
            ]);

        // Verify in central DB
        $tenant = Tenant::find($testSubdomain);
        $this->assertNotNull($tenant);
        $this->assertEquals('Crecimiento', $tenant->plan_name);
        $this->assertEquals('annual', $tenant->billing_cycle);
        $this->assertEquals('active', $tenant->subscription_status);
        $this->assertNotNull($tenant->subscription_amount);

        // Verify inside tenant database
        $tenant->run(function () use ($testSubdomain) {
            $settings = \App\Models\StoreSetting::first();
            $this->assertNotNull($settings);
            $this->assertEquals('Boutique Alta Costura', $settings->store_name);

            $admin = \App\Models\TenantUser::where('email', "admin@{$testSubdomain}.com")->first();
            $this->assertNotNull($admin);
            $this->assertEquals('Elena Rostova', $admin->name);
            $this->assertTrue(Hash::check('secret123', $admin->password));
        });
    }

    public function test_subdomain_uniqueness_validation(): void
    {
        $postData = [
            'company_name' => 'Empresa Duplicada',
            'subdomain' => 'conceptos7', // Already exists
            'plan_slug' => 'emprendedor',
            'billing_cycle' => 'monthly',
            'owner_name' => 'Juan Clon',
            'owner_email' => 'juan@clon.com',
            'owner_password' => '123456',
            'business_category' => 'Comercio General',
        ];

        $response = $this->withServerVariables(['HTTP_HOST' => 'localhost:8000'])
            ->postJson('/rentar-tienda', $postData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['subdomain']);
    }

    public function test_storefront_requires_active_subscription(): void
    {
        $tenant = Tenant::firstOrCreate(
            ['id' => 'conceptos7'],
            ['plan_name' => 'Corporativo', 'subscription_status' => 'active']
        );

        // 1. Active subscription returns 200
        $tenant->update(['subscription_status' => 'active', 'plan_name' => 'Corporativo']);
        $this->assertTrue($tenant->hasActiveSubscription());

        $resActive = $this->get('/tienda/conceptos7');
        $resActive->assertStatus(200);

        // 2. Inactive/cancelled subscription returns 402 with inactive view
        $tenant->update(['subscription_status' => 'cancelled']);
        $this->assertFalse($tenant->hasActiveSubscription());

        $resInactive = $this->get('/tienda/conceptos7');
        $resInactive->assertStatus(402);
        $resInactive->assertSee('Tienda en Pausa de Suscripción');
        $resInactive->assertSee('Suscripción Requerida');
        $resInactive->assertSee('Planes Disponibles para Activar la Tienda');

        // Restore for other tests
        $tenant->update(['subscription_status' => 'active', 'plan_name' => 'Corporativo']);
    }
}
