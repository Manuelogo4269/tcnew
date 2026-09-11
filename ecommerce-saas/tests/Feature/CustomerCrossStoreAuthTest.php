<?php

namespace Tests\Feature;

use App\Models\CentralUser;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CustomerCrossStoreAuthTest extends TestCase
{
    public function test_authenticated_user_on_central_retains_session_in_tenant_store(): void
    {
        $user = CentralUser::firstOrCreate(
            ['email' => 'cliente.prueba@gmail.com'],
            [
                'name' => 'Cliente de Prueba',
                'password' => bcrypt('secret123'),
                'auth_provider' => 'google',
                'avatar_url' => 'https://example.com/avatar.jpg',
            ]
        );

        // Log in on central and visit tenant store
        $response = $this->actingAs($user, 'web')->get('http://localhost/tienda/conceptos7');
        $response->assertStatus(200);

        // Verify that web auth check remains true
        $this->assertTrue(Auth::guard('web')->check());
        $this->assertEquals($user->email, Auth::guard('web')->user()?->email);
    }
}
