@php
    $bData = $block['data'] ?? [];
    $bTitle = $bData['title'] ?? '¿Deseas una cotización o pedido especial?';
    $bEyebrow = $bData['eyebrow'] ?? 'Atención Directa';
    $bSubtitle = $bData['subtitle'] ?? 'Estamos disponibles para responder cualquier duda sobre catálogo, personalizaciones o envíos nacionales e internacionales.';
@endphp

<!-- 8. CONTACT BOX -->
<section id="contacto" style="margin-bottom: 60px;">
    <div style="background: var(--card); border: 1px solid var(--card-border); border-radius: 24px; padding: 48px; display: flex; justify-content: space-between; align-items: center; gap: 30px; flex-wrap: wrap;">
        <div>
            <span class="section-eyebrow">{{ $bEyebrow }}</span>
            <h2 style="font-size: 32px; margin-bottom: 8px;">{{ $bTitle }}</h2>
            <p style="color: var(--muted); font-size: 14px; max-width: 520px;">{{ $bSubtitle }}</p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            @if(!empty($settings?->contact_email))
                <a href="mailto:{{ $settings->contact_email }}" class="btn-brand-outline" style="border-color: var(--line); color: var(--ink);">
                    ✉ Escribir Correo
                </a>
            @endif
            @if(!empty($settings?->whatsapp_number))
                @php $waNum = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
                <a href="https://wa.me/{{ $waNum }}?text={{ urlencode('¡Hola! Me comunico desde la tienda ' . $storeTitle) }}" target="_blank" class="btn-brand-primary" style="background:#25d366; box-shadow:0 8px 20px rgba(37,211,102,.4);">
                    <span>💬</span> Chat por WhatsApp
                </a>
            @endif
            @if(!empty($settings?->facebook_url))
                <a href="{{ $settings->facebook_url }}" target="_blank" class="btn-brand-outline" style="border-color: #1877f2; color: #1877f2;">
                    <span>📘</span> Facebook ↗
                </a>
            @endif
            @if(!empty($settings?->instagram_url))
                <a href="{{ $settings->instagram_url }}" target="_blank" class="btn-brand-outline" style="border-color: #e1306c; color: #e1306c;">
                    <span>📸</span> Instagram ↗
                </a>
            @endif
        </div>
    </div>
</section>
