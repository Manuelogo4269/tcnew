@php
    $bData = $block['data'] ?? [];
    $item1 = $bData['item1'] ?? 'Envíos Express Protegidos';
    $item2 = $bData['item2'] ?? 'Garantía de Calidad';
    $item3 = $bData['item3'] ?? 'Pagos 100% Cifrados';
    $item4 = $bData['item4'] ?? 'Atención por WhatsApp';
@endphp

<!-- 2. VALUE PROPOSITION BAR -->
<section class="trust-bar">
    <div class="trust-item">
        <div class="trust-icon">🚚</div>
        <div>
            <strong>{{ $item1 }}</strong>
            <small>Rastreo y entrega asegurada</small>
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
            <small>Seguridad de datos de nivel bancario</small>
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
