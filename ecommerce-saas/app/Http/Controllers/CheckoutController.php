<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request, string $tenantId): JsonResponse
    {
        $tenant = Tenant::where('id', $tenantId)->orWhereRaw('LOWER(id) = ?', [strtolower($tenantId)])->first();
        if (!$tenant) {
            return response()->json(['success' => false, 'message' => 'Tienda no encontrada.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'nullable|email|max:150',
            'delivery_type' => 'nullable|string|in:pickup,delivery',
            'shipping_address' => 'nullable|string|max:500',
            'payment_method' => 'required|string|in:tarjeta,spei,efectivo,oxxo,whatsapp,card,cash',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable',
            'items.*.product_id' => 'nullable',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.name' => 'nullable|string',
            'items.*.product_name' => 'nullable|string',
            'coupon_code' => 'nullable|string|max:50',
            'order_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor verifica los datos del pedido.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $validated['delivery_type'] = $validated['delivery_type'] ?? 'pickup';

        return $tenant->run(function () use ($validated, $tenantId) {
            return DB::transaction(function () use ($validated, $tenantId) {
                $subtotal = 0;
                $itemsData = [];

                foreach ($validated['items'] as $item) {
                    $qty = (int) $item['quantity'];
                    $price = (float) $item['price'];
                    $lineTotal = $qty * $price;
                    $subtotal += $lineTotal;

                    // Verify product exists in tenant database
                    $prodId = $item['product_id'] ?? ($item['id'] ?? null);
                    $product = $prodId ? Product::find($prodId) : null;
                    $prodName = $item['name'] ?? ($item['product_name'] ?? ($product?->name ?? 'Producto'));

                    $itemsData[] = [
                        'product_id' => $product?->id ?? $prodId,
                        'product_name' => $prodName,
                        'quantity' => $qty,
                        'price' => $price,
                    ];
                }

                // Discount coupons
                $discount = 0;
                $coupon = strtoupper(trim($validated['coupon_code'] ?? ''));
                if ($coupon === 'ZACATECAS2026' || $coupon === 'CENTRO10') {
                    $discount = round($subtotal * 0.10, 2); // 10% discount
                }

                // Shipping cost
                $shippingCost = $validated['delivery_type'] === 'delivery' ? 99.00 : 0.00;
                $totalAmount = max(0, $subtotal - $discount + $shippingCost);

                // Generate unique folio
                $prefix = strtoupper(substr($tenantId, 0, 4));
                $folio = Order::generateFolio($prefix);

                // Payment Status
                $paymentStatus = match ($validated['payment_method']) {
                    'tarjeta' => 'paid',
                    default => 'pending',
                };

                // Shipping address formatting
                $shippingAddress = $validated['delivery_type'] === 'pickup'
                    ? 'Recogida en Sucursal Zacatecas Centro'
                    : ($validated['shipping_address'] ?? 'Entrega a Domicilio en Zacatecas');

                $order = Order::create([
                    'folio' => $folio,
                    'user_id' => null,
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'] ?? null,
                    'customer_phone' => $validated['customer_phone'],
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => $paymentStatus,
                    'status' => 'confirmed',
                    'total_amount' => $totalAmount,
                    'shipping_address' => $shippingAddress,
                    'order_notes' => $validated['order_notes'] ?? null,
                ]);

                foreach ($itemsData as $itemRow) {
                    $order->items()->create($itemRow);
                }

                return response()->json([
                    'success' => true,
                    'message' => '¡Pedido registrado y procesado exitosamente!',
                    'order' => [
                        'id' => $order->id,
                        'folio' => $order->folio,
                        'customer_name' => $order->customer_name,
                        'customer_phone' => $order->customer_phone,
                        'total' => number_format($totalAmount, 2, '.', ''),
                        'subtotal' => number_format($subtotal, 2, '.', ''),
                        'discount' => number_format($discount, 2, '.', ''),
                        'discount_amount' => (float) $discount,
                        'shipping_cost' => number_format($shippingCost, 2, '.', ''),
                        'payment_method' => $order->payment_method,
                        'payment_status' => $order->payment_status,
                        'delivery_type' => $validated['delivery_type'],
                        'shipping_address' => $order->shipping_address,
                        'created_at' => $order->created_at->format('d/m/Y H:i'),
                        'items_count' => count($itemsData),
                    ],
                ]);
            });
        });
    }
}
