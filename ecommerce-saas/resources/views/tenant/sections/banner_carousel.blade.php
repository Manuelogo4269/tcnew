@php
    $bData = $block['data'] ?? [];
    $bTitle = !empty($settings?->hero_title) ? $settings->hero_title : ($bData['title'] ?? 'Calidad y diseño. Hecho para ti.');
    $bSubtitle = !empty($settings?->hero_subtitle) ? $settings->hero_subtitle : ($bData['subtitle'] ?? 'Explora nuestra cuidada selección de piezas y productos de alta gama con garantía de satisfacción.');
    $bEyebrow = !empty($bData['eyebrow']) ? $bData['eyebrow'] : 'Colección 2026';
    $bBtnText = !empty($settings?->hero_button_text) ? $settings->hero_button_text : ($bData['btn_text'] ?? 'Explorar Catálogo');
    $bBtnLink = !empty($bData['btn_link']) ? $bData['btn_link'] : '#catalogo';
    $customBanner = !empty($bData['image_url']) ? $bData['image_url'] : $heroBanner;
@endphp

<!-- 1. HERO CAROUSEL -->
<section class="hero-carousel-container" id="heroCarousel">
    <div class="hero-track" id="heroTrack">
        <!-- Slide 1: Principal de la tienda -->
        <div class="hero-slide" style="background-image: url('{{ $customBanner }}');">
            <div class="hero-slide-overlay"></div>
            <div class="hero-slide-content">
                <span class="hero-badge">{{ $bEyebrow }}</span>
                <h2>{!! nl2br(e($bTitle)) !!}</h2>
                <p>{{ $bSubtitle }}</p>
                <div class="hero-cta-group">
                    <a href="{{ $bBtnLink }}" class="btn-brand-primary">{{ $bBtnText }} <span>↓</span></a>
                    <a href="#destacados" class="btn-brand-outline">Ver Tendencias <span>→</span></a>
                </div>
            </div>
            <div class="hero-floating-tag">
                <strong>{{ $storeTitle }}</strong>
                <small>Garantía de Satisfacción 100%</small>
            </div>
        </div>

        <!-- Slide 2: Alta Artesanía -->
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1400&q=80');">
            <div class="hero-slide-overlay"></div>
            <div class="hero-slide-content">
                <span class="hero-badge">Materiales Nobles & Estilo</span>
                <h2>Elegancia atemporal.<br><em>Detalles que inspiran.</em></h2>
                <p>Diseños exclusivos confeccionados con las mejores materias primas. Estilo impecable tanto para tu día a día como para ocasiones memorables.</p>
                <div class="hero-cta-group">
                    <a href="#catalogo" class="btn-brand-primary">Ver Colección <span>↓</span></a>
                    <a href="#categorias" class="btn-brand-outline">Explorar Categorías</a>
                </div>
            </div>
            <div class="hero-floating-tag">
                <strong>Edición Exclusiva</strong>
                <small>Stock Limitado & Envíos Rápidos</small>
            </div>
        </div>

        <!-- Slide 3: Promoción & Envíos -->
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=1400&q=80');">
            <div class="hero-slide-overlay"></div>
            <div class="hero-slide-content">
                <span class="hero-badge">Promoción Especial</span>
                <h2>Tu pedido en tu puerta.<br><em>Sin complicaciones.</em></h2>
                <p>Disfruta de atención directa vía WhatsApp, empaque de regalo de lujo y envíos prioritarios protegidos a cualquier destino.</p>
                <div class="hero-cta-group">
                    <a href="#catalogo" class="btn-brand-primary">Comprar Ahora <span>→</span></a>
                    @if(!empty($settings?->whatsapp_number))
                        @php $waNum = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
                        <a href="https://wa.me/{{ $waNum }}" target="_blank" class="btn-brand-outline">Pedir por WhatsApp <span>💬</span></a>
                    @endif
                    <a href="#negocios" class="btn-brand-outline">Explorar Tiendas <span>🏢</span></a>
                </div>
            </div>
            <div class="hero-floating-tag">
                <strong>Atención Directa</strong>
                <small>Respuesta Inmediata</small>
            </div>
        </div>
    </div>

    <!-- Navigation Controls -->
    <button class="hero-nav-arrow hero-nav-prev" id="heroPrev" aria-label="Anterior">‹</button>
    <button class="hero-nav-arrow hero-nav-next" id="heroNext" aria-label="Siguiente">›</button>

    <!-- Dots -->
    <div class="hero-dots" id="heroDots">
        <span class="hero-dot active" data-index="0"></span>
        <span class="hero-dot" data-index="1"></span>
        <span class="hero-dot" data-index="2"></span>
    </div>
</section>
