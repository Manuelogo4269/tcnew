@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? 'Tendencias de la Semana';
    $bEyebrow = $bData['eyebrow'] ?? 'Selección Especial';
    $limit = intval($bData['limit'] ?? 8);
    $itemsToShow = $featuredProducts->take($limit);
@endphp

<!-- 4. FEATURED PRODUCTS CAROUSEL -->
@if($itemsToShow->count() > 0)
<section class="featured-carousel-wrap" id="destacados">
    <div class="section-header">
        <div>
            <span class="section-eyebrow">{{ $bEyebrow }}</span>
            <h2 class="section-title">{{ $bTitle }}</h2>
        </div>
        <div class="carousel-arrows">
            <button class="carousel-btn" id="featPrev" aria-label="Anterior">←</button>
            <button class="carousel-btn" id="featNext" aria-label="Siguiente">→</button>
        </div>
    </div>

    <div class="featured-track" id="featTrack">
        @foreach($itemsToShow as $item)
            <div class="featured-item">
                <article class="product-card">
                    <div class="product-card-thumb" onclick="openProductById({{ $item->id }})">
                        @if($item->category)
                            <span class="product-badge-cat" onclick="event.stopPropagation(); selectCategory('{{ $item->category->slug }}', '{{ addslashes($item->category->name) }}')">
                                {{ $item->category->name }}
                            </span>
                        @endif
                        <span class="product-stock-tag {{ $item->stock > 10 ? 'stock-available' : ($item->stock > 0 ? 'stock-low' : 'stock-none') }}">
                            {{ $item->stock > 0 ? ($item->stock . ' en stock') : 'Agotado' }}
                        </span>
                        <img src="{{ !empty($item->image_url) ? $item->image_url : 'https://placehold.co/600x600?text=' . urlencode($item->name) }}" alt="{{ $item->name }}" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/600x600?text=Zacatecas';">
                    </div>
                    <div class="product-card-body">
                        <h3 onclick="openProductById({{ $item->id }})">{{ $item->name }}</h3>
                        <p>{{ Str::limit($item->description, 80) }}</p>
                        <div class="product-card-footer">
                            <span class="product-price">${{ number_format($item->price, 2) }}</span>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <button class="btn-quick-view" onclick="openProductById({{ $item->id }})">Ver detalles ↗</button>
                                <button type="button" class="btn-card-add-cart" onclick="event.stopPropagation(); addCartItem({{ $item->id }})" title="Añadir al Carrito">🛒 +</button>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
</section>
@endif
