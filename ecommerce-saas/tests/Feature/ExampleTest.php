<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\TenantUser;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test tenant public storefront.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('http://acropolis.localhost/');

        $response->assertStatus(200);
    }

    /**
     * Test tenant dashboard (Resumen) has all working links.
     */
    public function test_tenant_admin_dashboard_renders_with_working_buttons(): void
    {
        $tenant = Tenant::find('acropolis');
        $user = $tenant->run(fn () => TenantUser::where('email', 'admin@acropolis.com')->first());

        $response = $this->actingAs($user, 'tenant')
            ->get('http://acropolis.localhost/tenant-admin');

        $response->assertStatus(200);
        $response->assertSee('/tenant-admin/products/create');
        $response->assertSee('/tenant-admin/orders');
        $response->assertSee('/tenant-admin/store-settings');
        $response->assertSee('/tenant-admin/categories');
        $response->assertSee('/tenant-admin/customers');
    }
}
