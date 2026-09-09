@php
    $storeTitle = $settings?->store_name ?? $storeName;
    $primaryColor = $settings?->primary_color ?? '#d96b45';
    $secondaryColor = $settings?->secondary_color ?? '#f4efe7';
    $fontFamily = $settings?->font_family ?? 'DM Sans';
    $officialUrl = $settings?->official_website_url;

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
    <title>{{ $storeTitle }} — Zacatecas Centro · Tienda Oficial</title>

    <!-- PWA Requirements for Mobile (Android & iOS) -->
    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $storeTitle }}">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/icons/icon-512.png">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/icons/icon-512.png">

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
        [data-theme="dark"] .store-mobile-nav a {
            color: #f3f4f6;
        }
        [data-theme="dark"] .store-mobile-nav a:hover {
            background: #1e232e;
        }
        [data-theme="dark"] .product-modal-card {
            background: #15181f;
            color: #f3f4f6;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            padding: 9px 24px;
            color: #ffffff;
            background: var(--ink);
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: .06em;
            text-align: center;
            text-transform: uppercase;
            position: relative;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .announcement-stores-link {
            color: {{ $primaryColor }};
            text-decoration: underline;
            text-underline-offset: 3px;
            font-weight: 700;
            cursor: pointer;
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
        .brand-info strong { display: block; font-size: 18px; font-weight: 700; letter-spacing: -.02em; }
        .brand-info small { display: block; font-size: 10.5px; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; }

        .nav-menu { display: flex; gap: 24px; font-size: 13.5px; font-weight: 500; }
        .nav-menu a { color: var(--muted); transition: color .2s ease; }
        .nav-menu a:hover, .nav-menu a.active { color: var(--accent); font-weight: 600; }

        .nav-actions { display: flex; align-items: center; gap: 10px; }

        /* Official Website Redirect Button (Top Header) */
        .btn-official-website {
            padding: 8px 15px;
            border-radius: 999px;
            background: transparent;
            border: 1.5px solid var(--accent);
            color: var(--accent);
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s ease;
            white-space: nowrap;
        }
        .btn-official-website:hover {
            background: var(--accent);
            color: #ffffff;
            box-shadow: 0 4px 14px {{ $primaryColor }}40;
            transform: translateY(-1px);
        }

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
            font-size: clamp(38px, 4.5vw, 62px);
            line-height: 1.06;
            margin-bottom: 18px;
            letter-spacing: -.03em;
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
        .section-title { font-size: clamp(28px, 3.5vw, 42px); letter-spacing: -.03em; line-height: 1.1; }

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
            z-index: 9999;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(10px);
            display: none;
            place-items: center;
            padding: 20px;
        }
        .modal-backdrop.open { display: grid; }
        .modal-card {
            background: var(--card);
            border-radius: 26px;
            width: min(920px, 100%);
            max-height: 92vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 30px 70px rgba(0,0,0,.35);
            padding: 36px;
        }
        .modal-close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--paper);
            color: var(--ink);
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 18px;
            transition: all .2s ease;
            z-index: 10;
        }
        .modal-close-btn:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }

        .modal-main-layout {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 32px;
            margin-bottom: 30px;
        }
        .modal-img-col {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .modal-img-wrap {
            aspect-ratio: 1;
            border-radius: 20px;
            overflow: hidden;
            background: #f4ede4;
            position: relative;
        }
        .modal-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .modal-badges-row {
            display: flex;
            gap: 8px;
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
        .modal-chip-stock { background: #dcfce7; color: #166534; }
        .modal-chip-delivery { background: #e0f2fe; color: #0369a1; }

        .modal-content-col { display: flex; flex-direction: column; }
        .modal-cat-tag {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: 6px;
            cursor: pointer;
            display: inline-block;
        }
        .modal-cat-tag:hover { text-decoration: underline; }
        .modal-title { font-size: clamp(22px, 2.5vw, 30px); line-height: 1.2; margin-bottom: 12px; }
        .modal-price-row {
            display: flex;
            align-items: baseline;
            gap: 12px;
            margin-bottom: 18px;
        }
        .modal-price { font-size: 28px; font-weight: 800; color: var(--accent); }
        .modal-price-currency { font-size: 13px; color: var(--muted); font-weight: 600; }

        .modal-desc {
            font-size: 14px;
            line-height: 1.65;
            color: var(--muted);
            margin-bottom: 22px;
        }

        /* QUANTITY SELECTOR WITH LIVE TOTAL */
        .modal-qty-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: var(--paper);
            border-radius: 14px;
            border: 1px solid var(--line);
            margin-bottom: 20px;
        }
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 16px;
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
            gap: 20px;
            margin-bottom: 16px;
        }
        .modal-tab-btn {
            background: none;
            border: none;
            padding: 8px 4px 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            position: relative;
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
        }
        .modal-tab-pane { display: none; font-size: 13px; line-height: 1.6; color: var(--muted); }
        .modal-tab-pane.active { display: block; }

        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .spec-box {
            padding: 10px 14px;
            background: var(--paper);
            border-radius: 10px;
            border: 1px solid var(--line);
        }
        .spec-box span { display: block; font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px; }
        .spec-box strong { font-size: 13px; color: var(--ink); }

        /* MODAL ACTION BUTTONS */
        .modal-actions-row {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 24px;
        }
        .btn-whatsapp-order {
            padding: 14px 20px;
            border-radius: 999px;
            background: #25d366;
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: transform .2s ease;
            box-shadow: 0 6px 18px rgba(37,211,102,.35);
        }
        .btn-whatsapp-order:hover { transform: translateY(-2px); }

        .modal-secondary-actions {
            display: flex;
            gap: 10px;
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
            transition: all .2s ease;
        }
        .btn-modal-action:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* RELATED PRODUCTS SECTION IN MODAL */
        .modal-related-wrap {
            border-top: 1px solid var(--line);
            padding-top: 24px;
            margin-top: 24px;
        }
        .modal-related-wrap h4 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 14px;
            color: var(--ink);
        }
        .modal-related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }
        .related-card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px;
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
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
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

        /* MOBILE DRAWER & HAMBURGER FOR STORE */
        .btn-store-menu {
            display: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--paper);
            border: 1px solid var(--line);
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            cursor: pointer;
            padding: 8px;
            transition: all .2s ease;
        }
        .btn-store-menu .bar {
            width: 18px;
            height: 2px;
            background: var(--ink);
            border-radius: 2px;
            transition: all .25s ease;
        }
        .btn-store-menu.active .bar:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }
        .btn-store-menu.active .bar:nth-child(2) {
            opacity: 0;
        }
        .btn-store-menu.active .bar:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        .store-mobile-drawer {
            display: none;
            background: var(--card);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
            position: sticky;
            top: 72px;
            z-index: 999;
            animation: slideDown .25s ease-out;
        }
        .store-mobile-drawer.open {
            display: block;
        }
        .store-mobile-nav {
            display: flex;
            flex-direction: column;
            padding: 16px 20px;
            gap: 8px;
        }
        .store-mobile-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
            transition: background .2s ease;
        }
        .store-mobile-nav a:hover {
            background: var(--paper);
            color: var(--accent);
        }
        .drawer-divider {
            height: 1px;
            background: var(--line);
            margin: 4px 0;
        }
        .btn-drawer-admin {
            background: var(--ink) !important;
            color: #ffffff !important;
            justify-content: center;
            border-radius: 999px !important;
            font-weight: 700 !important;
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
            .btn-store-menu { display: flex; }
        }

        @media (max-width: 650px) {
            .shell { width: calc(100% - 24px); }
            .brand-info small { display: none; }
            .brand-info strong { font-size: 15px; }
            .btn-official-website { display: none; }
            .btn-stores-dropdown-toggle .btn-stores-text { display: none; }
            .admin-direct-link .admin-link-text { display: none; }
            .admin-direct-link { padding: 8px 10px; }

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

            .modal-card { padding: 20px 14px; width: calc(100% - 16px); border-radius: 18px; }
            .modal-close-btn { top: 12px; right: 12px; width: 32px; height: 32px; font-size: 16px; }
            .modal-title { font-size: 20px; }
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
    </style>
</head>
<body>

@if($settings?->show_announcement ?? true)
    <aside class="announcement-bar">
        <span>✦ {{ !empty($settings?->announcement_text) ? $settings->announcement_text : ('Bienvenido a ' . $storeTitle . ' · Envíos seguros a todo el país') }} ✦</span>
        <span class="announcement-stores-link" onclick="toggleStoresDropdown()">Ver Tiendas Oficiales de la Red ▾</span>
    </aside>
@endif

<header class="site-header">
    <div class="shell nav-shell">
        <a class="brand-link" href="{{ url('/') }}">
            @if(!empty($settings?->logo_url))
                <img src="{{ $settings->logo_url }}" alt="{{ $storeTitle }}" class="brand-logo">
            @else
                <span class="brand-badge-circle">{{ str($storeTitle)->substr(0, 1) }}</span>
            @endif
            <div class="brand-info">
                <strong>{{ $storeTitle }}</strong>
                <small>{{ !empty($settings?->tagline) ? $settings->tagline : 'Tienda Oficial Verificada' }}</small>
            </div>
        </a>

        <nav class="nav-menu">
            <a href="#inicio" class="active">Inicio</a>
            <a href="#categorias">Categorías</a>
            <a href="#destacados">Tendencias</a>
            <a href="#catalogo">Catálogo</a>
            <a href="#negocios">Tiendas Oficiales</a>
            <a href="#contacto">Contacto</a>
        </nav>

        <div class="nav-actions">
            <!-- 1. Botón Sitio Web Oficial del Negocio -->
            @if(!empty($officialUrl))
                <a href="{{ $officialUrl }}" target="_blank" class="btn-official-website" title="Visitar Sitio Web Oficial de {{ $storeTitle }}">
                    <span>🌐</span> Sitio Oficial ↗
                </a>
            @endif

            <!-- 2. Dropdown de Negocios Oficiales de la Red SaaS -->
            <div class="official-stores-dropdown-wrap">
                <button class="btn-stores-dropdown-toggle" id="storesToggleBtn" onclick="toggleStoresDropdown()">
                    <span>🏢</span> <span class="btn-stores-text">Negocios Oficiales ▾</span>
                </button>
                <div class="official-stores-menu" id="storesDropdownMenu">
                    <div class="stores-menu-header">
                        <span>Red de Tiendas Oficiales</span>
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

            @if(!empty($settings?->facebook_url))
                <a href="{{ $settings->facebook_url }}" target="_blank" class="social-circle-btn" style="color: #1877f2;" title="Facebook Oficial de {{ $storeTitle }}">FB</a>
            @endif
            @if(!empty($settings?->instagram_url))
                <a href="{{ $settings->instagram_url }}" target="_blank" class="social-circle-btn" style="color: #e1306c;" title="Instagram Oficial de {{ $storeTitle }}">IG</a>
            @endif
            @if(!empty($settings?->whatsapp_number))
                @php $headerWa = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
                <a href="https://wa.me/{{ $headerWa }}?text={{ urlencode('¡Hola! Me comunico desde la tienda ' . $storeTitle) }}" target="_blank" class="social-circle-btn" style="color: #25d366;" title="Chat directo de WhatsApp">WA</a>
            @endif
            @if(!empty($officialUrl))
                <a href="{{ $officialUrl }}" target="_blank" class="social-circle-btn" style="color: var(--accent);" title="Sitio Web Oficial de {{ $storeTitle }}">🌐</a>
            @endif

            <a href="{{ url('/tenant-admin') }}" class="admin-direct-link" title="Panel de Administración de la Tienda">
                <span>⚙</span> <span class="admin-link-text">Panel</span>
            </a>

            <!-- Dark / Light Theme Toggle -->
            <button type="button" class="btn-theme-toggle" id="storeThemeToggleBtn" onclick="toggleTheme()" aria-label="Cambiar modo oscuro/claro" title="Cambiar a Modo Oscuro / Claro">
                <span class="theme-icon-light">🌙</span>
                <span class="theme-icon-dark" style="display: none;">☀️</span>
            </button>

            <!-- Mobile Store Hamburger Toggle -->
            <button type="button" class="btn-store-menu" id="storeMenuToggle" onclick="toggleStoreMenu()" aria-label="Abrir Menú">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        </div>
    </div>
</header>

<!-- STORE MOBILE DRAWER -->
<div class="store-mobile-drawer" id="storeMobileDrawer">
    <nav class="store-mobile-nav">
        <a href="#inicio" onclick="toggleStoreMenu()"><span>🏠</span> Inicio</a>
        <a href="#categorias" onclick="toggleStoreMenu()"><span>🏷️</span> Categorías</a>
        <a href="#destacados" onclick="toggleStoreMenu()"><span>🔥</span> Tendencias de la Semana</a>
        <a href="#catalogo" onclick="toggleStoreMenu()"><span>🛍️</span> Catálogo de Productos</a>
        <a href="#negocios" onclick="toggleStoreMenu()"><span>🏢</span> Red de Tiendas Oficiales</a>
        <a href="#contacto" onclick="toggleStoreMenu()"><span>💬</span> Contacto & Sucursal</a>
        <a href="{{ url('/') }}" target="_blank"><span>📍</span> Portal Zacatecas Centro ↗</a>
        <div style="display: flex; gap: 8px; justify-content: center; padding: 10px 0;">
            @if(!empty($settings?->facebook_url))
                <a href="{{ $settings->facebook_url }}" target="_blank" class="social-circle-btn" style="color: #1877f2;" title="Facebook">FB</a>
            @endif
            @if(!empty($settings?->instagram_url))
                <a href="{{ $settings->instagram_url }}" target="_blank" class="social-circle-btn" style="color: #e1306c;" title="Instagram">IG</a>
            @endif
            @if(!empty($settings?->whatsapp_number))
                @php $drawerWa = preg_replace('/[^0-9]/', '', $settings->whatsapp_number); @endphp
                <a href="https://wa.me/{{ $drawerWa }}?text={{ urlencode('¡Hola! Me comunico desde la tienda ' . $storeTitle) }}" target="_blank" class="social-circle-btn" style="color: #25d366;" title="WhatsApp">WA</a>
            @endif
            @if(!empty($officialUrl))
                <a href="{{ $officialUrl }}" target="_blank" class="social-circle-btn" style="color: var(--accent);" title="Sitio Web">🌐</a>
            @endif
        </div>
        <div class="drawer-divider"></div>
        <button type="button" class="btn-theme-toggle-drawer" onclick="toggleTheme()">
            <span class="theme-text-light">🌙 Cambiar a Modo Oscuro</span>
            <span class="theme-text-dark" style="display: none;">☀️ Cambiar a Modo Claro</span>
        </button>
        <a href="{{ url('/tenant-admin') }}" class="btn-drawer-admin"><span>⚙</span> Ingresar al Panel Administrativo</a>
    </nav>
</div>

<main class="shell" id="inicio">

    <!-- 1. HERO CAROUSEL -->
    <section class="hero-carousel-container" id="heroCarousel">
        <div class="hero-track" id="heroTrack">
            <!-- Slide 1: Oficial de la tienda -->
            <div class="hero-slide" style="background-image: url('{{ $heroBanner }}');">
                <div class="hero-slide-overlay"></div>
                <div class="hero-slide-content">
                    <span class="hero-badge">Colección Oficial 2026</span>
                    <h2>{!! nl2br(e($settings?->hero_title ?? 'Calidad y diseño. Hecho para ti.')) !!}</h2>
                    <p>{{ $settings?->hero_subtitle ?? 'Explora nuestra cuidada selección de piezas y productos de alta gama con garantía oficial y control de inventario.' }}</p>
                    <div class="hero-cta-group">
                        <a href="#catalogo" class="btn-brand-primary">{{ $settings?->hero_button_text ?? 'Explorar Catálogo' }} <span>↓</span></a>
                        @if(!empty($officialUrl))
                            <a href="{{ $officialUrl }}" target="_blank" class="btn-official-hero">
                                <span>🌐</span> Visitar Sitio Oficial ↗
                            </a>
                        @endif
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
                        <a href="#negocios" class="btn-brand-outline">Ver Tiendas Oficiales <span>🏢</span></a>
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

    <!-- 2. VALUE PROPOSITION BAR -->
    <section class="trust-bar">
        <div class="trust-item">
            <div class="trust-icon">🚚</div>
            <div>
                <strong>Envíos Express Protegidos</strong>
                <small>Rastreo y entrega asegurada</small>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">🛡️</div>
            <div>
                <strong>Garantía Oficial de Calidad</strong>
                <small>30 días para cambios y devoluciones</small>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">💳</div>
            <div>
                <strong>Pagos 100% Cifrados</strong>
                <small>Seguridad de datos de nivel bancario</small>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">💬</div>
            <div>
                <strong>Atención por WhatsApp</strong>
                <small>Asesoría personalizada en vivo</small>
            </div>
        </div>
    </section>

    <!-- 3. CATEGORIES CAROUSEL -->
    @if($categories->count() > 0)
    <section class="categories-carousel-wrap" id="categorias">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">Navegación Interactiva</span>
                <h2 class="section-title">Explorar por Categoría</h2>
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

    <!-- 4. FEATURED PRODUCTS CAROUSEL -->
    @if($featuredProducts->count() > 0)
    <section class="featured-carousel-wrap" id="destacados">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">Selección Especial</span>
                <h2 class="section-title">Tendencias de la Semana</h2>
            </div>
            <div class="carousel-arrows">
                <button class="carousel-btn" id="featPrev" aria-label="Anterior">←</button>
                <button class="carousel-btn" id="featNext" aria-label="Siguiente">→</button>
            </div>
        </div>

        <div class="featured-track" id="featTrack">
            @foreach($featuredProducts as $item)
                <div class="featured-item">
                    <article class="product-card">
                        <div class="product-card-thumb" onclick='openProductDetail(@json($item))'>
                            @if($item->category)
                                <span class="product-badge-cat" onclick="event.stopPropagation(); selectCategory('{{ $item->category->slug }}', '{{ addslashes($item->category->name) }}')">
                                    {{ $item->category->name }}
                                </span>
                            @endif
                            <span class="product-stock-tag {{ $item->stock > 10 ? 'stock-available' : ($item->stock > 0 ? 'stock-low' : 'stock-none') }}">
                                {{ $item->stock > 0 ? ($item->stock . ' en stock') : 'Agotado' }}
                            </span>
                            <img src="{{ !empty($item->image_url) ? $item->image_url : 'https://placehold.co/600x600?text=' . urlencode($item->name) }}" alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="product-card-body">
                            <h3 onclick='openProductDetail(@json($item))'>{{ $item->name }}</h3>
                            <p>{{ Str::limit($item->description, 80) }}</p>
                            <div class="product-card-footer">
                                <span class="product-price">${{ number_format($item->price, 2) }}</span>
                                <button class="btn-quick-view" onclick='openProductDetail(@json($item))'>Ver detalles ↗</button>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- 5. FULL CATALOG WITH REAL-TIME CATEGORY FILTERING & SEARCH -->
    <section id="catalogo">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">Catálogo Completo</span>
                <h2 class="section-title">Nuestra Colección de Productos</h2>
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
                    <div class="product-card-thumb" onclick='openProductDetail(@json($product))'>
                        @if($product->category)
                            <span class="product-badge-cat" onclick="event.stopPropagation(); selectCategory('{{ $product->category->slug }}', '{{ addslashes($product->category->name) }}')">
                                {{ $product->category->name }}
                            </span>
                        @endif
                        <span class="product-stock-tag {{ $product->stock > 10 ? 'stock-available' : ($product->stock > 0 ? 'stock-low' : 'stock-none') }}">
                            {{ $product->stock > 0 ? ($product->stock . ' en stock') : 'Agotado' }}
                        </span>
                        <img src="{{ !empty($product->image_url) ? $product->image_url : 'https://placehold.co/600x600?text=' . urlencode($product->name) }}" alt="{{ $product->name }}" loading="lazy">
                    </div>
                    <div class="product-card-body">
                        <h3 onclick='openProductDetail(@json($product))'>{{ $product->name }}</h3>
                        <p>{{ Str::limit($product->description, 85) }}</p>
                        <div class="product-card-footer">
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                            <button class="btn-quick-view" onclick='openProductDetail(@json($product))'>Ver detalles ↗</button>
                        </div>
                    </div>
                </article>
            @empty
                <div style="grid-column: 1 / -1; text-align:center; padding: 60px 20px; background:var(--card); border-radius:18px; border:1px dashed var(--line);">
                    <h3>No hay productos registrados</h3>
                    <p style="color:var(--muted); margin: 10px 0 20px;">Crea productos desde el panel administrativo de la tienda.</p>
                    <a href="{{ url('/tenant-admin/products/create') }}" class="btn-brand-primary">Añadir Primer Producto</a>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 6. RED DE NEGOCIOS Y TIENDAS OFICIALES (BOTONES DE REDIRECCIÓN A NEGOCIOS) -->
    <section class="official-network-section" id="negocios">
        <div class="section-header" style="margin-bottom: 10px;">
            <div>
                <span class="section-eyebrow">Ecosistema Multi-Tienda</span>
                <h2 class="section-title">Directorio de Negocios Oficiales</h2>
            </div>
            @if(!empty($officialUrl))
                <a href="{{ $officialUrl }}" target="_blank" class="btn-brand-primary">
                    <span>🌐</span> Web Oficial de {{ $storeTitle }} ↗
                </a>
            @endif
        </div>
        <p style="color: var(--muted); font-size: 14px; max-width: 700px;">
            Navega entre las diferentes marcas y tiendas oficiales registradas en nuestra plataforma SaaS multi-empresa. Cada negocio cuenta con catálogo independiente, atención directa y garantía verificada.
        </p>

        <div class="network-grid">
            @foreach($officialStores ?? [] as $store)
                <div class="network-card {{ $store['is_current'] ? 'is-current-card' : '' }}">
                    <div>
                        <div class="network-card-top">
                            <div class="network-logo-badge">
                                {{ strtoupper(substr($store['id'], 0, 1)) }}
                            </div>
                            <div>
                                <strong style="font-size: 16px;">{{ $store['name'] }}</strong>
                                <small style="display: block; color: var(--muted); font-size: 11.5px;">{{ parse_url($store['url'], PHP_URL_HOST) }}</small>
                            </div>
                        </div>
                        <p style="font-size: 12.5px; color: var(--muted); margin-bottom: 18px; line-height: 1.5;">
                            {{ $store['tagline'] ?? match($store['id']) {
                                'acropolis' => 'La cafetería y galería de arte más emblemática de Zacatecas desde 1943.',
                                'donajulia' => 'El sabor auténtico de Zacatecas, gorditas hechas a mano con guisados al comal.',
                                'rosadeplata' => 'Joyería fina en plata ley .925 cincelada a mano por maestros plateros.',
                                'elserranito' => 'Tradición dulce zacatecana: quesos de tuna, ates, cajetas de Jerez y artesanías.',
                                'quinceletras' => 'La cantina más legendaria de Zacatecas desde 1906. Maestros del mezcal artesanal.',
                                'libreriaandrea' => 'Libros de historia colonial de Zacatecas, novela, poesía, arte y papelería fina.',
                                default => 'Comercio emblemático verificado en el Centro Histórico de Zacatecas.'
                            } }}
                        </p>
                    </div>

                    @if($store['is_current'])
                        <div class="network-card-btn network-card-btn-primary">
                            <span>✓</span> Te encuentras en esta tienda
                        </div>
                    @else
                        <a href="{{ $store['url'] }}" target="_blank" class="network-card-btn network-card-btn-outline">
                            Visitar Tienda Oficial <span>↗</span>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- 7. TESTIMONIALS CAROUSEL -->
    <section class="testimonials-section" id="opiniones">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">Experiencias Reales</span>
                <h2 class="section-title">Lo que dicen nuestros clientes</h2>
            </div>
            <div class="carousel-arrows">
                <button class="carousel-btn" id="testPrev" aria-label="Anterior">←</button>
                <button class="carousel-btn" id="testNext" aria-label="Siguiente">→</button>
            </div>
        </div>

        <div class="testimonials-track" id="testTrack">
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"El bolso de cuero llegó en un empaque soberbio. La calidad de las costuras y el tacto del material superaron ampliamente mis expectativas."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="Camila R." class="testimonial-avatar">
                    <div>
                        <strong>Camila Restrepo</strong>
                        <small>Compradora Verificada · CDMX</small>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"Compré el cronógrafo suizo y la atención por WhatsApp fue inmediata y muy cordial. El reloj es una pieza de relojería de primer nivel."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Mateo V." class="testimonial-avatar">
                    <div>
                        <strong>Mateo Valenzuela</strong>
                        <small>Comprador Verificado · Monterrey</small>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"La lámpara de cerámica y las velas botánicas transformaron mi sala por completo. Los aromas son exquisitos y duraderos."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=100&q=80" alt="Lucía M." class="testimonial-avatar">
                    <div>
                        <strong>Lucía Mendoza</strong>
                        <small>Compradora Verificada · Guadalajara</small>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"Plataforma impecable y entrega en menos de 48 horas. Sin duda repetiré mis compras en esta tienda."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=80" alt="Rodrigo S." class="testimonial-avatar">
                    <div>
                        <strong>Rodrigo Santos</strong>
                        <small>Comprador Verificado · Querétaro</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. CONTACT BOX -->
    <section id="contacto" style="margin-bottom: 60px;">
        <div style="background: var(--card); border: 1px solid var(--card-border); border-radius: 24px; padding: 48px; display: flex; justify-content: space-between; align-items: center; gap: 30px; flex-wrap: wrap;">
            <div>
                <span class="section-eyebrow">Atención Directa</span>
                <h2 style="font-size: 32px; margin-bottom: 8px;">¿Deseas una cotización o pedido especial?</h2>
                <p style="color: var(--muted); font-size: 14px; max-width: 520px;">Estamos disponibles para responder cualquier duda sobre catálogo, personalizaciones o envíos nacionales e internacionales.</p>
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
                        <span>📘</span> Facebook Oficial ↗
                    </a>
                @endif
                @if(!empty($settings?->instagram_url))
                    <a href="{{ $settings->instagram_url }}" target="_blank" class="btn-brand-outline" style="border-color: #e1306c; color: #e1306c;">
                        <span>📸</span> Instagram Oficial ↗
                    </a>
                @endif
                @if(!empty($officialUrl))
                    <a href="{{ $officialUrl }}" target="_blank" class="btn-brand-outline" style="border-color: var(--accent); color: var(--accent);">
                        <span>🌐</span> Sitio Web Oficial ↗
                    </a>
                @endif
            </div>
        </div>
    </section>

</main>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="shell">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="brand-link" style="margin-bottom: 14px;">
                    <span class="brand-badge-circle">{{ str($storeTitle)->substr(0, 1) }}</span>
                    <strong style="font-size: 18px;">{{ $storeTitle }}</strong>
                </div>
                <p style="margin-bottom: 16px;">{{ !empty($settings?->tagline) ? $settings->tagline : 'Comercio independiente multi-tenant con diseño y seguridad de estándar internacional.' }}</p>
                @if(!empty($officialUrl))
                    <a href="{{ $officialUrl }}" target="_blank" class="btn-official-website" style="display:inline-flex;">
                        <span>🌐</span> Visitar Página Oficial ↗
                    </a>
                @endif
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
                    <li><a href="{{ url('/tenant-admin') }}">Panel de la Tienda</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Negocios Oficiales</h4>
                <p style="margin-bottom: 12px;">Descubre las tiendas oficiales de nuestra red:</p>
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
                    @if(!empty($officialUrl))
                        <a href="{{ $officialUrl }}" target="_blank" class="social-circle-btn" style="color: var(--accent);" title="Sitio Web Oficial">🌐</a>
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
        <button class="modal-close-btn" onclick="closeProductDetail()" aria-label="Cerrar modal">✕</button>
        
        <div class="modal-main-layout">
            <!-- Left: Product Image & Badges -->
            <div class="modal-img-col">
                <div class="modal-img-wrap">
                    <img id="modalImg" src="" alt="Producto">
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
                            <button class="qty-btn" onclick="changeModalQty(-1)">−</button>
                            <span class="qty-display" id="modalQtyDisplay">1</span>
                            <button class="qty-btn" onclick="changeModalQty(1)">+</button>
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
                    <button class="modal-tab-btn" onclick="switchModalTab('guarantee', this)">Garantía Oficial</button>
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
                            <span>Garantía Oficial</span>
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
                    <p style="margin-bottom: 8px;">• <strong>Soporte Dedicado:</strong> Asistencia post-venta y resolución de cualquier duda a través de WhatsApp o correo oficial.</p>
                    <p>• <strong>Comercio Seguro:</strong> Pagos protegidos con cifrado SSL de extremo a extremo.</p>
                </div>

                <!-- Sucursal Zacatecas Centro Location Pill / Infobox -->
                <div class="modal-zac-location-box" style="margin: 16px 0 12px; padding: 12px 14px; background: rgba(226,112,78,0.06); border: 1px solid rgba(226,112,78,0.22); border-radius: 14px;">
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
                    <a id="modalWhatsAppBtn" href="#" target="_blank" class="btn-whatsapp-order">
                        <svg style="width:20px; height:20px; fill:#fff;" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.769.814 2.797.814 3.18 0 5.767-2.587 5.768-5.766 0-3.18-2.588-5.766-5.769-5.766zm0 10.355c-.886 0-1.616-.242-2.348-.675l-.168-.1-1.745.458.466-1.701-.11-.175c-.476-.757-.728-1.503-.728-2.399 0-2.531 2.059-4.59 4.635-4.59 2.576 0 4.635 2.059 4.635 4.59 0 2.531-2.059 4.592-4.535 4.592zm-8.031-4.589c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12z"/></svg>
                        Pedir / Comprar por WhatsApp (<span id="modalBtnTotal">$0.00</span>)
                    </a>
                    <div class="modal-secondary-actions">
                        <button class="btn-modal-action" onclick="copyProductDirectLink()">
                            <span>🔗</span> Copiar Enlace Directo
                        </button>
                        @if(!empty($officialUrl))
                            <a href="{{ $officialUrl }}" target="_blank" class="btn-modal-action">
                                <span>🌐</span> Web Oficial del Negocio ↗
                            </a>
                        @endif
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

<!-- JAVASCRIPT LOGIC -->
<script>
// Catalog products database for rich details & related products
const ALL_PRODUCTS = @json($products);
const STORE_TITLE = @json($storeTitle);
const STORE_OFFICIAL_URL = @json($officialUrl);
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

document.addEventListener('DOMContentLoaded', () => {
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
        if (dropdown && dropdown.classList.contains('open')) {
            if (!dropdown.contains(e.target) && (!toggleBtn || !toggleBtn.contains(e.target))) {
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
});

// DROPDOWN OFICIAL STORES TOGGLE
function toggleStoresDropdown() {
    const dropdown = document.getElementById('storesDropdownMenu');
    if (dropdown) {
        dropdown.classList.toggle('open');
    }
}

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
function openProductDetail(product) {
    if (!product) return;
    currentModalProduct = product;
    currentModalQty = 1;

    const modal = document.getElementById('productDetailModal');
    if (!modal) return;

    // Fill Basic Details
    document.getElementById('modalImg').src = product.image_url || ('https://placehold.co/600x600?text=' + encodeURIComponent(product.name));
    document.getElementById('modalTitle').textContent = product.name;
    const catName = product.category ? product.category.name : 'Colección General';
    document.getElementById('modalCat').textContent = catName;
    document.getElementById('modalPrice').textContent = '$' + parseFloat(product.price).toFixed(2);
    document.getElementById('modalDesc').textContent = product.description || 'Artículo exclusivo confeccionado bajo estrictos estándares de manufactura y control de calidad.';
    
    // Fill Badges
    const skuCode = `SKU-${product.id ? String(product.id).padStart(4, '0') : '001'}-${product.slug ? product.slug.substring(0, 4).toUpperCase() : 'ART'}`;
    document.getElementById('modalSku').textContent = skuCode;
    
    const stockEl = document.getElementById('modalStock');
    if (product.stock > 10) {
        stockEl.textContent = `✓ En stock: ${product.stock} disponibles`;
        stockEl.className = 'modal-chip modal-chip-stock';
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

    // Dynamic Specifications Mapping
    const catSlug = product.category ? product.category.slug : '';
    const specs = getProductSpecs(product.name, catSlug);
    document.getElementById('specMaterial').textContent = specs.material;
    document.getElementById('specDimensions').textContent = specs.dimensions;
    document.getElementById('specAvailability').textContent = product.stock > 0 ? 'En existencia para despacho express' : 'Bajo pedido especial';
    document.getElementById('specWarranty').textContent = specs.warranty;

    // Reset Qty & Subtotal
    updateModalQtyUI();

    // Populate Related Products (same category)
    populateRelatedProducts(product);

    // Reset to specs tab
    switchModalTab('specs');

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';

    // Update URL parameter
    const url = new URL(window.location);
    url.searchParams.set('producto', product.slug || product.id);
    window.history.replaceState({}, '', url);
}

function closeProductDetail() {
    const modal = document.getElementById('productDetailModal');
    if (modal) modal.classList.remove('open');
    document.body.style.overflow = '';

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
    document.getElementById('modalQtyDisplay').textContent = currentModalQty;
    const unitPrice = parseFloat(currentModalProduct.price || 0);
    const subtotal = unitPrice * currentModalQty;
    const formatted = '$' + subtotal.toFixed(2);
    document.getElementById('modalSubtotal').textContent = formatted + ' MXN';
    document.getElementById('modalBtnTotal').textContent = formatted;

    // Update WhatsApp Link
    const waBtn = document.getElementById('modalWhatsAppBtn');
    const sku = `SKU-${currentModalProduct.id ? String(currentModalProduct.id).padStart(4, '0') : '001'}`;
    const productUrl = `${window.location.origin}${window.location.pathname}?producto=${currentModalProduct.slug}`;
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
                warranty: '3 años de garantía oficial en maquinaria de precisión'
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
                warranty: '12 meses de garantía oficial directa del fabricante'
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
        showToast(`¡Enlace de la tienda oficial copiado!`);
    }).catch(() => {
        showToast('Enlace copiado');
    });
}

// Mobile Store Menu Toggle
function toggleStoreMenu() {
    const drawer = document.getElementById('storeMobileDrawer');
    const toggle = document.getElementById('storeMenuToggle');
    if (drawer) drawer.classList.toggle('open');
    if (toggle) toggle.classList.toggle('active');
}

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

document.addEventListener('DOMContentLoaded', () => {
    const activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
    updateThemeIcons(activeTheme);
});
</script>

</body>
</html>