@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? 'Ubicación y Horarios de Atención';
    $bEyebrow = $bData['eyebrow'] ?? 'Punto de Encuentro';
    $bNote = $bData['note'] ?? 'Atención presencial y entrega inmediata de tus compras en el Centro Histórico de Zacatecas.';
    $address = $settings?->address ?? 'Centro Histórico, Zacatecas';
    $hours = $settings?->opening_hours ?? 'Lunes a Sábado: 10:00 AM - 8:30 PM';
    $zone = $settings?->neighborhood_zone ?? 'Centro Histórico';
    $ref = $settings?->location_reference ?? 'A pasos de los principales corredores del Centro';
    $lat = $settings?->latitude ?? 22.7753;
    $lng = $settings?->longitude ?? -102.5724;
    $mapsUrl = $settings?->maps_url ?? "https://maps.google.com/?q={$lat},{$lng}";
@endphp

<!-- LOCATION & OPENING HOURS SECTION -->
<section class="store-location-section" id="ubicacion">
    <div class="section-header">
        <div>
            <span class="section-eyebrow">{{ $bEyebrow }}</span>
            <h2 class="section-title">{{ $bTitle }}</h2>
        </div>
        <div>
            <a href="{{ $mapsUrl }}" target="_blank" class="btn-brand-outline" style="border-color: var(--line);">
                <span>🗺️</span> Abrir en Google Maps ↗
            </a>
        </div>
    </div>

    <div class="store-location-grid">
        <!-- Location details card -->
        <div class="location-details-box">
            <div class="loc-badge-zone">🏛️ {{ $zone }}</div>
            <h3>{{ $storeTitle }}</h3>
            <p style="color: var(--muted); font-size: 13.5px; line-height: 1.5; margin-bottom: 20px;">{{ $bNote }}</p>

            <div class="loc-info-list">
                <div class="loc-info-item">
                    <span class="loc-info-icon">📍</span>
                    <div>
                        <strong>Dirección</strong>
                        <p>{{ $address }}</p>
                    </div>
                </div>

                <div class="loc-info-item">
                    <span class="loc-info-icon">🕒</span>
                    <div>
                        <strong>Horario de Atención</strong>
                        <p>{{ $hours }}</p>
                    </div>
                </div>

                @if(!empty($ref))
                <div class="loc-info-item">
                    <span class="loc-info-icon">🧭</span>
                    <div>
                        <strong>Punto de Referencia</strong>
                        <p>{{ $ref }}</p>
                    </div>
                </div>
                @endif
            </div>

            <div style="margin-top: 24px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ $mapsUrl }}" target="_blank" class="btn-brand-primary">
                    <span>🧭</span> Cómo Llegar
                </a>
                @if(!empty($settings?->whatsapp_number))
                    @php $waLoc = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
                    <a href="https://wa.me/{{ $waLoc }}?text={{ urlencode('¡Hola! Me gustaría confirmar su ubicación y horarios en ' . $storeTitle) }}" target="_blank" class="btn-brand-outline" style="border-color: #25d366; color: #25d366;">
                        <span>💬</span> Preguntar por WhatsApp
                    </a>
                @endif
            </div>
        </div>

        <!-- Interactive Map frame or map card -->
        <div class="location-map-box">
            <iframe
                title="Mapa de {{ $storeTitle }}"
                width="100%"
                height="100%"
                style="border:0; border-radius: 20px; min-height: 320px;"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&hl=es&z=16&output=embed">
            </iframe>
        </div>
    </div>
</section>
