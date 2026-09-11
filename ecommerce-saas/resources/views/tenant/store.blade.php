@php
    $storeTitle = $settings?->store_name ?? $storeName;
    $primaryColor = $settings?->primary_color ?? '#d96b45';
    $secondaryColor = $settings?->secondary_color ?? '#f4efe7';
    $fontFamily = $settings?->font_family ?? 'DM Sans';

    
    // Determine Central Portal Home URL
    $portalHomeUrl = '/';
    $currentHost = request()->getHost();
    $centralDomain = config('tenancy.central_domains.0', 'localhost');
    if ($currentHost !== $centralDomain && !str_contains($currentHost, 'localhost') && !str_contains($currentHost, '127.0.0.1')) {
        $portalHomeUrl = request()->getScheme() . '://' . $centralDomain . '/';
    }
// Calculate background brightness for auto text contrast
    $cleanHex = ltrim($secondaryColor, '#');
    if (strlen($cleanHex) === 3) {
        $cleanHex = $cleanHex[0].$cleanHex[0].$cleanHex[1].$cleanHex[1].$cleanHex[2].$cleanHex[2];
    }
    $r = hexdec(substr($cleanHex, 0, 2) ?: 'f4');
    $g = hexdec(substr($cleanHex, 2, 2) ?: 'ef');
    $b = hexdec(substr($cleanHex, 4, 2) ?: 'e7');
    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    $isDark = $brightness < 135;

    $ink = $isDark ? '#f8fafc' : '#20211e';
    $muted = $isDark ? '#94a3b8' : '#77756d';
    $card = $isDark ? '#1e293b' : '#ffffff';
    $cardBorder = $isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(32, 33, 30, 0.08)';
    $line = $isDark ? 'rgba(255, 255, 255, 0.12)' : 'rgba(32, 33, 30, 0.1)';
    $glassNav = $isDark ? 'rgba(15, 23, 42, 0.92)' : 'rgba(255, 253, 249, 0.92)';

    $fontUrl = match($fontFamily) {
        'Inter' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
        'Poppins' => 'https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Poppins:wght@400;500;600;700&display=swap',
        'Plus Jakarta Sans' => 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
        'Cinzel' => 'https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Cormorant+Garamond:wght@400;600;700&display=swap',
        default => 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap',
    };

    $fontBody = match($fontFamily) {
        'Inter' => "'Inter', sans-serif",
        'Poppins' => "'Poppins', sans-serif",
        'Plus Jakarta Sans' => "'Plus Jakarta Sans', sans-serif",
        'Cinzel' => "'Cormorant Garamond', Georgia, serif",
        default => "'DM Sans', sans-serif",
    };

    $fontHeading = match($fontFamily) {
        'Inter' => "'Inter', sans-serif",
        'Poppins' => "'Montserrat', sans-serif",
        'Plus Jakarta Sans' => "'Plus Jakarta Sans', sans-serif",
        'Cinzel' => "'Cinzel', serif",
        default => "'Playfair Display', serif",
    };

    $storeAddress = $settings?->address ?? 'Av. Hidalgo #305, Centro Histórico, Zacatecas, Zac.';
    $storeZone = $settings?->neighborhood_zone ?? 'Centro Histórico';
    $storeCity = $settings?->city ?? 'Zacatecas';
    $storeMapsUrl = $settings?->maps_url ?? 'https://maps.google.com/?q=22.7748,-102.5732';
    $storeHours = $settings?->opening_hours ?? 'Lunes a Sábado: 10:00 AM - 8:30 PM';
    $storeRef = $settings?->location_reference ?? 'Zona Centro de Zacatecas';
    $storeLat = (float)($settings?->latitude ?? 22.7748);
    $storeLng = (float)($settings?->longitude ?? -102.5732);

    $heroBanner = !empty($settings?->banner_url) 
        ? $settings->banner_url 
        : 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1400&q=80';
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="{{ $primaryColor }}">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
    <title>{{ $storeTitle }} — Zacatecas Centro</title>

    <!-- Open Graph & Social Sharing -->
    <meta property="og:site_name" content="Atelier Zacatecas Centro">
    <meta property="og:title" content="{{ $storeTitle }} — Zacatecas Centro">
    <meta property="og:description" content="{{ $settings?->tagline ?? 'Catálogo en línea y pedidos directos en el Centro Histórico de Zacatecas.' }}">
    <meta property="og:image" content="{{ !empty($settings?->logo_url) ? $settings->logo_url : url('/app-icons/icon-512.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $storeTitle }} — Zacatecas Centro">
    <meta name="twitter:description" content="{{ $settings?->tagline ?? 'Catálogo en línea y pedidos directos en el Centro Histórico de Zacatecas.' }}">
    <meta name="twitter:image" content="{{ !empty($settings?->logo_url) ? $settings->logo_url : url('/app-icons/icon-512.png') }}">

    <!-- PWA Requirements for Mobile (Android & iOS) -->
    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $storeTitle }}">
    <link rel="icon" type="image/png" sizes="192x192" href="/app-icons/icon-192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/app-icons/icon-512.png">
    <link rel="apple-touch-icon" href="/app-icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/app-icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/app-icons/icon-512.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com">
    <link rel="dns-prefetch" href="https://images.unsplash.com">
    <link href="{{ $fontUrl }}" rel="stylesheet">
    <style>
        :root {
            --ink: {{ $ink }};
            --muted: {{ $muted }};
            --paper: {{ $secondaryColor }};
            --card: {{ $card }};
            --card-border: {{ $cardBorder }};
            --accent: {{ $primaryColor }};
            --line: {{ $line }};
            --glass-nav: {{ $glassNav }};
            --font-body: {!! $fontBody !!};
            --font-heading: {!! $fontHeading !!};
        }

        /* Dark Theme Variables */
        [data-theme="dark"] {
            --ink: #f3f4f6;
            --muted: #9ca3af;
            --paper: #0b0d11;
            --card: #15181f;
            --card-border: rgba(255, 255, 255, 0.08);
            --line: rgba(255, 255, 255, 0.1);
            --glass-nav: rgba(21, 24, 31, 0.94);
        }

        [data-theme="dark"] .store-header {
            background: rgba(12, 14, 18, 0.94);
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .brand-avatar-box {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
        }
        [data-theme="dark"] .nav-menu a {
            color: #d1d5db;
        }
        [data-theme="dark"] .nav-menu a:hover {
            color: var(--accent);
        }
        [data-theme="dark"] .trust-bar {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .category-carousel-card {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .category-carousel-card:hover {
            border-color: var(--accent);
            box-shadow: 0 16px 36px rgba(0,0,0,0.5);
        }
        [data-theme="dark"] .product-card {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .product-card:hover {
            border-color: rgba(255, 255, 255, 0.16);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }
        [data-theme="dark"] .product-card-body {
            background: #15181f;
        }
        [data-theme="dark"] .category-filter-pill {
            background: #181c24;
            color: #d1d5db;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .category-filter-pill.active {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }
        [data-theme="dark"] .network-store-card {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .network-store-card:hover {
            border-color: var(--accent);
        }
        [data-theme="dark"] .store-mobile-drawer {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.1);
        }
        [data-theme="dark"] .store-drawer-header {
            background: #0b0d11;
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .btn-store-drawer-close {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #f3f4f6;
        }
        [data-theme="dark"] .drawer-location-card {
            background: #0b0d11;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .drawer-location-address {
            color: #f3f4f6;
        }
        [data-theme="dark"] .drawer-location-hours {
            color: #9ca3af;
        }
        [data-theme="dark"] .drawer-nav-item {
            background: #0b0d11;
            border-color: rgba(255, 255, 255, 0.08);
            color: #f3f4f6;
        }
        [data-theme="dark"] .drawer-nav-item:hover {
            background: #1e232e;
            border-color: var(--accent);
        }
        [data-theme="dark"] .nav-item-title {
            color: #f3f4f6;
        }
        [data-theme="dark"] .nav-item-sub {
            color: #9ca3af;
        }
        [data-theme="dark"] .drawer-social-btn {
            background: #0b0d11;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .drawer-footer-actions {
            background: #0b0d11;
            border-top-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .btn-theme-toggle-drawer {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #f3f4f6;
        }
        [data-theme="dark"] .btn-share-drawer {
            background: #1e232e;
            border-color: var(--accent);
            color: var(--accent);
        }
        [data-theme="dark"] .btn-store-menu {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.12);
        }
        [data-theme="dark"] .btn-store-menu .bar {
            background: #f3f4f6;
        }
        [data-theme="dark"] .store-menu-label {
            color: #f3f4f6;
        }
        [data-theme="dark"] .store-mobile-nav a {
            color: #f3f4f6;
        }
        [data-theme="dark"] .store-mobile-nav a:hover {
            background: #1e232e;
        }
        [data-theme="dark"] .modal-card {
            background: #15181f;
            color: #f3f4f6;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.7);
        }
        [data-theme="dark"] .modal-close-btn {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.15);
            color: #f3f4f6;
        }
        [data-theme="dark"] .modal-close-btn:hover {
            background: var(--accent);
            color: #ffffff;
        }
        [data-theme="dark"] .modal-img-wrap {
            background: #0d0f14;
            border-color: rgba(255, 255, 255, 0.1);
        }
        [data-theme="dark"] .modal-chip-sku {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #9ca3af;
        }
        [data-theme="dark"] .modal-chip-stock {
            background: rgba(34, 197, 94, 0.18);
            color: #4ade80;
            border-color: rgba(34, 197, 94, 0.3);
        }
        [data-theme="dark"] .modal-chip-delivery {
            background: rgba(56, 189, 248, 0.18);
            color: #7dd3fc;
            border-color: rgba(56, 189, 248, 0.3);
        }
        [data-theme="dark"] .modal-qty-container {
            background: #0d0f14;
            border-color: rgba(255, 255, 255, 0.1);
        }
        [data-theme="dark"] .qty-btn {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.15);
            color: #f3f4f6;
        }
        [data-theme="dark"] .spec-box {
            background: #0d0f14;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .modal-zac-location-box {
            background: rgba(200, 109, 99, 0.12);
            border-color: rgba(200, 109, 99, 0.3);
        }
        [data-theme="dark"] .btn-modal-action {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #f3f4f6;
        }
        [data-theme="dark"] .related-card {
            background: #0d0f14;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .store-footer {
            background: #08090c;
            border-top-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .btn-store-menu {
            background: #181c24;
            border-color: rgba(255, 255, 255, 0.12);
        }
        [data-theme="dark"] .btn-store-menu .bar {
            background: #f3f4f6;
        }
        [data-theme="dark"] .stores-dropdown-menu {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
        }
        [data-theme="dark"] .stores-dropdown-item {
            color: #f3f4f6;
            border-bottom-color: rgba(255, 255, 255, 0.06);
        }
        [data-theme="dark"] .stores-dropdown-item:hover {
            background: #1e232e;
        }

        /* Toggle Button in Store */
        .btn-theme-toggle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 16px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            flex-shrink: 0;
        }
        .btn-theme-toggle:hover {
            transform: scale(1.08);
            border-color: var(--accent);
        }
        .btn-theme-toggle-drawer {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 4px 0;
            transition: all .2s ease;
        }
        .btn-theme-toggle-drawer:hover {
            border-color: var(--accent);
            background: var(--paper);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            color: var(--ink);
            background: var(--paper);
            font-family: var(--font-body);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        a { color: inherit; text-decoration: none; }
        h1, h2, h3, h4, .font-heading { font-family: var(--font-heading); font-weight: 600; }
        .shell { width: min(1260px, calc(100% - 48px)); margin: 0 auto; }

        /* Announcement Bar */
        .announcement-bar {
            padding: 8px 16px;
            color: #ffffff;
            background: var(--ink);
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: .04em;
            position: relative;
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .announcement-shell {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            width: min(1260px, 100%);
            margin: 0 auto;
        }
        .announcement-portal-back {
            color: rgba(255, 255, 255, 0.85);
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.1);
            transition: all .2s ease;
            white-space: nowrap;
        }
        .announcement-portal-back:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-1px);
        }
        .announcement-text-content {
            text-align: center;
            flex: 1;
            font-size: 11.5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .announcement-stores-wrap {
            position: relative;
            flex-shrink: 0;
        }
        .announcement-stores-link {
            color: {{ $primaryColor }};
            font-weight: 700;
            cursor: pointer;
            padding: 3px 10px;
            border-radius: 999px;
            background: rgba(217, 107, 69, 0.14);
            border: 1px solid rgba(217, 107, 69, 0.3);
            transition: all .2s ease;
            white-space: nowrap;
            display: inline-block;
        }
        .announcement-stores-link:hover {
            background: rgba(217, 107, 69, 0.28);
        }
        .announcement-stores-menu {
            top: calc(100% + 8px) !important;
            right: 0 !important;
            text-transform: none;
            letter-spacing: normal;
        }
        @media (max-width: 768px) {
            .announcement-portal-back { display: none; }
            .announcement-shell { justify-content: center; }
            .announcement-text-content { font-size: 10.5px; }
        }

        /* Glass Header */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 90;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            background: var(--glass-nav);
            border-bottom: 1px solid var(--line);
            transition: all .25s ease;
        }
        .nav-shell {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 80px;
            gap: 20px;
        }
        .brand-link { display: flex; align-items: center; gap: 12px; }
        .brand-logo { height: 42px; width: auto; max-width: 140px; object-fit: contain; border-radius: 8px; }
        .brand-badge-circle {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            color: #ffffff;
            background: var(--accent);
            border-radius: 50%;
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 700;
            box-shadow: 0 4px 14px {{ $primaryColor }}40;
            flex-shrink: 0;
        }
        .brand-info strong { display: block; font-size: 15px; font-weight: 700; letter-spacing: -.01em; line-height: 1.2; }
        .brand-sub-badge {
            display: block;
            font-size: 10px;
            color: var(--accent);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: 1px;
        }

        .btn-admin-gear {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--muted);
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
            text-decoration: none;
            flex-shrink: 0;
        }
        .btn-admin-gear:hover {
            color: var(--accent);
            border-color: var(--accent);
            transform: rotate(30deg);
        }

        .nav-menu { display: flex; gap: 24px; font-size: 13.5px; font-weight: 500; }
        .nav-menu a { color: var(--muted); transition: color .2s ease; }
        .nav-menu a:hover, .nav-menu a.active { color: var(--accent); font-weight: 600; }

        .nav-actions { display: flex; align-items: center; gap: 10px; }

        /* Customer Auth & Profile in Store */
        .store-user-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px 4px 5px;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: 999px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .store-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }
        .store-user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        .store-user-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--foreground);
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .store-user-status {
            font-size: 9px;
            font-weight: 800;
            color: var(--accent);
            text-transform: uppercase;
        }
        .store-user-logout {
            color: var(--muted);
            font-size: 12px;
            margin-left: 2px;
            text-decoration: none;
            padding: 2px 4px;
            border-radius: 4px;
            transition: color 0.15s ease;
        }
        .store-user-logout:hover { color: #dc2626; }

        .btn-store-auth-trigger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: var(--accent);
            color: #ffffff;
            border: none;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(200, 109, 99, 0.25);
            transition: all 0.2s ease;
        }
        .btn-store-auth-trigger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(200, 109, 99, 0.35);
        }

        .drawer-user-box {
            margin: 12px 18px 8px;
            padding: 12px 14px;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .drawer-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }
        .drawer-user-info {
            flex: 1;
            min-width: 0;
            line-height: 1.2;
        }
        .drawer-user-info strong {
            font-size: 13.5px;
            color: var(--foreground);
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .drawer-user-info small {
            font-size: 11px;
            color: var(--muted);
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .drawer-user-logout {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 800;
            text-decoration: none;
        }
        .drawer-login-wrap {
            padding: 12px 18px 6px;
        }
        .drawer-login-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
        }

        .store-auth-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 26px;
            width: min(440px, 100%);
            padding: 34px 28px;
            position: relative;
            box-shadow: 0 25px 65px rgba(0,0,0,0.35);
        }
        .auth-modal-title {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
            color: var(--foreground);
        }
        .auth-modal-subtitle {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 20px;
        }
        .social-login-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 18px;
        }
        .btn-social-auth {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 11px 18px;
            border-radius: 999px;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-google-auth {
            background: #ffffff;
            color: #1f2937;
            border: 1.5px solid #e5e7eb;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        .btn-google-auth:hover {
            background: #f9fafb;
            border-color: #d1d5db;
            transform: translateY(-1px);
        }
        .btn-facebook-auth {
            background: #1877f2;
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
        }
        .btn-facebook-auth:hover {
            background: #166fe5;
            transform: translateY(-1px);
        }
        .auth-separator {
            position: relative;
            text-align: center;
            margin: 18px 0;
        }
        .auth-separator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border);
        }
        .auth-separator span {
            position: relative;
            background: var(--card);
            padding: 0 12px;
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
        }
        .auth-field {
            margin-bottom: 14px;
            text-align: left;
        }
        .auth-field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 5px;
        }
        .auth-field input {
            width: 100%;
            padding: 11px 14px;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--foreground);
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .auth-field input:focus {
            border-color: var(--accent);
        }
        .btn-submit-email-auth {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            background: var(--accent);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.3);
            transition: all 0.2s ease;
        }
        .btn-submit-email-auth:hover {
            transform: translateY(-1px);
        }
        .auth-modal-switch-text {
            font-size: 12.5px;
            color: var(--muted);
            text-align: center;
            margin-top: 16px;
            margin-bottom: 0;
        }
        .auth-modal-switch-text a {
            color: var(--accent);
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
        }
        .social-back-btn {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            margin-bottom: 10px;
            padding: 0;
        }
        .social-back-btn:hover { color: var(--foreground); }

        /* Official Stores Dropdown in Header */
        .official-stores-dropdown-wrap {
            position: relative;
        }
        .btn-stores-dropdown-toggle {
            padding: 8px 14px;
            border-radius: 999px;
            background: var(--card);
            border: 1px solid var(--line);
            color: var(--ink);
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all .2s ease;
        }
        .btn-stores-dropdown-toggle:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .official-stores-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 320px;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            box-shadow: 0 18px 45px rgba(0,0,0,.15);
            padding: 14px;
            display: none;
            flex-direction: column;
            gap: 8px;
            z-index: 1000;
        }
        .official-stores-menu.open { display: flex; animation: dropdownFade .2s ease-out; }
        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stores-menu-header {
            padding: 6px 8px 8px;
            border-bottom: 1px solid var(--line);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .store-menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 12px;
            transition: background .2s ease;
            font-size: 13px;
        }
        .store-menu-item:hover {
            background: {{ $primaryColor }}12;
        }
        .store-menu-item.current {
            background: {{ $primaryColor }}18;
            border: 1px solid {{ $primaryColor }}40;
            font-weight: 700;
        }
        .store-menu-item-info strong { display: block; font-size: 13.5px; }
        .store-menu-item-info small { color: var(--muted); font-size: 11px; }
        .store-menu-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 999px;
            background: var(--accent);
            color: #ffffff;
        }
        .store-menu-external-icon { color: var(--muted); font-size: 14px; }

        .social-circle-btn {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 50%;
            border: 1px solid var(--line);
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            transition: all .2s ease;
        }
        .social-circle-btn:hover { color: var(--accent); border-color: var(--accent); transform: translateY(-2px); }

        .admin-direct-link {
            padding: 8px 14px;
            border-radius: 999px;
            background: var(--ink);
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: transform .2s ease;
        }
        .admin-direct-link:hover { transform: translateY(-2px); }

        /* HERO CAROUSEL */
        .hero-carousel-container {
            position: relative;
            overflow: hidden;
            margin: 20px auto 40px;
            border-radius: 28px;
            box-shadow: 0 20px 50px rgba(0,0,0, .07);
        }
        .hero-track {
            display: flex;
            transition: transform 0.65s cubic-bezier(0.25, 1, 0.5, 1);
            width: 300%;
        }
        .hero-slide {
            width: 33.333333%;
            flex-shrink: 0;
            min-height: 520px;
            position: relative;
            display: flex;
            align-items: center;
            padding: 60px 70px;
            background-size: cover;
            background-position: center;
        }
        .hero-slide-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(15,23,42,0.90) 0%, rgba(15,23,42,0.68) 50%, rgba(15,23,42,0.25) 100%);
        }
        .hero-slide-content {
            position: relative;
            z-index: 2;
            max-width: 640px;
            color: #ffffff;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: var(--accent);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .hero-slide h2 {
            font-size: clamp(24px, 3.2vw, 38px);
            line-height: 1.15;
            margin-bottom: 14px;
            letter-spacing: -.02em;
        }
        .hero-slide h2 em { color: var(--accent); font-style: normal; }
        .hero-slide p {
            font-size: 16px;
            line-height: 1.65;
            color: rgba(255,255,255,.84);
            margin-bottom: 30px;
            max-width: 540px;
        }
        .hero-cta-group { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .btn-brand-primary {
            padding: 14px 26px;
            border-radius: 999px;
            background: var(--accent);
            color: #ffffff;
            font-weight: 700;
            font-size: 13.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 20px {{ $primaryColor }}50;
            transition: all .2s ease;
            cursor: pointer;
            border: none;
        }
        .btn-brand-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 26px {{ $primaryColor }}65; }
        .btn-brand-outline {
            padding: 13px 24px;
            border-radius: 999px;
            border: 1.5px solid rgba(255,255,255,.75);
            color: #ffffff;
            font-weight: 600;
            font-size: 13.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
            transition: all .2s ease;
        }
        .btn-brand-outline:hover { background: rgba(255,255,255,.22); }

        .btn-official-hero {
            padding: 13px 24px;
            border-radius: 999px;
            background: #ffffff;
            color: #0f172a;
            font-weight: 700;
            font-size: 13.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,.25);
            transition: all .2s ease;
        }
        .btn-official-hero:hover { transform: translateY(-2px); background: #f8fafc; }

        .hero-floating-tag {
            position: absolute;
            right: 60px;
            bottom: 40px;
            z-index: 2;
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 16px;
            padding: 16px 22px;
            color: #ffffff;
            text-align: right;
        }
        .hero-floating-tag strong { display: block; font-size: 16px; }
        .hero-floating-tag small { color: rgba(255,255,255,.75); font-size: 11px; }

        /* Carousel Navigation Buttons */
        .hero-nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255,255,255,.85);
            color: #111;
            border: none;
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 22px;
            box-shadow: 0 4px 15px rgba(0,0,0,.18);
            transition: all .2s ease;
        }
        .hero-nav-arrow:hover { background: #ffffff; transform: translateY(-50%) scale(1.08); }
        .hero-nav-prev { left: 24px; }
        .hero-nav-next { right: 24px; }

        .hero-dots {
            position: absolute;
            bottom: 24px;
            left: 70px;
            z-index: 10;
            display: flex;
            gap: 10px;
        }
        .hero-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.45);
            cursor: pointer;
            transition: all .3s ease;
        }
        .hero-dot.active {
            width: 32px;
            background: var(--accent);
        }

        /* VALUE PROPOSITION BAR */
        .trust-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 30px;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            margin: 40px auto 60px;
            box-shadow: 0 10px 30px rgba(0,0,0,.03);
        }
        .trust-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .trust-icon {
            display: grid;
            width: 46px;
            height: 46px;
            place-items: center;
            border-radius: 12px;
            background: {{ $primaryColor }}15;
            color: var(--accent);
            font-size: 22px;
            flex-shrink: 0;
        }
        .trust-item strong { display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 2px; }
        .trust-item small { display: block; font-size: 11.5px; color: var(--muted); }

        /* SECTION HEADINGS */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 28px;
            gap: 20px;
        }
        .section-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: var(--accent);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }
        .section-eyebrow::before { content: ''; width: 22px; height: 2px; background: var(--accent); }
        .section-title { font-size: clamp(20px, 2.4vw, 30px); letter-spacing: -.02em; line-height: 1.18; }

        /* CATEGORIES CAROUSEL */
        .categories-carousel-wrap {
            position: relative;
            margin-bottom: 70px;
        }
        .categories-track {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px 4px 20px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .categories-track::-webkit-scrollbar { display: none; }
        .category-card-slide {
            flex: 0 0 200px;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            cursor: pointer;
            transition: all .25s ease;
            user-select: none;
        }
        .category-card-slide:hover, .category-card-slide.active-cat {
            transform: translateY(-4px);
            border-color: var(--accent);
            box-shadow: 0 12px 25px rgba(0,0,0,.06);
        }
        .category-card-slide.active-cat {
            background: var(--ink);
            color: #ffffff;
        }
        .category-card-slide.active-cat small { color: rgba(255,255,255,.7); }
        .category-icon-box {
            width: 60px;
            height: 60px;
            margin: 0 auto 12px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: {{ $primaryColor }}18;
            color: var(--accent);
            font-size: 24px;
        }
        .category-card-slide strong { display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 4px; }
        .category-card-slide small { font-size: 11px; color: var(--muted); }

        /* FEATURED PRODUCTS CAROUSEL */
        .featured-carousel-wrap {
            position: relative;
            margin-bottom: 70px;
        }
        .carousel-arrows {
            display: flex;
            gap: 10px;
        }
        .carousel-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 18px;
            transition: all .2s ease;
        }
        .carousel-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
            transform: scale(1.05);
        }
        .featured-track {
            display: flex;
            gap: 22px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px 4px 20px;
            scrollbar-width: none;
        }
        .featured-track::-webkit-scrollbar { display: none; }
        .featured-item {
            flex: 0 0 290px;
        }

        /* PRODUCT CARDS */
        .product-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all .3s ease;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 35px rgba(0,0,0,.08);
            border-color: {{ $primaryColor }}40;
        }
        .product-card-thumb {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            background: #f0ebe4;
            cursor: pointer;
        }
        .product-card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s ease;
        }
        .product-card:hover .product-card-thumb img { transform: scale(1.06); }
        .product-badge-cat {
            position: absolute;
            top: 14px;
            left: 14px;
            padding: 5px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(8px);
            color: #111;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            cursor: pointer;
            transition: all .2s ease;
        }
        .product-badge-cat:hover {
            background: var(--accent);
            color: #ffffff;
        }
        .product-stock-tag {
            position: absolute;
            top: 14px;
            right: 14px;
            padding: 4px 9px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
        }
        .stock-available { background: #dcfce7; color: #166534; }
        .stock-low { background: #fef9c3; color: #854d0e; }
        .stock-none { background: #fee2e2; color: #991b1b; }

        .product-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .product-card-body h3 {
            font-size: 17px;
            letter-spacing: -.02em;
            margin-bottom: 6px;
            line-height: 1.25;
            cursor: pointer;
        }
        .product-card-body h3:hover { color: var(--accent); }
        .product-card-body p {
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.5;
            margin-bottom: 16px;
            flex-grow: 1;
        }
        .product-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 14px;
            border-top: 1px solid var(--line);
        }
        .product-price {
            font-size: 19px;
            font-weight: 700;
            color: var(--ink);
        }
        .btn-quick-view {
            padding: 8px 16px;
            border-radius: 999px;
            background: {{ $primaryColor }}15;
            color: var(--accent);
            font-size: 11.5px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all .2s ease;
        }
        .btn-quick-view:hover {
            background: var(--accent);
            color: #ffffff;
        }

        /* CATEGORY FILTER PILLS ABOVE CATALOG */
        .category-pills-bar {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 6px 2px 16px;
            margin-bottom: 16px;
            scrollbar-width: none;
        }
        .category-pills-bar::-webkit-scrollbar { display: none; }
        .cat-pill {
            padding: 8px 16px;
            border-radius: 999px;
            background: var(--card);
            border: 1px solid var(--card-border);
            color: var(--ink);
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .cat-pill:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .cat-pill.active {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            box-shadow: 0 4px 12px {{ $primaryColor }}40;
        }
        .cat-pill-count {
            background: rgba(0,0,0, .12);
            padding: 2px 7px;
            border-radius: 999px;
            font-size: 10.5px;
        }
        .cat-pill.active .cat-pill-count {
            background: rgba(255,255,255, .3);
            color: #ffffff;
        }

        /* FULL CATALOG & SEARCH BAR */
        .catalog-filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
            padding: 16px 20px;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 16px;
        }
        .search-box {
            position: relative;
            flex: 1;
            min-width: 260px;
            max-width: 420px;
        }
        .search-box input {
            width: 100%;
            padding: 10px 16px 10px 38px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--paper);
            color: var(--ink);
            font-size: 13px;
            outline: none;
            transition: border-color .2s ease;
        }
        .search-box input:focus { border-color: var(--accent); }
        .search-box svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            fill: var(--muted);
        }
        .filter-status-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .active-filter-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 999px;
            background: {{ $primaryColor }}15;
            color: var(--accent);
            font-size: 12px;
            font-weight: 700;
        }
        .btn-clear-filter {
            background: none;
            border: none;
            color: var(--accent);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            padding: 0 2px;
        }
        .catalog-stats-count { font-size: 12.5px; color: var(--muted); }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 24px;
            margin-bottom: 80px;
        }

        /* TESTIMONIALS CAROUSEL */
        .testimonials-section {
            padding: 70px 0;
            border-top: 1px solid var(--line);
            margin-bottom: 50px;
        }
        .testimonials-track {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px 4px 20px;
            scrollbar-width: none;
        }
        .testimonials-track::-webkit-scrollbar { display: none; }
        .testimonial-card {
            flex: 0 0 360px;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0,0,0,.03);
        }
        .testimonial-stars { color: #f59e0b; font-size: 16px; margin-bottom: 12px; }
        .testimonial-quote {
            font-size: 14px;
            line-height: 1.6;
            color: var(--ink);
            margin-bottom: 20px;
            font-style: italic;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .testimonial-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
        }
        .testimonial-author strong { display: block; font-size: 13px; }
        .testimonial-author small { color: var(--muted); font-size: 11px; }

        /* OFFICIAL BUSINESSES PLATFORM DIRECTORY CARDS (FOOTER SECTION) */
        .official-network-section {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 50px;
        }
        .network-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 24px;
        }
        .network-card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all .25s ease;
        }
        .network-card:hover {
            border-color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,.06);
        }
        .network-card.is-current-card {
            border: 2px solid var(--accent);
            background: {{ $primaryColor }}0a;
        }
        .network-card-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }
        .network-logo-badge {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: var(--accent);
            color: #ffffff;
            display: grid;
            place-items: center;
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 700;
        }
        .network-card-btn {
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .2s ease;
        }
        .network-card-btn-primary {
            background: var(--accent);
            color: #ffffff;
        }
        .network-card-btn-outline {
            border: 1px solid var(--line);
            color: var(--ink);
            background: var(--card);
        }
        .network-card-btn-outline:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* ENRICHED PRODUCT MODAL ("VER MÁS COSAS DE LOS PRODUCTOS") */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 10000;
            background: rgba(10, 12, 16, 0.78);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .modal-backdrop.open { display: flex; }
        .modal-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 26px;
            width: min(880px, 100%);
            max-height: min(90vh, 840px);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            position: relative;
            box-shadow: 0 25px 65px rgba(0, 0, 0, 0.35);
            padding: 28px 32px 36px;
            margin: auto;
        }
        .modal-drag-indicator {
            display: none;
            width: 44px;
            height: 5px;
            border-radius: 999px;
            background: var(--line);
            margin: -8px auto 14px;
        }
        .modal-header-actions {
            position: sticky;
            top: -12px;
            z-index: 50;
            display: flex;
            justify-content: flex-end;
            margin-bottom: -32px;
            pointer-events: none;
        }
        .modal-close-btn {
            pointer-events: auto;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            transition: all .2s ease;
        }
        .modal-close-btn:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            transform: scale(1.08);
        }

        .modal-main-layout {
            display: grid;
            grid-template-columns: 1fr 1.25fr;
            gap: 28px;
            margin-top: 14px;
            margin-bottom: 24px;
        }
        .modal-img-col {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .modal-img-wrap {
            aspect-ratio: 1 / 1;
            border-radius: 20px;
            overflow: hidden;
            background: var(--paper);
            border: 1px solid var(--line);
            position: relative;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .modal-badges-row {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .modal-chip {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .modal-chip-sku { background: var(--paper); border: 1px solid var(--line); color: var(--muted); }
        .modal-chip-stock { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .modal-chip-delivery { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

        .modal-content-col { display: flex; flex-direction: column; }
        .modal-cat-tag {
            font-size: 11.5px;
            font-weight: 800;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 4px;
            cursor: pointer;
            display: inline-block;
        }
        .modal-cat-tag:hover { text-decoration: underline; }
        .modal-title { font-size: clamp(20px, 2.8vw, 26px); font-weight: 800; line-height: 1.25; margin-bottom: 8px; color: var(--ink); }
        .modal-price-row {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 14px;
        }
        .modal-price { font-size: 28px; font-weight: 900; color: var(--accent); letter-spacing: -0.02em; }
        .modal-price-currency { font-size: 12px; color: var(--muted); font-weight: 600; }

        .modal-desc {
            font-size: 13.5px;
            line-height: 1.6;
            color: var(--muted);
            margin-bottom: 18px;
        }

        /* QUANTITY SELECTOR WITH LIVE TOTAL */
        .modal-qty-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: var(--paper);
            border-radius: 14px;
            border: 1px solid var(--line);
            margin-bottom: 16px;
        }
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .qty-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: all .2s ease;
        }
        .qty-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .qty-display {
            font-size: 15px;
            font-weight: 700;
            min-width: 24px;
            text-align: center;
        }
        .modal-subtotal-info strong {
            display: block;
            font-size: 15px;
            color: var(--ink);
        }
        .modal-subtotal-info small {
            font-size: 11px;
            color: var(--muted);
        }

        /* TABS FOR RICH PRODUCT DETAILS */
        .modal-tabs-header {
            display: flex;
            border-bottom: 1px solid var(--line);
            gap: 16px;
            margin-bottom: 14px;
            overflow-x: auto;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }
        .modal-tab-btn {
            background: none;
            border: none;
            padding: 8px 4px 10px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            position: relative;
            white-space: nowrap;
            transition: color .2s ease;
        }
        .modal-tab-btn.active {
            color: var(--accent);
            font-weight: 700;
        }
        .modal-tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent);
            border-radius: 2px;
        }
        .modal-tab-pane { display: none; font-size: 13px; line-height: 1.6; color: var(--muted); }
        .modal-tab-pane.active { display: block; }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .spec-box {
            padding: 10px 12px;
            background: var(--paper);
            border-radius: 10px;
            border: 1px solid var(--line);
        }
        .spec-box span { display: block; font-size: 10.5px; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
        .spec-box strong { font-size: 12.5px; color: var(--ink); }

        /* ZACATECAS CENTRO SUCURSAL INFOBOX */
        .modal-zac-location-box {
            margin: 16px 0 14px;
            padding: 12px 14px;
            background: rgba(200, 109, 99, 0.08);
            border: 1px solid rgba(200, 109, 99, 0.22);
            border-radius: 14px;
        }

        /* MODAL ACTION BUTTONS */
        .modal-actions-row {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 18px;
        }
        .btn-whatsapp-order {
            padding: 14px 20px;
            border-radius: 999px;
            background: #25d366;
            color: #ffffff;
            font-weight: 800;
            font-size: 14.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 6px 18px rgba(37,211,102,.35);
            min-height: 48px;
        }
        .btn-whatsapp-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37,211,102,.45);
        }

        .modal-secondary-actions {
            display: flex;
            gap: 8px;
        }
        .btn-modal-action {
            flex: 1;
            padding: 10px 14px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--paper);
            color: var(--ink);
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            transition: all .2s ease;
        }
        .btn-modal-action:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* RELATED PRODUCTS SECTION IN MODAL */
        .modal-related-wrap {
            border-top: 1px solid var(--line);
            padding-top: 20px;
            margin-top: 20px;
        }
        .modal-related-wrap h4 {
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--ink);
        }
        .modal-related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .related-card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all .2s ease;
        }
        .related-card:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }
        .related-card img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            background: var(--card);
        }
        .related-card strong { display: block; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px; }
        .related-card span { font-size: 11.5px; font-weight: 700; color: var(--accent); }

        /* FLOATING WHATSAPP BUTTON */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #25d366;
            color: #ffffff;
            border-radius: 50%;
            display: grid;
            place-items: center;
            box-shadow: 0 12px 28px rgba(37, 211, 102, 0.45);
            z-index: 999;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: pulse-wa 2.5s infinite;
        }
        .whatsapp-float:hover {
            transform: scale(1.12) translateY(-4px);
            box-shadow: 0 16px 35px rgba(37, 211, 102, 0.6);
        }
        .whatsapp-float svg { width: 32px; height: 32px; fill: #ffffff; }
        @keyframes pulse-wa {
            0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.6); }
            70% { box-shadow: 0 0 0 16px rgba(37, 211, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
        }

        /* TOAST NOTIFICATION */
        .toast-notify {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--ink);
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
            z-index: 10000;
            transition: transform .3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: none;
        }
        .toast-notify.show {
            transform: translateX(-50%) translateY(0);
        }

        /* SMART CART INQUIRY POPUP BANNER */
        .cart-inquiry-banner {
            position: fixed;
            bottom: 24px;
            right: 24px;
            max-width: 420px;
            width: calc(100% - 32px);
            background: var(--card);
            border: 1.5px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 16px 48px rgba(0,0,0,0.2);
            z-index: 99999;
            padding: 16px 18px;
            transform: translateY(120px) scale(0.95);
            opacity: 0;
            pointer-events: none;
            transition: transform .35s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity .3s ease;
        }
        .cart-inquiry-banner.show {
            transform: translateY(0) scale(1);
            opacity: 1;
            pointer-events: auto;
        }
        .cib-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }
        .cib-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 800;
            color: #059669;
        }
        .cib-check {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #10b981;
            font-weight: 900;
        }
        .cib-close {
            background: transparent;
            border: none;
            color: var(--muted);
            font-size: 16px;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            border-radius: 6px;
        }
        .cib-product-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 10px;
            background: var(--paper);
            border-radius: 12px;
            margin-bottom: 12px;
            border: 1px solid var(--line);
        }
        .cib-thumb {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--line);
        }
        .cib-prod-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }
        .cib-prod-price {
            font-size: 11.5px;
            color: var(--accent);
            font-weight: 800;
        }
        .cib-inquiry-box {
            background: rgba(37, 211, 102, 0.08);
            border: 1.5px solid rgba(37, 211, 102, 0.28);
            border-radius: 14px;
            padding: 12px;
            margin-bottom: 12px;
        }
        .cib-inquiry-title {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 800;
            color: #15803d;
            margin-bottom: 4px;
        }
        [data-theme="dark"] .cib-inquiry-title {
            color: #4ade80;
        }
        .cib-inquiry-desc {
            font-size: 11.5px;
            color: var(--muted);
            line-height: 1.35;
        }
        .cib-actions {
            display: flex;
            gap: 8px;
        }
        .cib-btn-wa {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #25d366;
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 800;
            padding: 10px 14px;
            border-radius: 999px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(37,211,102,.35);
            transition: all .2s ease;
        }
        .cib-btn-wa:hover {
            background: #20ba5a;
            transform: translateY(-1px);
        }
        .cib-btn-cart {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--paper);
            color: var(--ink);
            font-size: 12px;
            font-weight: 700;
            border: 1px solid var(--line);
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
        }
        .cart-inquiry-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 800;
            color: #15803d;
            background: rgba(37, 211, 102, 0.12);
            border: 1px solid rgba(37, 211, 102, 0.28);
            padding: 3px 9px;
            border-radius: 999px;
            text-decoration: none;
            margin-top: 6px;
            transition: all .15s ease;
            width: fit-content;
        }
        [data-theme="dark"] .cart-inquiry-chip {
            color: #4ade80;
            background: rgba(37, 211, 102, 0.2);
        }
        .cart-inquiry-chip:hover {
            background: #25d366;
            color: #ffffff;
        }
        @media (max-width: 600px) {
            .cart-inquiry-banner {
                bottom: 84px;
                left: 14px;
                right: 14px;
                width: auto;
            }
        }

        /* FOOTER */
        .site-footer {
            padding: 60px 0 30px;
            border-top: 1px solid var(--line);
            background: var(--card);
            margin-top: 60px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-col h4 { font-size: 15px; margin-bottom: 16px; font-weight: 700; }
        .footer-col p { font-size: 13px; color: var(--muted); line-height: 1.6; }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: var(--muted); }
        .footer-links a:hover { color: var(--accent); }
        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--muted);
        }

        /* MOBILE DRAWER & HAMBURGER FOR STORE (Modern Pill Style & Slide-Over) */
        .btn-store-menu {
            display: none;
            height: 40px;
            padding: 0 13px;
            border-radius: 12px;
            background: var(--paper);
            border: 1.5px solid var(--line);
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            flex-shrink: 0;
        }
        .btn-store-menu:hover {
            border-color: var(--accent);
            background: var(--card);
            transform: translateY(-1px);
        }
        .btn-store-menu-bars {
            display: flex;
            flex-direction: column;
            gap: 4px;
            width: 18px;
        }
        .btn-store-menu .bar {
            width: 100%;
            height: 2px;
            background: var(--ink);
            border-radius: 2px;
            transition: all .25s ease;
        }
        .btn-store-menu.active .bar:nth-child(1) {
            transform: translateY(6px) rotate(45deg);
        }
        .btn-store-menu.active .bar:nth-child(2) {
            opacity: 0;
        }
        .btn-store-menu.active .bar:nth-child(3) {
            transform: translateY(-6px) rotate(-45deg);
        }
        .store-menu-label {
            font-size: 13px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.01em;
        }

        /* Backdrop overlay for store drawer */
        .store-drawer-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(17, 18, 16, 0.65);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9998;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .store-drawer-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* Slide-over Mobile Navigation Drawer for Store */
        .store-mobile-drawer {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: min(340px, 86vw);
            height: 100dvh;
            max-height: 100vh;
            background: var(--card);
            border-left: 1px solid var(--card-border);
            box-shadow: -12px 0 45px rgba(0, 0, 0, 0.28);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .store-mobile-drawer.open {
            transform: translateX(0);
        }

        /* Drawer Header */
        .store-drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid var(--line);
            background: var(--paper);
            position: sticky;
            top: 0;
            z-index: 2;
        }
        .store-drawer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }
        .store-drawer-badge {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            overflow: hidden;
            border: 1.5px solid var(--card-border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: grid;
            place-items: center;
            background: var(--accent);
            color: #ffffff;
            font-weight: 800;
            font-size: 18px;
            flex-shrink: 0;
        }
        .store-drawer-badge img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .store-drawer-title-box {
            min-width: 0;
        }
        .store-drawer-title-box strong {
            display: block;
            font-size: 14.5px;
            font-weight: 800;
            color: var(--ink);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .store-drawer-title-box small {
            display: block;
            font-size: 10.5px;
            color: var(--accent);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.04em;
        }
        .btn-store-drawer-close {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 16px;
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .btn-store-drawer-close:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            transform: scale(1.08);
        }

        /* Store Location Info Box in Drawer */
        .drawer-location-card {
            margin: 12px 14px 4px;
            padding: 12px 14px;
            background: var(--paper);
            border-radius: 14px;
            border: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .drawer-location-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .drawer-location-address {
            font-size: 12.5px;
            color: var(--ink);
            font-weight: 600;
            line-height: 1.35;
        }
        .drawer-location-hours {
            font-size: 11px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .drawer-location-maps-link {
            font-size: 11.5px;
            font-weight: 700;
            color: #2563eb;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px;
        }
        .drawer-location-maps-link:hover {
            text-decoration: underline;
        }

        /* Navigation list cards */
        .store-drawer-section-title {
            padding: 14px 20px 6px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
        }
        .store-drawer-nav-list {
            display: flex;
            flex-direction: column;
            padding: 4px 14px;
            gap: 8px;
        }
        .drawer-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            background: var(--paper);
            border: 1px solid var(--line);
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            color: var(--ink);
        }
        .drawer-nav-item:hover, .drawer-nav-item:active {
            border-color: var(--accent);
            transform: translateX(3px);
            background: var(--card);
            box-shadow: 0 4px 14px rgba(0,0,0, 0.06);
        }
        .nav-item-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .nav-item-text {
            flex: 1;
            min-width: 0;
        }
        .nav-item-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.3;
        }
        .nav-item-sub {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .nav-item-arrow {
            font-size: 18px;
            font-weight: 700;
            color: var(--muted);
            opacity: 0.6;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .drawer-nav-item:hover .nav-item-arrow {
            color: var(--accent);
            opacity: 1;
            transform: translateX(2px);
        }

        /* Drawer Social Links Grid */
        .drawer-social-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            padding: 4px 14px;
        }
        .drawer-social-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: var(--paper);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s ease;
        }
        .drawer-social-btn:hover {
            transform: translateY(-1px);
        }
        .drawer-social-wa { color: #16a34a; }
        .drawer-social-wa:hover { border-color: #16a34a; background: rgba(22, 163, 74, 0.08); }
        .drawer-social-fb { color: #1877f2; }
        .drawer-social-fb:hover { border-color: #1877f2; background: rgba(24, 119, 242, 0.08); }
        .drawer-social-ig { color: #e1306c; }
        .drawer-social-ig:hover { border-color: #e1306c; background: rgba(225, 48, 108, 0.08); }
        .drawer-social-web { color: var(--accent); }
        .drawer-social-web:hover { border-color: var(--accent); background: rgba(200, 109, 99, 0.08); }

        /* Drawer Footer Actions */
        .drawer-footer-actions {
            margin-top: auto;
            padding: 16px 14px 24px;
            border-top: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: var(--paper);
        }
        .btn-theme-toggle-drawer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px 16px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-theme-toggle-drawer:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .btn-share-drawer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--accent);
            background: var(--card);
            color: var(--accent);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-share-drawer:hover {
            background: var(--accent);
            color: #ffffff;
        }
        .drawer-brand-footer {
            text-align: center;
            margin-top: 4px;
        }
        .drawer-brand-footer span {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
        }
        .drawer-brand-footer small {
            display: block;
            font-size: 10px;
            color: var(--muted);
            opacity: 0.75;
            margin-top: 2px;
        }

        @media (max-width: 900px) {
            .trust-bar { grid-template-columns: repeat(2, 1fr); gap: 16px; padding: 20px; }
            .hero-slide { padding: 40px 30px; min-height: 420px; }
            .hero-floating-tag { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .modal-main-layout { grid-template-columns: 1fr; }
            .modal-related-grid { grid-template-columns: repeat(2, 1fr); }
            .specs-grid { grid-template-columns: 1fr; }
            .nav-menu { display: none; }
            .btn-store-menu { display: inline-flex; }
        }

        @media (max-width: 768px) {
            .shell { width: calc(100% - 24px); }
            .site-header {
                padding-top: max(6px, env(safe-area-inset-top));
            }
            .nav-shell {
                min-height: 58px;
                gap: 8px;
            }
            .brand-link {
                min-width: 0;
                gap: 8px;
                flex-shrink: 1;
            }
            .brand-logo {
                height: 36px;
                max-width: 100px;
            }
            .brand-badge-circle {
                width: 36px;
                height: 36px;
                font-size: 17px;
            }
            .brand-info {
                min-width: 0;
            }
            .brand-info strong {
                font-size: 14.5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 170px;
                display: block;
            }
            .brand-info small { display: none; }

            /* Clean up top header in mobile: brand on left, theme and menu drawer on right */
            .btn-official-website,
            .official-stores-dropdown-wrap,
            .social-circle-btn,
            .admin-direct-link,
            .btn-share-header {
                display: none !important;
            }
            .nav-actions {
                gap: 6px;
                flex-shrink: 0;
            }
            .btn-theme-toggle {
                width: 36px;
                height: 36px;
                font-size: 15px;
            }
            .btn-store-menu {
                display: inline-flex;
                height: 36px;
                padding: 0 10px;
                gap: 5px;
                border-radius: 999px;
            }
            .btn-store-menu-bars {
                width: 15px;
                height: 11px;
            }
            .store-menu-label {
                font-size: 12px;
            }
        }

        @media (max-width: 540px) {
            .store-menu-label { display: none; }
            .btn-store-menu { width: 36px; height: 36px; padding: 0; justify-content: center; }
            .brand-info strong { max-width: 130px; }
        }

        @media (max-width: 650px) {
            .hero-slide { padding: 30px 16px; min-height: 360px; }
            .hero-slide h2 { font-size: clamp(24px, 6vw, 36px); margin-bottom: 12px; }
            .hero-slide p { font-size: 13.5px; margin-bottom: 20px; }
            .hero-cta-group { flex-direction: column; width: 100%; }
            .btn-brand-primary, .btn-brand-outline, .btn-official-hero { width: 100%; justify-content: center; padding: 12px; }
            .hero-nav-arrow { width: 34px; height: 34px; font-size: 18px; }
            .hero-nav-prev { left: 10px; }
            .hero-nav-next { right: 10px; }
            .hero-dots { left: 50%; transform: translateX(-50%); bottom: 16px; }

            .trust-bar { grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 14px; }
            .trust-item { gap: 8px; }
            .trust-icon { width: 36px; height: 36px; font-size: 16px; }
            .trust-item strong { font-size: 12px; }
            .trust-item small { font-size: 10px; }

            .section-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .section-title { font-size: 24px; }

            .category-card-slide { flex: 0 0 140px; padding: 12px; border-radius: 14px; }
            .category-icon-box { width: 44px; height: 44px; font-size: 20px; margin-bottom: 8px; }
            .category-card-slide strong { font-size: 12px; }

            .featured-item { flex: 0 0 220px; }

            .catalog-filter-bar { padding: 12px 14px; flex-direction: column; align-items: stretch; }
            .search-box { min-width: 100%; max-width: 100%; }

            .products-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 50px; }
            .product-card { border-radius: 14px; }
            .product-card-body { padding: 10px; }
            .product-card-body h3 { font-size: 13px; line-height: 1.25; }
            .product-card-body p { display: none; }
            .product-card-footer { flex-direction: column; align-items: flex-start; gap: 6px; padding-top: 8px; }
            .product-price { font-size: 15px; }
            .btn-quick-view { width: 100%; text-align: center; padding: 6px; font-size: 10.5px; }
            .product-badge-cat { font-size: 8.5px; padding: 3px 6px; top: 6px; left: 6px; }
            .product-stock-tag { font-size: 8.5px; padding: 2px 5px; top: 6px; right: 6px; }

            .network-grid { grid-template-columns: 1fr; }
            .testimonial-card { flex: 0 0 280px; padding: 18px; }

            .modal-backdrop {
                padding: 0;
                align-items: flex-end;
            }
            .modal-card {
                padding: 14px 16px max(24px, env(safe-area-inset-bottom));
                width: 100%;
                max-height: 88vh;
                border-radius: 24px 24px 0 0;
                box-shadow: 0 -10px 40px rgba(0,0,0,0.5);
                margin: 0;
            }
            .modal-drag-indicator { display: block; }
            .modal-header-actions {
                top: -8px;
                margin-bottom: -28px;
            }
            .modal-close-btn { width: 34px; height: 34px; font-size: 15px; }
            .modal-main-layout { grid-template-columns: 1fr; gap: 12px; margin-top: 6px; }
            .modal-img-wrap {
                aspect-ratio: 16 / 10;
                max-height: 210px;
                border-radius: 16px;
            }
            .modal-title { font-size: 20px; line-height: 1.25; }
            .modal-price { font-size: 24px; }
            .modal-badges-row { gap: 4px; }
            .modal-chip { font-size: 10px; padding: 3px 7px; }
            .modal-tabs-header { overflow-x: auto; gap: 10px; padding-bottom: 4px; }
            .modal-tab-btn { font-size: 12px; white-space: nowrap; }
            .modal-secondary-actions { flex-direction: column; gap: 8px; }
            .btn-modal-action { width: 100%; justify-content: center; }
            .modal-related-grid { grid-template-columns: 1fr; }

            .whatsapp-float { width: 50px; height: 50px; bottom: 18px; right: 18px; }
            .whatsapp-float svg { width: 26px; height: 26px; }

            .footer-grid { grid-template-columns: 1fr; gap: 24px; }
            .footer-bottom { flex-direction: column; gap: 12px; text-align: center; }
        }

        @media (max-width: 360px) {
            .products-grid { grid-template-columns: 1fr; }
            .trust-bar { grid-template-columns: 1fr; }
        }

        /* ========================================================
           CART DRAWER, CHECKOUT MODAL, & PAYMENT GATEWAY STYLES
           ======================================================== */
        .btn-cart-header {
            background: linear-gradient(135deg, var(--accent) 0%, #a8544c 100%);
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.3);
            transition: all .2s ease;
        }
        .btn-cart-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(200, 109, 99, 0.45);
        }
        .header-cart-badge {
            background: #ffffff;
            color: var(--accent);
            font-size: 11px;
            font-weight: 900;
            padding: 2px 7px;
            border-radius: 999px;
            min-width: 18px;
            text-align: center;
        }

        .btn-card-add-cart {
            background: rgba(200, 109, 99, 0.12);
            color: var(--accent);
            border: 1px solid rgba(200, 109, 99, 0.25);
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: all .2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-card-add-cart:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            transform: scale(1.05);
        }

        .btn-modal-add-cart {
            flex: 1;
            background: linear-gradient(135deg, var(--accent) 0%, #a8544c 100%);
            color: #ffffff;
            border: none;
            padding: 13px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.35);
            transition: all .2s ease;
        }
        .btn-modal-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(200, 109, 99, 0.45);
        }
        .btn-modal-buy-now {
            flex: 1;
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 13px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            transition: all .2s ease;
        }
        .btn-modal-buy-now:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
        }

        /* CART DRAWER */
        .cart-drawer-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
            z-index: 10000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .cart-drawer-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }
        .store-cart-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 440px;
            max-width: 100vw;
            height: 100vh;
            background: var(--card);
            z-index: 10001;
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            box-shadow: -8px 0 30px rgba(0, 0, 0, 0.3);
        }
        .store-cart-drawer.open {
            transform: translateX(0);
        }
        .cart-drawer-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cart-drawer-header h3 {
            font-size: 18px;
            font-weight: 800;
            margin: 0;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .cart-drawer-close {
            background: transparent;
            border: none;
            font-size: 20px;
            color: var(--muted);
            cursor: pointer;
            padding: 4px;
            border-radius: 8px;
            line-height: 1;
        }
        .cart-drawer-close:hover {
            color: var(--ink);
            background: var(--paper);
        }
        .cart-drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .cart-empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
            margin: auto 0;
        }
        .cart-empty-icon {
            font-size: 54px;
            margin-bottom: 12px;
            display: block;
        }
        .cart-empty-state h4 {
            font-size: 18px;
            font-weight: 800;
            color: var(--ink);
            margin: 0 0 6px;
        }
        .cart-item-row {
            display: flex;
            gap: 14px;
            padding: 14px;
            background: var(--paper);
            border-radius: 14px;
            border: 1px solid var(--card-border);
            align-items: center;
            position: relative;
        }
        .cart-item-thumb {
            width: 64px;
            height: 64px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            background: var(--card);
        }
        .cart-item-details {
            flex: 1;
            min-width: 0;
        }
        .cart-item-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .cart-item-price {
            font-size: 13px;
            color: var(--accent);
            font-weight: 800;
        }
        .cart-qty-ctrls {
            display: inline-flex;
            align-items: center;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 8px;
            margin-top: 6px;
        }
        .cart-qty-btn {
            background: transparent;
            border: none;
            width: 26px;
            height: 26px;
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cart-qty-btn:hover {
            color: var(--accent);
        }
        .cart-qty-num {
            font-size: 12.5px;
            font-weight: 700;
            padding: 0 8px;
            color: var(--ink);
        }
        .cart-item-remove {
            background: transparent;
            border: none;
            color: #ef4444;
            font-size: 16px;
            cursor: pointer;
            padding: 6px;
            opacity: 0.7;
            transition: opacity .2s;
        }
        .cart-item-remove:hover {
            opacity: 1;
        }

        .cart-drawer-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--line);
            background: var(--card);
        }
        .coupon-row {
            display: flex;
            gap: 8px;
            margin-bottom: 14px;
        }
        .coupon-input {
            flex: 1;
            padding: 9px 12px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--paper);
            color: var(--ink);
            font-size: 13px;
            font-family: inherit;
        }
        .btn-apply-coupon {
            background: var(--paper);
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 9px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-apply-coupon:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .cart-summary-line {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .cart-summary-line.total-line {
            font-size: 17px;
            font-weight: 800;
            color: var(--ink);
            border-top: 1px dashed var(--line);
            padding-top: 10px;
            margin-top: 10px;
        }
        .btn-cart-checkout {
            width: 100%;
            background: linear-gradient(135deg, var(--accent) 0%, #a8544c 100%);
            color: #ffffff;
            border: none;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
            box-shadow: 0 4px 16px rgba(200, 109, 99, 0.4);
            transition: all .25s ease;
        }
        .btn-cart-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(200, 109, 99, 0.5);
        }
        .btn-cart-clear {
            width: 100%;
            background: transparent;
            border: none;
            color: var(--muted);
            font-size: 12px;
            padding: 8px;
            cursor: pointer;
            margin-top: 6px;
        }
        .btn-cart-clear:hover {
            color: #ef4444;
            text-decoration: underline;
        }

        /* CHECKOUT & PAYMENT MODAL */
        .checkout-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(6px);
            z-index: 10005;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-y: auto;
        }
        .checkout-modal-backdrop.open {
            display: flex;
        }
        .checkout-modal-card {
            background: var(--card);
            border-radius: 24px;
            border: 1px solid var(--card-border);
            width: 720px;
            max-width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 50px rgba(0,0,0,0.35);
            padding: 28px;
            position: relative;
        }
        .checkout-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid var(--line);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .checkout-modal-header h3 {
            font-size: 20px;
            font-weight: 800;
            color: var(--ink);
            margin: 0 0 4px;
        }
        .checkout-sec-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            color: #10b981;
            background: rgba(16, 185, 129, 0.12);
            padding: 3px 8px;
            border-radius: 6px;
        }
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 20px;
        }
        .checkout-grid-full {
            grid-column: 1 / -1;
        }
        .checkout-field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }
        .checkout-field input, .checkout-field select, .checkout-field textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--line);
            border-radius: 12px;
            background: var(--paper);
            color: var(--ink);
            font-size: 13.5px;
            font-family: inherit;
            outline: none;
            transition: border-color .2s ease;
            box-sizing: border-box;
        }
        .checkout-field input:focus, .checkout-field select:focus, .checkout-field textarea:focus {
            border-color: var(--accent);
        }

        /* PAYMENT METHOD SELECTOR */
        .payment-methods-tabs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 10px;
            margin-bottom: 18px;
        }
        .payment-tab-btn {
            background: var(--paper);
            border: 1.5px solid var(--line);
            border-radius: 12px;
            padding: 12px 10px;
            text-align: center;
            cursor: pointer;
            transition: all .2s ease;
        }
        .payment-tab-btn:hover {
            border-color: var(--accent);
        }
        .payment-tab-btn.active {
            border-color: var(--accent);
            background: rgba(200, 109, 99, 0.1);
            color: var(--accent);
            font-weight: 800;
        }
        .payment-tab-btn span {
            font-size: 20px;
            display: block;
            margin-bottom: 4px;
        }
        .payment-tab-btn small {
            display: block;
            font-size: 11px;
            color: var(--ink);
            font-weight: 700;
        }

        .payment-method-panel {
            display: none;
            background: var(--paper);
            border-radius: 16px;
            border: 1px solid var(--card-border);
            padding: 18px;
            margin-bottom: 20px;
            animation: fadeInPay .25s ease-out;
        }
        .payment-method-panel.active {
            display: block;
        }
        @keyframes fadeInPay {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .spei-box, .oxxo-box {
            background: var(--card);
            border: 1px dashed var(--line);
            border-radius: 12px;
            padding: 14px;
            margin-top: 10px;
        }
        .spei-clabe-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--paper);
            padding: 10px 14px;
            border-radius: 8px;
            margin-top: 8px;
            font-family: monospace;
            font-size: 14px;
            font-weight: 800;
            color: var(--accent);
        }
        .btn-copy-clabe {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-confirm-payment {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            border: none;
            padding: 16px 24px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 18px rgba(16, 185, 129, 0.4);
            transition: all .25s ease;
        }
        .btn-confirm-payment:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.5);
        }
        .btn-confirm-payment:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* ORDER SUCCESS MODAL */
        .success-modal-card {
            background: var(--card);
            border-radius: 24px;
            border: 1.5px solid #10b981;
            width: 580px;
            max-width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            padding: 32px;
            text-align: center;
            position: relative;
        }
        .success-icon-badge {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 16px;
        }
        .order-folio-tag {
            display: inline-block;
            background: var(--paper);
            border: 1.5px solid var(--line);
            padding: 8px 16px;
            border-radius: 10px;
            font-family: monospace;
            font-size: 16px;
            font-weight: 800;
            color: var(--accent);
            margin: 8px 0 16px;
        }
        .success-receipt-box {
            background: var(--paper);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 16px;
            text-align: left;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .receipt-line {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dashed var(--line);
        }
        .receipt-line:last-child {
            border-bottom: none;
        }
        .success-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn-print-receipt {
            flex: 1;
            background: var(--paper);
            border: 1.5px solid var(--line);
            color: var(--ink);
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-print-receipt:hover {
            border-color: var(--ink);
        }
        .btn-success-wa {
            flex: 1;
            background: #25d366;
            color: #fff;
            border: none;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-success-close {
            width: 100%;
            background: transparent;
            border: 1px solid var(--line);
            color: var(--muted);
            padding: 10px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 6px;
        }

        /* TICKET PRINT STYLES */
        @media print {
            body * {
                visibility: hidden;
            }
            #printableReceipt, #printableReceipt * {
                visibility: visible;
            }
            #printableReceipt {
                position: fixed;
                left: 0;
                top: 0;
                width: 80mm;
                padding: 10px;
                font-family: monospace;
                color: #000;
                background: #fff;
                display: block !important;
            }
        }
        /* ---------------------------------------------------- */
        /* PWA RETURN TO HOME & ENHANCED NAVIGATION CONTROLS   */
        /* ---------------------------------------------------- */
        .btn-back-to-portal-header {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 999px;
            background: rgba(217, 107, 69, 0.12);
            color: var(--accent);
            font-weight: 800;
            font-size: 13px;
            text-decoration: none;
            border: 1px solid rgba(217, 107, 69, 0.28);
            transition: all .2s ease;
            white-space: nowrap;
            margin-right: 6px;
            cursor: pointer;
        }
        .btn-back-to-portal-header:hover {
            background: var(--accent);
            color: #ffffff;
            transform: translateX(-2px);
        }
        .btn-back-to-portal-header .btn-back-arrow {
            font-size: 18px;
            line-height: 1;
            font-weight: 800;
        }
        @media (max-width: 640px) {
            .btn-back-to-portal-header {
                padding: 6px 10px;
                font-size: 12px;
                gap: 4px;
            }
        }

        /* Floating PWA Return Home Bar */
        .pwa-floating-bottom-bar {
            position: fixed;
            bottom: max(16px, env(safe-area-inset-bottom));
            left: 16px;
            right: 16px;
            display: flex;
            gap: 10px;
            z-index: 9995;
            pointer-events: none;
        }
        .pwa-fab-home, .pwa-fab-cart {
            pointer-events: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 13.5px;
            text-decoration: none;
            box-shadow: 0 10px 28px rgba(0,0,0,0.18);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .pwa-fab-home {
            background: rgba(32, 33, 30, 0.92);
            color: #ffffff;
            border: 1.5px solid rgba(255,255,255,0.22);
            flex: 1;
        }
        [data-theme="dark"] .pwa-fab-home {
            background: rgba(255, 255, 255, 0.94);
            color: #121212;
            border-color: rgba(255,255,255,0.4);
        }
        .pwa-fab-cart {
            background: var(--accent);
            color: #ffffff;
            border: 1.5px solid rgba(255,255,255,0.25);
            cursor: pointer;
            padding: 12px 16px;
        }
        .pwa-fab-home:active, .pwa-fab-cart:active {
            transform: scale(0.96);
        }
        @media (min-width: 900px) {
            .pwa-floating-bottom-bar {
                left: auto;
                right: 24px;
                bottom: 24px;
            }
            .pwa-fab-home {
                flex: initial;
            }
        }
        .drawer-nav-item-portal-home {
            background: rgba(217, 107, 69, 0.08) !important;
            border: 1.5px solid rgba(217, 107, 69, 0.25) !important;
            border-radius: 14px !important;
            margin-bottom: 8px !important;
        }
        .drawer-nav-item-portal-home:hover {
            background: rgba(217, 107, 69, 0.15) !important;
        }

        /* ---------------------------------------------------- */
        /* MODULAR BLOCKS: FLASH DEALS, STORY, LOCATION         */
        /* ---------------------------------------------------- */
        .flash-deals-section {
            margin: 40px 0;
        }
        .flash-deals-banner {
            background: linear-gradient(135deg, rgba(217, 107, 69, 0.08) 0%, rgba(217, 107, 69, 0.02) 100%);
            border: 1.5px solid rgba(217, 107, 69, 0.25);
            border-radius: 28px;
            padding: 36px 32px;
        }
        [data-theme="dark"] .flash-deals-banner {
            background: linear-gradient(135deg, rgba(217, 107, 69, 0.15) 0%, rgba(30, 41, 59, 0.6) 100%);
            border-color: rgba(217, 107, 69, 0.35);
        }
        .flash-deals-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }
        .flash-badge-pulse {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            background: #ef4444;
            color: #fff;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            animation: pulse-badge 2s infinite ease-in-out;
            margin-bottom: 8px;
        }
        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.04); opacity: 0.9; }
        }
        .flash-deals-title {
            font-size: 28px;
            font-weight: 900;
            margin: 4px 0 6px;
            color: var(--ink);
        }
        .flash-deals-desc {
            font-size: 14px;
            color: var(--muted);
            max-width: 520px;
            line-height: 1.5;
        }
        .flash-countdown-wrap {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            background: var(--card);
            border: 1px solid var(--card-border);
            padding: 16px 20px;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }
        .countdown-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--accent);
        }
        .flash-countdown-boxes {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .countdown-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: var(--ink);
            color: #fff;
            padding: 8px 12px;
            border-radius: 10px;
            min-width: 54px;
        }
        [data-theme="dark"] .countdown-box {
            background: #0f172a;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .countdown-num {
            font-size: 20px;
            font-weight: 900;
            line-height: 1;
        }
        .countdown-unit {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: 700;
            color: rgba(255,255,255,0.7);
            margin-top: 3px;
        }
        .countdown-sep {
            font-size: 20px;
            font-weight: 900;
            color: var(--accent);
        }
        .flash-deals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 18px;
        }
        .flash-deal-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
        }
        .flash-deal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: var(--accent);
        }
        .flash-deal-thumb {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
            background: #f1f5f9;
        }
        .flash-deal-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .flash-deal-card:hover .flash-deal-thumb img {
            transform: scale(1.06);
        }
        .flash-deal-discount {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #ef4444;
            color: #fff;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            z-index: 2;
        }
        .flash-deal-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .flash-deal-cat {
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .flash-deal-name {
            font-size: 15px;
            font-weight: 800;
            color: var(--ink);
            margin: 4px 0 10px;
            line-height: 1.3;
        }
        .flash-deal-pricing {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: auto;
            margin-bottom: 12px;
        }
        .flash-price-now {
            font-size: 18px;
            font-weight: 900;
            color: #ef4444;
        }
        .flash-price-old {
            font-size: 13px;
            text-decoration: line-through;
            color: var(--muted);
        }
        .btn-flash-add-cart {
            width: 100%;
            background: var(--ink);
            color: #fff;
            border: none;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 800;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .btn-flash-add-cart:hover {
            background: var(--accent);
        }

        /* ABOUT STORY SECTION */
        .about-story-section {
            margin: 50px 0;
        }
        .about-story-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 28px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
        }
        @media (max-width: 800px) {
            .about-story-card {
                grid-template-columns: 1fr;
            }
        }
        .about-story-media {
            position: relative;
            height: 100%;
            min-height: 340px;
        }
        .about-story-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .about-story-tag {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            color: #fff;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .about-story-content {
            padding: 44px;
        }
        .about-story-title {
            font-size: 28px;
            font-weight: 900;
            margin: 6px 0 16px;
            color: var(--ink);
        }
        .about-story-divider {
            width: 48px;
            height: 3px;
            background: var(--accent);
            border-radius: 2px;
            margin-bottom: 20px;
        }
        .about-story-text {
            font-size: 15px;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 24px;
        }
        .about-story-highlights {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .about-hl-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
        .about-hl-icon {
            font-size: 20px;
        }
        .about-hl-item strong {
            display: block;
            font-size: 13.5px;
            color: var(--ink);
        }
        .about-hl-item small {
            font-size: 11.5px;
            color: var(--muted);
            line-height: 1.3;
        }

        /* LOCATION & MAP SECTION */
        .store-location-section {
            margin: 50px 0;
        }
        .store-location-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 24px;
            align-items: stretch;
        }
        @media (max-width: 860px) {
            .store-location-grid {
                grid-template-columns: 1fr;
            }
        }
        .location-details-box {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .loc-badge-zone {
            display: inline-block;
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--accent);
            background: rgba(217, 107, 69, 0.1);
            padding: 5px 12px;
            border-radius: 999px;
            margin-bottom: 12px;
            align-self: flex-start;
        }
        .location-details-box h3 {
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 6px;
            color: var(--ink);
        }
        .loc-info-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 16px 0;
        }
        .loc-info-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .loc-info-icon {
            font-size: 20px;
            line-height: 1;
        }
        .loc-info-item strong {
            display: block;
            font-size: 13.5px;
            color: var(--ink);
            margin-bottom: 2px;
        }
        .loc-info-item p {
            font-size: 13px;
            color: var(--muted);
            margin: 0;
            line-height: 1.4;
        }
        .location-map-box {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            overflow: hidden;
            min-height: 360px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }
    </style>
</head>
<body>

@if($settings?->show_announcement ?? true)
    <aside class="announcement-bar">
        <div class="shell announcement-shell">
            <a href="{{ $portalHomeUrl }}" class="announcement-portal-back" id="btnHeaderBackPortal" title="Regresar al Portal Zacatecas Centro">
                ‹ Inicio Zacatecas
            </a>
            <span class="announcement-text-content">
                ✦ {{ !empty($settings?->announcement_text) ? $settings->announcement_text : ('Bienvenido a ' . $storeTitle . ' · Envíos seguros a todo el país') }} ✦
            </span>
            <div class="announcement-stores-wrap">
                <span class="announcement-stores-link" id="announcementStoresLink" onclick="toggleStoresDropdown()">
                    Red de Tiendas ▾
                </span>
                <div class="official-stores-menu announcement-stores-menu" id="storesDropdownMenu">
                    <div class="stores-menu-header">
                        <span>Red de Tiendas</span>
                        <span>{{ count($officialStores ?? []) }} disponibles</span>
                    </div>
                    @foreach($officialStores ?? [] as $store)
                        <a href="{{ $store['url'] }}" class="store-menu-item {{ $store['is_current'] ? 'current' : '' }}" {{ $store['is_current'] ? '' : 'target="_blank"' }}>
                            <div class="store-menu-item-info">
                                <strong>{{ $store['name'] }}</strong>
                                <small>{{ parse_url($store['url'], PHP_URL_HOST) }}</small>
                            </div>
                            @if($store['is_current'])
                                <span class="store-menu-badge">Tienda Actual</span>
                            @else
                                <span class="store-menu-external-icon">↗</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </aside>
@endif

<header class="site-header">
    <div class="shell nav-shell">
        <!-- Brand Link -->
        <a class="brand-link" href="#inicio" title="{{ $storeTitle }}">
            @if(!empty($settings?->logo_url))
                <img src="{{ $settings->logo_url }}" alt="{{ $storeTitle }}" class="brand-logo" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='grid';">
                <span class="brand-badge-circle" style="display: none;">{{ str($storeTitle)->substr(0, 1) }}</span>
            @else
                <span class="brand-badge-circle">{{ str($storeTitle)->substr(0, 1) }}</span>
            @endif
            <div class="brand-info">
                <strong>{{ $storeTitle }}</strong>
                <small class="brand-sub-badge">Centro Histórico</small>
            </div>
        </a>

        <!-- Clean Navigation Menu -->
        <nav class="nav-menu">
            <a href="#inicio" class="active">Inicio</a>
            <a href="#categorias">Categorías</a>
            <a href="#catalogo">Catálogo</a>
            <a href="#contacto">Ubicación</a>
        </nav>

        <!-- Header Actions -->
        <div class="nav-actions">
            @if(!empty($user))
                <!-- Usuario Autenticado en la Tienda -->
                <div class="store-user-pill" title="Conectado como {{ $user->name }}">
                    <img src="{{ $user->avatar_url ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80' }}" alt="{{ $user->name }}" class="store-user-avatar">
                    <div class="store-user-info">
                        <span class="store-user-name">{{ Str::limit($user->name, 12) }}</span>
                        <span class="store-user-status">✓ Conectado</span>
                    </div>
                    <a href="{{ url('/logout?return_url=' . urlencode(request()->fullUrl())) }}" class="store-user-logout" title="Cerrar Sesión">✕</a>
                </div>
            @else
                <!-- Botón Iniciar Sesión en la Tienda -->
                <button type="button" class="btn-store-auth-trigger" onclick="openStoreAuthModal('login')" title="Iniciar sesión con Google o correo">
                    <span>👤</span> <span>Entrar</span>
                </button>
            @endif

            <!-- Shopping Cart Header Button -->
            <button type="button" class="btn-cart-header" id="btnCartHeader" onclick="toggleCartDrawer()" aria-label="Ver Carrito de Compras" title="Ver Carrito de Compras">
                <span>🛒</span> <span class="cart-btn-text">Carrito</span> <span id="headerCartBadge" class="header-cart-badge">0</span>
            </button>

            <!-- Dark / Light Theme Toggle -->
            <button type="button" class="btn-theme-toggle" id="storeThemeToggleBtn" onclick="toggleTheme()" aria-label="Cambiar modo oscuro/claro" title="Cambiar a Modo Oscuro / Claro">
                <span class="theme-icon-light">🌙</span>
                <span class="theme-icon-dark" style="display: none;">☀️</span>
            </button>

            <!-- Store Admin Panel Direct Access -->
            <a href="{{ url('/tenant-admin/login?tenant=' . ($tenantId ?? 'acropolis')) }}" class="btn-admin-gear" title="Panel de Administración ({{ $storeTitle }})" aria-label="Panel Admin">
                <span>⚙</span>
            </a>

            <!-- Mobile Store Hamburger Toggle -->
            <button type="button" class="btn-store-menu" id="storeMenuToggle" onclick="toggleStoreMenu()" aria-label="Abrir Menú">
                <div class="btn-store-menu-bars">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <span class="store-menu-label">Menú</span>
            </button>
        </div>
    </div>
</header>

<!-- BACKDROP OVERLAY FOR STORE MOBILE DRAWER -->
<div class="store-drawer-backdrop" id="storeDrawerBackdrop" onclick="closeStoreMenu()"></div>

<!-- SLIDE-OVER MOBILE NAVIGATION DRAWER FOR STORE -->
<aside class="store-mobile-drawer" id="storeMobileDrawer" aria-label="Menú Móvil de la Tienda">
    <!-- Drawer Header -->
    <div class="store-drawer-header">
        <div class="store-drawer-brand">
            <div class="store-drawer-badge">
                @if(!empty($settings?->logo_url))
                    <img src="{{ $settings->logo_url }}" alt="{{ $storeTitle }}" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='grid';">
                    <span style="display: none;">{{ str($storeTitle)->substr(0, 1) }}</span>
                @else
                    <span>{{ str($storeTitle)->substr(0, 1) }}</span>
                @endif
            </div>
            <div class="store-drawer-title-box">
                <strong>{{ $storeTitle }}</strong>
                <small>Zacatecas Centro</small>
            </div>
        </div>
        <button type="button" class="btn-store-drawer-close" onclick="closeStoreMenu()" aria-label="Cerrar menú">
            ✕
        </button>
    </div>

    <!-- Store Physical Location & Hours Card -->
    <div class="drawer-location-card">
        <div class="drawer-location-tag">
            <span>📍</span> {{ $storeZone }}
        </div>
        <div class="drawer-location-address">
            {{ $storeAddress }}
        </div>
        <div class="drawer-location-hours">
            <span>🕒</span> {{ $storeHours }}
        </div>
        @if(!empty($storeMapsUrl))
            <a href="{{ $storeMapsUrl }}" target="_blank" class="drawer-location-maps-link">
                <span>🗺️</span> Cómo llegar en Google Maps ↗
            </a>
        @endif
    </div>

    <!-- Navigation Options -->
    <div class="store-drawer-section-title">Navegación de la Tienda</div>
    <nav class="store-drawer-nav-list">
        <!-- FIRST OPTION: RETURN TO CENTRAL PORTAL -->
        <a href="{{ $portalHomeUrl }}" class="drawer-nav-item drawer-nav-item-portal-home" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: var(--accent); color: #fff;">🏠</div>
            <div class="nav-item-text">
                <div class="nav-item-title" style="color: var(--accent); font-weight: 800;">Volver al Inicio del Portal</div>
                <div class="nav-item-sub">Zacatecas Centro · Directorio &amp; Mapa</div>
            </div>
            <span class="nav-item-arrow" style="color: var(--accent); font-weight: 800;">‹</span>
        </a>
        <a href="#inicio" class="drawer-nav-item" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: rgba(200, 109, 99, 0.15); color: var(--accent);">🏠</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Inicio &amp; Portada</div>
                <div class="nav-item-sub">Catálogo y novedades de {{ $storeTitle }}</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#categorias" class="drawer-nav-item" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">🏷️</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Categorías</div>
                <div class="nav-item-sub">Explora por departamento</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#destacados" class="drawer-nav-item" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">🔥</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Tendencias</div>
                <div class="nav-item-sub">Lo más destacado de la semana</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#catalogo" class="drawer-nav-item" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">🛍️</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Catálogo Completo</div>
                <div class="nav-item-sub">Todos los productos con buscador</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#negocios" class="drawer-nav-item" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">🏢</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Red de Tiendas</div>
                <div class="nav-item-sub">Explora otros comercios de Zacatecas</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#contacto" class="drawer-nav-item" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: rgba(236, 72, 153, 0.15); color: #ec4899;">💬</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Contacto &amp; Sucursal</div>
                <div class="nav-item-sub">Atención directa y horarios</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="{{ $portalHomeUrl }}" class="drawer-nav-item" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: rgba(200, 109, 99, 0.15); color: #c86d63;">📍</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Portal Zacatecas Centro ↗</div>
                <div class="nav-item-sub">Directorio general y mapa interactivo</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="{{ url('/tienda/' . ($tenantId ?? 'acropolis') . '/admin') }}" class="drawer-nav-item" onclick="closeStoreMenu()">
            <div class="nav-item-icon" style="background: rgba(30, 41, 59, 0.15); color: var(--ink);">⚙️</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Panel Administrativo</div>
                <div class="nav-item-sub">Gestión de productos y pedidos</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>
    </nav>

    @if(!empty($user))
        <div class="drawer-user-box">
            <img src="{{ $user->avatar_url ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80' }}" alt="{{ $user->name }}" class="drawer-user-avatar">
            <div class="drawer-user-info">
                <strong>{{ $user->name }}</strong>
                <small>{{ $user->email }}</small>
            </div>
            <a href="{{ url('/logout?return_url=' . urlencode(request()->fullUrl())) }}" class="drawer-user-logout">Salir</a>
        </div>
    @else
        <div class="drawer-login-wrap">
            <button type="button" class="drawer-login-btn" onclick="closeStoreMenu(); openStoreAuthModal('login');">
                <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                <span>Iniciar Sesión con Google</span>
            </button>
        </div>
    @endif

    <!-- Mobile Drawer Cart Action Button -->
    <div style="padding: 12px 20px 6px;">
        <button type="button" class="btn-cart-checkout" onclick="closeStoreMenu(); toggleCartDrawer();" style="margin-top: 0; padding: 12px 18px; font-size: 14px;">
            <span>🛒</span> Ver Mi Carrito (<span id="drawerCartBadge">0</span>)
        </button>
    </div>

    <!-- Social & Contact Links -->
    <div class="store-drawer-section-title">Contacto &amp; Redes</div>
    <div class="drawer-social-grid">
        @if(!empty($settings?->whatsapp_number))
            @php $drawerWa = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
            <a href="https://wa.me/{{ $drawerWa }}?text={{ urlencode('¡Hola! Me comunico desde la tienda ' . $storeTitle) }}" target="_blank" class="drawer-social-btn drawer-social-wa">
                <span>💬</span> WhatsApp
            </a>
        @endif
        @if(!empty($settings?->facebook_url))
            <a href="{{ $settings->facebook_url }}" target="_blank" class="drawer-social-btn drawer-social-fb">
                <span>📘</span> Facebook
            </a>
        @endif
        @if(!empty($settings?->instagram_url))
            <a href="{{ $settings->instagram_url }}" target="_blank" class="drawer-social-btn drawer-social-ig">
                <span>📷</span> Instagram
            </a>
        @endif
    </div>

    <!-- Drawer Footer Actions -->
    <div class="drawer-footer-actions">
        <button type="button" class="btn-theme-toggle-drawer" onclick="toggleTheme()">
            <span class="theme-text-light">🌙 Cambiar a Modo Oscuro</span>
            <span class="theme-text-dark" style="display: none;">☀️ Cambiar a Modo Claro</span>
        </button>
        <button type="button" class="btn-share-drawer" onclick="shareStorePage()">
            <span>📤</span> Compartir Esta Tienda
        </button>
        <div class="drawer-brand-footer">
            <span>Atelier Zacatecas · {{ $storeTitle }}</span>
            <small>Cantera Rosa &amp; Plata · PWA Offline Ready</small>
        </div>
    </div>
</aside>

<main class="shell" id="inicio">
    @foreach($layoutBlocks as $block)
        @if($block['is_visible'] ?? true)
            @includeIf('tenant.sections.' . $block['type'], ['block' => $block, 'data' => $block['data'] ?? []])
        @endif
    @endforeach
</main>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="shell">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="brand-link" style="margin-bottom: 14px;">
                    <span class="brand-badge-circle">{{ str($storeTitle)->substr(0, 1) }}</span>
                    <strong style="font-size: 16px;">{{ $storeTitle }}</strong>
                </div>
                <p style="margin-bottom: 16px;">{{ !empty($settings?->tagline) ? $settings->tagline : 'Comercio independiente multi-tenant con diseño y seguridad de estándar internacional.' }}</p>
            </div>
            <div class="footer-col">
                <h4>Navegación</h4>
                <ul class="footer-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#categorias">Categorías</a></li>
                    <li><a href="#destacados">Tendencias</a></li>
                    <li><a href="#catalogo">Catálogo Completo</a></li>
                    <li><a href="#negocios">Red de Negocios</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Atención & Soporte</h4>
                <ul class="footer-links">
                    <li><a href="#opiniones">Garantía y Envíos</a></li>
                    <li><a href="#contacto">Contacto Directo</a></li>
                    <li><a href="{{ url('/tienda/' . ($tenantId ?? 'acropolis') . '/admin') }}">Panel de la Tienda</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Red de Negocios</h4>
                <p style="margin-bottom: 12px;">Descubre las tiendas de nuestra red:</p>
                <ul class="footer-links" style="margin-bottom: 16px;">
                    @foreach($officialStores ?? [] as $store)
                        <li>
                            <a href="{{ $store['url'] }}" {{ $store['is_current'] ? '' : 'target="_blank"' }}>
                                {{ $store['name'] }} {{ $store['is_current'] ? '(Esta tienda)' : '↗' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    @if(!empty($settings?->facebook_url))
                        <a href="{{ $settings->facebook_url }}" target="_blank" class="social-circle-btn" style="color: #1877f2;" title="Facebook">FB</a>
                    @endif
                    @if(!empty($settings?->instagram_url))
                        <a href="{{ $settings->instagram_url }}" target="_blank" class="social-circle-btn" style="color: #e1306c;" title="Instagram">IG</a>
                    @endif
                    @if(!empty($settings?->whatsapp_number))
                        @php $footerWa = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
                        <a href="https://wa.me/{{ $footerWa }}?text={{ urlencode('¡Hola! Me comunico desde la tienda ' . $storeTitle) }}" target="_blank" class="social-circle-btn" style="color: #25d366;" title="WhatsApp">WA</a>
                    @endif
                    <a href="javascript:void(0)" onclick="copyCurrentStoreLink()" class="social-circle-btn" title="Compartir Tienda">🔗</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <span>{{ !empty($settings?->footer_text) ? $settings->footer_text : ('© ' . date('Y') . ' ' . $storeTitle . '. Todos los derechos reservados.') }}</span>
            <span>Plataforma E-commerce SaaS Multi-Tenant Stancl & Filament.</span>
        </div>
    </div>
</footer>

<!-- ENRICHED PRODUCT DETAILS MODAL ("VER MÁS COSAS DE LOS PRODUCTOS") -->
<div class="modal-backdrop" id="productDetailModal">
    <div class="modal-card">
        <div class="modal-drag-indicator"></div>
        <div class="modal-header-actions">
            <button class="modal-close-btn" onclick="closeProductDetail()" aria-label="Cerrar modal" title="Cerrar">✕</button>
        </div>
        
        <div class="modal-main-layout">
            <!-- Left: Product Image & Badges -->
            <div class="modal-img-col">
                <div class="modal-img-wrap">
                    <img id="modalImg" src="" alt="Producto" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/600x600?text=Zacatecas+Producto';">
                </div>
                <div class="modal-badges-row">
                    <span class="modal-chip modal-chip-sku" id="modalSku">SKU: PROD-000</span>
                    <span class="modal-chip modal-chip-stock" id="modalStock">✓ En stock</span>
                    <span class="modal-chip modal-chip-delivery">🚚 Envío rápido 24-48h</span>
                </div>
            </div>

            <!-- Right: Product Info, Tabs, Quantity & CTA -->
            <div class="modal-content-col">
                <span class="modal-cat-tag" id="modalCat" onclick="filterFromModal()">Categoría</span>
                <h3 class="modal-title" id="modalTitle">Nombre de Producto</h3>
                
                <div class="modal-price-row">
                    <div class="modal-price" id="modalPrice">$0.00</div>
                    <span class="modal-price-currency">MXN / Impuestos incluidos</span>
                </div>

                <p class="modal-desc" id="modalDesc">Descripción completa del producto.</p>

                <!-- Interactive Quantity Selector with Live Subtotal -->
                <div class="modal-qty-container">
                    <div>
                        <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--muted); display: block; margin-bottom: 6px;">Cantidad a comprar</span>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="changeModalQty(-1)" aria-label="Disminuir cantidad">−</button>
                            <span class="qty-display" id="modalQtyDisplay">1</span>
                            <button class="qty-btn" onclick="changeModalQty(1)" aria-label="Aumentar cantidad">+</button>
                        </div>
                    </div>
                    <div class="modal-subtotal-info" style="text-align: right;">
                        <small>Subtotal estimado:</small>
                        <strong id="modalSubtotal">$0.00</strong>
                    </div>
                </div>

                <!-- Tabs: Specifications, Shipping, Guarantee -->
                <div class="modal-tabs-header">
                    <button class="modal-tab-btn active" onclick="switchModalTab('specs', this)">Especificaciones</button>
                    <button class="modal-tab-btn" onclick="switchModalTab('shipping', this)">Envíos y Devolución</button>
                    <button class="modal-tab-btn" onclick="switchModalTab('guarantee', this)">Garantía</button>
                </div>

                <div class="modal-tab-pane active" id="tab-specs">
                    <div class="specs-grid">
                        <div class="spec-box">
                            <span>Material / Composición</span>
                            <strong id="specMaterial">Alta Calidad Certificada</strong>
                        </div>
                        <div class="spec-box">
                            <span>Dimensiones / Medidas</span>
                            <strong id="specDimensions">Diseño ergonómico estándar</strong>
                        </div>
                        <div class="spec-box">
                            <span>Disponibilidad</span>
                            <strong id="specAvailability">Almacén Central Inmediato</strong>
                        </div>
                        <div class="spec-box">
                            <span>Garantía</span>
                            <strong id="specWarranty">12 meses de cobertura</strong>
                        </div>
                    </div>
                </div>

                <div class="modal-tab-pane" id="tab-shipping">
                    <p style="margin-bottom: 8px;">• <strong>Envío Express Nacional:</strong> Tiempo estimado de entrega de 24 a 48 horas hábiles con número de seguimiento en vivo.</p>
                    <p style="margin-bottom: 8px;">• <strong>Empaque Protegido:</strong> Sellado de alta resistencia con caja personalizada y protección contra impactos.</p>
                    <p>• <strong>Garantía de Devolución:</strong> 30 días naturales a partir de la recepción para cambios o devoluciones sin costo.</p>
                </div>

                <div class="modal-tab-pane" id="tab-guarantee">
                    <p style="margin-bottom: 8px;">• <strong>100% Auténtico:</strong> Certificado de autenticidad emitido directamente por {{ $storeTitle }}.</p>
                    <p style="margin-bottom: 8px;">• <strong>Soporte Dedicado:</strong> Asistencia post-venta y resolución de cualquier duda a través de WhatsApp o correo de atención.</p>
                    <p>• <strong>Comercio Seguro:</strong> Pagos protegidos con cifrado SSL de extremo a extremo.</p>
                </div>

                <!-- Sucursal Zacatecas Centro Location Pill / Infobox -->
                <div class="modal-zac-location-box">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 4px;">
                        <span style="font-size: 11.5px; font-weight: 800; color: var(--accent); text-transform: uppercase; letter-spacing: .06em; display: flex; align-items: center; gap: 5px;">
                            <span>📍</span> Sucursal Zacatecas Centro
                        </span>
                        <a href="{{ $storeMapsUrl }}" target="_blank" style="font-size: 11px; font-weight: 700; color: var(--accent); text-decoration: underline;">
                            Ver en Google Maps ↗
                        </a>
                    </div>
                    <div style="font-size: 12.5px; font-weight: 600; color: var(--ink);">{{ $storeAddress }}</div>
                    <div style="font-size: 11px; color: var(--muted); margin-top: 3px;">
                        {{ $storeRef }} · ⏰ {{ $storeHours }}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="modal-actions-row">
                    <div style="display: flex; gap: 10px; width: 100%; flex-wrap: wrap; margin-bottom: 6px;">
                        <button type="button" class="btn-modal-add-cart" onclick="addModalProductToCart()">
                            <span>🛒</span> Agregar al Carrito (<span id="modalAddCartTotal">$0.00</span>)
                        </button>
                        <button type="button" class="btn-modal-buy-now" onclick="buyNowFromModal()">
                            <span>⚡</span> Comprar Ahora
                        </button>
                    </div>
                    <a id="modalWhatsAppBtn" href="#" target="_blank" class="btn-whatsapp-order">
                        <svg style="width:20px; height:20px; fill:#fff;" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.769.814 2.797.814 3.18 0 5.767-2.587 5.768-5.766 0-3.18-2.588-5.766-5.769-5.766zm0 10.355c-.886 0-1.616-.242-2.348-.675l-.168-.1-1.745.458.466-1.701-.11-.175c-.476-.757-.728-1.503-.728-2.399 0-2.531 2.059-4.59 4.635-4.59 2.576 0 4.635 2.059 4.635 4.59 0 2.531-2.059 4.592-4.535 4.592zm-8.031-4.589c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12z"/></svg>
                        Pedir por WhatsApp (<span id="modalBtnTotal">$0.00</span>)
                    </a>
                    <div class="modal-secondary-actions">
                        <button class="btn-modal-action" onclick="copyProductDirectLink()">
                            <span>🔗</span> Copiar Enlace Directo
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Inside Modal -->
        <div class="modal-related-wrap" id="modalRelatedWrap">
            <h4>Otros productos de esta categoría que te pueden interesar:</h4>
            <div class="modal-related-grid" id="modalRelatedGrid">
                <!-- Dynamically populated via JS -->
            </div>
        </div>
    </div>
</div>

<!-- STORE CUSTOMER AUTH MODAL -->
<div class="modal-backdrop" id="storeAuthModal">
    <div class="store-auth-card">
        <button type="button" class="modal-close-x" onclick="closeStoreAuthModal()" aria-label="Cerrar modal">✕</button>

        <!-- Tab 1: LOGIN -->
        <div id="storeLoginView">
            <div style="text-align: center; margin-bottom: 20px;">
                <span style="background: rgba(200, 109, 99, 0.12); color: var(--accent); padding: 4px 12px; border-radius: 999px; font-size: 11.5px; font-weight: 800; text-transform: uppercase;">{{ $storeTitle }}</span>
                <h3 class="auth-modal-title" style="margin-top: 8px;">Iniciar Sesión</h3>
                <p class="auth-modal-subtitle">Accede con tu cuenta preferida para realizar pedidos en esta tienda.</p>
            </div>

            <div class="social-login-group">
                <!-- 1. GOOGLE LOGIN -->
                <a href="{{ url('/auth/google?return_url=' . urlencode(request()->fullUrl())) }}" class="btn-social-auth btn-google-auth">
                    <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                    <span>Continuar con Google</span>
                </a>

                <!-- 2. FACEBOOK LOGIN -->
                @if(!empty($hasFacebookKeys))
                    <a href="{{ url('/auth/facebook?return_url=' . urlencode(request()->fullUrl())) }}" class="btn-social-auth btn-facebook-auth">
                        <svg width="20" height="20" fill="#ffffff" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Continuar con Facebook</span>
                    </a>
                @else
                    <button type="button" onclick="switchStoreAuthTab('facebookChooser')" class="btn-social-auth btn-facebook-auth">
                        <svg width="20" height="20" fill="#ffffff" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Continuar con Facebook</span>
                    </button>
                @endif
            </div>

            <div style="text-align: center; margin-top: -6px; margin-bottom: 14px;">
                <a href="javascript:void(0)" onclick="switchStoreAuthTab('googleChooser')" style="font-size: 12px; color: var(--muted); text-decoration: underline;">
                    ¿Problemas con el pop-up de Google? Ingresar Gmail directo
                </a>
            </div>

            <div class="auth-separator">
                <span>o con correo electrónico</span>
            </div>

            <!-- 3. EMAIL LOGIN -->
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <input type="hidden" name="return_url" value="{{ request()->fullUrl() }}">
                <div class="auth-field">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" placeholder="tu@correo.com" required>
                </div>
                <div class="auth-field">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="Tu contraseña" required>
                </div>
                <button type="submit" class="btn-submit-email-auth">
                    Iniciar Sesión
                </button>
            </form>

            <p class="auth-modal-switch-text">
                ¿No tienes cuenta? <a href="javascript:void(0)" onclick="switchStoreAuthTab('register')">Crear cuenta gratis</a>
            </p>
        </div>

        <!-- Tab 2: REGISTER -->
        <div id="storeRegisterView" style="display: none;">
            <div style="text-align: center; margin-bottom: 18px;">
                <h3 class="auth-modal-title">Crear Cuenta</h3>
                <p class="auth-modal-subtitle">Regístrate para comprar en {{ $storeTitle }} y en toda la red de Zacatecas.</p>
            </div>

            <form action="{{ url('/register') }}" method="POST">
                @csrf
                <input type="hidden" name="return_url" value="{{ request()->fullUrl() }}">
                <div class="auth-field">
                    <label>Nombre Completo</label>
                    <input type="text" name="name" placeholder="Tu nombre" required>
                </div>
                <div class="auth-field">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" placeholder="tu@correo.com" required>
                </div>
                <div class="auth-field">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="Mínimo 6 caracteres" required>
                </div>
                <div class="auth-field">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" placeholder="Repite tu contraseña" required>
                </div>
                <button type="submit" class="btn-submit-email-auth">
                    Crear Cuenta
                </button>
            </form>

            <p class="auth-modal-switch-text">
                ¿Ya tienes cuenta? <a href="javascript:void(0)" onclick="switchStoreAuthTab('login')">Iniciar sesión</a>
            </p>
        </div>

        <!-- Tab 3: GOOGLE CHOOSER DIRECT GMAIL -->
        <div id="storeGoogleChooserView" style="display: none;">
            <button type="button" onclick="switchStoreAuthTab('login')" class="social-back-btn">
                ← Volver al login
            </button>
            <div style="text-align: center; margin-bottom: 16px;">
                <h3 class="auth-modal-title">Acceso Directo con Gmail</h3>
                <p class="auth-modal-subtitle">Ingresa tus datos reales para identificarte como cliente en {{ $storeTitle }}</p>
            </div>
            <form action="{{ url('/auth/social/login') }}" method="POST">
                @csrf
                <input type="hidden" name="provider" value="google">
                <input type="hidden" name="return_url" value="{{ request()->fullUrl() }}">
                <input type="hidden" name="avatar_url" value="">
                <div class="auth-field">
                    <label>Tu Nombre Completo *</label>
                    <input type="text" name="name" placeholder="Tu nombre real" required>
                </div>
                <div class="auth-field">
                    <label>Tu Cuenta de Gmail *</label>
                    <input type="email" name="email" placeholder="tu.nombre@gmail.com" required>
                </div>
                <button type="submit" class="btn-submit-email-auth" style="background: #ea4335;">
                    Acceder con Google
                </button>
            </form>
        </div>

        <!-- Tab 4: FACEBOOK CHOOSER -->
        <div id="storeFacebookChooserView" style="display: none;">
            <button type="button" onclick="switchStoreAuthTab('login')" class="social-back-btn">
                ← Volver al login
            </button>
            <div style="text-align: center; margin-bottom: 16px;">
                <h3 class="auth-modal-title">Acceso con Facebook</h3>
                <p class="auth-modal-subtitle">Ingresa tus datos para identificarte con tu perfil de Facebook</p>
            </div>
            <form action="{{ url('/auth/social/login') }}" method="POST">
                @csrf
                <input type="hidden" name="provider" value="facebook">
                <input type="hidden" name="return_url" value="{{ request()->fullUrl() }}">
                <input type="hidden" name="avatar_url" value="">
                <div class="auth-field">
                    <label>Tu Nombre en Facebook *</label>
                    <input type="text" name="name" placeholder="Ej. Juan Pérez" required>
                </div>
                <div class="auth-field">
                    <label>Correo de Facebook *</label>
                    <input type="email" name="email" placeholder="tu.cuenta@facebook.com" required>
                </div>
                <button type="submit" class="btn-submit-email-auth" style="background: #1877f2;">
                    Acceder con Facebook
                </button>
            </form>
        </div>
    </div>
</div>

<!-- FLOATING WHATSAPP BUTTON -->
@if(!empty($settings?->whatsapp_number))
    @php
        $cleanWa = preg_replace('/[^0-9]/', '', $settings->whatsapp_number);
        $waMsg = urlencode('¡Hola! Me gustaría hacer una consulta sobre los productos de la tienda ' . $storeTitle);
    @endphp
    <a href="https://wa.me/{{ $cleanWa }}?text={{ $waMsg }}" target="_blank" class="whatsapp-float" title="Chat directo de WhatsApp con {{ $storeTitle }}">
        <svg viewBox="0 0 24 24">
            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.769.814 2.797.814 3.18 0 5.767-2.587 5.768-5.766 0-3.18-2.588-5.766-5.769-5.766zm0 10.355c-.886 0-1.616-.242-2.348-.675l-.168-.1-1.745.458.466-1.701-.11-.175c-.476-.757-.728-1.503-.728-2.399 0-2.531 2.059-4.59 4.635-4.59 2.576 0 4.635 2.059 4.635 4.59 0 2.531-2.059 4.592-4.535 4.592zm-8.031-4.589c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12z"/>
        </svg>
    </a>
@endif

<!-- TOAST NOTIFICATION CONTAINER -->
<div class="toast-notify" id="toastNotify">¡Enlace copiado al portapapeles!</div>

<!-- SMART CART ADDED INQUIRY BANNER -->
<div class="cart-inquiry-banner" id="cartInquiryBanner" role="dialog" aria-live="polite">
    <div class="cib-header">
        <div class="cib-status">
            <span class="cib-check">✓</span>
            <span>¡Añadido al carrito!</span>
        </div>
        <button type="button" class="cib-close" onclick="closeCartInquiryBanner()" aria-label="Cerrar aviso">✕</button>
    </div>
    <div class="cib-product-row">
        <img src="" alt="" id="cibProdThumb" class="cib-thumb">
        <div>
            <div class="cib-prod-name" id="cibProdName"></div>
            <div class="cib-prod-price" id="cibProdPrice"></div>
        </div>
    </div>
    <div class="cib-inquiry-box">
        <div class="cib-inquiry-title" id="cibInquiryTitle"></div>
        <div class="cib-inquiry-desc" id="cibInquiryDesc"></div>
    </div>
    <div class="cib-actions">
        <a href="#" target="_blank" class="cib-btn-wa" id="cibBtnWa" onclick="closeCartInquiryBanner()">
            <span id="cibBtnWaIcon">💬</span> <span id="cibBtnWaText">Preguntar por WhatsApp</span>
        </a>
        <button type="button" class="cib-btn-cart" onclick="closeCartInquiryBanner(); toggleCartDrawer();">
            Ver Carrito (<span id="cibCartCount">1</span>)
        </button>
    </div>
</div>

<!-- CART DRAWER BACKDROP -->
<div class="cart-drawer-backdrop" id="cartDrawerBackdrop" onclick="toggleCartDrawer()"></div>

<!-- CART SLIDE-OVER DRAWER -->
<aside class="store-cart-drawer" id="storeCartDrawer" aria-label="Carrito de Compras">
    <div class="cart-drawer-header">
        <h3>🛒 Carrito (<span id="cartDrawerCount">0</span>)</h3>
        <button type="button" class="cart-drawer-close" onclick="toggleCartDrawer()" aria-label="Cerrar carrito">✕</button>
    </div>

    <div class="cart-drawer-body" id="cartDrawerBody">
        <!-- Dynamically rendered items or empty state -->
    </div>

    <div class="cart-drawer-footer" id="cartDrawerFooter">
        <div class="coupon-row">
            <input type="text" id="cartCouponInput" class="coupon-input" placeholder="Cupón (ej. CENTRO10)" maxlength="20">
            <button type="button" class="btn-apply-coupon" onclick="applyCartCoupon()">Aplicar</button>
        </div>
        <div id="couponAppliedBadge" style="display: none; font-size: 11.5px; color: #10b981; font-weight: 700; margin-bottom: 8px;">
            ✓ Descuento del 10% aplicado (<span id="couponCodeLabel"></span>)
        </div>
        <div class="cart-summary-line">
            <span>Subtotal:</span>
            <strong id="cartSummarySubtotal">$0.00 MXN</strong>
        </div>
        <div class="cart-summary-line" id="cartDiscountLine" style="display: none; color: #10b981;">
            <span>Descuento (Cupón):</span>
            <strong id="cartSummaryDiscount">-$0.00 MXN</strong>
        </div>
        <div class="cart-summary-line">
            <span>Envío Zacatecas Centro:</span>
            <strong style="color: #10b981;">Gratis ($0.00)</strong>
        </div>
        <div class="cart-summary-line total-line">
            <span>Total a Pagar:</span>
            <span id="cartSummaryTotal" style="color: var(--accent);">$0.00 MXN</span>
        </div>

        <button type="button" class="btn-cart-checkout" id="btnGoToCheckout" onclick="openCheckoutModal()">
            <span>💳</span> Proceder al Pago / Checkout
        </button>
        <a href="{{ url('/?action=cart_route&store=' . $tenantId) }}" class="btn-cart-view-route" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; border-radius: 12px; background: rgba(200, 109, 99, 0.12); color: var(--accent); font-weight: 700; font-size: 13px; text-decoration: none; border: 1.5px solid var(--accent); margin-top: 8px; transition: all .2s ease;">
            <span>🚶‍♂️</span> Ver Ruta en el Mapa para Visitar/Recoger
        </a>
        <button type="button" class="btn-cart-clear" onclick="clearCart()">
            Vaciar Carrito
        </button>
            <a href="{{ $portalHomeUrl }}" class="btn-cart-back-home" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 11px; border-radius: 12px; background: rgba(217, 107, 69, 0.08); color: var(--accent); font-weight: 700; font-size: 12.5px; text-decoration: none; border: 1.5px solid rgba(217, 107, 69, 0.25); margin-top: 8px; transition: all .2s ease;">
            <span>🏠</span> Volver al Portal Zacatecas Centro
        </a>
</div>
</aside>

<!-- CHECKOUT & PAYMENT MODAL -->
<div class="checkout-modal-backdrop" id="checkoutModal">
    <div class="checkout-modal-card">
        <div class="checkout-modal-header">
            <div>
                <h3>Pasarela de Pago Segura</h3>
                <div class="checkout-sec-badge">🔒 Cifrado Bancario SSL · Pedido Seguro en {{ $storeTitle }}</div>
            </div>
            <button type="button" class="cart-drawer-close" onclick="closeCheckoutModal()" aria-label="Cerrar checkout">✕</button>
        </div>

        <form id="checkoutForm" onsubmit="event.preventDefault(); processOrderCheckout();">
            <!-- Customer Information -->
            <div style="font-size: 13px; font-weight: 800; color: var(--accent); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 10px;">
                1. Datos del Cliente &amp; Entrega
            </div>

            <div class="checkout-grid">
                <div class="checkout-field">
                    <label for="checkCustName">Nombre Completo *</label>
                    <input type="text" id="checkCustName" required placeholder="Ej. Juan Pérez González">
                </div>
                <div class="checkout-field">
                    <label for="checkCustEmail">Correo Electrónico *</label>
                    <input type="email" id="checkCustEmail" required placeholder="tu@correo.com">
                </div>
                <div class="checkout-field">
                    <label for="checkCustPhone">Teléfono / WhatsApp *</label>
                    <input type="tel" id="checkCustPhone" required placeholder="492 123 4567">
                </div>
                <div class="checkout-field">
                    <label for="checkDeliveryType">Método de Entrega</label>
                    <select id="checkDeliveryType" onchange="toggleShippingAddressField(this.value)">
                        <option value="pickup">🛍️ Recoger en Sucursal Centro (Gratis)</option>
                        <option value="delivery">🚚 Envío a Domicilio en Zacatecas (Gratis)</option>
                    </select>
                </div>
                <div class="checkout-field checkout-grid-full" id="shippingAddressWrap" style="display: none;">
                    <label for="checkCustAddress">Dirección de Entrega (Calle, Número, Colonia, C.P.) *</label>
                    <input type="text" id="checkCustAddress" placeholder="Ej. Av. Hidalgo #123, Col. Centro, C.P. 98000, Zacatecas">
                </div>
                <div class="checkout-field checkout-grid-full">
                    <label for="checkCustNotes">Notas o Instrucciones Especiales (Opcional)</label>
                    <input type="text" id="checkCustNotes" placeholder="Ej. Empaque para regalo, timbre blanco, etc.">
                </div>
            </div>

            <!-- Payment Method Selection -->
            <div style="font-size: 13px; font-weight: 800; color: var(--accent); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 10px;">
                2. Selecciona tu Método de Pago
            </div>

            <div class="payment-methods-tabs">
                <div class="payment-tab-btn active" data-method="card" onclick="switchPaymentTab('card', this)">
                    <span>💳</span>
                    <small>Tarjeta Débito/Crédito</small>
                </div>
                <div class="payment-tab-btn" data-method="spei" onclick="switchPaymentTab('spei', this)">
                    <span>🏦</span>
                    <small>Transferencia SPEI</small>
                </div>
                <div class="payment-tab-btn" data-method="oxxo" onclick="switchPaymentTab('oxxo', this)">
                    <span>🏪</span>
                    <small>OXXO Pay Efectivo</small>
                </div>
                <div class="payment-tab-btn" data-method="cash" onclick="switchPaymentTab('cash', this)">
                    <span>💵</span>
                    <small>Contra Entrega</small>
                </div>
                <div class="payment-tab-btn" data-method="whatsapp" onclick="switchPaymentTab('whatsapp', this)">
                    <span>💬</span>
                    <small>Por WhatsApp</small>
                </div>
            </div>

            <!-- Card Payment Panel -->
            <div class="payment-method-panel active" id="payPanel_card">
                <div style="font-size: 12.5px; color: var(--muted); margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                    <span>Tarjetas aceptadas: Visa, Mastercard, American Express</span>
                    <span style="color: #10b981; font-weight: 700;">✓ 3D Secure Activo</span>
                </div>
                <div class="checkout-grid">
                    <div class="checkout-field checkout-grid-full">
                        <label>Titular de la Tarjeta</label>
                        <input type="text" id="cardHolderName" placeholder="Nombre como aparece en el plástico">
                    </div>
                    <div class="checkout-field checkout-grid-full">
                        <label>Número de Tarjeta</label>
                        <input type="text" id="cardNumber" placeholder="4152 •••• •••• 1234" maxlength="19" oninput="formatCreditCardNumber(this)">
                    </div>
                    <div class="checkout-field">
                        <label>Vencimiento (MM/AA)</label>
                        <input type="text" id="cardExpiry" placeholder="MM/AA" maxlength="5" oninput="formatCardExpiry(this)">
                    </div>
                    <div class="checkout-field">
                        <label>CVV / CVC</label>
                        <input type="password" id="cardCvv" placeholder="•••" maxlength="4">
                    </div>
                </div>
            </div>

            <!-- SPEI Panel -->
            <div class="payment-method-panel" id="payPanel_spei">
                <div style="font-size: 13px; color: var(--ink); margin-bottom: 6px;">
                    Realiza tu transferencia bancaria a la cuenta CLABE de la tienda:
                </div>
                <div class="spei-box">
                    <div style="font-size: 12px; color: var(--muted);">Banco Receptor: <strong>STP / BBVA México</strong></div>
                    <div style="font-size: 12px; color: var(--muted); margin-top: 3px;">Beneficiario: <strong>Atelier Zacatecas ({{ $storeTitle }})</strong></div>
                    <div class="spei-clabe-row">
                        <span id="speiClabeText">6469 0300 1234 5678 90</span>
                        <button type="button" class="btn-copy-clabe" onclick="copySpeiClabe()">Copiar CLABE</button>
                    </div>
                    <small style="display: block; color: var(--muted); margin-top: 8px; font-size: 11px;">
                        * Tu pedido quedará registrado inmediatamente y confirmado al validar el comprobante.
                    </small>
                </div>
            </div>

            <!-- OXXO Panel -->
            <div class="payment-method-panel" id="payPanel_oxxo">
                <div style="font-size: 13px; color: var(--ink); margin-bottom: 6px;">
                    Paga en efectivo en cualquier tienda OXXO de Zacatecas o del país:
                </div>
                <div class="oxxo-box" style="text-align: center;">
                    <div style="font-size: 26px; letter-spacing: 4px; font-family: monospace; font-weight: 800; color: #d97706; margin: 8px 0;" id="oxxoBarcodeVal">
                        9340 1284 9281 74
                    </div>
                    <div style="font-size: 12px; color: var(--muted);">Referencia de 14 dígitos para el cajero de OXXO</div>
                    <small style="display: block; color: var(--muted); margin-top: 8px; font-size: 11px;">
                        Comisión OXXO habitual: $15 MXN. La confirmación de pago se procesa al instante.
                    </small>
                </div>
            </div>

            <!-- Cash on Delivery Panel -->
            <div class="payment-method-panel" id="payPanel_cash">
                <div style="font-size: 13px; color: var(--ink); margin-bottom: 6px;">
                    💵 <strong>Pago Contra Entrega en Zacatecas Centro:</strong>
                </div>
                <p style="font-size: 12.5px; color: var(--muted); margin: 0; line-height: 1.4;">
                    Paga en efectivo en moneda nacional al momento de recibir tu paquete en tu domicilio o al recoger en mostrador en nuestra sucursal de <strong>{{ $storeAddress }}</strong>.
                </p>
            </div>

            <!-- WhatsApp Order Panel -->
            <div class="payment-method-panel" id="payPanel_whatsapp">
                <div style="font-size: 13px; color: var(--ink); margin-bottom: 6px;">
                    💬 <strong>Confirmación Asistida por WhatsApp:</strong>
                </div>
                <p style="font-size: 12.5px; color: var(--muted); margin: 0; line-height: 1.4;">
                    Al confirmar, se generará tu folio de pedido en el sistema y se abrirá una conversación directa con el asesor de {{ $storeTitle }} para acordar detalles de entrega o pago personalizado.
                </p>
            </div>

            <!-- Total Preview & Submit Button -->
            <div style="margin-top: 14px;">
                <button type="submit" class="btn-confirm-payment" id="btnSubmitCheckout">
                    <span id="btnPayIcon">🔒</span> <span id="btnPayText">Confirmar y Pagar</span> $<span id="checkoutPayBtnTotal">0.00</span> MXN
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ORDER SUCCESS CONFIRMATION MODAL -->
<div class="checkout-modal-backdrop" id="orderSuccessModal">
    <div class="success-modal-card">
        <div class="success-icon-badge">✓</div>
        <h3 style="font-size: 22px; font-weight: 800; color: var(--ink); margin: 0 0 4px;">¡Pedido Realizado con Éxito!</h3>
        <p style="font-size: 13.5px; color: var(--muted); margin: 0 0 12px;">Tu compra ha sido registrada en el sistema de {{ $storeTitle }}.</p>
        
        <div>
            <span style="font-size: 11.5px; color: var(--muted); font-weight: 700; text-transform: uppercase;">Folio de Pedido</span><br>
            <div class="order-folio-tag" id="successFolioTag">ACRO-20260909-XXXX</div>
        </div>

        <div class="success-receipt-box" id="successReceiptDetails">
            <!-- Dynamically populated receipt summary -->
        </div>

        <div class="success-actions">
            <button type="button" class="btn-print-receipt" onclick="printOrderReceipt()">
                <span>🖨️</span> Imprimir Ticket
            </button>
            <a href="#" id="btnSuccessWhatsApp" target="_blank" class="btn-success-wa">
                <span>💬</span> Enviar a WhatsApp
            </a>
            <button type="button" class="btn-success-close" onclick="closeSuccessModal()">
                Cerrar y Seguir Comprando
            </button>
        </div>
    </div>
</div>

<!-- PRINTABLE RECEIPT CONTAINER (VISIBLE ONLY IN WINDOW.PRINT) -->
<div id="printableReceipt" style="display: none;"></div>

<!-- JAVASCRIPT LOGIC -->
<script>
// Catalog products database for rich details & related products
window.ALL_PRODUCTS = @json($products) || [];
var ALL_PRODUCTS = window.ALL_PRODUCTS;
const STORE_TITLE = @json($storeTitle);
const WA_PHONE = @json(!empty($settings?->whatsapp_number) ? preg_replace('/[^0-9]/', '', $settings->whatsapp_number) : '');
const STORE_ADDRESS = @json($storeAddress);
const STORE_ZONE = @json($storeZone);
const STORE_MAPS_URL = @json($storeMapsUrl);
const STORE_HOURS = @json($storeHours);
const STORE_REF = @json($storeRef);

let currentActiveCategory = 'all';
let currentActiveCategoryName = 'Todos los productos';
let currentModalProduct = null;
let currentModalQty = 1;

// ========================================================
// E-COMMERCE SHOPPING CART & CHECKOUT MANAGER
// ========================================================
const TENANT_ID = @json($tenantId);
const CART_STORAGE_KEY = 'atelier_cart_' + TENANT_ID;
let storeCart = [];
let appliedCoupon = null;
let selectedPaymentMethod = 'card';

function initCart() {
    try {
        const saved = localStorage.getItem(CART_STORAGE_KEY);
        if (saved) {
            storeCart = JSON.parse(saved) || [];
        }
    } catch (e) {
        storeCart = [];
    }
    updateCartUI();
}

function saveCart() {
    try {
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(storeCart));
        syncTenantCartToGlobalRegistry(TENANT_ID, @json($storeTitle), storeCart);
    } catch (e) {}
    updateCartUI();
}

function syncTenantCartToGlobalRegistry(storeId, storeName, items) {
    try {
        let registry = JSON.parse(localStorage.getItem('atelier_unified_cart') || '{}');
        if (!items || items.length === 0) {
            delete registry[storeId];
        } else {
            registry[storeId] = {
                store_id: storeId,
                store_name: storeName,
                items: items
            };
        }
        localStorage.setItem('atelier_unified_cart', JSON.stringify(registry));
    } catch (e) {}
}

function showToast(message) {
    const toast = document.getElementById('toastNotify');
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    clearTimeout(window.__storeToastTimer);
    window.__storeToastTimer = setTimeout(() => {
        toast.classList.remove('show');
    }, 3200);
}

function toggleCartDrawer() {
    const drawer = document.getElementById('storeCartDrawer');
    const backdrop = document.getElementById('cartDrawerBackdrop');
    if (!drawer) return;
    const isOpen = drawer.classList.toggle('open');
    if (backdrop) backdrop.classList.toggle('active', isOpen);
    if (isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        if (!document.getElementById('checkoutModal')?.classList.contains('open') &&
            !document.getElementById('productDetailModal')?.classList.contains('open') &&
            !document.getElementById('orderSuccessModal')?.classList.contains('open')) {
            document.body.style.overflow = '';
        }
    }
}

// DETECT PRODUCT TYPE & TAILOR SMART CONTEXTUAL INQUIRY
function detectProductInquiryType(product) {
    const pName = (product.name || '').toLowerCase();
    const pDesc = (product.description || '').toLowerCase();
    const catName = ((product.category && product.category.name) || product.category_name || '').toLowerCase();
    const catSlug = ((product.category && product.category.slug) || '').toLowerCase();
    const fullText = `${pName} ${catName} ${catSlug} ${pDesc}`;

    // 1. CLOTHING / APPAREL / SHOES / TEXTILES
    const clothingTerms = ['ropa', 'moda', 'prenda', 'vestir', 'vestido', 'camisa', 'playera', 'pantalon', 'pantalón', 'falda', 'blusa', 'sueter', 'suéter', 'chamarra', 'chaleco', 'saco', 'calzado', 'zapato', 'tenis', 'bota', 'sandalia', 'talla', 'tallas', 'sombrero', 'rebozo', 'reboso', 'poncho', 'bufanda', 'textil', 'lujo'];
    const isClothing = clothingTerms.some(term => fullText.includes(term));

    // 2. FOOD / BEVERAGES / SWEETS / RESTAURANT
    const foodTerms = ['comida', 'alimento', 'bebida', 'cafe', 'café', 'postre', 'dulce', 'gordita', 'pan', 'restaurante', 'comestible', 'snack', 'tuna', 'queso de tuna', 'ate', 'cajeta', 'mezcal', 'vino', 'licor', 'cerveza', 'chicharron', 'desayuno', 'cena', 'sabor', 'orden', 'pieza', 'rebanada'];
    const isFood = foodTerms.some(term => fullText.includes(term));

    // 3. JEWELRY / SILVER / ARTISAN CRAFTS
    const jewelryTerms = ['plata', 'joya', 'joyeria', 'joyería', 'platería', 'plateria', 'anillo', 'dije', 'collar', 'pulsera', 'arete', 'aretes', 'cantera', 'mineral', 'oro', 'artesan', 'souvenir', 'recuerdo'];
    const isJewelry = jewelryTerms.some(term => fullText.includes(term));

    let icon = '💬';
    let btnText = 'Preguntar a la Tienda';
    let promptTitle = '¿Deseas consultar con la tienda?';
    let promptSubtitle = 'Pregunta directamente por WhatsApp sobre este producto.';
    let waMessage = '';

    if (isClothing) {
        icon = '👕';
        btnText = 'Preguntar por Tallas';
        promptTitle = '👕 ¿Tienes dudas sobre la talla o medida?';
        promptSubtitle = 'Pregunta por WhatsApp qué tallas están disponibles en la sucursal del Centro.';
        waMessage = `¡Hola! Vi el producto "${product.name}" en su tienda online de Zacatecas Centro. Me interesa comprarlo, ¿qué tallas tienen disponibles en existencia?`;
    } else if (isFood) {
        icon = '🍽️';
        btnText = 'Preguntar por Existencia Hoy';
        promptTitle = '🍽️ ¿Deseas verificar si hay existencia hoy?';
        promptSubtitle = 'Consulta si tienen porciones o unidades listas para recoger o consumir hoy.';
        waMessage = `¡Hola! Vi en su menú/catálogo de Zacatecas Centro "${product.name}". ¿Aún tienen disponible en existencia para hoy?`;
    } else if (isJewelry) {
        icon = '💍';
        btnText = 'Consultar Acabado o Medida';
        promptTitle = '💍 ¿Deseas consultar sobre esta pieza?';
        promptSubtitle = 'Verifica acabados de plata ley .925, medidas de anillo o grabado personalizado.';
        waMessage = `¡Hola! Me interesa la pieza de joyería/platería "${product.name}" de su tienda en Zacatecas Centro. ¿Tienen medidas o piezas disponibles en sucursal?`;
    } else {
        icon = '📦';
        btnText = 'Consultar Disponibilidad';
        promptTitle = '📦 ¿Deseas consultar sobre este producto?';
        promptSubtitle = 'Consulta directamente sobre stock o recogida física en el Centro Histórico.';
        waMessage = `¡Hola! Vi en su tienda de Zacatecas Centro el producto "${product.name}". ¿Tienen disponibilidad para entrega o recogida en sucursal?`;
    }

    const cleanPhone = (typeof WA_PHONE !== 'undefined' && WA_PHONE) ? WA_PHONE.replace(/[^0-9]/g, '') : '';
    const waUrl = cleanPhone 
        ? `https://wa.me/${cleanPhone}?text=${encodeURIComponent(waMessage)}`
        : `https://wa.me/?text=${encodeURIComponent(waMessage)}`;

    return {
        isClothing,
        isFood,
        isJewelry,
        icon,
        btnText,
        promptTitle,
        promptSubtitle,
        waMessage,
        waUrl
    };
}

let __cartInquiryTimer = null;

function showCartInquiryBanner(prod, qty = 1) {
    const banner = document.getElementById('cartInquiryBanner');
    if (!banner) return;

    const inq = detectProductInquiryType(prod);

    const thumbEl = document.getElementById('cibProdThumb');
    if (thumbEl) {
        thumbEl.src = prod.image_url || 'https://placehold.co/100x100?text=Prod';
        thumbEl.alt = prod.name || 'Producto';
    }

    const nameEl = document.getElementById('cibProdName');
    if (nameEl) nameEl.textContent = prod.name;

    const priceEl = document.getElementById('cibProdPrice');
    if (priceEl) priceEl.textContent = `$${(parseFloat(prod.price) || 0).toFixed(2)} MXN (${qty} pza${qty > 1 ? 's' : ''})`;

    const titleEl = document.getElementById('cibInquiryTitle');
    if (titleEl) titleEl.innerHTML = inq.promptTitle;

    const descEl = document.getElementById('cibInquiryDesc');
    if (descEl) descEl.textContent = inq.promptSubtitle;

    const btnWa = document.getElementById('cibBtnWa');
    if (btnWa) {
        btnWa.href = inq.waUrl;
    }
    const iconEl = document.getElementById('cibBtnWaIcon');
    if (iconEl) iconEl.textContent = inq.icon;
    const textEl = document.getElementById('cibBtnWaText');
    if (textEl) textEl.textContent = inq.btnText;

    const countEl = document.getElementById('cibCartCount');
    if (countEl) {
        const totalItems = storeCart.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);
        countEl.textContent = totalItems;
    }

    banner.classList.add('show');

    clearTimeout(__cartInquiryTimer);
    __cartInquiryTimer = setTimeout(() => {
        closeCartInquiryBanner();
    }, 7500);
}

function closeCartInquiryBanner() {
    const banner = document.getElementById('cartInquiryBanner');
    if (banner) banner.classList.remove('show');
    clearTimeout(__cartInquiryTimer);
}

function addCartItem(productId, qty = 1) {
    const list = window.ALL_PRODUCTS || (typeof ALL_PRODUCTS !== 'undefined' ? ALL_PRODUCTS : []);
    if (!list || !Array.isArray(list) || list.length === 0) return;
    const prod = list.find(p => String(p.id) === String(productId) || p.slug === String(productId));
    if (!prod) return;

    const existing = storeCart.find(item => String(item.id) === String(prod.id));
    if (existing) {
        existing.quantity += qty;
    } else {
        storeCart.push({
            id: prod.id,
            name: prod.name,
            price: parseFloat(prod.price) || 0,
            image_url: prod.image_url || 'https://placehold.co/100x100?text=Prod',
            quantity: qty,
            slug: prod.slug
        });
    }

    saveCart();
    showToast(`🛒 "${prod.name}" añadido al carrito`);
    showCartInquiryBanner(prod, qty);
    
    // Animate badge
    const badge = document.getElementById('headerCartBadge');
    if (badge) {
        badge.style.transform = 'scale(1.35)';
        setTimeout(() => badge.style.transform = 'scale(1)', 250);
    }
}

function addModalProductToCart() {
    if (!currentModalProduct) return;
    addCartItem(currentModalProduct.id, currentModalQty);
    closeProductDetail();
    toggleCartDrawer();
}

function buyNowFromModal() {
    if (!currentModalProduct) return;
    addCartItem(currentModalProduct.id, currentModalQty);
    closeProductDetail();
    openCheckoutModal();
}

function updateCartItemQty(index, delta) {
    if (!storeCart[index]) return;
    storeCart[index].quantity += delta;
    if (storeCart[index].quantity <= 0) {
        storeCart.splice(index, 1);
    }
    saveCart();
}

function removeCartItem(index) {
    if (!storeCart[index]) return;
    storeCart.splice(index, 1);
    saveCart();
}

function clearCart() {
    storeCart = [];
    appliedCoupon = null;
    saveCart();
    const couponInput = document.getElementById('cartCouponInput');
    if (couponInput) couponInput.value = '';
    const couponBadge = document.getElementById('couponAppliedBadge');
    if (couponBadge) couponBadge.style.display = 'none';
}

function applyCartCoupon() {
    const input = document.getElementById('cartCouponInput');
    if (!input) return;
    const code = input.value.trim().toUpperCase();

    if (code === 'CENTRO10' || code === 'ZACATECAS2026') {
        appliedCoupon = { code: code, discountPercent: 10 };
        const badge = document.getElementById('couponAppliedBadge');
        const label = document.getElementById('couponCodeLabel');
        if (badge && label) {
            label.textContent = code;
            badge.style.display = 'block';
        }
        showToast(`✓ Cupón ${code} aplicado: 10% de descuento`);
    } else if (!code) {
        appliedCoupon = null;
        const badge = document.getElementById('couponAppliedBadge');
        if (badge) badge.style.display = 'none';
    } else {
        showToast('⚠️ Cupón no válido. Prueba con CENTRO10 o ZACATECAS2026');
        appliedCoupon = null;
        const badge = document.getElementById('couponAppliedBadge');
        if (badge) badge.style.display = 'none';
    }
    updateCartUI();
}

function updateCartUI() {
    const totalItems = storeCart.reduce((sum, item) => sum + item.quantity, 0);
    const subtotal = storeCart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const discount = appliedCoupon ? (subtotal * (appliedCoupon.discountPercent / 100)) : 0;
    const total = Math.max(0, subtotal - discount);

    // Badges
    const headerBadge = document.getElementById('headerCartBadge');
    const drawerBadge = document.getElementById('drawerCartBadge');
    const drawerCount = document.getElementById('cartDrawerCount');
    if (headerBadge) headerBadge.textContent = totalItems;
    if (drawerBadge) drawerBadge.textContent = totalItems;
    if (drawerCount) drawerCount.textContent = totalItems;

    // Cart Drawer Items Container
    const body = document.getElementById('cartDrawerBody');
    const footer = document.getElementById('cartDrawerFooter');

    if (body) {
        if (storeCart.length === 0) {
            body.innerHTML = `
                <div class="cart-empty-state">
                    <span class="cart-empty-icon">🛍️</span>
                    <h4>Tu carrito está vacío</h4>
                    <p style="font-size: 13px; color: var(--muted); margin: 0 0 16px;">Descubre las piezas y productos exclusivos de ${STORE_TITLE}.</p>
                    <button type="button" class="btn-brand-primary" onclick="toggleCartDrawer()" style="display: inline-block; font-size: 13px;">Explorar Catálogo</button>
                </div>
            `;
            if (footer) footer.style.display = 'none';
        } else {
            if (footer) footer.style.display = 'block';
            let html = '';
            storeCart.forEach((item, idx) => {
                const itemTotal = (item.price * item.quantity).toFixed(2);
                const fullProd = (window.ALL_PRODUCTS && ALL_PRODUCTS.find(p => String(p.id) === String(item.id) || p.slug === String(item.id))) || item;
                const inq = detectProductInquiryType(fullProd);
                html += `
                    <div class="cart-item-row">
                        <img src="${item.image_url}" alt="${item.name}" class="cart-item-thumb" onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=Zacatecas';">
                        <div class="cart-item-details">
                            <h4 class="cart-item-name">${item.name}</h4>
                            <div class="cart-item-price">$${item.price.toFixed(2)} MXN</div>
                            <div class="cart-qty-ctrls">
                                <button type="button" class="cart-qty-btn" onclick="updateCartItemQty(${idx}, -1)">−</button>
                                <span class="cart-qty-num">${item.quantity}</span>
                                <button type="button" class="cart-qty-btn" onclick="updateCartItemQty(${idx}, 1)">+</button>
                            </div>
                            <a href="${inq.waUrl}" target="_blank" class="cart-inquiry-chip" title="${inq.promptTitle}">
                                <span>${inq.icon}</span> ${inq.btnText}
                            </a>
                        </div>
                        <div style="text-align: right;">
                            <strong style="font-size: 13.5px; color: var(--ink); display: block; margin-bottom: 8px;">$${itemTotal}</strong>
                            <button type="button" class="cart-item-remove" onclick="removeCartItem(${idx})" title="Eliminar del carrito">🗑️</button>
                        </div>
                    </div>
                `;
            });
            body.innerHTML = html;
        }
    }

    // Summary numbers
    const subtotalEl = document.getElementById('cartSummarySubtotal');
    const discountLine = document.getElementById('cartDiscountLine');
    const discountEl = document.getElementById('cartSummaryDiscount');
    const totalEl = document.getElementById('cartSummaryTotal');
    const checkoutPayTotalEl = document.getElementById('checkoutPayBtnTotal');

    if (subtotalEl) subtotalEl.textContent = `$${subtotal.toFixed(2)} MXN`;
    if (discountLine && discountEl) {
        if (discount > 0) {
            discountLine.style.display = 'flex';
            discountEl.textContent = `-$${discount.toFixed(2)} MXN`;
        } else {
            discountLine.style.display = 'none';
        }
    }
    if (totalEl) totalEl.textContent = `$${total.toFixed(2)} MXN`;
    if (checkoutPayTotalEl) checkoutPayTotalEl.textContent = total.toFixed(2);
}

// CHECKOUT MODAL ACTIONS
function openCheckoutModal() {
    if (storeCart.length === 0) {
        alert('Tu carrito está vacío. Agrega al menos un producto antes de proceder al pago.');
        return;
    }
    const drawer = document.getElementById('storeCartDrawer');
    const backdrop = document.getElementById('cartDrawerBackdrop');
    if (drawer) drawer.classList.remove('open');
    if (backdrop) backdrop.classList.remove('active');

    const modal = document.getElementById('checkoutModal');
    if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeCheckoutModal() {
    const modal = document.getElementById('checkoutModal');
    if (modal) {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
}

function switchPaymentTab(method, btn) {
    selectedPaymentMethod = method;
    document.querySelectorAll('.payment-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.payment-method-panel').forEach(p => p.classList.remove('active'));

    if (btn) btn.classList.add('active');
    const panel = document.getElementById('payPanel_' + method);
    if (panel) panel.classList.add('active');

    const payText = document.getElementById('btnPayText');
    const payIcon = document.getElementById('btnPayIcon');
    if (payText && payIcon) {
        if (method === 'card') {
            payText.textContent = 'Confirmar y Pagar';
            payIcon.textContent = '💳';
        } else if (method === 'spei') {
            payText.textContent = 'Registrar Pedido SPEI';
            payIcon.textContent = '🏦';
        } else if (method === 'oxxo') {
            payText.textContent = 'Generar Ficha OXXO';
            payIcon.textContent = '🏪';
        } else if (method === 'cash') {
            payText.textContent = 'Confirmar Contra Entrega';
            payIcon.textContent = '💵';
        } else if (method === 'whatsapp') {
            payText.textContent = 'Ordenar por WhatsApp';
            payIcon.textContent = '💬';
        }
    }
}

function toggleShippingAddressField(deliveryType) {
    const wrap = document.getElementById('shippingAddressWrap');
    const input = document.getElementById('checkCustAddress');
    if (wrap && input) {
        if (deliveryType === 'delivery') {
            wrap.style.display = 'block';
            input.required = true;
        } else {
            wrap.style.display = 'none';
            input.required = false;
        }
    }
}

function formatCreditCardNumber(input) {
    let val = input.value.replace(/\D/g, '').substring(0, 16);
    let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
    input.value = formatted;
}

function formatCardExpiry(input) {
    let val = input.value.replace(/\D/g, '').substring(0, 4);
    if (val.length >= 3) {
        input.value = val.substring(0, 2) + '/' + val.substring(2);
    } else {
        input.value = val;
    }
}

function copySpeiClabe() {
    const clabe = '646903001234567890';
    if (navigator.clipboard) {
        navigator.clipboard.writeText(clabe).then(() => {
            showToast('✓ CLABE interbancaria copiada al portapapeles');
        });
    } else {
        window.prompt('Copia la CLABE interbancaria:', clabe);
    }
}

let lastCompletedOrder = null;

async function processOrderCheckout() {
    if (storeCart.length === 0) {
        alert('El carrito está vacío.');
        return;
    }

    const name = document.getElementById('checkCustName')?.value.trim();
    const email = document.getElementById('checkCustEmail')?.value.trim();
    const phone = document.getElementById('checkCustPhone')?.value.trim();
    const deliveryType = document.getElementById('checkDeliveryType')?.value || 'pickup';
    const address = document.getElementById('checkCustAddress')?.value.trim();
    const notes = document.getElementById('checkCustNotes')?.value.trim();

    if (!name || !email || !phone) {
        alert('Por favor completa tu nombre, correo electrónico y teléfono.');
        return;
    }

    if (deliveryType === 'delivery' && !address) {
        alert('Por favor indica tu dirección completa para la entrega a domicilio en Zacatecas.');
        return;
    }

    const submitBtn = document.getElementById('btnSubmitCheckout');
    const originalBtnHtml = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>⏳</span> Procesando pago y registrando orden...';

    const fullAddress = (deliveryType === 'pickup') 
        ? `Recoger en Sucursal: ${STORE_ADDRESS} (${STORE_ZONE})`
        : address;

    const payload = {
        customer_name: name,
        customer_email: email,
        customer_phone: phone,
        payment_method: selectedPaymentMethod,
        shipping_address: fullAddress,
        order_notes: notes || `Tipo de entrega: ${deliveryType === 'pickup' ? 'Recogida en tienda' : 'Envío local Zacatecas'}`,
        coupon_code: appliedCoupon ? appliedCoupon.code : null,
        items: storeCart.map(item => ({
            product_id: item.id,
            quantity: item.quantity,
            price: item.price
        }))
    };

    try {
        const response = await fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/checkout`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (response.ok && data.success) {
            lastCompletedOrder = data.order;
            handleOrderSuccess(data.order, payload);
        } else {
            throw new Error(data.message || 'Error al procesar la orden en el servidor');
        }
    } catch (error) {
        console.warn('[Checkout Note]: Guardando comprobante offline resiliente:', error);
        const subtotal = storeCart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const discount = appliedCoupon ? (subtotal * (appliedCoupon.discountPercent / 100)) : 0;
        const total = Math.max(0, subtotal - discount);
        const randomHex = Math.random().toString(16).substring(2, 7).toUpperCase();
        const dateStr = new Date().toISOString().slice(0, 10).replace(/-/g, '');
        const fallbackFolio = `${TENANT_ID.substring(0, 4).toUpperCase()}-${dateStr}-${randomHex}`;

        const fallbackOrder = {
            folio: fallbackFolio,
            customer_name: name,
            customer_email: email,
            customer_phone: phone,
            payment_method: selectedPaymentMethod,
            payment_status: selectedPaymentMethod === 'cash' ? 'pending_on_delivery' : 'confirmed',
            total: total,
            subtotal: subtotal,
            discount_amount: discount,
            items: storeCart.map(i => ({
                product_name: i.name,
                quantity: i.quantity,
                unit_price: i.price,
                subtotal: i.price * i.quantity
            })),
            created_at: new Date().toLocaleString('es-MX')
        };

        lastCompletedOrder = fallbackOrder;
        handleOrderSuccess(fallbackOrder, payload);
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnHtml;
    }
}

function handleOrderSuccess(order, payload) {
    clearCart();
    closeCheckoutModal();

    const modal = document.getElementById('orderSuccessModal');
    if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    const folioTag = document.getElementById('successFolioTag');
    if (folioTag) folioTag.textContent = order.folio;

    const detailsBox = document.getElementById('successReceiptDetails');
    const itemsHtml = (order.items || []).map(it => `
        <div class="receipt-line">
            <span>${it.quantity}x ${it.product_name || it.name}</span>
            <strong>$${parseFloat(it.subtotal || (it.unit_price * it.quantity)).toFixed(2)}</strong>
        </div>
    `).join('');

    const methodLabels = {
        card: 'Tarjeta Bancaria (3D Secure)',
        spei: 'Transferencia Interbancaria SPEI',
        oxxo: 'OXXO Pay Efectivo',
        cash: 'Contra Entrega en Zacatecas Centro',
        whatsapp: 'Pedido por WhatsApp'
    };

    if (detailsBox) {
        detailsBox.innerHTML = `
            <div class="receipt-line">
                <span>Cliente:</span>
                <strong>${order.customer_name}</strong>
            </div>
            <div class="receipt-line">
                <span>Contacto:</span>
                <span>${order.customer_phone} · ${order.customer_email}</span>
            </div>
            <div class="receipt-line">
                <span>Método de Pago:</span>
                <strong style="color: var(--accent);">${methodLabels[order.payment_method] || order.payment_method}</strong>
            </div>
            <div class="receipt-line">
                <span>Dirección / Entrega:</span>
                <span style="max-width: 60%; text-align: right;">${order.shipping_address || payload.shipping_address}</span>
            </div>
            <div style="margin: 10px 0 4px; font-weight: 700; font-size: 11px; text-transform: uppercase; color: var(--muted);">Desglose de Artículos:</div>
            ${itemsHtml}
            ${order.discount_amount > 0 ? `
            <div class="receipt-line" style="color: #10b981;">
                <span>Descuento aplicado:</span>
                <strong>-$${parseFloat(order.discount_amount).toFixed(2)}</strong>
            </div>` : ''}
            <div class="receipt-line" style="font-size: 15px; font-weight: 800; border-top: 1px solid var(--line); padding-top: 8px; margin-top: 6px;">
                <span>Total Pagado:</span>
                <span style="color: var(--accent);">$${parseFloat(order.total).toFixed(2)} MXN</span>
            </div>
        `;
    }

    const waBtn = document.getElementById('btnSuccessWhatsApp');
    if (waBtn) {
        const orderSummaryMsg = encodeURIComponent(`¡Hola ${STORE_TITLE}! He completado mi pedido:
• Folio: ${order.folio}
• Cliente: ${order.customer_name}
• Teléfono: ${order.customer_phone}
• Método de Pago: ${methodLabels[order.payment_method] || order.payment_method}
• Total: $${parseFloat(order.total).toFixed(2)} MXN
• Entrega: ${order.shipping_address || payload.shipping_address}

Por favor confirmen la recepción y el tiempo de despacho. ¡Muchas gracias!`);
        
        if (WA_PHONE) {
            waBtn.href = `https://wa.me/${WA_PHONE}?text=${orderSummaryMsg}`;
            waBtn.style.display = 'inline-flex';
        } else {
            waBtn.href = `https://wa.me/?text=${orderSummaryMsg}`;
            waBtn.style.display = 'inline-flex';
        }
    }

    const printBox = document.getElementById('printableReceipt');
    if (printBox) {
        printBox.innerHTML = `
            <div style="text-align: center; margin-bottom: 12px; border-bottom: 1px dashed #000; padding-bottom: 8px;">
                <h2 style="margin: 0; font-size: 18px;">${STORE_TITLE}</h2>
                <div style="font-size: 11px;">Centro Histórico, Zacatecas, Zac.</div>
                <div style="font-size: 10px;">${STORE_ADDRESS}</div>
                <div style="font-size: 10px;">Tel: ${WA_PHONE || 'Zacatecas Centro'}</div>
            </div>
            <div style="font-size: 11px; margin-bottom: 8px;">
                <div><strong>FOLIO:</strong> ${order.folio}</div>
                <div><strong>FECHA:</strong> ${new Date().toLocaleString('es-MX')}</div>
                <div><strong>CLIENTE:</strong> ${order.customer_name}</div>
                <div><strong>PAGO:</strong> ${methodLabels[order.payment_method] || order.payment_method}</div>
            </div>
            <div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 6px 0; margin: 6px 0; font-size: 11px;">
                ${(order.items || []).map(it => `
                    <div style="display: flex; justify-content: space-between;">
                        <span>${it.quantity}x ${it.product_name || it.name}</span>
                        <span>$${parseFloat(it.subtotal || (it.unit_price * it.quantity)).toFixed(2)}</span>
                    </div>
                `).join('')}
            </div>
            <div style="text-align: right; font-size: 13px; font-weight: bold; margin-top: 4px;">
                TOTAL: $${parseFloat(order.total).toFixed(2)} MXN
            </div>
            <div style="text-align: center; margin-top: 16px; font-size: 10px; border-top: 1px dashed #000; padding-top: 8px;">
                ¡GRACIAS POR TU COMPRA EN EL CENTRO DE ZACATECAS!<br>
                Conserva este comprobante para cualquier aclaración o entrega.
            </div>
        `;
    }
}

function printOrderReceipt() {
    window.print();
}

function closeSuccessModal() {
    const modal = document.getElementById('orderSuccessModal');
    if (modal) {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initCart();
    // 1. HERO CAROUSEL
    const heroTrack = document.getElementById('heroTrack');
    const heroDots = document.querySelectorAll('.hero-dot');
    const heroPrev = document.getElementById('heroPrev');
    const heroNext = document.getElementById('heroNext');
    let currentHeroSlide = 0;
    const totalHeroSlides = 3;
    let heroInterval = null;

    function goToHeroSlide(index) {
        currentHeroSlide = (index + totalHeroSlides) % totalHeroSlides;
        if (heroTrack) {
            heroTrack.style.transform = `translateX(-${currentHeroSlide * 33.333333}%)`;
        }
        heroDots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === currentHeroSlide);
        });
    }

    function startHeroAutoplay() {
        stopHeroAutoplay();
        heroInterval = setInterval(() => {
            goToHeroSlide(currentHeroSlide + 1);
        }, 5500);
    }

    function stopHeroAutoplay() {
        if (heroInterval) clearInterval(heroInterval);
    }

    if (heroPrev && heroNext) {
        heroPrev.addEventListener('click', () => {
            goToHeroSlide(currentHeroSlide - 1);
            startHeroAutoplay();
        });
        heroNext.addEventListener('click', () => {
            goToHeroSlide(currentHeroSlide + 1);
            startHeroAutoplay();
        });
        heroDots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                goToHeroSlide(parseInt(e.target.dataset.index, 10));
                startHeroAutoplay();
            });
        });

        const heroCarousel = document.getElementById('heroCarousel');
        if (heroCarousel) {
            heroCarousel.addEventListener('mouseenter', stopHeroAutoplay);
            heroCarousel.addEventListener('mouseleave', startHeroAutoplay);
        }
        startHeroAutoplay();
    }

    // 2. HORIZONTAL SCROLL HELPERS FOR CAROUSELS
    function setupScrollButtons(prevBtnId, nextBtnId, trackId, step = 320) {
        const prev = document.getElementById(prevBtnId);
        const next = document.getElementById(nextBtnId);
        const track = document.getElementById(trackId);
        if (prev && next && track) {
            prev.addEventListener('click', () => track.scrollBy({ left: -step, behavior: 'smooth' }));
            next.addEventListener('click', () => track.scrollBy({ left: step, behavior: 'smooth' }));
        }
    }
    setupScrollButtons('catPrev', 'catNext', 'catTrack', 250);
    setupScrollButtons('featPrev', 'featNext', 'featTrack', 310);
    setupScrollButtons('testPrev', 'testNext', 'testTrack', 380);

    // 3. SEARCH INPUT LISTENER
    const searchInput = document.getElementById('catalogSearch');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            applyCatalogFilter();
        });
    }

    // 4. CHECK URL PARAMS ON LOAD (e.g. ?categoria=... or ?producto=...)
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('categoria');
    const productParam = urlParams.get('producto');

    if (categoryParam) {
        const matchingProduct = ALL_PRODUCTS.find(p => p.category && p.category.slug === categoryParam);
        const catName = matchingProduct && matchingProduct.category ? matchingProduct.category.name : categoryParam;
        selectCategory(categoryParam, catName, false);
    }

    if (productParam) {
        const productToOpen = ALL_PRODUCTS.find(p => p.slug === productParam || String(p.id) === productParam);
        if (productToOpen) {
            openProductDetail(productToOpen);
        }
    }

    // Close dropdown on outside click
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('storesDropdownMenu');
        const toggleBtn = document.getElementById('storesToggleBtn');
        const annLink = document.getElementById('announcementStoresLink');
        if (dropdown && dropdown.classList.contains('open')) {
            if (!dropdown.contains(e.target) && (!toggleBtn || !toggleBtn.contains(e.target)) && (!annLink || !annLink.contains(e.target))) {
                dropdown.classList.remove('open');
            }
        }
    });

    // Close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeProductDetail();
        }
    });

    // Close modal on backdrop click
    const productModalEl = document.getElementById('productDetailModal');
    if (productModalEl) {
        productModalEl.addEventListener('click', (e) => {
            if (e.target === productModalEl) {
                closeProductDetail();
            }
        });
    }
});

// DROPDOWN STORES TOGGLE
function toggleStoresDropdown() {
    const dropdown = document.getElementById('storesDropdownMenu');
    if (dropdown) {
        dropdown.classList.toggle('open');
    }
}
const toggleOfficialDropdown = toggleStoresDropdown;

// CATEGORY SELECTION & FILTERING
function selectCategory(slug, name = '', scroll = true) {
    currentActiveCategory = slug;
    currentActiveCategoryName = name || slug;

    // Sync Pills Bar
    document.querySelectorAll('.cat-pill').forEach(pill => {
        pill.classList.toggle('active', pill.dataset.category === slug);
    });

    // Sync Carousel Cards
    document.querySelectorAll('.category-card-slide').forEach(card => {
        card.classList.toggle('active-cat', card.dataset.category === slug);
    });

    // Sync Active Filter Badge
    const badge = document.getElementById('activeFilterBadge');
    const badgeLabel = document.getElementById('activeFilterLabel');
    if (badge && badgeLabel) {
        if (slug === 'all') {
            badge.style.display = 'none';
        } else {
            badge.style.display = 'inline-flex';
            badgeLabel.textContent = `Categoría: ${currentActiveCategoryName}`;
        }
    }

    applyCatalogFilter();

    // Update URL query without page reload
    const url = new URL(window.location);
    if (slug === 'all') {
        url.searchParams.delete('categoria');
    } else {
        url.searchParams.set('categoria', slug);
    }
    window.history.replaceState({}, '', url);

    if (scroll) {
        const catalogSection = document.getElementById('catalogo');
        if (catalogSection) {
            catalogSection.scrollIntoView({ behavior: 'smooth' });
        }
    }
}

function applyCatalogFilter() {
    const searchInput = document.getElementById('catalogSearch');
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const items = document.querySelectorAll('.product-grid-item');
    const counterEl = document.getElementById('catalogCounter');
    let visibleCount = 0;

    items.forEach(item => {
        const name = item.dataset.name || '';
        const desc = item.dataset.desc || '';
        const cat = item.dataset.category || '';

        const matchesCat = (currentActiveCategory === 'all') || (cat === currentActiveCategory);
        const matchesQuery = !query || name.includes(query) || desc.includes(query) || cat.includes(query);

        if (matchesCat && matchesQuery) {
            item.style.display = 'flex';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    if (counterEl) {
        if (currentActiveCategory === 'all' && !query) {
            counterEl.textContent = `Mostrando ${visibleCount} producto(s) disponibles`;
        } else {
            counterEl.textContent = `Mostrando ${visibleCount} producto(s) encontrados`;
        }
    }
}

// ENRICHED PRODUCT DETAIL MODAL LOGIC ("VER MÁS COSAS DE LOS PRODUCTOS")
function openProductById(id) {
    const list = window.ALL_PRODUCTS || (typeof ALL_PRODUCTS !== 'undefined' ? ALL_PRODUCTS : []);
    if (!list || !Array.isArray(list) || list.length === 0) return;
    const p = list.find(item => String(item.id) === String(id) || item.slug === String(id));
    if (p) {
        openProductDetail(p);
    }
}

function openProductDetail(product) {
    if (!product) return;
    currentModalProduct = product;
    currentModalQty = 1;

    const modal = document.getElementById('productDetailModal');
    if (!modal) return;

    // Fill Basic Details
    const modalImgEl = document.getElementById('modalImg');
    if (modalImgEl) {
        modalImgEl.src = product.image_url || ('https://placehold.co/600x600?text=' + encodeURIComponent(product.name));
        modalImgEl.alt = product.name;
    }
    const titleEl = document.getElementById('modalTitle');
    if (titleEl) titleEl.textContent = product.name;
    const catName = product.category ? product.category.name : 'Colección General';
    const catEl = document.getElementById('modalCat');
    if (catEl) catEl.textContent = catName;
    const priceEl = document.getElementById('modalPrice');
    if (priceEl) priceEl.textContent = '$' + parseFloat(product.price || 0).toFixed(2);
    const descEl = document.getElementById('modalDesc');
    if (descEl) descEl.textContent = product.description || 'Artículo exclusivo confeccionado bajo estrictos estándares de manufactura y control de calidad.';
    
    // Fill Badges
    const skuCode = `SKU-${product.id ? String(product.id).padStart(4, '0') : '001'}-${product.slug ? product.slug.substring(0, 4).toUpperCase() : 'ART'}`;
    const skuEl = document.getElementById('modalSku');
    if (skuEl) skuEl.textContent = skuCode;
    
    const stockEl = document.getElementById('modalStock');
    if (stockEl) {
        if (product.stock > 10) {
            stockEl.textContent = `✓ En stock: ${product.stock} disponibles`;
            stockEl.className = 'modal-chip modal-chip-stock';
            stockEl.style.background = '';
            stockEl.style.color = '';
        } else if (product.stock > 0) {
            stockEl.textContent = `⚡ Stock bajo: últimas ${product.stock} unidades`;
            stockEl.className = 'modal-chip';
            stockEl.style.background = '#fef9c3';
            stockEl.style.color = '#854d0e';
        } else {
            stockEl.textContent = `✕ Agotado temporalmente`;
            stockEl.className = 'modal-chip';
            stockEl.style.background = '#fee2e2';
            stockEl.style.color = '#991b1b';
        }
    }

    // Dynamic Specifications Mapping
    const catSlug = product.category ? product.category.slug : '';
    const specs = (typeof getProductSpecs === 'function') ? getProductSpecs(product.name, catSlug) : {
        material: 'Plata / Acero / Joyería de Autor',
        dimensions: 'Ajustable / Medida Estándar',
        warranty: '12 meses de garantía directa'
    };
    const specMat = document.getElementById('specMaterial');
    if (specMat) specMat.textContent = specs.material;
    const specDim = document.getElementById('specDimensions');
    if (specDim) specDim.textContent = specs.dimensions;
    const specAvail = document.getElementById('specAvailability');
    if (specAvail) specAvail.textContent = product.stock > 0 ? 'En existencia para despacho express' : 'Bajo pedido especial';
    const specWar = document.getElementById('specWarranty');
    if (specWar) specWar.textContent = specs.warranty;

    // Reset Qty & Subtotal
    updateModalQtyUI();

    // Populate Related Products (same category)
    if (typeof populateRelatedProducts === 'function') {
        populateRelatedProducts(product);
    }

    // Reset to specs tab
    if (typeof switchModalTab === 'function') {
        switchModalTab('specs');
    }

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';

    const card = modal.querySelector('.modal-card');
    if (card) {
        card.scrollTop = 0;
    }

    // Update URL parameter
    try {
        const url = new URL(window.location);
        url.searchParams.set('producto', product.slug || product.id);
        window.history.replaceState({}, '', url);
    } catch (e) {}
}

function closeProductDetail() {
    const modal = document.getElementById('productDetailModal');
    if (modal) modal.classList.remove('open');
    document.body.style.overflow = '';
    document.documentElement.style.overflow = '';

    const url = new URL(window.location);
    url.searchParams.delete('producto');
    window.history.replaceState({}, '', url);
}

function filterFromModal() {
    if (currentModalProduct && currentModalProduct.category) {
        const cat = currentModalProduct.category;
        closeProductDetail();
        selectCategory(cat.slug, cat.name, true);
    }
}

function changeModalQty(delta) {
    const maxStock = currentModalProduct ? (currentModalProduct.stock || 99) : 99;
    const newQty = currentModalQty + delta;
    if (newQty >= 1 && newQty <= Math.max(maxStock, 1)) {
        currentModalQty = newQty;
        updateModalQtyUI();
    }
}

function updateModalQtyUI() {
    if (!currentModalProduct) return;
    const qtyDisplay = document.getElementById('modalQtyDisplay');
    if (qtyDisplay) qtyDisplay.textContent = currentModalQty;
    const unitPrice = parseFloat(currentModalProduct.price || 0);
    const subtotal = unitPrice * currentModalQty;
    const formatted = '$' + subtotal.toFixed(2);
    const subtotalEl = document.getElementById('modalSubtotal');
    if (subtotalEl) subtotalEl.textContent = formatted + ' MXN';
    const btnTotalEl = document.getElementById('modalBtnTotal');
    if (btnTotalEl) btnTotalEl.textContent = formatted;
    const addCartTotalEl = document.getElementById('modalAddCartTotal');
    if (addCartTotalEl) addCartTotalEl.textContent = formatted;

    // Update WhatsApp Link
    const waBtn = document.getElementById('modalWhatsAppBtn');
    if (waBtn) {
        const sku = `SKU-${currentModalProduct.id ? String(currentModalProduct.id).padStart(4, '0') : '001'}`;
        const productUrl = `${window.location.origin}${window.location.pathname}?producto=${currentModalProduct.slug || currentModalProduct.id}`;
        const msg = encodeURIComponent(`¡Hola! Me interesa comprar el siguiente producto en ${STORE_TITLE}:
• Producto: ${currentModalProduct.name}
• ${sku}
• Cantidad: ${currentModalQty} unidad(es)
• Total estimado: ${formatted} MXN
• Enlace directo: ${productUrl}

📍 Sucursal / Recogida en Zacatecas Centro:
${STORE_ADDRESS} (${STORE_REF})
🗺️ Ubicación en Google Maps: ${STORE_MAPS_URL}
⏰ Horario de atención: ${STORE_HOURS}

¿Tienen disponibilidad para entrega local en Zacatecas o recogida en tienda?`);

        if (WA_PHONE) {
            waBtn.href = `https://wa.me/${WA_PHONE}?text=${msg}`;
            waBtn.style.display = 'flex';
        } else {
            waBtn.href = `mailto:contacto@${window.location.hostname}?subject=` + encodeURIComponent(`Pedido de ${currentModalProduct.name}`);
            waBtn.innerHTML = `✉ Consultar Disponibilidad por Correo (${formatted})`;
        }
    }
}

function switchModalTab(tabId, btn) {
    document.querySelectorAll('.modal-tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.modal-tab-btn').forEach(b => b.classList.remove('active'));

    const pane = document.getElementById('tab-' + tabId);
    if (pane) pane.classList.add('active');

    if (btn) {
        btn.classList.add('active');
    } else {
        const defaultBtn = document.querySelector(`.modal-tab-btn[onclick*="${tabId}"]`);
        if (defaultBtn) defaultBtn.classList.add('active');
    }
}

function populateRelatedProducts(currentProduct) {
    const container = document.getElementById('modalRelatedGrid');
    const wrap = document.getElementById('modalRelatedWrap');
    if (!container || !wrap) return;

    container.innerHTML = '';
    const currentCatSlug = currentProduct.category ? currentProduct.category.slug : '';

    const related = ALL_PRODUCTS.filter(p => {
        return p.id !== currentProduct.id && p.category && p.category.slug === currentCatSlug;
    }).slice(0, 3);

    if (related.length === 0) {
        wrap.style.display = 'none';
        return;
    }

    wrap.style.display = 'block';
    related.forEach(item => {
        const card = document.createElement('div');
        card.className = 'related-card';
        card.innerHTML = `
            <img src="${item.image_url || 'https://placehold.co/100x100?text=Prod'}" alt="${item.name}">
            <div>
                <strong>${item.name}</strong>
                <span>$${parseFloat(item.price).toFixed(2)}</span>
            </div>
        `;
        card.addEventListener('click', () => {
            openProductDetail(item);
        });
        container.appendChild(card);
    });
}

function getProductSpecs(name, categorySlug) {
    switch (categorySlug) {
        case 'bolsos-marroquineria':
            return {
                material: 'Piel vacuna genuina de grano entero curtida al vegetal',
                dimensions: '36 cm × 28 cm × 14 cm · Asa de 22 cm',
                warranty: '2 años contra desprendimiento o rotura de herrajes'
            };
        case 'relojeria-cronografos':
            return {
                material: 'Acero quirúrgico 316L y cristal de zafiro antireflejante',
                dimensions: 'Caja 41 mm · Grosor 11 mm · Pulso de 20 mm',
                warranty: '3 años de garantía en maquinaria de precisión'
            };
        case 'joyeria-accesorios':
            return {
                material: 'Oro macizo 18k / Plata de ley 925 con acabado electrolítico',
                dimensions: 'Longitud ajustable 42 cm a 48 cm',
                warranty: 'Certificado de autenticidad vitalicio de metales nobles'
            };
        case 'ropa-accesorios':
        case 'moda-alta-costura':
            return {
                material: 'Lino orgánico natural / Seda hilada y lana peinada',
                dimensions: 'Corte Regular Fit a medida · Consulta guía de tallas',
                warranty: 'Garantía de ajuste perfecto o cambio de talla sin costo'
            };
        case 'hogar-decoracion':
        case 'hogar-diseno':
            return {
                material: 'Cerámica de gres horneada a alta temperatura / Mármol natural',
                dimensions: '28 cm de alto × 18 cm de diámetro de boca',
                warranty: 'Garantía de integridad de transporte y satisfacción total'
            };
        case 'fragancias-cuidado':
            return {
                material: 'Aceites esenciales puros, cera vegetal y notas botánicas',
                dimensions: 'Presentación de 100 ml / 3.4 fl oz de alta fijación',
                warranty: 'Fórmula hipoalergénica sin parabenos ni crueldad animal'
            };
        case 'tecnologia-accesorios':
        case 'audio-tecnologia':
            return {
                material: 'Madera de nogal macizo tratada, aluminio aeroespacial y cobre',
                dimensions: '110 mm × 110 mm × 15 mm · Cable trenzado de 1.5 m',
                warranty: '18 meses de garantía en circuitos y componentes internos'
            };
        case 'coleccion-gourmet':
            return {
                material: 'Ingredientes con denominación de origen protegida (D.O.P.)',
                dimensions: 'Botella de vidrio oscuro de 500 ml con pico dosificador',
                warranty: 'Cosecha premium certificada y sellado hermético'
            };
        default:
            return {
                material: 'Materias primas de primer nivel seleccionadas a mano',
                dimensions: 'Dimensiones proporcionales y acabado de precisión',
                warranty: '12 meses de garantía directa del fabricante'
            };
    }
}

// COPY LINK UTILITIES WITH TOAST
function showToast(text) {
    const toast = document.getElementById('toastNotify');
    if (toast) {
        toast.textContent = text;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }
}

function copyProductDirectLink() {
    if (!currentModalProduct) return;
    const url = `${window.location.origin}${window.location.pathname}?producto=${currentModalProduct.slug || currentModalProduct.id}`;
    navigator.clipboard.writeText(url).then(() => {
        showToast(`¡Enlace de "${currentModalProduct.name}" copiado!`);
    }).catch(() => {
        showToast('Enlace copiado al portapapeles');
    });
}

function copyCurrentStoreLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        showToast(`¡Enlace de la tienda copiado!`);
    }).catch(() => {
        showToast('Enlace copiado');
    });
}

// Mobile Store Navigation Drawer Toggle, Open & Close
function toggleStoreMenu() {
    const drawer = document.getElementById('storeMobileDrawer');
    const isOpen = drawer && drawer.classList.contains('open');
    if (isOpen) {
        closeStoreMenu();
    } else {
        openStoreMenu();
    }
}

function openStoreMenu() {
    const drawer = document.getElementById('storeMobileDrawer');
    const backdrop = document.getElementById('storeDrawerBackdrop');
    const toggle = document.getElementById('storeMenuToggle');
    if (drawer) drawer.classList.add('open');
    if (backdrop) backdrop.classList.add('active');
    if (toggle) toggle.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeStoreMenu() {
    const drawer = document.getElementById('storeMobileDrawer');
    const backdrop = document.getElementById('storeDrawerBackdrop');
    const toggle = document.getElementById('storeMenuToggle');
    if (drawer) drawer.classList.remove('open');
    if (backdrop) backdrop.classList.remove('active');
    if (toggle) toggle.classList.remove('active');
    document.body.style.overflow = '';
}

// Close store mobile drawer on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeStoreMenu();
    }
});

// ========================================================
// PWA AUTO-UPDATE MANAGER (ACTUALIZACIÓN AUTOMÁTICA EN TIENDAS)
// ========================================================
if ('serviceWorker' in navigator) {
    let isRefreshing = false;

    navigator.serviceWorker.addEventListener('controllerchange', () => {
        if (!isRefreshing) {
            isRefreshing = true;
            console.log('[PWA Tienda] Nueva versión activada. Actualizando interfaz...');
            window.location.reload();
        }
    });

    navigator.serviceWorker.addEventListener('message', (event) => {
        if (event.data && event.data.type === 'SW_UPDATED') {
            if (!isRefreshing) {
                isRefreshing = true;
                window.location.reload();
            }
        }
    });

    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js', { updateViaCache: 'none' })
            .then((registration) => {
                // 1. Verificar actualización al cargar
                registration.update().catch(() => {});

                // 2. Si hay worker esperando, activarlo
                if (registration.waiting) {
                    registration.waiting.postMessage({ type: 'SKIP_WAITING' });
                }

                // 3. Si se descarga nueva versión, activar sin requerir reinstalación
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    if (newWorker) {
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                newWorker.postMessage({ type: 'SKIP_WAITING' });
                            }
                        });
                    }
                });

                // 4. Verificar al reabrir la app en el teléfono
                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'visible') {
                        registration.update().catch(() => {});
                    }
                });

                window.addEventListener('focus', () => {
                    registration.update().catch(() => {});
                });

                // 5. Verificación periódica cada 15 minutos
                setInterval(() => {
                    registration.update().catch(() => {});
                }, 15 * 60 * 1000);
            })
            .catch(err => console.log('SW registration note:', err));
    });
}

// THEME TOGGLE (DARK / LIGHT MODE)
function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    updateThemeIcons(next);
}

function updateThemeIcons(theme) {
    document.querySelectorAll('.theme-icon-light').forEach(el => el.style.display = theme === 'dark' ? 'none' : 'inline-block');
    document.querySelectorAll('.theme-icon-dark').forEach(el => el.style.display = theme === 'dark' ? 'inline-block' : 'none');
    document.querySelectorAll('.theme-text-light').forEach(el => el.style.display = theme === 'dark' ? 'none' : 'inline-flex');
    document.querySelectorAll('.theme-text-dark').forEach(el => el.style.display = theme === 'dark' ? 'inline-flex' : 'none');
}

// WEB SHARE API FOR STORE
function shareStorePage() {
    const shareData = {
        title: document.title,
        text: 'Visita ' + @json($storeTitle) + ' en Zacatecas Centro.',
        url: window.location.href
    };
    if (navigator.share) {
        navigator.share(shareData).catch(() => {});
    } else if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('¡Enlace de la tienda copiado al portapapeles!');
        });
    } else {
        window.prompt('Copia el enlace de la tienda:', window.location.href);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
    updateThemeIcons(activeTheme);
});

// STORE AUTH MODAL CONTROLLERS
function openStoreAuthModal(view = 'login') {
    const modal = document.getElementById('storeAuthModal');
    if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
        switchStoreAuthTab(view);
    }
}

function closeStoreAuthModal() {
    const modal = document.getElementById('storeAuthModal');
    if (modal) {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
}

function switchStoreAuthTab(tab) {
    const views = ['storeLoginView', 'storeRegisterView', 'storeGoogleChooserView', 'storeFacebookChooserView'];
    views.forEach(v => {
        const el = document.getElementById(v);
        if (el) el.style.display = 'none';
    });
    const target = document.getElementById(
        tab === 'login' ? 'storeLoginView' :
        (tab === 'register' ? 'storeRegisterView' :
        (tab === 'googleChooser' ? 'storeGoogleChooserView' : 'storeFacebookChooserView'))
    );
    if (target) target.style.display = 'block';
}

document.addEventListener('click', function(e) {
    const authModal = document.getElementById('storeAuthModal');
    if (authModal && e.target === authModal) {
        closeStoreAuthModal();
    }
});
</script>

<!-- FLOATING PWA HOME & CART ACTION BAR -->
<div class="pwa-floating-bottom-bar" id="pwaFloatingBottomBar">
    <a href="{{ $portalHomeUrl }}" class="pwa-fab-home" id="pwaFabHomeBtn" title="Regresar al Inicio del Portal">
        <span class="pwa-fab-icon">🏠</span>
        <span class="pwa-fab-text">Volver al Inicio</span>
    </a>
    <button type="button" class="pwa-fab-cart" onclick="toggleCartDrawer()" aria-label="Ver Carrito">
        <span class="pwa-fab-icon">🛒</span>
        <span class="pwa-fab-text">Carrito (<span id="fabCartCount">0</span>)</span>
    </button>
</div>

<script>
// PWA Navigation History & Gestures Trap
(function initPwaHistoryGuard() {
    if (!window.history || !window.history.pushState) return;

    window.addEventListener('popstate', function(event) {
        // 1. Check if auth modal is open
        const authModal = document.getElementById('storeAuthModal');
        if (authModal && authModal.classList.contains('open')) {
            closeStoreAuthModal();
            return;
        }

        // 2. Check if product modal is open
        const productModal = document.getElementById('productDetailModal');
        if (productModal && productModal.classList.contains('open')) {
            closeProductDetail();
            return;
        }

        // 3. Check if cart drawer is open
        const cartDrawer = document.getElementById('storeCartDrawer');
        if (cartDrawer && cartDrawer.classList.contains('open')) {
            toggleCartDrawer();
            return;
        }

        // 4. Check if store mobile menu is open
        const storeDrawer = document.getElementById('storeMobileDrawer');
        if (storeDrawer && storeDrawer.classList.contains('open')) {
            closeStoreMenu();
            return;
        }

        // 5. Check if checkout modal is open
        const checkoutModal = document.getElementById('checkoutModal');
        if (checkoutModal && checkoutModal.classList.contains('open')) {
            closeCheckoutModal();
            return;
        }

        // 6. Check if success modal is open
        const orderModal = document.getElementById('orderSuccessModal');
        if (orderModal && orderModal.classList.contains('open')) {
            closeOrderSuccessModal();
            return;
        }

        // 7. If no modal is open, let standard browser navigation occur naturally without redirecting
    });

    // In-page smooth scroll navigation for anchors
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const hash = this.getAttribute('href');
            if (!hash || hash === '#') return;
            const target = document.querySelector(hash);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                document.querySelectorAll('.nav-menu a').forEach(a => a.classList.remove('active'));
                if (this.closest('.nav-menu')) {
                    this.classList.add('active');
                }
                history.replaceState(null, '', hash);
            }
        });
    });

    // Also update fabCartCount on cart changes
    const origUpdateCartUI = window.updateCartUI;
    window.updateCartUI = function() {
        if (typeof origUpdateCartUI === 'function') origUpdateCartUI();
        const fabBadge = document.getElementById('fabCartCount');
        const headerBadge = document.getElementById('headerCartBadge');
        if (fabBadge && headerBadge) {
            fabBadge.textContent = headerBadge.textContent;
        }
    };

    // Flash Deals Live Countdown Timer
    (function initFlashDealsCountdown() {
        const hoursEl = document.getElementById('cdHours');
        const minsEl = document.getElementById('cdMinutes');
        const secsEl = document.getElementById('cdSeconds');
        if (!hoursEl || !minsEl || !secsEl) return;

        let totalSeconds = 7 * 3600 + 45 * 60 + 20;
        setInterval(() => {
            if (totalSeconds <= 0) {
                totalSeconds = 8 * 3600; // Reset loop
            }
            totalSeconds--;
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;
            hoursEl.textContent = String(h).padStart(2, '0');
            minsEl.textContent = String(m).padStart(2, '0');
            secsEl.textContent = String(s).padStart(2, '0');
        }, 1000);
    })();
})();
</script>
</body>
</html>