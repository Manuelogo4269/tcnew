@php
    $bData = $block['data'] ?? [];
    $item1 = $bData['item1'] ?? 'Recogida en Sucursal';
    $item2 = $bData['item2'] ?? 'Garantía de Calidad';
    $item3 = $bData['item3'] ?? 'Pagos 100% Cifrados';
    $item4 = $bData['item4'] ?? 'Atención Personalizada';
@endphp

<!-- 2. VALUE PROPOSITION BAR -->
<section class="trust-bar">
    <div class="trust-item">
        <div class="trust-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
        </div>
        <div class="trust-content">
            <strong>{{ $item1 }}</strong>
            <small>Listo para recoger en sucursal Centro</small>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                <polyline points="9 12 11 14 15 10"></polyline>
            </svg>
        </div>
        <div class="trust-content">
            <strong>{{ $item2 }}</strong>
            <small>30 días para cambios y devoluciones</small>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                <line x1="2" y1="10" x2="22" y2="10"></line>
            </svg>
        </div>
        <div class="trust-content">
            <strong>{{ $item3 }}</strong>
            <small>Tarjetas bancarias y Stripe 3D Secure</small>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
            </svg>
        </div>
        <div class="trust-content">
            <strong>{{ $item4 }}</strong>
            <small>Asesoría en vivo por WhatsApp</small>
        </div>
    </div>
</section>
