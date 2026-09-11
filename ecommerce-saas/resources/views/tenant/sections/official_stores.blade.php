<!-- 6. OFFICIAL STORES NETWORK -->
@if(!empty($officialStores) && count($officialStores) > 1)
@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? ($block['title'] ?? 'Directorio de Negocios');
    $bEyebrow = $bData['eyebrow'] ?? 'Ecosistema Multi-Tienda';
@endphp
<section class="official-network-section" id="negocios">
    <div class="section-header" style="margin-bottom: 10px;">
        <div>
            <span class="section-eyebrow">{{ $bEyebrow }}</span>
            <h2 class="section-title">{{ $bTitle }}</h2>
        </div>
        <div class="carousel-arrows">
            <button class="carousel-btn" id="networkPrev" aria-label="Anterior">←</button>
            <button class="carousel-btn" id="networkNext" aria-label="Siguiente">→</button>
        </div>
    </div>

    <div class="network-track" id="networkTrack">
        @foreach($officialStores as $store)
            <div class="network-card {{ $store['is_current'] ? 'is-current-store' : '' }}">
                <div>
                    <div class="network-card-header">
                        <span class="network-card-badge {{ $store['is_current'] ? 'badge-current' : 'badge-partner' }}">
                            {{ $store['is_current'] ? '📍 Tienda Actual' : '🏬 Tienda Oficial' }}
                        </span>
                    </div>
                    <h3 class="network-card-title">{{ $store['name'] }}</h3>
                    <p style="font-size: 12.5px; color: var(--muted); margin-bottom: 18px; line-height: 1.5;">
                        {{ $store['tagline'] ?? match($store['id']) {
                            'acropolis' => 'La cafetería y galería de arte más emblemática de Zacatecas desde 1943.',
                            'donajulia' => 'El sabor auténtico de Zacatecas, gorditas hechas a mano con guisados al comal.',
                            'rosadeplata' => 'Joyería fina en plata ley .925 cincelada a mano por maestros plateros.',
                            'elserranito' => 'Tradición dulce zacatecana: quesos de tuna, ates, cajetas de Jerez y artesanías.',
                            'quinceletras' => 'La cantina más legendaria de Zacatecas desde 1906. Maestros del mezcal artesanal.',
                            'libreriaandrea' => 'Libros de historia colonial de Zacatecas, novela, poesía, arte y papelería fina.',
                            default => 'Comercio emblemático en el Centro Histórico de Zacatecas.'
                        } }}
                    </p>
                </div>

                @if($store['is_current'])
                    <div class="network-card-btn network-card-btn-primary">
                        <span>✓</span> Te encuentras en esta tienda
                    </div>
                @else
                    <a href="{{ $store['url'] }}" target="_blank" class="network-card-btn network-card-btn-outline">
                        Visitar Tienda <span>↗</span>
                    </a>
                @endif
            </div>
        @endforeach
    </div>
</section>
@endif
