@php
    $bData = $block['data'] ?? [];
    $item1 = $bData['item1'] ?? 'Recogida en Sucursal';
    $item2 = $bData['item2'] ?? 'Garantía de Calidad';
    $item3 = $bData['item3'] ?? 'Pagos Seguros con Stripe';
    $item4 = $bData['item4'] ?? 'Atención por WhatsApp';
@endphp

<!-- 2. VALUE PROPOSITION BAR -->
<section class="trust-bar">
    <div class="trust-item">
        <div class="trust-icon">🛍️</div>
        <div>
            <strong>{{ $item1 }}</strong>
            <small>Listo para recoger en sucursal Centro</small>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon">🛡️</div>
        <div>
            <strong>{{ $item2 }}</strong>
            <small>30 días para cambios y devoluciones</small>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon">💳</div>
        <div>
            <strong>{{ $item3 }}</strong>
            <small>Tarjetas bancarias y 3D Secure</small>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon">💬</div>
        <div>
            <strong>{{ $item4 }}</strong>
            <small>Asesoría personalizada en vivo</small>
        </div>
    </div>
</section>
