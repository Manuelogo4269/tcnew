<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Tests\TestCase;

class TenantAdminAccessTest extends TestCase
{
    public function test_subdomain_tenant_admin_redirects_to_login(): void
    {
        $response = $this->get('http://conceptos7.localhost/tenant-admin');
        $response->assertStatus(302);
        $this->assertStringEndsWith('/tenant-admin/login', $response->headers->get('Location'));
    }

    public function test_universal_path_tenant_admin_redirects_with_session(): void
    {
        $response = $this->get('/tienda/conceptos7/admin');
        $response->assertStatus(302);
        $response->assertRedirect('/tenant-admin');
        $response->assertSessionHas('tenant_admin_tenant_id', 'conceptos7');
    }

    public function test_tenant_admin_panel_accessible_with_session(): void
    {
        $tenant = Tenant::findOrFail('conceptos7');
        $adminUser = $tenant->run(fn () => \App\Models\TenantUser::where('email', 'admin@conceptos7.com')->first());

        $response = $this->withSession(['tenant_admin_tenant_id' => 'conceptos7'])
            ->actingAs($adminUser, 'tenant')
            ->get('/tenant-admin');

        $response->assertStatus(200);
        $response->assertSee('Atelier');
    }
}
