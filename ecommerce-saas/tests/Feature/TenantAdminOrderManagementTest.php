<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\TenantUser;
use Tests\TestCase;

class TenantAdminOrderManagementTest extends TestCase
{
    public function test_tenant_admin_orders_page_is_accessible_with_authenticated_admin(): void
    {
        $tenant = Tenant::findOrFail('conceptos7');
        $adminUser = $tenant->run(fn () => \App\Models\TenantUser::where('email', 'admin@conceptos7.com')->first());

        $response = $this->withSession(['tenant_admin_tenant_id' => 'conceptos7'])
            ->actingAs($adminUser, 'tenant')
            ->get('/tenant-admin/orders?tenant=conceptos7');

        $response->assertStatus(200);
        $response->assertSee('Pedidos');
    }

    public function test_can_create_order_with_multiple_store_products_and_calculate_total(): void
    {
        $tenant = Tenant::find('conceptos7');
        if (!$tenant) {
            $this->markTestSkipped('Tenant conceptos7 not found.');
        }

        tenancy()->initialize($tenant);
        $products = Product::where('is_active', true)->take(2)->get();
        $this->assertGreaterThanOrEqual(2, $products->count(), 'At least 2 products should exist for this test.');

        $p1 = $products[0];
        $p2 = $products[1];

        $qty1 = 2;
        $qty2 = 3;
        $expectedTotal = ($p1->price * $qty1) + ($p2->price * $qty2);

        $order = Order::create([
            'folio' => Order::generateFolio('CONC'),
            'customer_name' => 'Compradora Boutique Presencial',
            'customer_phone' => '4925551234',
            'customer_email' => 'compradora@test.com',
            'status' => 'completed',
            'payment_method' => 'tarjeta',
            'payment_status' => 'paid',
            'shipping_address' => 'Entrega inmediata en boutique',
            'order_notes' => 'Incluye empaque especial de regalo',
            'total_amount' => $expectedTotal,
        ]);

        $order->items()->createMany([
            [
                'product_id' => $p1->id,
                'product_name' => $p1->name,
                'quantity' => $qty1,
                'price' => $p1->price,
            ],
            [
                'product_id' => $p2->id,
                'product_name' => $p2->name,
                'quantity' => $qty2,
                'price' => $p2->price,
            ],
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_name' => 'Compradora Boutique Presencial',
            'total_amount' => $expectedTotal,
        ]);

        $this->assertCount(2, $order->fresh()->items);
        $this->assertEquals($p1->name, $order->items[0]->product_name);
        $this->assertEquals($p2->name, $order->items[1]->product_name);
        $this->assertEquals($p1->id, $order->items[0]->product_id);
        $this->assertEquals($p2->id, $order->items[1]->product_id);

        // Verify order items can be loaded with product relationship
        $loadedItem = $order->fresh()->items()->first();
        $this->assertInstanceOf(Product::class, $loadedItem->product);
        $this->assertEquals($p1->id, $loadedItem->product->id);

        // Clean up test order
        $order->delete();
    }
}
