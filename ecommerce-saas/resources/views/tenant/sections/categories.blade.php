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
            <div class="category-icon-box">
                <svg class="ui-icon" width="20" height="20" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <strong>Todos</strong>
            <small>{{ $products->count() }} piezas</small>
        </div>
        @foreach($categories as $cat)
            @php
                $catIconSvg = match($cat->slug) {
                    'joyeria-accesorios', 'joyeria-y-accesorios' => '<svg class="ui-icon" width="20" height="20" viewBox="0 0 24 24"><polygon points="6 3 18 3 22 9 12 22 2 9"/></svg>',
                    'ropa-accesorios', 'moda-alta-costura', 'ropa-tendencia', 'ropa-y-tendencia' => '<svg class="ui-icon" width="20" height="20" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>',
                    'calzado-y-tacones' => '<svg class="ui-icon" width="20" height="20" viewBox="0 0 24 24"><path d="M4 17h16M4 17l2-7h12l2 7M4 17v3h16v-3"/></svg>',
                    'bolsos-marroquineria', 'bolsos-y-complementos', 'bolsos-complementos' => '<svg class="ui-icon" width="20" height="20" viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="15" rx="2"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
                    'relojeria-cronografos' => '<svg class="ui-icon" width="20" height="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="7"/><polyline points="12 9 12 12 13.5 13.5"/><path d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"/></svg>',
                    'hogar-decoracion', 'hogar-diseno' => '<svg class="ui-icon" width="20" height="20" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>',
                    default => '<svg class="ui-icon" width="20" height="20" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',
                };
            @endphp
            <div class="category-card-slide" data-category="{{ $cat->slug }}" onclick="selectCategory('{{ $cat->slug }}', '{{ addslashes($cat->name) }}')">
                <div class="category-icon-box">
                    {!! $catIconSvg !!}
                </div>
                <strong>{{ $cat->name }}</strong>
                <small>{{ $cat->products_count }} disponibles</small>
            </div>
        @endforeach
    </div>
</section>
@endif
