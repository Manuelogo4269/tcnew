@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? 'Descuentos & Ofertas Relámpago';
    $bEyebrow = $bData['eyebrow'] ?? '¡Oferta de Temporada!';
    $bSubtitle = $bData['subtitle'] ?? 'Aprovecha precios especiales en piezas seleccionadas antes de que termine el temporizador.';
    $bBadge = $bData['discount_badge'] ?? '30% OFF';
    $bBtnText = $bData['btn_text'] ?? 'Ver Ofertas Disponibles';
    $hours = intval($bData['hours_duration'] ?? 8);
    // Take 4 products to display as flash deals
    $dealProducts = $products->take(4);
@endphp

<!-- FLASH DEALS & SPECIAL DISCOUNTS -->
<section class="flash-deals-section" id="ofertas">
    <div class="flash-deals-banner">
        <div class="flash-deals-header-row">
            <div class="flash-deals-info">
                <span class="flash-badge-pulse">⚡ {{ $bEyebrow }}</span>
                <h2 class="flash-deals-title">{{ $bTitle }}</h2>
                <p class="flash-deals-desc">{{ $bSubtitle }}</p>
            </div>
            <div class="flash-countdown-wrap">
                <span class="countdown-label">⏳ La oferta finaliza en:</span>
                <div class="flash-countdown-boxes" id="flashCountdownBoxes">
                    <div class="countdown-box">
                        <span class="countdown-num" id="cdHours">07</span>
                        <span class="countdown-unit">Horas</span>
                    </div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cdMinutes">45</span>
                        <span class="countdown-unit">Min</span>
                    </div>
                    <span class="countdown-sep">:</span>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cdSeconds">20</span>
                        <span class="countdown-unit">Seg</span>
                    </div>
                </div>
            </div>
        </div>

        @if($dealProducts->count() > 0)
            <div class="flash-deals-grid">
                @foreach($dealProducts as $dealItem)
                    @php
                        $regularPrice = $dealItem->price * 1.25; // Original simulated crossed-out price
                    @endphp
                    <div class="flash-deal-card" onclick="openProductById({{ $dealItem->id }})">
                        <div class="flash-deal-thumb">
                            <span class="flash-deal-discount">{{ $bBadge }}</span>
                            <img src="{{ !empty($dealItem->image_url) ? $dealItem->image_url : 'https://placehold.co/400x400?text=' . urlencode($dealItem->name) }}" alt="{{ $dealItem->name }}" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/400x400?text=' + encodeURIComponent('{{ $dealItem->name }}');">
                        </div>
                        <div class="flash-deal-body">
                            <small class="flash-deal-cat">{{ $dealItem->category?->name ?? 'Zacatecas Centro' }}</small>
                            <h4 class="flash-deal-name">{{ $dealItem->name }}</h4>
                            <div class="flash-deal-pricing">
                                <span class="flash-price-now">${{ number_format($dealItem->price, 2) }}</span>
                                <span class="flash-price-old">${{ number_format($regularPrice, 2) }}</span>
                            </div>
                            <button type="button" class="btn-flash-add-cart" onclick="event.stopPropagation(); addCartItem({{ $dealItem->id }})">
                                🛒 Agregar con Descuento
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
