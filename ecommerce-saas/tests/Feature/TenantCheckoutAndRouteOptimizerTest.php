<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use Tests\TestCase;

class TenantCheckoutAndRouteOptimizerTest extends TestCase
{
    protected function tearDown(): void
    {
        $tenant = Tenant::find('conceptos7');
        if ($tenant) {
            $tenant->run(function () {
                Product::where('slug', 'test-checkout-prod')->delete();
            });
        }
        parent::tearDown();
    }
    public function test_central_portal_displays_smart_shopping_route_optimizer(): void
    {
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);

        $response->assertSee('btnToggleRoutePanel');
        $response->assertSee('routeOptimizerPanel');
        $response->assertSee('Ruta de Compras según tu Carrito');
        $response->assertSee('cartRouteItemsContainer');
        $response->assertSee('routeOriginBar');
        $response->assertSee('btnRouteUseGps');
        $response->assertSee('floatingRouteCartBar');
        $response->assertSee('btnCentralCart');
        $response->assertSee('btnCalculateRoute');
        $response->assertSee('Calcular Ruta Recomendada');
        $response->assertSee('routeStoresSelector');
        $response->assertSee('optimizeShoppingRoute');
        $response->assertSee('computeExactShortestRoute');
        $response->assertSee('loadSampleCartForRouteDemo');
        $response->assertSee('addCurrentModalProductToRouteCart');
        $response->assertSee('quickAddProductToRouteCart');
    }

    public function test_tenant_storefront_displays_cart_drawer_and_checkout_modal(): void
    {
        $response = $this->get('http://localhost/tienda/conceptos7');
        $response->assertStatus(200);

        $response->assertSee('btnCartHeader');
        $response->assertSee('headerCartBadge');

        $response->assertSee('storeCartDrawer');
        $response->assertSee('cartDrawerBackdrop');
        $response->assertSee('btn-cart-view-route');
        $response->assertSee('action=cart_route');
        $response->assertSee('btnGoToCheckout');
        $response->assertSee('Proceder al Pago / Checkout');

        $response->assertSee('checkoutModal');
        $response->assertSee('Pasarela de Pago Segura');
        $response->assertSee('Tarjeta Débito/Crédito');
        $response->assertSee('Transferencia SPEI');
        $response->assertSee('OXXO Pay');
        $response->assertSee('Contra Entrega');
        $response->assertSee('Por WhatsApp');

        $response->assertSee('orderSuccessModal');
        $response->assertSee('printableReceipt');
        $response->assertSee('printOrderReceipt');
    }

    public function test_checkout_api_creates_order_with_folio_and_coupon(): void
    {
        $tenant = Tenant::find('conceptos7');
        if (!$tenant) {
            $this->markTestSkipped('Tenant conceptos7 does not exist.');
        }

        $product = $tenant->run(function () {
            $cat = Category::firstOrCreate(['slug' => 'joyeria-y-accesorios'], ['name' => 'Joyería y Accesorio ✨']);
            return Product::firstOrCreate(
                ['slug' => 'test-checkout-prod'],
                [
                    'category_id' => $cat->id,
                    'name' => 'Producto Checkout Test',
                    'description' => 'Test checkout',
                    'price' => 150.00,
                    'stock' => 20,
                    'is_active' => true,
                ]
            );
        });

        $payload = [
            'customer_name' => 'Turista Zacatecas',
            'customer_email' => 'turista.test@gmail.com',
            'customer_phone' => '4929876543',
            'payment_method' => 'card',
            'shipping_address' => 'Hotel Quinta Real, Av. Ignacio Rayon 434, Zacatecas',
            'order_notes' => 'Entregar en recepcion antes de las 6 PM',
            'coupon_code' => 'CENTRO10',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'price' => (float) $product->price,
                ]
            ]
        ];

        $response = $this->postJson('http://localhost/api/tienda/conceptos7/checkout', $payload);
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertTrue($json['success']);
        $this->assertNotEmpty($json['order']['folio']);
        $this->assertEquals('Turista Zacatecas', $json['order']['customer_name']);
        $this->assertEquals('card', $json['order']['payment_method']);
        $this->assertGreaterThan(0, $json['order']['discount_amount']);

        $orderInDb = $tenant->run(function () use ($json) {
            return Order::with('items')->where('folio', $json['order']['folio'])->first();
        });

        $this->assertNotNull($orderInDb);
        $this->assertEquals('Turista Zacatecas', $orderInDb->customer_name);
        $this->assertCount(1, $orderInDb->items);
        $this->assertEquals(2, $orderInDb->items[0]->quantity);
    }
}