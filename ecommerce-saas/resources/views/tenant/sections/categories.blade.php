@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? 'Explorar por Categoría';
    $bEyebrow = $bData['eyebrow'] ?? 'Navegación Interactiva';
@endphp

<!-- 3. CATEGORIES CAROUSEL -->
@if($categories->count() > 0)
<section class="categories-carousel-wrap" id="categorias">
    <div class="section-header">
        <div>
            <span class="section-eyebrow">{{ $bEyebrow }}</span>
            <h2 class="section-title">{{ $bTitle }}</h2>
        </div>
        <div class="carousel-arrows">
            <button class="carousel-btn" id="catPrev" aria-label="Categorías anteriores">←</button>
            <button class="carousel-btn" id="catNext" aria-label="Siguientes categorías">→</button>
        </div>
    </div>

    <div class="categories-track" id="catTrack">
        <div class="category-card-slide active-cat" data-category="all" onclick="selectCategory('all', 'Todos los productos')">
            <div class="category-icon-box">✦</div>
            <strong>Todos</strong>
            <small>{{ $products->count() }} piezas</small>
        </div>
        @foreach($categories as $cat)
            <div class="category-card-slide" data-category="{{ $cat->slug }}" onclick="selectCategory('{{ $cat->slug }}', '{{ addslashes($cat->name) }}')">
                <div class="category-icon-box">
                    {{ match($cat->slug) {
                        'bolsos-marroquineria' => '👜',
                        'relojeria-cronografos' => '⌚',
                        'joyeria-accesorios' => '💍',
                        'ropa-accesorios', 'moda-alta-costura' => '🧥',
                        'hogar-decoracion', 'hogar-diseno' => '🏺',
                        'fragancias-cuidado' => '🌿',
                        'tecnologia-accesorios', 'audio-tecnologia' => '🎧',
                        'coleccion-gourmet' => '🫒',
                        default => '🏷️'
                    } }}
                </div>
                <strong>{{ $cat->name }}</strong>
                <small>{{ $cat->products_count }} disponibles</small>
            </div>
        @endforeach
    </div>
</section>
@endif
