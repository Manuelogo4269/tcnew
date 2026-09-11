<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\Tenant;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TenantStripeAndPickupOnlyTest extends TestCase
{
    protected function tearDown(): void
    {
        $tenant = Tenant::find('conceptos7');
        if ($tenant) {
            $tenant->run(function () {
                Product::where('slug', 'test-stripe-prod')->delete();
                Order::where('customer_email', 'stripe.tester@gmail.com')->delete();
                StoreSetting::first()?->update([
                    'stripe_secret_key' => null,
                    'stripe_publishable_key' => null,
                ]);
            });
        }
        parent::tearDown();
    }

    public function test_storefront_displays_pickup_only_and_stripe(): void
    {
        $response = $this->get('http://localhost/tienda/conceptos7');
        $response->assertStatus(200);

        // Assert pickup only
        $response->assertSee('Recogida Exclusiva en Sucursal');
        $response->assertDontSee('Envío a Domicilio en Zacatecas');

        // Assert Stripe badge
        $response->assertSee('Pasarela Oficial Stripe');
        $response->assertSee('Tarjeta Débito/Crédito (Stripe)');
    }

    public function test_checkout_enforces_pickup_and_zero_shipping(): void
    {
        $tenant = Tenant::find('conceptos7');
        if (!$tenant) {
            $this->markTestSkipped('Tenant conceptos7 not found.');
        }

        $product = $tenant->run(function () {
            $cat = Category::firstOrCreate(['slug' => 'bolsos-y-complementos'], ['name' => 'Bolsos & Complementos 👜']);
            return Product::firstOrCreate(
                ['slug' => 'test-stripe-prod'],
                [
                    'category_id' => $cat->id,
                    'name' => 'Producto Stripe Test',
                    'description' => 'Test pickup and stripe',
                    'price' => 200.00,
                    'stock' => 10,
                    'is_active' => true,
                ]
            );
        });

        $payload = [
            'customer_name' => 'Cliente Recogida',
            'customer_email' => 'stripe.tester@gmail.com',
            'customer_phone' => '4921112233',
            'payment_method' => 'cash',
            'order_notes' => 'Paso a las 4 PM',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => 200.00,
                ]
            ]
        ];

        $response = $this->postJson('http://localhost/api/tienda/conceptos7/checkout', $payload);
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertTrue($json['success']);
        $this->assertEquals('pickup', $json['order']['delivery_type']);
        $this->assertEquals('0.00', $json['order']['shipping_cost']);
        $this->assertStringContainsString('Recoger en Sucursal', $json['order']['shipping_address']);
    }

    public function test_stripe_checkout_session_redirect(): void
    {
        $tenant = Tenant::find('conceptos7');
        if (!$tenant) {
            $this->markTestSkipped('Tenant conceptos7 not found.');
        }

        $product = $tenant->run(function () {
            $cat = Category::firstOrCreate(['slug' => 'bolsos-y-complementos'], ['name' => 'Bolsos & Complementos 👜']);
            return Product::firstOrCreate(
                ['slug' => 'test-stripe-prod'],
                [
                    'category_id' => $cat->id,
                    'name' => 'Producto Stripe Test',
                    'description' => 'Test pickup and stripe',
                    'price' => 350.00,
                    'stock' => 5,
                    'is_active' => true,
                ]
            );
        });

        // Set Stripe test secret key in tenant settings
        $tenant->run(function () {
            $settings = StoreSetting::first();
            if ($settings) {
                $settings->update([
                    'stripe_secret_key' => 'sk_test_fake_mock_key',
                    'stripe_publishable_key' => 'pk_test_fake_mock_key',
                ]);
            }
        });

        // Fake Stripe Checkout session response
        Http::fake([
            'https://api.stripe.com/v1/checkout/sessions' => Http::response([
                'id' => 'cs_test_mock_session_123',
                'url' => 'https://checkout.stripe.com/c/pay/cs_test_mock_session_123',
                'payment_status' => 'unpaid',
            ], 200),
        ]);

        $payload = [
            'customer_name' => 'Comprador Stripe',
            'customer_email' => 'stripe.tester@gmail.com',
            'customer_phone' => '4921112233',
            'payment_method' => 'card',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => 350.00,
                ]
            ]
        ];

        $response = $this->postJson('http://localhost/api/tienda/conceptos7/checkout', $payload);
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertTrue($json['success']);
        $this->assertEquals('https://checkout.stripe.com/c/pay/cs_test_mock_session_123', $json['redirect_url']);
        $this->assertEquals('pending', $json['order']['payment_status']);

        // Verify order saved stripe_session_id in database
        $orderInDb = $tenant->run(function () use ($json) {
            return Order::where('folio', $json['order']['folio'])->first();
        });

        $this->assertNotNull($orderInDb);
        $this->assertEquals('cs_test_mock_session_123', $orderInDb->stripe_session_id);

        // Test Stripe Return verification
        Http::fake([
            'https://api.stripe.com/v1/checkout/sessions/cs_test_mock_session_123' => Http::response([
                'id' => 'cs_test_mock_session_123',
                'payment_status' => 'paid',
                'payment_intent' => 'pi_mock_intent_456',
            ], 200),
        ]);

        $returnResponse = $this->get("http://localhost/tienda/conceptos7?payment_result=stripe_success&session_id=cs_test_mock_session_123&folio={$orderInDb->folio}");
        $returnResponse->assertStatus(200);

        // Check that the order is updated to paid in DB
        $updatedOrder = $tenant->run(function () use ($orderInDb) {
            return Order::find($orderInDb->id);
        });

        $this->assertEquals('paid', $updatedOrder->payment_status);
        $this->assertEquals('confirmed', $updatedOrder->status);
        $this->assertEquals('pi_mock_intent_456', $updatedOrder->stripe_payment_intent_id);
    }
}
