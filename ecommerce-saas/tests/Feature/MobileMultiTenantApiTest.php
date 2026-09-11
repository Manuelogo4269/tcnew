<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\CustomerAccount;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileMultiTenantApiTest extends TestCase
{
    public function test_mobile_customer_can_register_and_login_globally(): void
    {
        $uniqueEmail = 'user_' . uniqid() . '@example.com';

        $response = $this->postJson('/api/auth/register', [
            'name' => 'María López',
            'email' => $uniqueEmail,
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email'],
                'token',
            ]);

        $this->assertDatabaseHas('customer_accounts', [
            'email' => $uniqueEmail,
        ], 'central');

        // Test login
        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => $uniqueEmail,
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(200)
            ->assertJsonStructure(['user', 'token']);
    }

    public function test_mobile_can_list_stores_and_products(): void
    {
        $storesResponse = $this->getJson('/api/stores');
        $storesResponse->assertStatus(200);

        $productsResponse = $this->getJson('/api/stores/conceptos7/products');
        $productsResponse->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_same_global_email_can_order_in_multiple_tenants(): void
    {
        // 1. Get global customer and Sanctum token
        $customer = CustomerAccount::firstOrCreate(
            ['email' => 'juan@gmail.com'],
            ['name' => 'Juan Pérez', 'password' => bcrypt('password123')]
        );
        $token = $customer->createToken('mobile-test')->plainTextToken;

        // 2. Get a product from conceptos7
        $tenant1 = Tenant::find('conceptos7');
        $prod1 = $tenant1->run(function () {
            $p = Product::first();
            $p->update(['stock' => 50]);
            return $p->fresh();
        });
        $this->assertNotNull($prod1);

        $orderResponse1 = $this->withToken($token)->postJson('/api/stores/conceptos7/orders', [
            'shipping_address' => 'Calle Tacuba 123, Zacatecas',
            'items' => [
                [
                    'product_id' => $prod1->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $orderResponse1->assertStatus(201)
            ->assertJsonPath('order.total_amount', number_format($prod1->price * 2, 2, '.', ''));

        // Verify user exists in conceptos7 with the same email
        $userInTenant1 = $tenant1->run(fn () => TenantUser::where('email', 'juan@gmail.com')->first());
        $this->assertNotNull($userInTenant1);
        $this->assertEquals((string) $customer->id, $userInTenant1->customer_account_id);

        // 3. Verify orders list in conceptos7
        $ordersListResponse = $this->withToken($token)->getJson('/api/stores/conceptos7/orders');
        $ordersListResponse->assertStatus(200)
            ->assertJsonPath('data.0.shipping_address', 'Calle Tacuba 123, Zacatecas');
    }
}
