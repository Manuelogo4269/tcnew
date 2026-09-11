@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? 'Nuestra Colección de Productos';
    $bEyebrow = $bData['eyebrow'] ?? 'Catálogo Completo';
@endphp

<!-- 5. FULL CATALOG WITH REAL-TIME CATEGORY FILTERING & SEARCH -->
<section id="catalogo">
    <div class="section-header">
        <div>
            <span class="section-eyebrow">{{ $bEyebrow }}</span>
            <h2 class="section-title">{{ $bTitle }}</h2>
        </div>
    </div>

    <!-- Interactive Category Filter Pills directly above grid -->
    <div class="category-pills-bar" id="categoryPills">
        <button class="cat-pill active" data-category="all" onclick="selectCategory('all', 'Todos los productos')">
            ✦ Todos <span class="cat-pill-count">{{ $products->count() }}</span>
        </button>
        @foreach($categories as $cat)
            <button class="cat-pill" data-category="{{ $cat->slug }}" onclick="selectCategory('{{ $cat->slug }}', '{{ addslashes($cat->name) }}')">
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
                } }} {{ $cat->name }} <span class="cat-pill-count">{{ $cat->products_count }}</span>
            </button>
        @endforeach
    </div>

    <div class="catalog-filter-bar">
        <div class="search-box">
            <svg viewBox="0 0 24 24"><path d="M10 2a8 8 0 015.293 13.707l5 5a1 1 0 01-1.414 1.414l-5-5A8 8 0 1110 2zm0 2a6 6 0 100 12 6 6 0 000-12z"/></svg>
            <input type="text" id="catalogSearch" placeholder="Buscar por nombre, categoría o material...">
        </div>
        <div class="filter-status-info">
            <div class="active-filter-badge" id="activeFilterBadge" style="display: none;">
                <span id="activeFilterLabel">Filtrando por: Categoría</span>
                <button class="btn-clear-filter" onclick="selectCategory('all', 'Todos los productos')" title="Quitar filtro">✕</button>
            </div>
            <div class="catalog-stats-count" id="catalogCounter">
                Mostrando {{ $products->count() }} producto(s) disponibles
            </div>
        </div>
    </div>

    <div class="products-grid" id="productsGrid">
        @forelse($products as $product)
            <article class="product-card product-grid-item" 
                data-id="{{ $product->id }}"
                data-slug="{{ $product->slug }}"
                data-name="{{ strtolower($product->name) }}" 
                data-desc="{{ strtolower($product->description ?? '') }}" 
                data-category="{{ $product->category?->slug ?? 'sin-categoria' }}"
                data-category-name="{{ $product->category?->name ?? 'General' }}">
                <div class="product-card-thumb" onclick="openProductById({{ $product->id }})">
                    @if($product->category)
                        <span class="product-badge-cat" onclick="event.stopPropagation(); selectCategory('{{ $product->category->slug }}', '{{ addslashes($product->category->name) }}')">
                            {{ $product->category->name }}
                        </span>
                    @endif
                    <span class="product-stock-tag {{ $product->stock > 10 ? 'stock-available' : ($product->stock > 0 ? 'stock-low' : 'stock-none') }}">
                        {{ $product->stock > 0 ? ($product->stock . ' en stock') : 'Agotado' }}
                    </span>
                    <img src="{{ !empty($product->image_url) ? $product->image_url : 'https://placehold.co/600x600?text=' . urlencode($product->name) }}" alt="{{ $product->name }}" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/600x600?text=Zacatecas';">
                </div>
                <div class="product-card-body">
                    <h3 onclick="openProductById({{ $product->id }})">{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->description, 90) }}</p>
                    <div class="product-card-footer">
                        <span class="product-price">${{ number_format($product->price, 2) }}</span>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <button class="btn-quick-view" onclick="openProductById({{ $product->id }})">Ver detalles ↗</button>
                            <button type="button" class="btn-card-add-cart" onclick="event.stopPropagation(); addCartItem({{ $product->id }})" title="Añadir al Carrito">🛒 +</button>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state" style="grid-column: 1 / -1; padding: 60px 20px; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 12px;">🛍️</div>
                <h3>Próximamente nuevas colecciones</h3>
                <p style="color: var(--muted); margin-top: 6px;">El catálogo se encuentra en actualización de inventario.</p>
            </div>
        @endforelse
    </div>
</section>
