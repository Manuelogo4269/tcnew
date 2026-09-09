<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use Tests\TestCase;

class TenantCheckoutAndRouteOptimizerTest extends TestCase
{
    public function test_central_portal_displays_smart_shopping_route_optimizer(): void
    {
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);

        $response->assertSee('routeOptimizerPanel');
        $response->assertSee('RUTA INTELIGENTE SEGÚN TU CARRITO');
        $response->assertSee('Ruta Peatonal para Ver Productos en Tiendas Físicas');
        $response->assertSee('cartRouteItemsContainer');
        $response->assertSee('btnCentralCart');
        $response->assertSee('btnCalculateRoute');
        $response->assertSee('Calcular Ruta Recomendada');
        $response->assertSee('routeStoresSelector');
        $response->assertSee('optimizeShoppingRoute');
        $response->assertSee('loadSampleCartForRouteDemo');
        $response->assertSee('addCurrentModalProductToRouteCart');
    }

    public function test_tenant_storefront_displays_cart_drawer_and_checkout_modal(): void
    {
        $response = $this->get('http://localhost/tienda/acropolis');
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
        $tenant = Tenant::find('acropolis');
        if (!$tenant) {
            $this->markTestSkipped('Tenant acropolis does not exist.');
        }

        $product = $tenant->run(function () {
            return Product::where('is_active', true)->first();
        });

        if (!$product) {
            $this->markTestSkipped('No product available in acropolis.');
        }

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

        $response = $this->postJson('http://localhost/api/tienda/acropolis/checkout', $payload);
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