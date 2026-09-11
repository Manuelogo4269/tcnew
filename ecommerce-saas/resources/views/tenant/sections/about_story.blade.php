@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? 'Nuestra Historia en el Centro Histórico';
    $bEyebrow = $bData['eyebrow'] ?? 'Tradición & Raíces';
    $bContent = $bData['content'] ?? 'Con pasión artesanal y compromiso por la excelencia, ofrecemos productos auténticos diseñados para inspirar. Cada pieza representa el talento local, la cantera rosa y el legado de Zacatecas.';
    $bImage = !empty($bData['image_url']) ? $bData['image_url'] : 'https://images.unsplash.com/photo-1513151233558-d860c5398176?auto=format&fit=crop&w=800&q=80';
    $bBadge = $bData['badge'] ?? '100% Zacatecano';
@endphp

<!-- ABOUT US / LOCAL STORY SECTION -->
<section class="about-story-section" id="nosotros">
    <div class="about-story-card">
        <div class="about-story-media">
            <img src="{{ $bImage }}" alt="{{ $storeTitle }}" loading="lazy" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&q=80';">
            <div class="about-story-tag">
                <span>🏛️</span> {{ $bBadge }}
            </div>
        </div>
        <div class="about-story-content">
            <span class="section-eyebrow">{{ $bEyebrow }}</span>
            <h2 class="about-story-title">{{ $bTitle }}</h2>
            <div class="about-story-divider"></div>
            <p class="about-story-text">{{ $bContent }}</p>
            
            <div class="about-story-highlights">
                <div class="about-hl-item">
                    <span class="about-hl-icon">✨</span>
                    <div>
                        <strong>Calidad Certificada</strong>
                        <small>Atención al detalle y materiales de primera</small>
                    </div>
                </div>
                <div class="about-hl-item">
                    <span class="about-hl-icon">📍</span>
                    <div>
                        <strong>Comercio Local</strong>
                        <small>Orgullosamente en Zacatecas Centro</small>
                    </div>
                </div>
            </div>

            @if(!empty($settings?->whatsapp_number))
                @php $waAbout = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
                <div style="margin-top: 24px;">
                    <a href="https://wa.me/{{ $waAbout }}?text={{ urlencode('¡Hola! Me gustaría conocer más sobre ' . $storeTitle) }}" target="_blank" class="btn-brand-primary">
                        <span>💬</span> Contactar al Negocio
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
