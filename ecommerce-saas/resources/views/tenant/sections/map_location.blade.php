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
                <svg class="ui-icon" width="16" height="16" viewBox="0 0 24 24"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg> Abrir en Google Maps ↗
            </a>
        </div>
    </div>

    <div class="store-location-grid">
        <!-- Location details card -->
        <div class="location-details-box">
            <div class="loc-badge-zone" style="display: inline-flex; align-items: center; gap: 6px;">
                <svg class="ui-icon" width="14" height="14" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>{{ $zone }}</span>
            </div>
            <h3>{{ $storeTitle }}</h3>
            <p style="color: var(--muted); font-size: 13.5px; line-height: 1.5; margin-bottom: 20px;">{{ $bNote }}</p>

            <div class="loc-info-list">
                <div class="loc-info-item">
                    <span class="loc-info-icon">
                        <svg class="ui-icon" width="16" height="16" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <div>
                        <strong>Dirección</strong>
                        <p>{{ $address }}</p>
                    </div>
                </div>

                <div class="loc-info-item">
                    <span class="loc-info-icon">
                        <svg class="ui-icon" width="16" height="16" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                    <div>
                        <strong>Horario de Atención</strong>
                        <p>{{ $hours }}</p>
                    </div>
                </div>

                @if(!empty($ref))
                <div class="loc-info-item">
                    <span class="loc-info-icon">
                        <svg class="ui-icon" width="16" height="16" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                    </span>
                    <div>
                        <strong>Punto de Referencia</strong>
                        <p>{{ $ref }}</p>
                    </div>
                </div>
                @endif
            </div>

            <div style="margin-top: 24px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ $mapsUrl }}" target="_blank" class="btn-brand-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg class="ui-icon" width="15" height="15" viewBox="0 0 24 24"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                    <span>Cómo Llegar</span>
                </a>
                @if(!empty($settings?->whatsapp_number))
                    @php $waLoc = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
                    <a href="https://wa.me/{{ $waLoc }}?text={{ urlencode('¡Hola! Me gustaría confirmar su ubicación y horarios en ' . $storeTitle) }}" target="_blank" class="btn-brand-outline" style="border-color: #25d366; color: #25d366; display: inline-flex; align-items: center; gap: 6px;">
                        <svg style="width:16px; height:16px; fill:#25d366;" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>WhatsApp Sucursal</span>
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
