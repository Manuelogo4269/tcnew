<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#121311">
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
    <title>Atelier Marketplace — Tiendas y Comercios de Zacatecas Centro</title>
    <meta name="description" content="Directorio y marketplace oficial de comercios en el Centro Histórico de Zacatecas. Explora tiendas emblemáticas, productos típicos, mapa interactivo con GPS y pedidos por WhatsApp con sucursal física.">

    <!-- Open Graph & Social Cards (WhatsApp, Facebook, Telegram, Twitter) -->
    <meta property="og:site_name" content="Atelier Zacatecas">
    <meta property="og:title" content="Atelier Zacatecas — Tiendas y Comercios de Zacatecas Centro">
    <meta property="og:description" content="Explora comercios emblemáticos en la Ciudad de Cantera Rosa y Plata: Café Acrópolis, Gorditas Doña Julia, Platería Rosa de Plata y más. Mapa interactivo y pedidos por WhatsApp.">
    <meta property="og:image" content="{{ url('/app-icons/icon-512.png') }}">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Atelier Zacatecas — Tiendas y Comercios de Zacatecas Centro">
    <meta name="twitter:description" content="Directorio oficial de comercios en el Centro Histórico de Zacatecas. Mapa interactivo, catálogo y pedidos directos.">
    <meta name="twitter:image" content="{{ url('/app-icons/icon-512.png') }}">

    <!-- PWA Requirements for Mobile (Android Chrome, iOS Safari & Desktop) -->
    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Atelier ZAC">
    <meta name="theme-color" content="#c86d63">
    <link rel="icon" type="image/svg+xml" href="/app-icons/icon.svg">
    <link rel="icon" type="image/png" sizes="192x192" href="/app-icons/icon-192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/app-icons/icon-512.png">
    <link rel="apple-touch-icon" href="/app-icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/app-icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/app-icons/icon-512.png">

    <!-- Leaflet CSS & JS for Interactive Zacatecas Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com">
    <link rel="dns-prefetch" href="https://images.unsplash.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        /* ======================================================== */
        /* ZACATECAS: CIUDAD DE CANTERA ROSA & CORAZÓN DE PLATA     */
        /* ======================================================== */
        :root {
            --ink: #181d26;
            --paper: #fbf8f6; /* Matiz suave de cantera pulida y plata */
            --card: #ffffff;
            --card-border: rgba(203, 213, 225, 0.75); /* Borde de plata sutil */
            --muted: #5e6c7e;
            --line: rgba(148, 163, 184, 0.25);
            --accent: #c86d63; /* Rosa Cantera de Zacatecas */
            --accent-hover: #b1554a;
            --accent-soft: rgba(200, 109, 99, 0.12);
            --cantera: #c86d63;
            --cantera-dark: #9e4338;
            --cantera-light: #faeae7;
            --plata: #cbd5e1; /* Plata Ley .925 */
            --plata-pure: #ffffff;
            --plata-dark: #64748b;
            --blue: #2563eb;
            --fb: #1877f2;
            --glass: rgba(255, 255, 255, 0.95);
        }

        /* Dark Theme Variables */
        [data-theme="dark"] {
            --ink: #f1f5f9; /* Brillo de plata pura */
            --paper: #0b0e14; /* Pizarra oscura de mina */
            --card: #141822; /* Carbón plateado */
            --card-border: rgba(203, 213, 225, 0.16); /* Filigrana de plata */
            --muted: #94a3b8; /* Plata mate */
            --line: rgba(203, 213, 225, 0.12);
            --accent: #dc7e74; /* Rosa cantera luminosa */
            --accent-hover: #ea9187;
            --accent-soft: rgba(220, 126, 116, 0.18);
            --cantera: #dc7e74;
            --cantera-dark: #b6574c;
            --cantera-light: #2a1e23;
            --plata: #cbd5e1;
            --plata-pure: #ffffff;
            --plata-dark: #94a3b8;
            --glass: rgba(20, 24, 34, 0.96);
        }

        /* Dark Theme Components & Elements */
        [data-theme="dark"] .portal-header {
            background: rgba(12, 14, 18, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .brand-badge {
            background: var(--accent);
            color: #ffffff;
        }
        [data-theme="dark"] .portal-nav-links a {
            color: #d1d5db;
        }
        [data-theme="dark"] .portal-nav-links a:hover {
            color: var(--accent);
        }
        [data-theme="dark"] .global-search-form {
            background: #181c24;
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        [data-theme="dark"] .global-search-input {
            color: #f3f4f6;
        }
        [data-theme="dark"] .global-search-input::placeholder {
            color: #6b7280;
        }
        [data-theme="dark"] .live-search-dropdown {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
        }
        [data-theme="dark"] .live-search-item {
            color: #f3f4f6;
            border-bottom-color: rgba(255, 255, 255, 0.06);
        }
        [data-theme="dark"] .live-search-item:hover {
            background: #1e232e;
        }
        [data-theme="dark"] .category-pill {
            background: #181c24;
            color: #d1d5db;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .category-pill:hover {
            border-color: var(--accent);
            color: #ffffff;
        }
        [data-theme="dark"] .category-pill.active {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }
        [data-theme="dark"] .company-card {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .company-card:hover {
            border-color: rgba(255, 255, 255, 0.16);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }
        [data-theme="dark"] .company-product-item {
            background: #1a1e27;
        }
        [data-theme="dark"] .btn-visit-company {
            background: #222733;
            color: #f3f4f6;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        [data-theme="dark"] .btn-visit-company:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }
        [data-theme="dark"] .social-icon-btn {
            background: #181c24;
            border-color: rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
        }
        [data-theme="dark"] .social-icon-btn:hover {
            border-color: var(--accent);
            color: #ffffff;
        }
        [data-theme="dark"] .social-icon-btn.btn-wa {
            color: #4ade80;
            background: rgba(37, 211, 102, 0.12);
            border-color: rgba(37, 211, 102, 0.25);
        }
        [data-theme="dark"] .social-icon-btn.btn-wa:hover {
            background: #25d366;
            color: #ffffff;
        }
        [data-theme="dark"] .social-icon-btn.btn-fb {
            color: #60a5fa;
            background: rgba(24, 119, 242, 0.12);
            border-color: rgba(24, 119, 242, 0.25);
        }
        [data-theme="dark"] .social-icon-btn.btn-fb:hover {
            background: #1877f2;
            color: #ffffff;
        }
        [data-theme="dark"] .social-icon-btn.btn-ig {
            color: #f472b6;
            background: rgba(225, 48, 108, 0.12);
            border-color: rgba(225, 48, 108, 0.25);
        }
        [data-theme="dark"] .social-icon-btn.btn-ig:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: #ffffff;
        }
        [data-theme="dark"] .social-icon-btn.btn-web {
            color: #fb923c;
            background: rgba(251, 146, 60, 0.12);
            border-color: rgba(251, 146, 60, 0.25);
        }
        [data-theme="dark"] .social-icon-btn.btn-web:hover {
            background: var(--accent);
            color: #ffffff;
        }
        [data-theme="dark"] .social-icon-btn.btn-map {
            color: #94a3b8;
            background: rgba(148, 163, 184, 0.12);
            border-color: rgba(148, 163, 184, 0.25);
        }
        [data-theme="dark"] .social-icon-btn.btn-map:hover {
            background: #475569;
            color: #ffffff;
        }
        [data-theme="dark"] .plan-card {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .plan-card.highlight {
            background: #191e28;
            border-color: var(--accent);
        }
        [data-theme="dark"] .billing-toggle-wrap {
            background: #181c24;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .auth-modal-card,
        [data-theme="dark"] .central-product-modal-card {
            background: #15181f;
            color: #f3f4f6;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.7);
        }
        [data-theme="dark"] .central-product-modal-card .modal-close-btn {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.15);
            color: #f3f4f6;
        }
        [data-theme="dark"] .central-product-modal-card .modal-close-btn:hover {
            background: var(--accent);
            color: #ffffff;
        }
        [data-theme="dark"] .central-product-modal-card .modal-img-wrap {
            background: #0d0f14;
            border-color: rgba(255, 255, 255, 0.1);
        }
        [data-theme="dark"] .central-product-modal-card .modal-chip-store {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #9ca3af;
        }
        [data-theme="dark"] .central-product-modal-card .modal-zac-location-box {
            background: rgba(200, 109, 99, 0.12);
            border-color: rgba(200, 109, 99, 0.3);
        }
        [data-theme="dark"] .btn-visit-store-modal {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #f3f4f6;
        }
        [data-theme="dark"] .modal-close-x {
            background: #202532;
            color: #d1d5db;
        }
        [data-theme="dark"] .modal-close-x:hover {
            background: #2d3444;
            color: #ffffff;
        }
        [data-theme="dark"] .auth-field input,
        [data-theme="dark"] .rent-field input,
        [data-theme="dark"] .rent-field select {
            background: #1a1e27;
            color: #f3f4f6;
            border-color: rgba(255, 255, 255, 0.12);
        }
        [data-theme="dark"] .social-account-item {
            background: #181c24;
            border-color: rgba(255, 255, 255, 0.1);
        }
        [data-theme="dark"] .social-account-item:hover {
            background: #202532;
            border-color: var(--accent);
        }
        [data-theme="dark"] details {
            background: #181c24 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        [data-theme="dark"] .social-env-notice {
            background: #0d2818;
            border-color: #166534;
            color: #86efac;
        }
        [data-theme="dark"] .social-env-notice code {
            background: #14532d;
            color: #bbf7d0;
        }
        [data-theme="dark"] .portal-footer {
            background: #08090c;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .mobile-drawer-backdrop {
            background: rgba(0, 0, 0, 0.82);
        }
        [data-theme="dark"] .portal-mobile-menu {
            background: #11141a;
            border-left-color: rgba(255, 255, 255, 0.1);
            box-shadow: -12px 0 45px rgba(0, 0, 0, 0.65);
        }
        [data-theme="dark"] .drawer-header {
            background: #161922;
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .drawer-logo-badge {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.14);
        }
        [data-theme="dark"] .drawer-brand strong {
            color: #f3f4f6;
        }
        [data-theme="dark"] .btn-drawer-close {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #f3f4f6;
        }
        [data-theme="dark"] .drawer-user-card,
        [data-theme="dark"] .drawer-guest-box {
            background: #161922;
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .drawer-user-info strong {
            color: #f3f4f6;
        }
        [data-theme="dark"] .btn-drawer-login {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #f3f4f6;
        }
        [data-theme="dark"] .drawer-section-title {
            color: #9ca3af;
        }
        [data-theme="dark"] .drawer-nav-item {
            background: #161922;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .drawer-nav-item:hover,
        [data-theme="dark"] .drawer-nav-item:active {
            background: #1c212d;
            border-color: var(--accent);
        }
        [data-theme="dark"] .nav-item-title {
            color: #f3f4f6;
        }
        [data-theme="dark"] .nav-item-sub {
            color: #9ca3af;
        }
        [data-theme="dark"] .drawer-footer-actions {
            background: #161922;
            border-top-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .btn-theme-toggle-drawer {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #f3f4f6;
        }
        [data-theme="dark"] .btn-mobile-menu {
            background: #181c24;
            border-color: rgba(255, 255, 255, 0.14);
            color: #f3f4f6;
        }
        [data-theme="dark"] .btn-mobile-menu .bar {
            background: #f3f4f6;
        }
        [data-theme="dark"] .mobile-menu-label {
            color: #f3f4f6;
        }
        [data-theme="dark"] .tradition-pill {
            background: rgba(220, 126, 116, 0.15);
            color: var(--accent);
            border-color: rgba(220, 126, 116, 0.3);
        }
        [data-theme="dark"] .rating-score,
        [data-theme="dark"] .rating-num {
            color: #f3f4f6;
        }
        [data-theme="dark"] .store-open-badge.badge-open,
        [data-theme="dark"] .store-open-badge.status-open {
            background: rgba(16, 185, 129, 0.18);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.35);
        }
        [data-theme="dark"] .store-open-badge.badge-closed,
        [data-theme="dark"] .store-open-badge.status-closed {
            background: rgba(239, 68, 68, 0.18);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.35);
        }
        [data-theme="dark"] .store-hours-bar {
            background: #1a1e28;
            border-color: rgba(255, 255, 255, 0.08);
        }
        [data-theme="dark"] .hours-text {
            color: #f1f5f9;
        }
        [data-theme="dark"] .radius-pill {
            background: #1e232e;
            border-color: rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
        }
        [data-theme="dark"] .radius-pill:hover,
        [data-theme="dark"] .radius-pill.active {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }
        [data-theme="dark"] .filter-only-open {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.35);
            color: #34d399;
        }
        [data-theme="dark"] .filter-only-open.active {
            background: #059669;
            color: #ffffff;
            border-color: #059669;
        }
        [data-theme="dark"] .btn-back-to-top {
            background: #151820;
            border-color: rgba(255, 255, 255, 0.14);
            color: var(--accent);
        }
        [data-theme="dark"] .btn-share-header,
        [data-theme="dark"] .btn-share-card,
        [data-theme="dark"] .btn-lang-toggle {
            background: #151820;
            border-color: rgba(255, 255, 255, 0.14);
            color: #f3f4f6;
        }
        /* Map in Dark Mode: Clean Night Grayscale with High Contrast Roads & Labels */
        [data-theme="dark"] .leaflet-layer {
            filter: grayscale(100%) invert(92%) contrast(108%) brightness(88%) !important;
        }
        [data-theme="dark"] .leaflet-container {
            background: #15181f !important;
        }
        [data-theme="dark"] .zac-map-box {
            border-color: rgba(255, 255, 255, 0.12);
            background: #15181f;
        }
        [data-theme="dark"] .leaflet-control-zoom {
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4) !important;
        }
        [data-theme="dark"] .leaflet-control-zoom a {
            background: #1e232e !important;
            color: #f3f4f6 !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
        }
        [data-theme="dark"] .leaflet-control-zoom a:hover {
            background: #2b3240 !important;
            color: #ffffff !important;
        }
        [data-theme="dark"] .leaflet-popup-content-wrapper {
            background: #15181f !important;
            color: #f3f4f6 !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        }
        [data-theme="dark"] .leaflet-popup-tip {
            background: #15181f !important;
        }
        [data-theme="dark"] .leaflet-popup-content h4 {
            color: #ffffff !important;
        }
        [data-theme="dark"] .leaflet-popup-content p {
            color: #94a3b8 !important;
        }
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
        }
        [data-theme="dark"] .leaflet-popup-tip {
            background: #15181f !important;
        }
        [data-theme="dark"] .leaflet-popup-content p {
            color: #9ca3af !important;
        }
        [data-theme="dark"] .leaflet-popup-content a {
            color: #ffffff !important;
        }

        /* Proximity & Location GPS Controls in Dark Mode */
        [data-theme="dark"] .proximity-toolbar {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }
        [data-theme="dark"] .btn-use-gps {
            background: #2563eb !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }
        [data-theme="dark"] .btn-use-gps:hover {
            background: #1d4ed8 !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        [data-theme="dark"] .btn-use-gps.active {
            background: #059669 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.45);
        }
        [data-theme="dark"] .gps-status-indicator {
            color: #cbd5e1 !important;
        }

        /* Zone Pills in Dark Mode */
        [data-theme="dark"] .zone-pill {
            background: #1e232e;
            color: #e5e7eb;
            border: 1px solid rgba(255, 255, 255, 0.14);
        }
        [data-theme="dark"] .zone-pill:hover {
            background: #2b3240;
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.25);
        }
        [data-theme="dark"] .zone-pill.active {
            background: var(--accent) !important;
            color: #ffffff !important;
            border-color: var(--accent) !important;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.4);
        }

        /* Category Filter Pills in Dark Mode */
        [data-theme="dark"] .filter-pill {
            background: #1e232e;
            color: #e5e7eb;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        [data-theme="dark"] .filter-pill:hover {
            background: #2b3240;
            color: #ffffff;
            border-color: var(--accent);
        }
        [data-theme="dark"] .filter-pill.active {
            background: var(--accent) !important;
            color: #ffffff !important;
            border-color: var(--accent) !important;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.4);
        }

        /* Card location badges in Dark Mode */
        [data-theme="dark"] .store-location-chip {
            color: #9ca3af;
        }
        [data-theme="dark"] .store-location-chip strong {
            color: #f3f4f6;
        }
        [data-theme="dark"] .distance-badge-pill {
            background: rgba(5, 150, 105, 0.2);
            color: #34d399;
            border: 1px solid rgba(5, 150, 105, 0.3);
        }


        /* Toggle Button Styles */
        .btn-theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 17px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            flex-shrink: 0;
        }
        .btn-theme-toggle:hover {
            transform: scale(1.08);
            border-color: var(--accent);
        }
        .btn-theme-toggle-mobile {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            margin-bottom: 8px;
            transition: all .2s ease;
        }
        .btn-theme-toggle-mobile:hover {
            border-color: var(--accent);
            background: var(--paper);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            color: var(--ink);
            background: var(--paper);
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        a { color: inherit; text-decoration: none; }
        h1, h2, h3, h4, .font-heading { font-family: 'Playfair Display', serif; }
        .shell { width: min(1260px, calc(100% - 48px)); margin: 0 auto; }

        /* Notification Banner / Toast */
        .alert-banner {
            padding: 12px 24px;
            background: #dcfce7;
            color: #166534;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            border-bottom: 1px solid #bbf7d0;
        }
        .alert-banner.info { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }

        /* Sticky Glass Header */
        .portal-header {
            position: sticky;
            top: 0;
            z-index: 900;
            background: var(--glass);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--line);
        }
        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 76px;
            gap: 20px;
        }
        .portal-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-badge {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--ink);
            color: #ffffff;
            display: grid;
            place-items: center;
            font-size: 18px;
            font-weight: 800;
        }
        .brand-text strong { display: block; font-size: 17px; font-weight: 800; letter-spacing: -.02em; }
        .brand-text small { display: block; font-size: 10.5px; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; }

        .portal-nav-links {
            display: flex;
            align-items: center;
            gap: 26px;
            font-size: 13.5px;
            font-weight: 600;
        }
        .portal-nav-links a { color: var(--muted); transition: color .2s ease; }
        .portal-nav-links a:hover, .portal-nav-links a.active { color: var(--accent); }

        .portal-auth-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn-auth-login {
            padding: 9px 18px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
        }
        .btn-auth-login:hover { border-color: var(--accent); color: var(--accent); }
        .btn-admin-panel {
            padding: 9px 18px;
            border-radius: 999px;
            background: var(--ink);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: transform .2s ease;
        }
        .btn-admin-panel:hover { transform: translateY(-2px); }

        /* User Profile Pill in Header */
        .user-profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 12px 5px 6px;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 999px;
        }
        .user-avatar-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-info-text { font-size: 12.5px; font-weight: 700; }
        .user-provider-tag {
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 999px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .tag-google { background: #fee2e2; color: #dc2626; }
        .tag-facebook { background: #dbeafe; color: #1d4ed8; }
        .tag-email { background: #f3f4f6; color: #4b5563; }
        .btn-logout {
            color: var(--muted);
            font-size: 12px;
            margin-left: 6px;
            transition: color .2s ease;
        }
        .btn-logout:hover { color: #dc2626; }

        /* HERO & GLOBAL MULTI-STORE SEARCH */
        .portal-hero {
            padding: 60px 0 45px;
            text-align: center;
            background: linear-gradient(180deg, rgba(226, 112, 78, 0.08) 0%, rgba(247, 245, 240, 0) 100%);
        }
        .hero-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: var(--card);
            border: 1px solid var(--card-border);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--accent);
            margin-bottom: 20px;
        }
        .portal-hero h1 {
            font-size: clamp(38px, 4.5vw, 60px);
            line-height: 1.08;
            letter-spacing: -.03em;
            margin-bottom: 16px;
            max-width: 820px;
            margin-left: auto;
            margin-right: auto;
        }
        .portal-hero h1 em { color: var(--accent); font-style: normal; }
        .portal-hero p {
            font-size: 16px;
            color: var(--muted);
            max-width: 640px;
            margin: 0 auto 34px;
            line-height: 1.6;
        }

        /* SEARCH BAR FORM */
        .global-search-container {
            max-width: 760px;
            margin: 0 auto;
            position: relative;
        }
        .global-search-form {
            display: flex;
            align-items: center;
            background: var(--card);
            border: 2px solid var(--ink);
            border-radius: 999px;
            padding: 6px 8px 6px 20px;
            box-shadow: 0 16px 40px rgba(0,0,0,.08);
            transition: border-color .2s ease;
        }
        .global-search-form:focus-within {
            border-color: var(--accent);
        }
        .global-search-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 15px;
            font-family: inherit;
            color: var(--ink);
            background: transparent;
        }
        .global-search-btn {
            padding: 13px 26px;
            border-radius: 999px;
            background: var(--accent);
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
            white-space: nowrap;
        }
        .global-search-btn:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }

        .popular-tags-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 16px;
            font-size: 12px;
            color: var(--muted);
        }
        .popular-tag {
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--card);
            border: 1px solid var(--card-border);
            color: var(--ink);
            cursor: pointer;
            transition: all .2s ease;
        }
        .popular-tag:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* LIVE AJAX SEARCH DROPDOWN */
        .live-search-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,.15);
            padding: 14px;
            z-index: 1000;
            display: none;
            text-align: left;
            max-height: 420px;
            overflow-y: auto;
        }
        .live-search-dropdown.open { display: block; }
        .live-search-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 12px;
            transition: background .2s ease;
            gap: 14px;
        }
        .live-search-item:hover { background: #fdf5f2; }
        .live-search-thumb {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }
        .live-search-details strong { display: block; font-size: 13.5px; }
        .live-search-details small { color: var(--muted); font-size: 11px; }
        .live-search-price { font-size: 14px; font-weight: 800; color: var(--accent); text-align: right; }
        .live-search-store-badge {
            font-size: 10.5px;
            padding: 2px 7px;
            border-radius: 999px;
            background: var(--paper);
            border: 1px solid var(--line);
        }

        /* USER AUTH BANNER (ON LOGIN) */
        .user-welcome-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            padding: 20px 24px;
            margin: 20px auto 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,.03);
            flex-wrap: wrap;
        }
        .user-welcome-info { display: flex; align-items: center; gap: 14px; }
        .user-welcome-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
        .user-welcome-info strong { font-size: 16px; display: block; }
        .user-welcome-info span { font-size: 12.5px; color: var(--muted); }

        /* SEARCH RESULTS SECTION (WHEN SEARCH IS ACTIVE) */
        .search-results-section {
            margin: 30px auto 60px;
        }
        .results-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 20px;
            flex-wrap: wrap;
        }
        .results-header-bar h2 { font-size: 26px; }
        .btn-clear-search {
            padding: 8px 16px;
            border-radius: 999px;
            background: var(--card);
            border: 1px solid var(--line);
            font-size: 12.5px;
            font-weight: 700;
            color: var(--accent);
        }
        .btn-clear-search:hover { background: var(--accent); color: #ffffff; }

        .search-results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 22px;
        }
        .search-product-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all .25s ease;
        }
        .search-product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 35px rgba(0,0,0,.08);
            border-color: var(--accent);
        }
        .search-product-thumb {
            position: relative;
            aspect-ratio: 1;
            background: #f0ebe4;
        }
        .search-product-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .search-store-badge-float {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 5px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            backdrop-filter: blur(8px);
            font-size: 11px;
            font-weight: 800;
            color: var(--ink);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,.08);
        }
        .search-product-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .search-product-body h3 { font-size: 16px; margin-bottom: 6px; }
        .search-product-body p { font-size: 12px; color: var(--muted); margin-bottom: 14px; flex-grow: 1; line-height: 1.5; }
        .search-product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid var(--line);
        }
        .search-product-price { font-size: 18px; font-weight: 800; color: var(--accent); }
        .btn-buy-store {
            padding: 8px 14px;
            border-radius: 999px;
            background: var(--ink);
            color: #ffffff;
            font-size: 11.5px;
            font-weight: 700;
            transition: background .2s ease;
        }
        .btn-buy-store:hover { background: var(--accent); }

        /* BUSINESS CATEGORIES SECTION ("MOSTRARA POR CATEGORIAS LAS EMPRESAS") */
        .companies-section {
            padding: 50px 0 80px;
        }
        .section-intro {
            margin-bottom: 28px;
        }
        .section-eyebrow {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .14em;
            color: var(--accent);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }
        .section-eyebrow::before { content:''; width: 22px; height: 2px; background: var(--accent); }
        .section-title { font-size: clamp(28px, 3.5vw, 42px); letter-spacing: -.03em; }

        /* Category Filter Pills */
        .category-filter-pills {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 6px 2px 18px;
            margin-bottom: 24px;
            scrollbar-width: none;
        }
        .category-filter-pills::-webkit-scrollbar { display: none; }
        .filter-pill {
            padding: 10px 18px;
            border-radius: 999px;
            background: var(--card);
            border: 1px solid var(--card-border);
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .filter-pill:hover { border-color: var(--accent); color: var(--accent); }
        .filter-pill.active {
            background: var(--ink);
            color: #ffffff;
            border-color: var(--ink);
        }

        /* ENTERPRISE CARDS GRID */
        .companies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(370px, 1fr));
            gap: 28px;
        }
        .company-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 22px;
            padding: 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all .3s ease;
            position: relative;
        }
        .company-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px rgba(0,0,0,.07);
            border-color: var(--accent);
        }
        .company-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
            gap: 14px;
        }
        .company-badge-logo {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            color: #ffffff;
            display: grid;
            place-items: center;
            font-size: 22px;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            box-shadow: 0 6px 16px rgba(0,0,0,.12);
            flex-shrink: 0;
        }
        .company-cat-tag {
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 999px;
            background: var(--paper);
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .06em;
        }
        .company-info h3 { font-size: 21px; margin-bottom: 6px; letter-spacing: -.02em; }
        .company-info p { font-size: 13.5px; color: var(--muted); line-height: 1.55; margin-bottom: 20px; }

        /* Preview Products of Company */
        .company-preview-strip {
            margin-bottom: 22px;
            border-top: 1px solid var(--line);
            padding-top: 16px;
        }
        .preview-strip-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }
        .preview-products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .preview-thumb-box {
            position: relative;
            aspect-ratio: 1;
            border-radius: 10px;
            overflow: hidden;
            background: #f0ede6;
            cursor: pointer;
        }
        .preview-thumb-box img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease; }
        .preview-thumb-box:hover img { transform: scale(1.1); }
        .preview-thumb-price {
            position: absolute;
            bottom: 4px;
            left: 4px;
            background: rgba(0,0,0,.7);
            color: #ffffff;
            font-size: 9.5px;
            font-weight: 700;
            padding: 2px 5px;
            border-radius: 4px;
        }

        /* Company Social & Contact Bar */
        .company-social-bar {
            margin-top: 14px;
            margin-bottom: 14px;
            padding-top: 12px;
            border-top: 1px dashed var(--line);
        }
        .company-social-label {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 8px;
        }
        .company-social-links {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
        }
        .social-icon-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--card-border);
            background: var(--paper);
            color: var(--ink);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .social-icon-btn svg {
            flex-shrink: 0;
        }
        .social-icon-btn:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }
        .social-icon-btn.btn-wa {
            color: #15803d;
            background: rgba(34, 197, 94, 0.08);
            border-color: rgba(34, 197, 94, 0.25);
        }
        .social-icon-btn.btn-wa:hover {
            background: #22c55e;
            color: #ffffff;
            border-color: #22c55e;
        }
        .social-icon-btn.btn-fb {
            color: #1d4ed8;
            background: rgba(29, 78, 216, 0.08);
            border-color: rgba(29, 78, 216, 0.25);
        }
        .social-icon-btn.btn-fb:hover {
            background: #1877f2;
            color: #ffffff;
            border-color: #1877f2;
        }
        .social-icon-btn.btn-ig {
            color: #be185d;
            background: rgba(219, 39, 119, 0.08);
            border-color: rgba(219, 39, 119, 0.25);
        }
        .social-icon-btn.btn-ig:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: #ffffff;
            border-color: transparent;
        }
        .social-icon-btn.btn-web {
            color: var(--accent);
            background: rgba(217, 107, 69, 0.08);
            border-color: rgba(217, 107, 69, 0.25);
        }
        .social-icon-btn.btn-web:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }
        .social-icon-btn.btn-map {
            color: #475569;
            background: rgba(100, 116, 139, 0.08);
            border-color: rgba(100, 116, 139, 0.25);
        }
        .social-icon-btn.btn-map:hover {
            background: #475569;
            color: #ffffff;
            border-color: #475569;
        }

        /* Company Actions */
        .company-actions-footer {
            display: flex;
            align-items: center;
            padding-top: 14px;
            border-top: 1px solid var(--line);
        }
        .btn-visit-company {
            width: 100%;
            padding: 12px 18px;
            border-radius: 999px;
            background: var(--ink);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all .2s ease;
        }
        .btn-visit-company:hover {
            background: var(--accent);
            transform: translateY(-1px);
        }

        /* AUTH MODAL (GOOGLE, FACEBOOK, CORREO) */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(17, 18, 16, 0.75);
            backdrop-filter: blur(8px);
            display: none;
            place-items: center;
            padding: 20px;
        }
        .modal-backdrop.open { display: flex; align-items: center; justify-content: center; overflow-y: auto; }
        .central-product-modal-card {
            width: min(840px, 100%);
            max-height: min(90vh, 820px);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 28px 32px 32px;
            border-radius: 26px;
            background: var(--card);
            border: 1px solid var(--line);
            position: relative;
            box-shadow: 0 25px 65px rgba(0,0,0,0.35);
            margin: auto;
        }
        .central-product-modal-card .modal-drag-indicator {
            display: none;
            width: 44px;
            height: 5px;
            border-radius: 999px;
            background: var(--line);
            margin: -8px auto 14px;
        }
        .central-product-modal-card .modal-header-actions {
            position: sticky;
            top: -12px;
            z-index: 50;
            display: flex;
            justify-content: flex-end;
            margin-bottom: -32px;
            pointer-events: none;
        }
        .central-product-modal-card .modal-close-btn {
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
        .central-product-modal-card .modal-close-btn:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            transform: scale(1.08);
        }
        .central-product-modal-card .modal-main-layout {
            display: grid;
            grid-template-columns: 1fr 1.25fr;
            gap: 28px;
            margin-top: 14px;
            margin-bottom: 10px;
        }
        .central-product-modal-card .modal-img-col {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .central-product-modal-card .modal-img-wrap {
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
        .central-product-modal-card .modal-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .central-product-modal-card .modal-badges-row {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .central-product-modal-card .modal-chip {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .central-product-modal-card .modal-chip-store { background: var(--paper); border: 1px solid var(--line); color: var(--muted); }
        .central-product-modal-card .modal-chip-stock { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .central-product-modal-card .modal-content-col { display: flex; flex-direction: column; }
        .central-product-modal-card .modal-cat-tag {
            font-size: 11.5px;
            font-weight: 800;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 4px;
            display: inline-block;
        }
        .central-product-modal-card .modal-title { font-size: clamp(20px, 2.8vw, 26px); font-weight: 800; line-height: 1.25; margin-bottom: 8px; color: var(--ink); }
        .central-product-modal-card .modal-price-row {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 14px;
        }
        .central-product-modal-card .modal-price { font-size: 28px; font-weight: 900; color: var(--accent); letter-spacing: -0.02em; }
        .central-product-modal-card .modal-price-currency { font-size: 12px; color: var(--muted); font-weight: 600; }
        .central-product-modal-card .modal-desc {
            font-size: 13.5px;
            line-height: 1.6;
            color: var(--muted);
            margin-bottom: 16px;
        }
        .central-product-modal-card .modal-zac-location-box {
            margin: 14px 0;
            padding: 12px 14px;
            background: rgba(200, 109, 99, 0.08);
            border: 1px solid rgba(200, 109, 99, 0.22);
            border-radius: 14px;
        }
        .central-product-modal-card .modal-actions-row {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 14px;
        }
        .btn-visit-store-modal {
            padding: 12px 18px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--paper);
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all .2s ease;
        }
        .btn-visit-store-modal:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .auth-modal-card {
            background: var(--card);
            border-radius: 26px;
            width: min(440px, 100%);
            padding: 36px 32px;
            position: relative;
            box-shadow: 0 25px 60px rgba(0,0,0,.3);
        }
        .modal-close-x {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--paper);
            color: var(--ink);
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 16px;
        }
        .auth-modal-title { font-size: 24px; margin-bottom: 8px; text-align: center; }
        .auth-modal-subtitle { font-size: 13px; color: var(--muted); text-align: center; margin-bottom: 24px; }

        /* Social Auth Buttons */
        .social-login-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 22px;
        }
        .btn-social-auth {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 12px 20px;
            border-radius: 999px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
            text-decoration: none;
        }
        .btn-google-auth {
            background: #ffffff;
            color: #1f2937;
            border: 1.5px solid #e5e7eb;
            box-shadow: 0 2px 6px rgba(0,0,0,.04);
        }
        .btn-google-auth:hover { background: #f9fafb; border-color: #d1d5db; transform: translateY(-1px); }
        .btn-facebook-auth {
            background: var(--fb);
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.35);
        }
        .btn-facebook-auth:hover { background: #166fe5; transform: translateY(-1px); }

        .social-back-btn {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
            padding: 0;
            transition: color .2s ease;
        }
        .social-back-btn:hover { color: var(--ink); }

        /* Social Account Item & Chooser */
        .social-account-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border: 1.5px solid var(--line);
            border-radius: 14px;
            background: var(--card);
            cursor: pointer;
            transition: all .2s ease;
            text-align: left;
            width: 100%;
        }
        .social-account-item:hover {
            border-color: var(--accent);
            background: var(--paper);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .social-account-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
        .social-account-info strong { display: block; font-size: 13.5px; color: var(--ink); }
        .social-account-info small { font-size: 11.5px; color: var(--muted); }
        .social-env-notice {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 11.5px;
            line-height: 1.45;
            margin-top: 14px;
            text-align: left;
        }
        .social-env-notice code {
            background: #dcfce7;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 10.5px;
        }

        .auth-separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: var(--muted);
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
        }
        .auth-separator::before, .auth-separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--line);
        }
        .auth-separator span { padding: 0 12px; }

        /* Email Auth Form */
        .auth-field {
            margin-bottom: 14px;
            text-align: left;
        }
        .auth-field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .auth-field input {
            width: 100%;
            padding: 11px 16px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: var(--paper);
            color: var(--ink);
            font-size: 13.5px;
            outline: none;
            transition: border-color .2s ease;
        }
        .auth-field input:focus { border-color: var(--accent); }
        .btn-submit-email-auth {
            width: 100%;
            padding: 13px;
            border-radius: 999px;
            background: var(--ink);
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            transition: background .2s ease;
        }
        .btn-submit-email-auth:hover { background: var(--accent); }

        .auth-modal-switch-text {
            margin-top: 18px;
            font-size: 12.5px;
            color: var(--muted);
            text-align: center;
        }
        .auth-modal-switch-text a {
            color: var(--accent);
            font-weight: 700;
            cursor: pointer;
        }

        /* FOOTER */
        .portal-footer {
            padding: 50px 0 30px;
            background: var(--card);
            border-top: 1px solid var(--line);
            font-size: 12.5px;
            color: var(--muted);
        }
        .portal-footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }
        .portal-footer h4 { font-size: 14px; margin-bottom: 12px; color: var(--ink); font-weight: 700; }
        .portal-footer ul { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .portal-footer-bottom {
            padding-top: 20px;
            border-top: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ======================================================== */
        /* SAAS RENTAL PLANS & BILLING TOGGLE STYLES               */
        /* ======================================================== */
        .btn-rent-nav {
            padding: 8px 16px;
            border-radius: 999px;
            background: linear-gradient(135deg, #d47a6f 0%, #ba584d 100%);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.25);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.35);
            transition: all .2s ease;
        }
        .btn-rent-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(200, 109, 99, 0.45);
        }

        .plans-section {
            padding: 70px 0 90px;
            border-top: 1px solid var(--line);
        }
        .billing-toggle-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin: 28px 0 10px;
        }
        .billing-toggle-box {
            display: inline-flex;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 999px;
            padding: 5px;
            box-shadow: 0 4px 14px rgba(0,0,0,.04);
            gap: 4px;
        }
        .billing-toggle-btn {
            padding: 9px 24px;
            border-radius: 999px;
            border: none;
            background: transparent;
            color: var(--muted);
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s ease;
        }
        .billing-toggle-btn.active {
            background: var(--ink);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }
        .annual-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            color: #047857;
            background: #d1fae5;
            padding: 4px 14px;
            border-radius: 999px;
            border: 1px solid #a7f3d0;
            animation: pulse-soft 2s infinite;
        }
        @keyframes pulse-soft {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }

        /* PLANS GRID */
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 28px;
            margin-top: 40px;
            align-items: stretch;
        }
        .plan-card {
            background: var(--card);
            border: 1.5px solid var(--card-border);
            border-radius: 26px;
            padding: 36px 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: all .3s cubic-bezier(.16, 1, .3, 1);
        }
        .plan-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(0,0,0,.08);
            border-color: var(--accent);
        }
        .plan-card-popular {
            border-color: #c86d63;
            background: linear-gradient(180deg, #ffffff 0%, #fdf6f5 100%);
            box-shadow: 0 15px 40px rgba(200, 109, 99, 0.15);
            position: relative;
        }
        .plan-popular-badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #d47a6f 0%, #ba584d 100%);
            color: #ffffff;
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 5px 16px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(200, 109, 99, 0.4);
            white-space: nowrap;
        }
        .plan-header { margin-bottom: 20px; }
        .plan-name { font-size: 24px; font-weight: 700; margin-bottom: 8px; }
        .plan-tagline { font-size: 13.5px; color: var(--muted); line-height: 1.5; min-height: 40px; }

        /* Price Wrapper */
        .plan-price-wrapper {
            margin-bottom: 24px;
            padding: 20px;
            background: var(--paper);
            border-radius: 18px;
            text-align: center;
        }
        .price-currency { font-size: 22px; font-weight: 700; color: var(--ink); vertical-align: top; margin-right: 2px; }
        .price-amount { font-size: 44px; font-weight: 800; color: var(--ink); letter-spacing: -.03em; line-height: 1; }
        .price-period { font-size: 13px; font-weight: 600; color: var(--muted); margin-left: 4px; }
        .price-subnote { font-size: 12px; color: var(--muted); margin-top: 6px; font-weight: 500; }

        .plan-divider { height: 1px; background: var(--line); margin: 0 0 22px; }

        /* Highlights */
        .plan-highlights {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }
        .highlight-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--ink);
        }
        .hl-icon { font-size: 16px; }

        /* Features List */
        .plan-features-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 32px;
            padding: 0;
        }
        .plan-features-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: var(--muted);
            line-height: 1.45;
        }
        .check-icon {
            flex-shrink: 0;
            margin-top: 2px;
            color: #059669;
        }

        /* Plan CTA Button */
        .btn-plan-cta {
            width: 100%;
            padding: 14px 20px;
            border-radius: 999px;
            border: 1.5px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .2s ease;
        }
        .btn-plan-cta:hover {
            border-color: var(--ink);
            background: var(--ink);
            color: #ffffff;
            transform: translateY(-2px);
        }
        .btn-plan-cta.btn-popular {
            background: linear-gradient(135deg, #d47a6f 0%, #ba584d 100%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(200, 109, 99, 0.35);
        }
        .btn-plan-cta.btn-popular:hover {
            box-shadow: 0 10px 25px rgba(200, 109, 99, 0.5);
            transform: translateY(-2px);
        }

        /* RENTAL MODAL STYLES */
        .rent-modal-card {
            width: min(520px, 100%);
            max-height: 90vh;
            overflow-y: auto;
        }
        .rent-modal-header { text-align: center; margin-bottom: 20px; }
        .rent-modal-pill {
            display: inline-block;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--accent);
            background: #fff3ee;
            padding: 4px 12px;
            border-radius: 999px;
            margin-bottom: 10px;
        }
        .rent-summary-box {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }
        .rent-cycle-tag {
            font-size: 11.5px;
            font-weight: 700;
            color: #059669;
            background: #d1fae5;
            padding: 3px 8px;
            border-radius: 999px;
        }
        .rent-select {
            padding: 9px 12px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 13px;
            font-weight: 600;
            outline: none;
            flex: 1;
        }
        .subdomain-input-wrap {
            display: flex;
            align-items: center;
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
        }
        .subdomain-input-wrap input {
            border: none;
            background: transparent;
            padding: 11px 14px;
            font-size: 14px;
            outline: none;
            flex: 1;
            color: var(--ink);
        }
        .subdomain-suffix {
            padding: 0 14px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            background: rgba(0,0,0,.03);
            align-self: stretch;
            display: flex;
            align-items: center;
            border-left: 1px solid var(--line);
        }
        .subdomain-preview-text {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 6px;
        }
        .subdomain-preview-text strong { color: var(--accent); }

        /* ======================================================== */
        /* PWA MOBILE INSTALL BANNER & PROXIMITY TOOLBAR          */
        /* ======================================================== */
        .pwa-install-bar {
            display: none;
            background: linear-gradient(90deg, #1e1f1c 0%, #111210 100%);
            color: #ffffff;
            padding: 12px 20px;
            border-bottom: 2px solid var(--accent);
            font-size: 13px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 16px rgba(0,0,0,.3);
        }
        .pwa-install-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        .pwa-install-btn {
            background: var(--accent);
            color: #ffffff;
            border: none;
            padding: 7px 16px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(200,109,99,0.4);
        }

        /* ZACATECAS PROXIMITY & MAP TOOLBAR */
        .zac-location-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #ffffff;
            background: linear-gradient(135deg, #d47a6f 0%, #ba584d 100%);
            padding: 5px 14px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(200,109,99,0.35);
            margin-bottom: 12px;
        }

        .proximity-toolbar {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 18px 20px;
            margin: 20px 0 28px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            box-shadow: 0 6px 20px rgba(0,0,0,.03);
        }
        .proximity-actions-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .btn-use-gps {
            padding: 10px 20px;
            border-radius: 999px;
            background: var(--ink);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
        }
        .btn-use-gps:hover {
            background: var(--accent);
            transform: translateY(-1px);
        }
        .btn-use-gps.active {
            background: #059669;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35);
        }
        .gps-status-indicator {
            font-size: 12.5px;
            color: var(--muted);
            font-weight: 600;
        }

        .zac-zones-pills {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            scrollbar-width: none;
            padding-bottom: 2px;
        }
        .zac-zones-pills::-webkit-scrollbar { display: none; }
        .zone-pill {
            padding: 6px 14px;
            border-radius: 999px;
            background: var(--paper);
            border: 1px solid var(--line);
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s ease;
        }
        .zone-pill:hover, .zone-pill.active {
            background: var(--ink);
            color: #ffffff;
            border-color: var(--ink);
        }

        /* MAP CONTAINER */
        .zac-map-section {
            margin: 24px 0 36px;
        }
        .zac-map-box {
            height: 380px;
            width: 100%;
            border-radius: 22px;
            overflow: hidden;
            border: 1.5px solid var(--card-border);
            box-shadow: 0 10px 30px rgba(0,0,0,.06);
            z-index: 10;
        }

        /* SMART SHOPPING ROUTE OPTIMIZER STYLES */
        .route-optimizer-box {
            margin-top: 18px;
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 22px 24px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        }
        .route-opt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }
        .route-opt-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--accent);
            background: rgba(200, 109, 99, 0.12);
            padding: 4px 10px;
            border-radius: 999px;
            margin-bottom: 6px;
        }
        .route-opt-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 6px;
            color: var(--ink);
        }
        .route-opt-desc {
            font-size: 13px;
            color: var(--muted);
            margin: 0;
            max-width: 720px;
            line-height: 1.45;
        }
        .route-opt-actions-top {
            display: flex;
            gap: 8px;
        }
        .btn-opt-select-all, .btn-opt-clear {
            font-size: 12px;
            font-weight: 700;
            padding: 7px 12px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--bg);
            color: var(--ink);
            cursor: pointer;
            transition: all .2s ease;
        }
        .btn-opt-select-all:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .btn-opt-clear:hover {
            border-color: #ef4444;
            color: #ef4444;
        }
        .route-stores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }
        .route-store-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: var(--bg);
            border: 1.5px solid var(--card-border);
            border-radius: 14px;
            cursor: pointer;
            transition: all .2s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            position: relative;
        }
        .route-store-chip input[type="checkbox"] {
            display: none;
        }
        .route-chip-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }
        .route-chip-info {
            flex: 1;
            min-width: 0;
        }
        .route-chip-info strong {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .route-chip-info small {
            display: block;
            font-size: 11px;
            color: var(--muted);
        }
        .route-chip-check {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1.5px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: transparent;
            transition: all .2s ease;
        }
        .route-store-chip.selected {
            border-color: var(--accent);
            background: rgba(200, 109, 99, 0.08);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(200, 109, 99, 0.15);
        }
        .route-store-chip.selected .route-chip-check {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }
        .route-opt-trigger-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }
        .btn-calculate-route {
            background: linear-gradient(135deg, var(--accent) 0%, #a8544c 100%);
            color: #fff;
            border: none;
            padding: 12px 22px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(200, 109, 99, 0.35);
            transition: all .25s ease;
        }
        .btn-calculate-route:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(200, 109, 99, 0.45);
        }
        .btn-route-gps-origin {
            background: var(--bg);
            color: var(--ink);
            border: 1.5px solid var(--line);
            padding: 11px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
        }
        .btn-route-gps-origin:hover {
            border-color: #2563eb;
            color: #2563eb;
        }
        .route-itinerary-card {
            margin-top: 20px;
            background: var(--bg);
            border: 1.5px solid var(--accent);
            border-radius: 16px;
            padding: 20px;
            animation: fadeInItinerary .35s ease-out;
        }
        @keyframes fadeInItinerary {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .itinerary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
            flex-wrap: wrap;
            border-bottom: 1px dashed var(--line);
            padding-bottom: 14px;
        }
        .itinerary-tag {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #10b981;
            background: rgba(16, 185, 129, 0.12);
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 4px;
        }
        .itinerary-header h4 {
            font-size: 16px;
            font-weight: 800;
            margin: 0;
            color: var(--ink);
        }
        .itinerary-metrics {
            display: flex;
            gap: 12px;
        }
        .metric-box {
            background: var(--card);
            padding: 8px 14px;
            border-radius: 10px;
            border: 1px solid var(--card-border);
            text-align: center;
        }
        .metric-label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--muted);
        }
        .metric-val {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: var(--accent);
        }
        .itinerary-timeline {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 18px;
        }
        .itinerary-stop {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 14px;
            background: var(--card);
            border-radius: 12px;
            border: 1px solid var(--card-border);
            position: relative;
        }
        .stop-number-badge {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(200, 109, 99, 0.35);
        }
        .stop-info {
            flex: 1;
        }
        .stop-title {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 2px;
        }
        .stop-meta {
            font-size: 11.5px;
            color: var(--muted);
            line-height: 1.4;
        }
        .stop-distance-pill {
            font-size: 10.5px;
            font-weight: 700;
            color: #2563eb;
            background: rgba(37, 99, 235, 0.1);
            padding: 2px 7px;
            border-radius: 6px;
            margin-top: 4px;
            display: inline-block;
        }
        .itinerary-actions-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn-itinerary-gmaps {
            background: #1a73e8;
            color: #fff;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s ease;
        }
        .btn-itinerary-gmaps:hover {
            background: #1557b0;
            color: #fff;
        }
        .btn-itinerary-wa {
            background: #25d366;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-itinerary-reset {
            background: transparent;
            border: 1px solid var(--line);
            color: var(--muted);
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-itinerary-reset:hover {
            color: var(--ink);
            border-color: var(--ink);
        }

        /* CART-DRIVEN ROUTE OPTIMIZER STYLES */
        .btn-central-cart {
            padding: 8px 14px;
            border-radius: 999px;
            background: var(--bg);
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
            border: 1.5px solid var(--line);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s ease;
            position: relative;
        }
        .btn-central-cart:hover {
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-1px);
        }
        .central-cart-badge {
            background: var(--accent);
            color: #fff;
            border-radius: 999px;
            padding: 1px 7px;
            font-size: 11px;
            font-weight: 800;
        }
        .cart-route-items-container {
            margin-bottom: 16px;
        }
        .cart-route-card {
            background: var(--bg);
            border: 1.5px solid rgba(200, 109, 99, 0.35);
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 14px;
        }
        .cart-route-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 14px;
            border-bottom: 1px dashed var(--line);
            padding-bottom: 12px;
        }
        .cart-badge-count {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(200, 109, 99, 0.12);
            color: var(--accent);
            font-size: 12.5px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 8px;
        }
        .cart-subtotal-text {
            font-size: 13.5px;
            color: var(--ink);
        }
        .cart-store-group {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 10px;
        }
        .cart-store-group-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 6px;
        }
        .cart-store-info strong {
            font-size: 13px;
            color: var(--ink);
            display: block;
        }
        .cart-store-info small {
            font-size: 11px;
            color: var(--muted);
        }
        .cart-store-products-grid {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .cart-prod-row {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 6px 10px;
        }
        .cart-prod-row img {
            width: 38px;
            height: 38px;
            border-radius: 6px;
            object-fit: cover;
        }
        .cart-prod-meta {
            flex: 1;
            min-width: 0;
        }
        .cart-prod-name {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--ink);
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .cart-prod-price {
            font-size: 11.5px;
            color: var(--muted);
        }
        .cart-prod-qty-ctrl {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .cart-prod-qty-ctrl button {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 12px;
            font-weight: 700;
        }
        .cart-prod-qty-ctrl button:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .cart-prod-qty-ctrl span {
            font-size: 12px;
            font-weight: 700;
            min-width: 16px;
            text-align: center;
        }
        .cart-prod-qty-ctrl .btn-del-item {
            border-color: transparent;
            background: transparent;
            font-size: 13px;
            cursor: pointer;
        }
        .cart-prod-qty-ctrl .btn-del-item:hover {
            color: #ef4444;
        }
        .cart-route-empty {
            background: var(--bg);
            border: 1.5px dashed var(--line);
            border-radius: 16px;
            padding: 24px 20px;
            text-align: center;
        }
        .cart-empty-icon {
            font-size: 36px;
            margin-bottom: 6px;
        }
        .cart-route-empty h4 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px;
            color: var(--ink);
        }
        .cart-route-empty p {
            font-size: 12.5px;
            color: var(--muted);
            margin: 0 auto;
            max-width: 480px;
            line-height: 1.45;
        }
        .btn-seed-sample-cart {
            background: linear-gradient(135deg, var(--accent) 0%, #ba584d 100%);
            color: #fff;
            border: none;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(200, 109, 99, 0.3);
            transition: all .2s ease;
        }
        .btn-seed-sample-cart:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(200, 109, 99, 0.4);
        }
        .btn-explore-stores-scroll {
            background: var(--card);
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 9px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
        }
        .btn-explore-stores-scroll:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .btn-add-cart-route-modal {
            background: rgba(200, 109, 99, 0.12);
            color: var(--accent);
            border: 1.5px solid var(--accent);
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .2s ease;
            width: 100%;
            margin-top: 8px;
        }
        .btn-add-cart-route-modal:hover {
            background: var(--accent);
            color: #fff;
        }
        .itinerary-cart-box {
            background: rgba(200, 109, 99, 0.06);
            border: 1px solid rgba(200, 109, 99, 0.2);
            border-radius: 10px;
            padding: 8px 12px;
            margin-top: 8px;
        }
        .itinerary-cart-header {
            display: flex;
            justify-content: space-between;
            font-size: 11.5px;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 6px;
        }
        .itinerary-cart-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .itinerary-cart-list li {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11.5px;
            color: var(--ink);
        }
        .itinerary-prod-thumb {
            width: 22px;
            height: 22px;
            border-radius: 4px;
            object-fit: cover;
        }
        .itinerary-prod-info {
            flex: 1;
        }
        .itinerary-prod-total {
            font-weight: 700;
            color: var(--ink);
        }
        .route-chip-cart-badge {
            background: var(--accent);
            color: #fff;
            border-radius: 999px;
            font-size: 9.5px;
            font-weight: 800;
            padding: 1px 6px;
            margin-left: auto;
        }

        /* QUICK ADD ON PRODUCT THUMBNAIL */
        .preview-thumb-box {
            position: relative;
        }
        .preview-quick-add-btn {
            position: absolute;
            top: 6px;
            right: 6px;
            background: rgba(200, 109, 99, 0.94);
            color: #fff;
            border: none;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.25);
            transition: all .18s ease;
            z-index: 2;
        }
        .preview-quick-add-btn:hover {
            background: #ba584d;
            transform: scale(1.08);
        }
        .search-quick-add-btn {
            background: rgba(200, 109, 99, 0.12);
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .2s ease;
            margin-top: 6px;
            width: 100%;
            justify-content: center;
        }
        .search-quick-add-btn:hover {
            background: var(--accent);
            color: #fff;
        }

        /* FLOATING ROUTE CART BAR */
        .floating-route-cart-bar {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 999;
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            color: #fff;
            padding: 10px 18px;
            border-radius: 999px;
            border: 1.5px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all .25s cubic-bezier(0.16, 1, 0.3, 1);
            max-width: 92vw;
        }
        .floating-route-cart-bar:hover {
            transform: translateX(-50%) translateY(-2px);
            box-shadow: 0 12px 38px rgba(200, 109, 99, 0.5);
            border-color: var(--accent);
        }
        .floating-cart-inner {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            justify-content: space-between;
        }
        .floating-cart-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .floating-cart-icon {
            font-size: 20px;
        }
        .floating-cart-info strong {
            font-size: 13px;
            color: #fff;
            display: block;
        }
        .floating-cart-info small {
            font-size: 11px;
            color: #cbd5e1;
        }
        .floating-cart-action {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .floating-cart-total {
            font-size: 13px;
            font-weight: 800;
            color: #fcd34d;
            white-space: nowrap;
        }
        .btn-floating-route-cta {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        /* MINIMALIST ROUTE TOGGLE BAR & COMPACT PANEL */
        .route-panel-toggle-wrapper {
            margin: 12px 0 0 0;
            display: flex;
            justify-content: center;
        }
        .btn-toggle-route-panel {
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 999px;
            padding: 8px 18px;
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all .2s ease;
        }
        .btn-toggle-route-panel:hover, .btn-toggle-route-panel.active {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--bg);
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.18);
        }
        .route-toggle-left {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .route-toggle-right {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--muted);
        }
        .btn-toggle-route-panel.active .route-toggle-right {
            color: var(--accent);
        }
        .route-cart-badge-pill {
            background: var(--accent);
            color: #fff;
            padding: 1px 8px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 800;
        }
        .toggle-arrow {
            font-size: 11px;
            transition: transform .2s ease;
        }

        /* MINIMALIST ROUTE OPTIMIZER HEADER */
        .route-opt-header-minimal {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            margin-bottom: 12px;
            border-bottom: 1px dashed var(--line);
            flex-wrap: wrap;
            gap: 8px;
        }
        .btn-opt-close-min {
            background: transparent;
            border: 1px solid var(--line);
            color: var(--muted);
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s ease;
        }
        .btn-opt-close-min:hover {
            border-color: var(--ink);
            color: var(--ink);
        }
        .btn-opt-clear-min {
            background: transparent;
            border: 1px solid transparent;
            color: #ef4444;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s ease;
        }
        .btn-opt-clear-min:hover {
            background: rgba(239, 68, 68, 0.08);
        }

        /* MINIMALIST EMPTY CART STATE */
        .cart-route-empty-min {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            padding: 12px 16px;
            background: var(--bg);
            border: 1px dashed var(--line);
            border-radius: 12px;
        }
        .btn-seed-sample-cart-min {
            background: rgba(200, 109, 99, 0.12);
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 800;
            cursor: pointer;
            transition: all .2s ease;
            white-space: nowrap;
        }
        .btn-seed-sample-cart-min:hover {
            background: var(--accent);
            color: #fff;
        }

        /* ROUTE ORIGIN CONTROLS BAR (MINIMAL) */
        .route-origin-bar {
            background: rgba(37, 99, 235, 0.04);
            border: 1px solid rgba(37, 99, 235, 0.18);
            border-radius: 10px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        .btn-route-origin-pill {
            background: var(--card);
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .2s ease;
        }
        .btn-route-origin-pill:hover, .btn-route-origin-pill.active {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }

        @keyframes pulseGps {
            0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7); }
            70% { box-shadow: 0 0 0 14px rgba(37, 99, 235, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
        }

        /* STORE CARD LOCATION SPECIFICS */
        .store-location-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            color: var(--muted);
            margin: 8px 0 12px;
            font-weight: 600;
        }
        .distance-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 999px;
            background: #d1fae5;
            color: #065f46;
            margin-bottom: 8px;
            align-self: flex-start;
        }

        /* REPUTATION, RATINGS & TRADITION CHIPS */
        .store-rating-row {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            margin: 4px 0 6px;
        }
        .stars-gold {
            color: #f59e0b;
            font-size: 13px;
            letter-spacing: 1px;
        }
        .rating-score, .rating-num {
            font-weight: 800;
            color: var(--ink);
            font-size: 12px;
        }
        .reviews-count, .rating-count {
            color: var(--muted);
            font-size: 11px;
        }
        .tradition-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
            background: rgba(200, 109, 99, 0.1);
            color: var(--accent);
            border: 1px solid rgba(200, 109, 99, 0.25);
            margin-bottom: 8px;
            align-self: flex-start;
        }

        /* REAL-TIME OPEN / CLOSED STATUS BADGES */
        .store-hours-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
            background: var(--paper);
            padding: 8px 12px;
            border-radius: 12px;
            border: 1px solid var(--line);
            margin-bottom: 14px;
        }
        .store-hours-info {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            flex: 1;
            min-width: 150px;
        }
        .hours-text {
            color: var(--ink);
            font-weight: 700;
        }
        .store-open-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 999px;
            white-space: nowrap;
            flex-shrink: 0;
            line-height: 1.2;
        }
        .store-open-badge .dot,
        .store-open-badge .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }
        .store-open-badge.badge-open,
        .store-open-badge.status-open {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .store-open-badge.badge-open .dot,
        .store-open-badge.status-open .status-dot {
            background: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
            animation: pulseDot 2s infinite;
        }
        .store-open-badge.badge-closed,
        .store-open-badge.status-closed {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .store-open-badge.badge-closed .dot,
        .store-open-badge.status-closed .status-dot {
            background: #ef4444;
        }
        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        /* WALKING RADIUS FILTER PILLS */
        .walking-radius-row {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 10px 0 6px;
            border-top: 1px dashed var(--line);
        }
        .walking-radius-row::-webkit-scrollbar { display: none; }
        .walking-radius-label {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .radius-pill {
            padding: 6px 14px;
            border-radius: 999px;
            background: var(--paper);
            border: 1px solid var(--line);
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .radius-pill:hover, .radius-pill.active {
            background: var(--ink);
            color: #ffffff;
            border-color: var(--ink);
        }
        .filter-only-open {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid #10b981;
            background: #ecfdf5;
            color: #065f46;
            white-space: nowrap;
            flex-shrink: 0;
            transition: all 0.2s ease;
            margin-left: 4px;
        }
        .filter-only-open.active {
            background: #059669;
            color: #ffffff;
        }

        /* FLOATING BACK TO TOP BUTTON */
        .btn-back-to-top {
            position: fixed;
            bottom: 24px;
            left: 24px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--card);
            border: 1.5px solid var(--card-border);
            color: var(--accent);
            font-size: 20px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(0,0,0,0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 998;
            opacity: 0;
            pointer-events: none;
            transform: translateY(12px);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-back-to-top.visible {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
        .btn-back-to-top:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(200, 109, 99, 0.35);
        }

        /* WEB SHARE BUTTONS */
        .btn-share-header {
            width: 40px;
            height: 40px;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            flex-shrink: 0;
        }
        .btn-share-header:hover {
            transform: scale(1.08);
            border-color: var(--accent);
            color: var(--accent);
        }
        .btn-share-card {
            background: var(--paper);
            border: 1px solid var(--line);
            color: var(--ink);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-share-card:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--card);
        }

        /* LANGUAGE SELECTOR PILL */
        .btn-lang-toggle {
            height: 38px;
            padding: 0 12px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            flex-shrink: 0;
        }
        .btn-lang-toggle:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* TOAST NOTIFICATION */
        .toast-popup {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: #111210;
            color: #ffffff;
            border: 1px solid var(--accent);
            padding: 10px 22px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 10002;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .toast-popup.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* PWA MOBILE INSTALL BAR & FLOATING BADGE */
        .pwa-install-bar {
            display: none;
            background: linear-gradient(135deg, #111210 0%, #1f221e 100%);
            color: #ffffff;
            border-bottom: 2px solid var(--accent);
            padding: 12px 16px;
            position: sticky;
            top: 0;
            z-index: 9999;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
        }
        .pwa-install-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        .pwa-install-btn {
            background: linear-gradient(135deg, #d47a6f 0%, #ba584d 100%);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 9px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s ease;
        }
        .pwa-install-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(226, 112, 78, 0.5);
        }
        .floating-pwa-badge {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999;
            background: #111210;
            color: #ffffff;
            border: 1.5px solid var(--accent);
            padding: 10px 18px;
            border-radius: 999px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s ease;
        }
        .floating-pwa-badge:hover {
            transform: scale(1.05);
            background: var(--accent);
        }

        /* ======================================================== */
        /* COMPREHENSIVE RESPONSIVE DESIGN (MOBILE & TABLET)        */
        /* ======================================================== */
        
        /* Mobile menu hamburger button (Modern Pill Style) */
        .btn-mobile-menu {
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
        .btn-mobile-menu:hover {
            border-color: var(--accent);
            background: var(--card);
            transform: translateY(-1px);
        }
        .btn-mobile-menu-bars {
            display: flex;
            flex-direction: column;
            gap: 4px;
            width: 18px;
        }
        .btn-mobile-menu .bar {
            width: 100%;
            height: 2px;
            background: var(--ink);
            border-radius: 2px;
            transition: all .25s ease;
        }
        .btn-mobile-menu.active .bar:nth-child(1) {
            transform: translateY(6px) rotate(45deg);
        }
        .btn-mobile-menu.active .bar:nth-child(2) {
            opacity: 0;
        }
        .btn-mobile-menu.active .bar:nth-child(3) {
            transform: translateY(-6px) rotate(-45deg);
        }
        .mobile-menu-label {
            font-size: 13px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.01em;
        }

        /* Backdrop overlay for mobile navigation drawer */
        .mobile-drawer-backdrop {
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
        .mobile-drawer-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* Slide-over Mobile Navigation Drawer */
        .portal-mobile-menu {
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
        .portal-mobile-menu.open {
            transform: translateX(0);
        }

        /* Drawer Header */
        .drawer-header {
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
        .drawer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .drawer-logo-badge {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            overflow: hidden;
            border: 1.5px solid var(--card-border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: grid;
            place-items: center;
            background: #ffffff;
            flex-shrink: 0;
        }
        .drawer-logo-badge img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .drawer-brand strong {
            display: block;
            font-size: 15px;
            font-weight: 800;
            color: var(--ink);
            line-height: 1.2;
        }
        .drawer-brand small {
            display: block;
            font-size: 10.5px;
            color: var(--accent);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.04em;
        }
        .btn-drawer-close {
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
        .btn-drawer-close:hover {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            transform: scale(1.08);
        }

        /* User / Guest Status inside Drawer */
        .drawer-user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            background: var(--paper);
            border-bottom: 1px solid var(--line);
        }
        .drawer-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid var(--accent);
        }
        .drawer-user-info {
            flex: 1;
            min-width: 0;
        }
        .drawer-user-info strong {
            display: block;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .drawer-user-badge {
            font-size: 11px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }
        .btn-drawer-logout {
            font-size: 11.5px;
            font-weight: 700;
            color: #dc2626;
            background: rgba(220, 38, 38, 0.1);
            padding: 5px 12px;
            border-radius: 999px;
            transition: all 0.2s ease;
        }
        .btn-drawer-logout:hover {
            background: #dc2626;
            color: #ffffff;
        }
        .drawer-guest-box {
            padding: 14px 20px;
            background: var(--paper);
            border-bottom: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .drawer-guest-box span {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--muted);
        }
        .btn-drawer-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 9px 14px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-drawer-login:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* Drawer Nav List Cards */
        .drawer-section-title {
            padding: 16px 20px 8px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
        }
        .mobile-nav-list {
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
        }
        .drawer-nav-item:hover, .drawer-nav-item:active {
            border-color: var(--accent);
            transform: translateX(3px);
            background: var(--card);
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.12);
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

        /* Drawer Footer Actions */
        .drawer-footer-actions {
            margin-top: auto;
            padding: 16px 20px 24px;
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
        .btn-rent-drawer {
            width: 100%;
            padding: 13px;
            border-radius: 12px;
            background: linear-gradient(135deg, #d47a6f 0%, #ba584d 100%);
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 800;
            border: 1px solid rgba(255, 255, 255, 0.25);
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(200, 109, 99, 0.35);
            text-align: center;
            display: block;
            transition: all 0.2s ease;
        }
        .btn-rent-drawer:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(200, 109, 99, 0.45);
        }
        .drawer-brand-footer {
            text-align: center;
            margin-top: 6px;
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

        /* Responsive Breakpoints */
        @media (max-width: 980px) {
            .portal-nav-links { display: none; }
            .btn-mobile-menu { display: inline-flex; }
            .companies-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
            .plans-grid { grid-template-columns: repeat(2, 1fr); }
            .portal-footer-grid { grid-template-columns: repeat(2, 1fr); gap: 30px; }
        }

        @media (max-width: 768px) {
            .shell { width: calc(100% - 24px); }
            .portal-header {
                padding-top: max(6px, env(safe-area-inset-top));
            }
            .header-inner {
                min-height: 58px;
                gap: 8px;
            }
            .portal-brand {
                min-width: 0;
                gap: 8px;
            }
            .portal-brand strong { font-size: 14.5px; white-space: nowrap; }
            .portal-brand small { display: none; }
            
            /* Clean up top header in mobile: brand on left, theme and menu drawer on right */
            .btn-rent-nav,
            .btn-admin-panel,
            .btn-lang-toggle,
            .btn-share-header,
            .btn-auth-login,
            .user-profile-pill {
                display: none !important;
            }
            .portal-auth-actions {
                gap: 6px;
                flex-shrink: 0;
            }
            .btn-theme-toggle {
                width: 36px;
                height: 36px;
                font-size: 15px;
            }
            .btn-mobile-menu {
                display: inline-flex;
                height: 36px;
                padding: 0 10px;
                gap: 5px;
                border-radius: 999px;
            }
            .btn-mobile-menu-bars {
                width: 15px;
                height: 11px;
            }
            .mobile-menu-label {
                font-size: 12px;
            }
            
            .portal-hero { padding: 32px 0 20px; }
            .portal-hero h1 { font-size: clamp(24px, 5.5vw, 36px); }
            .portal-hero p { font-size: 13.5px; margin-bottom: 20px; }
            
            .companies-grid { grid-template-columns: 1fr; gap: 16px; }
            .company-card { padding: 18px 16px; border-radius: 18px; }
            
            .plans-grid { grid-template-columns: 1fr; max-width: 440px; margin-left: auto; margin-right: auto; }
            .plan-card { padding: 24px 18px; }
            
            .search-results-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .search-product-body { padding: 10px; }
            .search-product-body h3 { font-size: 13px; }
            .search-product-body p { display: none; }
            .search-product-price { font-size: 15px; }
            .btn-buy-store { font-size: 10px; padding: 5px 8px; }
            
            .proximity-actions-row { flex-direction: column; align-items: stretch; gap: 8px; }
            .btn-use-gps { width: 100%; justify-content: center; }
            .gps-status-indicator { text-align: center; }
            .zac-map-box { height: 290px; border-radius: 16px; }
            
            /* PWA Install prompts */
            .pwa-install-bar { display: block; }
            .pwa-install-inner { flex-direction: column; text-align: center; gap: 10px; }
            .floating-pwa-badge { display: none !important; }
            .btn-back-to-top { bottom: 20px; right: 16px; left: auto; width: 42px; height: 42px; }
        }

        @media (max-width: 540px) {
            .mobile-menu-label { display: none; }
            .btn-mobile-menu { width: 36px; height: 36px; padding: 0; justify-content: center; }

            .search-btn-text { display: none; }
            .global-search-btn::after { content: 'Buscar'; }
            .global-search-form { padding: 4px 6px 4px 12px; }
            .global-search-input { font-size: 14px; }
            
            .search-results-grid { grid-template-columns: 1fr; }
            
            .company-actions-footer {
                width: 100%;
                display: flex;
                align-items: center;
                gap: 8px;
                padding-top: 12px;
            }
            .btn-visit-company {
                flex: 1;
                min-width: 0;
                width: auto !important;
                justify-content: center;
                padding: 10px 14px;
                font-size: 12.5px;
            }
            .btn-share-card {
                flex-shrink: 0;
                width: 38px;
                height: 38px;
            }

            .company-social-links {
                gap: 5px;
            }
            .social-icon-btn {
                padding: 4px 7px;
                font-size: 11px;
                border-radius: 6px;
            }
            .social-icon-btn span {
                font-size: 10.5px;
            }
            
            .billing-toggle-box { width: 100%; justify-content: center; }
            .billing-toggle-btn { padding: 7px 12px; font-size: 12px; flex: 1; text-align: center; }
            .annual-badge-pill { font-size: 10.5px; padding: 3px 8px; text-align: center; }
            
            .portal-footer-grid { grid-template-columns: 1fr; gap: 24px; }
            .portal-footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
            
            .auth-modal-card, .rent-modal-card { padding: 22px 16px; border-radius: 20px; }
            .auth-modal-title { font-size: 20px; }

            .central-product-modal-card {
                padding: 14px 16px max(24px, env(safe-area-inset-bottom));
                width: 100%;
                max-height: 88vh;
                border-radius: 24px 24px 0 0;
                box-shadow: 0 -10px 40px rgba(0,0,0,0.5);
                margin: 0;
            }
            .central-product-modal-card .modal-drag-indicator { display: block; }
            .central-product-modal-card .modal-header-actions {
                top: -8px;
                margin-bottom: -28px;
            }
            .central-product-modal-card .modal-close-btn { width: 34px; height: 34px; font-size: 15px; }
            .central-product-modal-card .modal-main-layout {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-top: 6px;
            }
            .central-product-modal-card .modal-img-wrap {
                aspect-ratio: 16 / 10;
                max-height: 210px;
                border-radius: 16px;
            }
            .central-product-modal-card .modal-title { font-size: 20px; line-height: 1.25; }
            .central-product-modal-card .modal-price { font-size: 24px; }
        }

        @media (max-width: 380px) {
            .global-search-btn::after { display: none; }
            .global-search-btn { padding: 10px 14px; }
            .brand-badge { width: 32px; height: 32px; font-size: 16px; }
            .portal-brand strong { font-size: 13.5px; }
        }

        /* STICKY QUICK JUMP BAR */
        .portal-quick-jump-bar {
            position: sticky;
            top: 72px;
            z-index: 85;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 10px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--line);
            border-radius: 999px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            max-width: fit-content;
            overflow-x: auto;
            scrollbar-width: none;
            transition: all .2s ease;
        }
        .portal-quick-jump-bar::-webkit-scrollbar { display: none; }
        [data-theme="dark"] .portal-quick-jump-bar {
            background: rgba(20, 24, 34, 0.94);
            border-color: rgba(255, 255, 255, 0.1);
        }
        .jump-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
            text-decoration: none;
            transition: all .2s ease;
            white-space: nowrap;
            background: transparent;
            border: none;
            cursor: pointer;
        }
        .jump-pill:hover, .jump-pill.active {
            background: var(--accent);
            color: #fff;
        }

        /* HERO QUICK INTUITIVE ACTIONS */
        .hero-quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            max-width: 960px;
            margin: 24px auto 0;
            text-align: left;
        }
        @media (max-width: 900px) {
            .hero-quick-actions { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .hero-quick-actions { grid-template-columns: 1fr; }
        }
        .hero-action-card {
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            transition: all .2s ease;
            position: relative;
            text-align: left;
            width: 100%;
        }
        .hero-action-card:hover {
            transform: translateY(-2px);
            border-color: var(--accent);
            box-shadow: 0 8px 20px rgba(200, 109, 99, 0.14);
        }
        .hero-action-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .hero-action-text {
            flex: 1;
            min-width: 0;
        }
        .hero-action-text strong {
            display: block;
            font-size: 13px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 2px;
        }
        .hero-action-text p {
            font-size: 11px;
            color: var(--muted);
            margin: 0;
            line-height: 1.35;
        }
        .hero-action-arrow {
            font-size: 12px;
            color: var(--muted);
            transition: transform .2s ease, color .2s ease;
        }
        .hero-action-card:hover .hero-action-arrow {
            transform: translateX(3px);
            color: var(--accent);
        }

        /* HOW IT WORKS GUIDANCE STRIP */
        .how-it-works-strip {
            background: linear-gradient(135deg, rgba(200,109,99,0.05) 0%, rgba(37,99,235,0.03) 100%);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 20px 24px;
            margin: 8px 0 28px;
        }
        .how-it-works-header {
            text-align: center;
            max-width: 580px;
            margin: 0 auto 16px;
        }
        .how-steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }
        @media (max-width: 768px) {
            .how-steps-grid { grid-template-columns: 1fr; }
        }
        .how-step-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            transition: transform .2s ease;
        }
        .how-step-card:hover {
            transform: translateY(-2px);
        }
        .how-step-badge {
            display: inline-block;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 999px;
            margin-bottom: 6px;
        }
        .how-step-icon {
            font-size: 20px;
            margin-bottom: 6px;
        }
        .how-step-card h3 {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--ink);
            margin: 0 0 4px;
        }
        .how-step-card p {
            font-size: 11.5px;
            color: var(--muted);
            margin: 0;
            line-height: 1.4;
        }

        /* DIRECT STORE TO MAP FOCUS BUTTON */
        .btn-focus-map-card {
            background: rgba(37, 99, 235, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.22);
            color: #2563eb;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .2s ease;
            white-space: nowrap;
        }
        .btn-focus-map-card:hover {
            background: #2563eb;
            color: #fff;
        }
        [data-theme="dark"] .btn-focus-map-card {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.4);
            color: #60a5fa;
        }
        [data-theme="dark"] .btn-focus-map-card:hover {
            background: #3b82f6;
            color: #fff;
        }

        /* ======================================================== */
        /* TIKTOK & FACEBOOK / INSTAGRAM STYLE DESIGN SYSTEM         */
        /* ======================================================== */

        /* 1. STORIES TRAY (HISTORIAS EN VIVO DE ZACATECAS) */
        .stories-tray-section {
            padding: 10px 0 6px;
            margin-bottom: 12px;
        }
        .stories-tray-scroll {
            display: flex;
            gap: 14px;
            overflow-x: auto;
            padding: 4px 2px 10px;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }
        .stories-tray-scroll::-webkit-scrollbar { display: none; }
        .story-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            background: transparent;
            border: none;
            padding: 0;
            flex-shrink: 0;
            width: 72px;
            transition: transform .18s ease;
        }
        .story-item:hover, .story-item:active {
            transform: scale(1.06);
        }
        .story-ring {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            padding: 2.5px;
            background: linear-gradient(45deg, #c86d63, #f59e0b, #ec4899, #c86d63);
            background-size: 200% 200%;
            animation: storyRingGlow 4s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(200, 109, 99, 0.22);
        }
        @keyframes storyRingGlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .story-avatar-box {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--card);
            border: 2px solid var(--card);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            overflow: hidden;
        }
        .story-avatar-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .story-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--ink);
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }

        /* 2. TIKTOK / FACEBOOK MAIN SEGMENTED TABS */
        .main-tab-nav-wrapper {
            position: sticky;
            top: 68px;
            z-index: 80;
            background: var(--paper);
            padding: 6px 0;
            margin-bottom: 16px;
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .main-tab-switcher {
            display: flex;
            gap: 8px;
            justify-content: center;
            overflow-x: auto;
            scrollbar-width: none;
            padding: 2px 0;
        }
        .main-tab-switcher::-webkit-scrollbar { display: none; }
        .main-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            color: var(--muted);
            background: var(--card);
            border: 1px solid var(--line);
            cursor: pointer;
            transition: all .2s ease;
            white-space: nowrap;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .main-tab-btn:hover {
            color: var(--ink);
            border-color: var(--accent);
        }
        .main-tab-btn.active {
            background: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.28);
        }
        .tab-badge {
            background: rgba(255,255,255,0.25);
            padding: 1px 7px;
            border-radius: 999px;
            font-size: 10.5px;
        }
        .main-tab-btn:not(.active) .tab-badge {
            background: var(--line);
            color: var(--muted);
        }

        /* 3. LEGACY FEED STREAM */
        .legacy-feed-stream {
            max-width: 620px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .social-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0,0,0,0.04);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .social-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .social-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
        }
        .social-card-user {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: inherit;
        }
        .social-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .social-user-info strong {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13.5px;
            font-weight: 800;
            color: var(--ink);
        }
        .verified-check {
            color: #2563eb;
            font-size: 12px;
        }
        .social-user-info small {
            display: block;
            font-size: 11px;
            color: var(--muted);
        }
        .social-card-media {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            background: #0b0e14;
            cursor: pointer;
            overflow: hidden;
        }
        .social-card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }
        .social-card-media:hover img {
            transform: scale(1.03);
        }
        .social-price-float {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(18, 22, 32, 0.88);
            backdrop-filter: blur(8px);
            color: #ffffff;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 4px 12px rgba(0,0,0,0.35);
        }
        .social-heart-pop {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 72px;
            opacity: 0;
            pointer-events: none;
            transform: scale(0.4);
            transition: all .4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .social-heart-pop.animate {
            opacity: 1;
            transform: scale(1.2);
        }
        .social-actions-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            border-bottom: 1px solid var(--line);
        }
        .social-left-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .btn-social-action {
            background: transparent;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
            padding: 4px;
            transition: transform .15s ease, color .15s ease;
        }
        .btn-social-action:hover {
            transform: scale(1.08);
        }
        .btn-social-action.liked {
            color: #ef4444;
        }
        .btn-social-add-cart {
            background: var(--accent);
            color: #ffffff;
            border: none;
            padding: 7px 15px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all .2s ease;
            box-shadow: 0 2px 8px rgba(200, 109, 99, 0.28);
        }
        .btn-social-add-cart:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }
        .social-card-body {
            padding: 12px 16px 14px;
        }
        .social-card-body h4 {
            font-size: 14.5px;
            font-weight: 800;
            color: var(--ink);
            margin: 0 0 4px;
        }
        .social-card-body p {
            font-size: 12px;
            color: var(--muted);
            margin: 0 0 8px;
            line-height: 1.45;
        }
        .social-card-store-link {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--accent);
            text-decoration: underline;
        }

        /* 4. NATIVE MOBILE BOTTOM NAVIGATION BAR */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 62px;
            background: var(--card);
            border-top: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-around;
            z-index: 9990;
            padding-bottom: max(4px, env(safe-area-inset-bottom));
            box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }
        [data-theme="dark"] .mobile-bottom-nav {
            background: rgba(20, 24, 34, 0.96);
            border-color: rgba(255, 255, 255, 0.1);
        }
        .bottom-nav-tab {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            background: transparent;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 6px 0;
            text-decoration: none;
            position: relative;
            transition: all .15s ease;
        }
        .bottom-nav-tab.active {
            color: var(--accent);
            font-weight: 800;
        }
        .bottom-nav-icon {
            font-size: 19px;
            line-height: 1;
            transition: transform .15s ease;
        }
        .bottom-nav-tab:active .bottom-nav-icon,
        .bottom-nav-tab.active .bottom-nav-icon {
            transform: scale(1.15);
        }
        .bottom-nav-label {
            font-size: 10px;
            font-weight: 700;
            line-height: 1;
        }
        .bottom-nav-badge {
            position: absolute;
            top: 3px;
            right: calc(50% - 18px);
            background: #ef4444;
            color: #ffffff;
            font-size: 9px;
            font-weight: 900;
            padding: 1px 5px;
            border-radius: 999px;
            border: 1.5px solid var(--card);
        }
        body {
            padding-bottom: 74px;
        }

        /* 5. TIKTOK / INSTAGRAM STORIES VIEWER MODAL */
        .story-viewer-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 10000;
            background: rgba(0, 0, 0, 0.94);
            backdrop-filter: blur(10px);
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .story-viewer-content {
            position: relative;
            max-width: 400px;
            width: 100%;
            height: 82vh;
            max-height: 700px;
            background: #000;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7);
            display: flex;
            flex-direction: column;
        }
        .story-progress-bar-wrap {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            z-index: 10;
            height: 3px;
            background: rgba(255,255,255,0.3);
            border-radius: 999px;
            overflow: hidden;
        }
        .story-progress-bar-fill {
            height: 100%;
            width: 0%;
            background: #ffffff;
            transition: width 5s linear;
        }
        .story-header-bar {
            position: absolute;
            top: 22px;
            left: 14px;
            right: 14px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .story-store-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            text-shadow: 0 1px 4px rgba(0,0,0,0.8);
        }
        .story-store-brand .story-brand-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            background: #c86d63;
        }
        .btn-close-story {
            background: rgba(0,0,0,0.5);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 16px;
            cursor: pointer;
        }
        .story-media-main {
            flex: 1;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .story-caption-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px 18px 24px;
            background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, transparent 100%);
            color: #fff;
            z-index: 10;
        }
        .story-caption-overlay h3 {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 6px;
        }
        .story-caption-overlay p {
            font-size: 12.5px;
            color: rgba(255,255,255,0.88);
            margin: 0 0 14px;
            line-height: 1.4;
        }
        .btn-story-cta {
            display: block;
            text-align: center;
            background: #c86d63;
            color: #fff;
            padding: 12px 20px;
            border-radius: 999px;
            font-weight: 800;
            text-decoration: none;
            font-size: 13.5px;
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.4);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-story-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(200, 109, 99, 0.55);
        }

        /* --- STORY CREATION & TRAY ENHANCEMENTS --- */
        .story-create-item {
            cursor: pointer;
        }
        .story-create-ring {
            background: linear-gradient(135deg, #cbd5e1, #94a3b8) !important;
            border: 2px dashed rgba(200, 109, 99, 0.8) !important;
            padding: 2px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
        }
        .story-create-box {
            background: linear-gradient(135deg, #faeae7, #ffffff) !important;
            display: grid !important;
            place-items: center !important;
        }
        [data-theme="dark"] .story-create-box {
            background: linear-gradient(135deg, #2a1e23, #1e2430) !important;
        }
        .story-create-icon {
            font-size: 24px;
            color: #c86d63;
            filter: drop-shadow(0 2px 4px rgba(200,109,99,0.3));
            transition: transform 0.2s ease;
        }
        .story-create-item:hover .story-create-icon {
            transform: scale(1.2) rotate(90deg);
        }
        .story-count-badge {
            position: absolute;
            bottom: -2px;
            right: -2px;
            background: #c86d63;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            width: 19px;
            height: 19px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            border: 2px solid var(--paper);
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        }
        .story-ring.story-viewed {
            background: #cbd5e1 !important;
            opacity: 0.75;
        }

        /* --- MULTI-SEGMENT STORY VIEWER --- */
        .story-segments-row {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            gap: 4px;
            padding: 12px 14px 6px;
            z-index: 20;
        }
        .story-segment-bar {
            flex: 1;
            height: 3.5px;
            background: rgba(255, 255, 255, 0.35);
            border-radius: 999px;
            overflow: hidden;
        }
        .story-segment-fill {
            height: 100%;
            width: 0%;
            background: #ffffff;
            border-radius: 999px;
            transition: width 0.1s linear;
        }
        .story-segment-fill.completed {
            width: 100% !important;
            transition: none !important;
        }
        .story-touch-nav {
            position: absolute;
            top: 55px;
            bottom: 140px;
            z-index: 8;
            -webkit-tap-highlight-color: transparent;
        }
        .story-touch-nav.left {
            left: 0;
            width: 35%;
            cursor: pointer;
        }
        .story-touch-nav.right {
            right: 0;
            width: 65%;
            cursor: pointer;
        }
        .story-views-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(6px);
            color: #fff;
            padding: 3px 8px;
            border-radius: 999px;
        }
        .story-quick-chat-row {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-top: 10px;
        }
        .story-quick-chat-input {
            flex: 1;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 999px;
            color: #fff;
            padding: 9px 16px;
            font-size: 12.5px;
            outline: none;
        }
        .story-quick-chat-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* --- CREATE STORY MODAL --- */
        .create-story-modal-card {
            background: var(--card);
            border-radius: 24px;
            max-width: 500px;
            width: 100%;
            padding: 28px 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
            border: 1.5px solid var(--card-border);
        }
        .create-story-header {
            text-align: center;
            margin-bottom: 16px;
        }

        /* --- PRODUCT LAYOUT & SPACING COHESION --- */
        @keyframes tabFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .tab-panel-content {
            animation: tabFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Companies Grid & Product Thumbnails Uniformity */
        .companies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 24px;
        }
        .company-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 20px;
            padding: 24px;
            border: 1.5px solid var(--card-border);
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            background: var(--card);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .company-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.09);
        }

        .company-preview-strip {
            margin: 18px 0 14px;
            padding-top: 14px;
            border-top: 1px dashed var(--line);
        }
        .preview-products-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 10px !important;
            margin-top: 8px !important;
        }
        .preview-thumb-box {
            position: relative;
            aspect-ratio: 1 / 1 !important;
            height: auto !important;
            border-radius: 12px;
            overflow: hidden;
            background: var(--paper);
            border: 1.5px solid var(--card-border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .preview-thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.25s ease;
            display: block;
        }
        .preview-thumb-box:hover img {
            transform: scale(1.08);
        }
        .preview-thumb-price {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: rgba(18, 19, 17, 0.88);
            backdrop-filter: blur(4px);
            color: #ffffff;
            font-size: 10.5px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 6px;
            z-index: 2;
            pointer-events: none;
        }
        .preview-quick-add-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #c86d63;
            color: #fff;
            border: none;
            border-radius: 6px;
            width: 26px;
            height: 26px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            display: grid;
            place-items: center;
            z-index: 3;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            transition: transform 0.15s ease, background 0.15s ease;
        }
        .preview-quick-add-btn:hover {
            transform: scale(1.15);
            background: #b1554a;
        }

        /* Search Results Grid Cohesion */
        .search-results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }
        .search-product-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 18px;
            border: 1.5px solid var(--card-border);
            background: var(--card);
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .search-product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
        }
        .search-product-thumb {
            aspect-ratio: 1 / 1;
            position: relative;
            overflow: hidden;
            background: var(--paper);
        }
        .search-product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.25s ease;
        }
        .search-product-thumb:hover img {
            transform: scale(1.05);
        }

        /* Social Feed Cohesion */
        .legacy-feed-stream {
            max-width: 680px;
            margin: 0 auto 40px;
            padding: 0 4px;
        }
        .social-card {
            margin-bottom: 28px;
            border-radius: 22px;
            border: 1.5px solid var(--card-border);
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
            background: var(--card);
        }
        .social-card-media {
            aspect-ratio: 4 / 3;
            width: 100%;
            overflow: hidden;
            position: relative;
            background: #000;
        }
        .social-card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
            /* --- MOST VISITED PRODUCTS SECTION --- */
        .most-visited-section {
            margin: 32px 0 45px;
        }
        .most-visited-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            padding: 0 4px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .most-visited-tag-badge {
            font-size: 12.5px;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #c86d63, #b45b51);
            padding: 7px 16px;
            border-radius: 999px;
            box-shadow: 0 4px 12px rgba(200, 109, 99, 0.35);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .most-visited-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 22px;
        }
        .visited-product-card {
            background: var(--card);
            border-radius: 20px;
            border: 1.5px solid var(--card-border);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 18px rgba(0,0,0,0.05);
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }
        .visited-product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.1);
        }
        .visited-product-thumb {
            aspect-ratio: 1 / 1;
            position: relative;
            overflow: hidden;
            background: var(--paper);
            cursor: pointer;
        }
        .visited-product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            display: block;
        }
        .visited-product-card:hover .visited-product-thumb img {
            transform: scale(1.07);
        }
        .visited-badge-visits {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(18, 19, 17, 0.88);
            backdrop-filter: blur(8px);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 9px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.18);
            z-index: 2;
        }
        .visited-badge-store {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            color: #181d26;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 999px;
            border: 1px solid rgba(203, 213, 225, 0.8);
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            z-index: 2;
        }
        [data-theme="dark"] .visited-badge-store {
            background: rgba(20, 24, 34, 0.92);
            color: #f1f5f9;
            border-color: rgba(255,255,255,0.15);
        }
        .visited-product-body {
            padding: 16px 18px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .visited-product-cat {
            font-size: 11px;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 4px;
        }
        .visited-product-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--ink);
            margin: 0 0 8px;
            line-height: 1.35;
            cursor: pointer;
            transition: color 0.15s ease;
        }
        .visited-product-title:hover {
            color: var(--accent);
        }
        .visited-product-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 12.5px;
        }
        .stars-gold {
            color: #f59e0b;
            letter-spacing: 1px;
            font-size: 13px;
        }
        .rating-val {
            font-weight: 800;
            color: var(--ink);
        }
        .rating-qty {
            color: var(--muted);
            font-size: 11.5px;
        }
        .visited-product-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 8px;
            border-top: 1px dashed var(--line);
        }
        .visited-product-price {
            font-size: 16.5px;
            font-weight: 800;
            color: var(--accent);
        }
        .visited-product-stock {
            font-size: 11px;
            font-weight: 700;
            color: #10b981;
        }
        .visited-product-footer {
            padding: 0 18px 16px;
            display: flex;
            gap: 8px;
        }
        .btn-visited-add-cart {
            flex: 1;
            padding: 10px 14px;
            border-radius: 999px;
            background: linear-gradient(135deg, #c86d63, #b45b51);
            color: #fff;
            border: none;
            font-weight: 800;
            font-size: 12.5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow: 0 3px 10px rgba(200, 109, 99, 0.3);
            transition: transform 0.15s ease, background 0.15s ease;
        }
        .btn-visited-add-cart:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #b85b51, #9e4338);
        }
        .btn-visited-view {
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--paper);
            color: var(--ink);
            border: 1.5px solid var(--card-border);
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .btn-visited-view:hover {
            background: var(--card-border);
        }

        /* --- 1-5 STAR RATING & REVIEWS SYSTEM STYLES --- */
        .reviews-section-box {
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px dashed var(--line);
        }
        .reviews-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 8px;
        }
        .reviews-summary-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(245, 158, 11, 0.12);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            color: #d97706;
        }
        .btn-toggle-review-form {
            background: var(--paper);
            border: 1.5px solid var(--card-border);
            border-radius: 999px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 700;
            color: var(--ink);
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .btn-toggle-review-form:hover {
            background: var(--card-border);
        }
        .review-form-card {
            background: var(--paper);
            border: 1.5px solid var(--card-border);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 16px;
        }
        .star-rating-selector {
            display: flex;
            gap: 4px;
            margin: 6px 0 12px;
        }
        .star-pick-btn {
            background: transparent;
            border: none;
            font-size: 24px;
            color: #cbd5e1;
            cursor: pointer;
            transition: transform 0.15s ease, color 0.15s ease;
            padding: 2px;
        }
        .star-pick-btn.active {
            color: #f59e0b;
        }
        .star-pick-btn:hover {
            transform: scale(1.2);
        }
        .review-item-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 10px;
        }
        .review-item-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .review-author-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .review-verified-tag {
            font-size: 10px;
            color: #10b981;
            font-weight: 700;
            background: rgba(16, 185, 129, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
        }
        .review-item-date {
            font-size: 11px;
            color: var(--muted);
        }
        .review-item-text {
            font-size: 12.5px;
            color: var(--ink);
            margin: 4px 0 0;
            line-height: 1.45;
        }

        /* Company Card Interactive Review Pill */
        .btn-company-reviews-trigger {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 700;
            color: #b45309;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.15s ease, transform 0.15s ease;
            margin-top: 4px;
        }
        .btn-company-reviews-trigger:hover {
            background: rgba(245, 158, 11, 0.2);
            transform: translateY(-1px);
        }
        /* FLOATING RETURN HOME PILL (VISIBLE ON MOBILE SCROLL & STANDALONE PWA) */
        .pwa-floating-home-pill {
            position: fixed;
            bottom: 74px;
            left: 16px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(32, 33, 30, 0.88);
            color: #ffffff;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 8px 24px rgba(0,0,0,0.16);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 9980;
            cursor: pointer;
            transition: transform .2s ease, opacity .2s ease;
        }
        [data-theme="dark"] .pwa-floating-home-pill {
            background: rgba(255, 255, 255, 0.92);
            color: #111210;
            border-color: rgba(255, 255, 255, 0.4);
        }
        .pwa-floating-home-pill:active {
            transform: scale(0.96);
        }
        @media (min-width: 900px) {
            .pwa-floating-home-pill {
                display: none;
            }
        }
    </style>
</head>
<body>

<!-- PWA MOBILE INSTALL BANNER -->
<div class="pwa-install-bar" id="pwaInstallBar">
    <div class="shell pwa-install-inner">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 22px;">📱</span>
            <div>
                <strong>Instala la App de Tiendas de Zacatecas Centro</strong>
                <div style="font-size: 11.5px; opacity: 0.85;">PWA rápida para tu teléfono · Funciona sin conexión y pedidos por WhatsApp</div>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <button type="button" class="pwa-install-btn" id="btnPwaInstall" onclick="triggerPwaInstall()">
                ⬇️ Instalar en Celular
            </button>
            <button type="button" onclick="dismissPwaBanner()" style="background: transparent; border: none; color: #fff; font-size: 16px; cursor: pointer; padding: 4px 8px;" title="Cerrar">✕</button>
        </div>
    </div>
</div>

<!-- FLOATING PWA INSTALL BADGE -->
<button type="button" class="floating-pwa-badge" id="floatingPwaBadge" onclick="triggerPwaInstall()">
    <span>📲</span> <span>Instalar App</span>
</button>

<!-- PWA STEP-BY-STEP GUIDE MODAL -->
<div id="pwaGuideModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 10000; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(4px);">
    <div style="background: #ffffff; border-radius: 24px; max-width: 480px; width: 100%; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35); position: relative; max-height: 90vh; overflow-y: auto;">
        <button type="button" onclick="closePwaModal()" style="position: absolute; top: 18px; right: 18px; background: #f3f4f6; border: none; border-radius: 50%; width: 34px; height: 34px; cursor: pointer; font-size: 16px; display: grid; place-items: center;">✕</button>
        
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 72px; height: 72px; border-radius: 18px; margin: 0 auto 12px; box-shadow: 0 8px 22px rgba(200,109,99,0.35); overflow: hidden; border: 2.5px solid #cbd5e1; display: grid; place-items: center; background: linear-gradient(135deg, #c86d63, #b45b51);">
                <img src="/app-icons/icon-192.png" alt="Zacatecas Centro Minimapa" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='/icons/icon-192.png'; this.onerror=function(){this.style.display='none'; this.nextElementSibling.style.display='grid';};">
                <span style="display: none; font-size: 32px; color: #fff;">🏛️</span>
            </div>
            <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 4px; color: #111210;">Instalar Atelier Zacatecas</h3>
            <p style="font-size: 13px; color: #6b7280;">Aplicación oficial de comercios en el Centro Histórico de Zacatecas.</p>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 16px; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 14px;">
                <span>🤖</span> En Android (Google Chrome)
            </div>
            <ol style="margin-left: 20px; font-size: 13px; color: #475569; line-height: 1.6;">
                <li>Toca el botón de <strong>3 puntos verticales (⋮)</strong> arriba a la derecha en Chrome.</li>
                <li>Selecciona <strong>"Instalar aplicación"</strong> o <strong>"Agregar a la pantalla principal"</strong>.</li>
                <li>Confirma en <strong>"Instalar"</strong> y el icono de la app aparecerá en tu teléfono.</li>
            </ol>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 16px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 14px;">
                <span>🍏</span> En iPhone / iPad (Safari)
            </div>
            <ol style="margin-left: 20px; font-size: 13px; color: #475569; line-height: 1.6;">
                <li>Toca el botón <strong>Compartir</strong> (icono de cuadrado con flecha hacia arriba <strong>[↑]</strong>) en Safari.</li>
                <li>Desliza hacia abajo en las opciones y selecciona <strong>"Agregar al inicio"</strong> (+).</li>
                <li>Toca <strong>"Agregar"</strong> en la esquina superior derecha.</li>
            </ol>
        </div>

        <button type="button" onclick="closePwaModal()" style="width: 100%; padding: 12px; border-radius: 999px; background: #111210; color: #fff; font-weight: 700; border: none; cursor: pointer; font-size: 14px;">
            Entendido, volver a la App
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert-banner">
        <span>✓ {{ session('success') }}</span>
    </div>
@endif
@if(session('info'))
    <div class="alert-banner info">
        <span>ℹ {{ session('info') }}</span>
    </div>
@endif

@if(session('success_store_created'))
    @php $newStore = session('success_store_created'); @endphp
    <div class="alert-banner store-created-banner" style="background: #ecfdf5; border-bottom: 2px solid #10b981; padding: 18px 24px; color: #064e3b; text-align: center;">
        <div style="font-size: 16px; font-weight: 800; margin-bottom: 4px;">🎉 ¡Felicitaciones! Tu tienda "{{ $newStore['name'] }}" ha sido dada de alta y activada en la plataforma.</div>
        <div style="font-size: 13.5px; margin-bottom: 12px; color: #047857;">
            Plan contratado: <strong>{{ $newStore['plan_name'] }}</strong> ({{ $newStore['billing_cycle'] }}) · Usuario admin: <strong>{{ $newStore['owner_email'] }}</strong>
        </div>
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ $newStore['admin_url'] }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; border-radius: 999px; background: #059669; color: #fff; font-weight: 700; font-size: 13px; text-decoration: none; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);">
                🚀 Ingresar al Panel de tu Tienda
            </a>
            <a href="{{ $newStore['store_url'] }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; border-radius: 999px; background: #fff; border: 1.5px solid #059669; color: #059669; font-weight: 700; font-size: 13px; text-decoration: none;">
                🛍️ Ver tu Tienda Pública Online
            </a>
        </div>
    </div>
@endif

<!-- HEADER -->
<header class="portal-header">
    <div class="shell header-inner">
        <a href="{{ url('/') }}" class="portal-brand">
            <div class="brand-badge" style="padding: 0; overflow: hidden; background: linear-gradient(135deg, #c86d63, #b45b51); border: 1.5px solid #cbd5e1; width: 38px; height: 38px; border-radius: 10px; display: grid; place-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.12); position: relative;">
                <img src="/app-icons/icon.svg" alt="Minimapa Zacatecas Centro" style="width: 100%; height: 100%; object-fit: cover; border-radius: 9px; display: block;" onerror="this.onerror=null; this.src='/icons/icon.svg'; this.onerror=function(){this.style.display='none'; this.nextElementSibling.style.display='grid';};">
                <span style="display: none; width: 100%; height: 100%; place-items: center; font-size: 18px; color: #fff;">🏛️</span>
            </div>
            <div class="brand-text">
                <strong>Atelier Zacatecas</strong>
                <small>Centro Histórico · Cantera &amp; Plata</small>
            </div>
        </a>

        <nav class="portal-nav-links">
            <a href="#cercanas" onclick="switchMainTab('map')" style="color: var(--accent); font-weight: 700;">📍 Tiendas Cercanas</a>
            <a href="#empresas" onclick="switchMainTab('stores')">Empresas</a>
            <a href="#buscar" onclick="switchMainTab('feed')">Búsqueda Global</a>
            <a href="{{ url('/planes') }}">💎 Planes de Renta</a>
            <a href="{{ url('/admin') }}" target="_blank">Super Admin</a>
        </nav>

        <div class="portal-auth-actions">
            <button type="button" class="btn-central-cart" id="btnCentralCart" onclick="goToCartRoutePlanner()" title="Ver productos en mi Carrito y calcular ruta">
                <span>🛒</span> <span class="central-cart-label">Mi Carrito</span>
                <span class="central-cart-badge" id="centralCartBadge">0</span>
            </button>

            <a href="{{ url('/planes') }}" class="btn-rent-nav">
                <span>✨</span> <span class="rent-btn-long-text">Rentar Tienda</span>
            </a>

            @if($user)
                <!-- Usuario Autenticado -->
                <div class="user-profile-pill">
                    <img src="{{ $user->avatar_url ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80' }}" alt="{{ $user->name }}" class="user-avatar-circle">
                    <div>
                        <div class="user-info-text">{{ Str::limit($user->name, 12) }}</div>
                        <span class="user-provider-tag {{ $user->auth_provider === 'google' ? 'tag-google' : ($user->auth_provider === 'facebook' ? 'tag-facebook' : 'tag-email') }}">
                            {{ $user->auth_provider ?? 'Correo' }}
                        </span>
                    </div>
                    <a href="{{ url('/logout') }}" class="btn-logout" title="Cerrar Sesión">✕</a>
                </div>
            @else
                <!-- Invitado (No autenticado) -->
                <button class="btn-auth-login" onclick="openAuthModal('login')">
                    Entrar
                </button>
            @endif

            <a href="{{ url('/admin') }}" target="_blank" class="btn-admin-panel" title="Panel Central Multi-Tenant">
                <span>⚙</span> <span class="admin-btn-text">Central</span>
            </a>

            <!-- Language Toggle (ES / EN) -->
            <button type="button" class="btn-lang-toggle" onclick="toggleLanguage()" title="Cambiar idioma / Change language">
                <span>🌐</span> <span class="lang-label-text">ES</span>
            </button>

            <!-- Web Share Button -->
            <button type="button" class="btn-share-header" onclick="sharePortal()" title="Compartir portal por WhatsApp / Redes" aria-label="Compartir">
                <span>📤</span>
            </button>

            <!-- Dark / Light Theme Toggle -->
            <button type="button" class="btn-theme-toggle" id="themeToggleBtn" onclick="toggleTheme()" aria-label="Cambiar modo oscuro/claro" title="Cambiar a Modo Oscuro / Claro">
                <span class="theme-icon-light">🌙</span>
                <span class="theme-icon-dark" style="display: none;">☀️</span>
            </button>

            <!-- Mobile Hamburger Toggle -->
            <button type="button" class="btn-mobile-menu" id="mobileMenuToggle" onclick="toggleMobileMenu()" aria-label="Abrir Menú">
                <div class="btn-mobile-menu-bars">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <span class="mobile-menu-label">Menú</span>
            </button>
        </div>
    </div>
</header>

<!-- BACKDROP OVERLAY FOR MOBILE DRAWER -->
<div class="mobile-drawer-backdrop" id="mobileDrawerBackdrop" onclick="closeMobileMenu()"></div>

<!-- SLIDE-OVER MOBILE NAVIGATION DRAWER -->
<aside class="portal-mobile-menu" id="portalMobileMenu" aria-label="Menú Móvil">
    <!-- Header inside drawer -->
    <div class="drawer-header">
        <div class="drawer-brand">
            <div class="drawer-logo-badge" style="display: grid; place-items: center; overflow: hidden; background: linear-gradient(135deg, #c86d63, #b45b51); position: relative;">
                <img src="/app-icons/icon.svg" alt="Minimapa Zacatecas Centro" style="width: 100%; height: 100%; object-fit: cover; display: block;" onerror="this.onerror=null; this.src='/icons/icon.svg'; this.onerror=function(){this.style.display='none'; this.nextElementSibling.style.display='grid';};">
                <span style="display: none; width: 100%; height: 100%; place-items: center; font-size: 18px; color: #fff;">🏛️</span>
            </div>
            <div>
                <strong>Atelier Zacatecas</strong>
                <small>Cantera Rosa &amp; Plata</small>
            </div>
        </div>
        <button type="button" class="btn-drawer-close" onclick="closeMobileMenu()" aria-label="Cerrar menú">
            ✕
        </button>
    </div>

    <!-- User Profile / Session Status Bar inside drawer -->
    @if($user)
        <div class="drawer-user-card">
            <img src="{{ $user->avatar_url ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80' }}" alt="{{ $user->name }}" class="drawer-avatar">
            <div class="drawer-user-info">
                <strong>{{ $user->name }}</strong>
                <span class="drawer-user-badge">{{ $user->email ?? $user->auth_provider }}</span>
            </div>
            <a href="{{ url('/logout') }}" class="btn-drawer-logout" title="Cerrar Sesión">Salir</a>
        </div>
    @else
        <div class="drawer-guest-box">
            <span>👋 Bienvenido(a) a Zacatecas Centro</span>
            <button type="button" class="btn-drawer-login" onclick="closeMobileMenu(); openAuthModal('login')">
                <span>👤</span> Iniciar Sesión / Registrarse
            </button>
        </div>
    @endif

    <!-- Navigation Options (The 5 requested sections) -->
    <div class="drawer-section-title">Navegación del Portal</div>
    <nav class="mobile-nav-list">
        <a href="#zacatecasMap" class="drawer-nav-item" onclick="closeMobileMenu(); goToCartRoutePlanner();">
            <div class="nav-item-icon" style="background: rgba(200, 109, 99, 0.15); color: #c86d63;">🛒</div>
            <div class="nav-item-text">
                <div class="nav-item-title">Mi Carrito de Compras (<span id="drawerCartBadge">0</span>)</div>
                <div class="nav-item-sub">Ruta para ver y comprar tus artículos en tiendas</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#cercanas" class="drawer-nav-item" onclick="closeMobileMenu(); switchMainTab('map');">
            <div class="nav-item-icon" style="background: rgba(200, 109, 99, 0.15); color: #c86d63;">📍</div>
            <div class="nav-item-text">
                <div class="nav-item-title" data-i18n="nav_cercanas">Tiendas Cercanas</div>
                <div class="nav-item-sub" data-i18n="nav_cercanas_sub">Zacatecas Centro Histórico &amp; Mapa</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#empresas" class="drawer-nav-item" onclick="closeMobileMenu(); switchMainTab('stores');">
            <div class="nav-item-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">🏢</div>
            <div class="nav-item-text">
                <div class="nav-item-title" data-i18n="nav_empresas">Directorio de Empresas</div>
                <div class="nav-item-sub" data-i18n="nav_empresas_sub">Bitácora oficial de comercios locales</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#buscar" class="drawer-nav-item" onclick="closeMobileMenu(); switchMainTab('feed');">
            <div class="nav-item-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">🔍</div>
            <div class="nav-item-text">
                <div class="nav-item-title" data-i18n="nav_buscar">Búsqueda Global de Productos</div>
                <div class="nav-item-sub" data-i18n="nav_buscar_sub">Catálogo completo de todas las tiendas</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#planes" class="drawer-nav-item" onclick="closeMobileMenu(); switchMainTab('plans');">
            <div class="nav-item-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">💎</div>
            <div class="nav-item-text">
                <div class="nav-item-title" data-i18n="nav_planes">Planes de Renta de Tiendas</div>
                <div class="nav-item-sub" data-i18n="nav_planes_sub">Abre tu sucursal en línea hoy</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="{{ url('/admin') }}" target="_blank" class="drawer-nav-item" onclick="closeMobileMenu()">
            <div class="nav-item-icon" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">⚙️</div>
            <div class="nav-item-text">
                <div class="nav-item-title" data-i18n="nav_admin">Panel Super Admin Central</div>
                <div class="nav-item-sub" data-i18n="nav_admin_sub">Administración multi-tenant del sistema</div>
            </div>
            <span class="nav-item-arrow">↗</span>
        </a>
    </nav>

    <!-- Quick Action Controls & Buttons -->
    <div class="drawer-footer-actions">
        <!-- Theme Toggle in Drawer -->
        <button type="button" class="btn-theme-toggle-drawer" onclick="toggleTheme()">
            <span class="theme-text-light">🌙 Cambiar a Modo Oscuro</span>
            <span class="theme-text-dark" style="display: none;">☀️ Cambiar a Modo Claro</span>
        </button>

        <!-- Language and Share in Drawer -->
        <div style="display: flex; gap: 8px;">
            <button type="button" class="btn-theme-toggle-drawer" style="flex: 1;" onclick="toggleLanguage()">
                <span>🌐</span> <span class="lang-drawer-text">Español (ES)</span>
            </button>
            <button type="button" class="btn-theme-toggle-drawer" style="flex: 1;" onclick="sharePortal()">
                <span>📤</span> <span data-i18n="btn_share">Compartir</span>
            </button>
        </div>

        <!-- Rent CTA Button in Drawer -->
        <a href="{{ url('/planes') }}" class="btn-rent-drawer" onclick="closeMobileMenu()">
            ✨ <span data-i18n="btn_rent_cta">Rentar Tienda Online (-20% Anual)</span>
        </a>

        <div class="drawer-brand-footer">
            <span>Atelier Zacatecas · Cantera Rosa &amp; Plata</span>
            <small>Plataforma PWA Offline Ready v2.2.0</small>
        </div>
    </div>
</aside>

<main class="shell">

    <!-- SEGMENTED TABS (ESTILO TIKTOK 'PARA TI' / FACEBOOK FEED TABS) -->
    <nav class="main-tab-nav-wrapper" id="mainTabNavWrapper" aria-label="Secciones principales">
        <div class="main-tab-switcher">
            <button type="button" class="main-tab-btn active" id="tabBtnFeed" onclick="switchMainTab('feed')">
                <span>🔥</span> Más Visitados
            </button>
            <button type="button" class="main-tab-btn" id="tabBtnMap" onclick="switchMainTab('map')">
                <span>📍</span> Mapa &amp; Cercanía
            </button>
            <button type="button" class="main-tab-btn" id="tabBtnStores" onclick="switchMainTab('stores')">
                <span>🏬</span> Directorio <span class="tab-badge">{{ count($allBusinesses) }}</span>
            </button>
            <a href="{{ url('/planes') }}" class="main-tab-btn" id="tabBtnPlans" style="text-decoration: none;">
                <span>💎</span> Planes ↗
            </a>
        </div>
    </nav>

    <!-- TAB 1: PARA TI (FEED SOCIAL Y BÚSQUEDA) -->
    <div id="panelFeed" class="tab-panel-content">

    <!-- HERO WITH MULTI-STORE GLOBAL SEARCH -->
    <section class="portal-hero" id="buscar">
        <span class="zac-location-hero-badge">📍 Zacatecas Centro Histórico · Cantera Rosa &amp; Plata</span>
        <h1>Explora Comercios y Tiendas Locales de <em>Zacatecas Centro</em></h1>
        <p>Directorio oficial en la <strong>Ciudad de Cantera Rosa y Plata</strong> para descubrir comercios emblemáticos, consultar productos y enviar pedidos directos por WhatsApp con sucursal física geolocalizada.</p>

        <!-- GLOBAL SEARCH BAR -->
        <div class="global-search-container">
            <form action="{{ url('/') }}" method="GET" class="global-search-form" id="globalSearchForm">
                <input type="text" name="q" id="globalSearchInput" class="global-search-input" value="{{ $searchQuery }}" placeholder="Buscar en tiendas de Zacatecas (ej. café americano, plata ley .925, gorditas, dulces, mezcal)..." autocomplete="off">
                <button type="submit" class="global-search-btn">
                    <span>🔍</span> <span class="search-btn-text">Buscar en todas las tiendas</span>
                </button>
            </form>

            <!-- LIVE SEARCH DROPDOWN -->
            <div class="live-search-dropdown" id="liveSearchDropdown">
                <!-- Dynamically populated via AJAX -->
            </div>

            <!-- POPULAR QUICK SEARCH TAGS -->
            <div class="popular-tags-row">
                <span>Búsquedas de Zacatecas:</span>
                <a href="{{ url('/?q=Café') }}" class="popular-tag">☕ Café Acrópolis</a>
                <a href="{{ url('/?q=Gordita') }}" class="popular-tag">🌮 Gorditas Doña Julia</a>
                <a href="{{ url('/?q=Plata') }}" class="popular-tag">💎 Rosa de Plata</a>
                <a href="{{ url('/?q=Dulce') }}" class="popular-tag">🍬 El Serranito</a>
                <a href="{{ url('/?q=Mezcal') }}" class="popular-tag">🍷 Las Quince Letras</a>
                <a href="{{ url('/?q=Libro') }}" class="popular-tag">📚 Librería André-a</a>
            </div>
        </div>

        <!-- QUICK INTUITIVE ACTION DECK ("¿QUÉ DESEAS HACER HOY?") -->
        <div class="hero-quick-actions">
            <a href="#cercanas" class="hero-action-card" onclick="switchMainTab('map')">
                <div class="hero-action-icon" style="background: rgba(37, 99, 235, 0.12); color: #2563eb;">📍</div>
                <div class="hero-action-text">
                    <strong>Mapa &amp; Cercanía</strong>
                    <p>Comercios y cafeterías a pocos minutos a pie</p>
                </div>
                <span class="hero-action-arrow">➔</span>
            </a>

            <a href="#empresas" class="hero-action-card" onclick="switchMainTab('stores')">
                <div class="hero-action-icon" style="background: rgba(200, 109, 99, 0.12); color: #c86d63;">🏬</div>
                <div class="hero-action-text">
                    <strong>Directorio Oficial</strong>
                    <p>Marcas locales de plata, comida, café y arte</p>
                </div>
                <span class="hero-action-arrow">➔</span>
            </a>

            <button type="button" class="hero-action-card" onclick="goToCartRoutePlanner()">
                <div class="hero-action-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">🗺️</div>
                <div class="hero-action-text">
                    <strong>Ruta de Compras</strong>
                    <p>Arma tu carrito y genera el itinerario sugerido</p>
                </div>
                <span class="hero-action-arrow">➔</span>
            </button>

            <a href="#planes" class="hero-action-card" onclick="switchMainTab('plans')">
                <div class="hero-action-icon" style="background: rgba(168, 85, 247, 0.12); color: #a855f7;">✨</div>
                <div class="hero-action-text">
                    <strong>Renta tu Tienda</strong>
                    <p>Digitaliza tu marca con 0% de comisiones</p>
                </div>
                <span class="hero-action-arrow">➔</span>
            </a>
        </div>
    </section>

    <!-- USER WELCOME BANNER (IF LOGGED IN) -->
    @if($user)
        <div class="user-welcome-card">
            <div class="user-welcome-info">
                <img src="{{ $user->avatar_url ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80' }}" alt="{{ $user->name }}" class="user-welcome-avatar">
                <div>
                    <strong>¡Hola, {{ $user->name }}! Has iniciado sesión con {{ ucfirst($user->auth_provider ?? 'Correo') }}.</strong>
                    <span>Tu cuenta te permite explorar las empresas oficiales y rastrear tus pedidos en toda la plataforma.</span>
                </div>
            </div>
            <a href="{{ url('/logout') }}" class="btn-auth-login">Cerrar Sesión</a>
        </div>
    @endif

    <!-- GLOBAL SEARCH RESULTS (IF SEARCH IS PERFORMED) -->
    @if($searchQuery !== '')
        <section class="search-results-section">
            <div class="results-header-bar">
                <div>
                    <span class="section-eyebrow">Búsqueda Cruzada en Tiempo Real</span>
                    <h2>Resultados para "{{ $searchQuery }}" ({{ count($searchResults) }} encontrados)</h2>
                </div>
                <a href="{{ url('/') }}" class="btn-clear-search">✕ Limpiar Búsqueda</a>
            </div>

            @if(count($searchResults) > 0)
                <div class="search-results-grid">
                    @foreach($searchResults as $item)
                        <article class="search-product-card">
                            <div class="search-product-thumb" style="cursor: pointer;"
                                onclick='openCentralProductModal({
                                    id: @json((string)$item["id"]),
                                    store_id: @json((string)$item["store_id"]),
                                    name: @json($item["name"]),
                                    price: {{ (float)$item["price"] }},
                                    image_url: @json($item["image_url"] ?? ""),
                                    description: @json($item["description"] ?? ""),
                                    stock: {{ (int)($item["stock"] ?? 10) }},
                                    url: @json($item["store_url"]),
                                    store_name: @json($item["store_name"]),
                                    store_url: @json($item["store_url"]),
                                    address: "Centro Histórico, Zacatecas, Zac.",
                                    hours: "Lunes a Sábado: 10:00 AM - 8:30 PM",
                                    whatsapp: "",
                                    maps_url: "https://maps.google.com/?q=22.7753,-102.5724"
                                });'>
                                <span class="search-store-badge-float" style="border-left: 3px solid {{ $item['store_color'] }};">
                                    🏬 {{ $item['store_name'] }}
                                </span>
                                <img src="{{ !empty($item['image_url']) ? $item['image_url'] : 'https://placehold.co/600x600?text=' . urlencode($item['name']) }}" alt="{{ $item['name'] }}" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/600x600?text=Zacatecas';">
                            </div>
                            <div class="search-product-body">
                                <span style="font-size: 11px; font-weight: 700; color: var(--accent); text-transform: uppercase; margin-bottom: 4px;">{{ $item['category_name'] }}</span>
                                <h3 style="cursor: pointer;" onclick='openCentralProductModal({
                                    id: @json((string)$item["id"]),
                                    store_id: @json((string)$item["store_id"]),
                                    name: @json($item["name"]),
                                    price: {{ (float)$item["price"] }},
                                    image_url: @json($item["image_url"] ?? ""),
                                    description: @json($item["description"] ?? ""),
                                    stock: {{ (int)($item["stock"] ?? 10) }},
                                    url: @json($item["store_url"]),
                                    store_name: @json($item["store_name"]),
                                    store_url: @json($item["store_url"]),
                                    address: "Centro Histórico, Zacatecas, Zac.",
                                    hours: "Lunes a Sábado: 10:00 AM - 8:30 PM",
                                    whatsapp: "",
                                    maps_url: "https://maps.google.com/?q=22.7753,-102.5724"
                                });'>{{ $item['name'] }}</h3>
                                <p>{{ Str::limit($item['description'], 75) }}</p>
                                <div class="search-product-footer">
                                    <span class="search-product-price">${{ number_format($item['price'], 2) }}</span>
                                    <a href="{{ $item['store_url'] }}" class="btn-buy-store">
                                        Ver en {{ Str::limit($item['store_name'], 12) }} ↗
                                    </a>
                                </div>
                                <button type="button" class="search-quick-add-btn" onclick='quickAddProductToRouteCart({
                                    id: @json((string)$item["id"]),
                                    store_id: @json((string)$item["store_id"]),
                                    store_name: @json($item["store_name"]),
                                    name: @json($item["name"]),
                                    price: {{ (float)$item["price"] }},
                                    image_url: @json($item["image_url"] ?? "")
                                });'>+ 🛒 Añadir al Carrito de Ruta</button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 60px 20px; background: var(--card); border-radius: 20px; border: 1px dashed var(--line);">
                    <h3>No se encontraron productos coincidentes en ninguna tienda</h3>
                    <p style="color: var(--muted); margin: 10px 0 20px;">Intenta con términos más generales como "reloj", "bolso", "pepsi", "sonido" o explora el catálogo de cada empresa.</p>
                    <a href="{{ url('/') }}" class="btn-visit-company" style="display: inline-flex; width: auto;">Ver todas las empresas</a>
                </div>
            @endif
        </section>
    @endif

    <!-- SECCIÓN DESTACADA: PRODUCTOS MÁS VISITADOS DE ZACATECAS CENTRO -->
    <section class="most-visited-section" id="productosPopulares" aria-label="Productos más visitados">
        <div class="most-visited-header-bar">
            <div>
                <span class="section-eyebrow" style="color: var(--accent);">✦ Lo Más Buscado en Zacatecas</span>
                <h2 style="font-size: 24px; font-weight: 800; margin: 2px 0; color: var(--ink);">Productos Más Visitados de Zacatecas Centro</h2>
                <p style="font-size: 13.5px; color: var(--muted); margin: 0;">Los artículos más populares y con mejores calificaciones en los comercios del Centro Histórico.</p>
            </div>
            <div class="most-visited-tag-badge">
                🔥 Tendencias en Vivo
            </div>
        </div>

        <!-- Grid of Most Visited Products -->
        <div class="most-visited-grid">
            @foreach($mostVisitedProducts as $item)
                <article class="visited-product-card" id="card-prod-{{ $item['id'] }}">
                    <div class="visited-product-thumb" onclick='openCentralProductModal({
                        id: @json($item["id"]),
                        slug: @json($item["slug"]),
                        store_id: @json($item["store_id"]),
                        name: @json($item["name"]),
                        price: {{ (float)$item["price"] }},
                        image_url: @json($item["image_url"] ?? ""),
                        description: @json($item["description"] ?? ""),
                        stock: {{ (int)($item["stock"] ?? 15) }},
                        url: @json($item["url"]),
                        store_name: @json($item["store_name"]),
                        store_url: @json($item["store_url"]),
                        address: @json($item["address"]),
                        hours: @json($item["hours"]),
                        whatsapp: @json($item["whatsapp"] ?? ""),
                        maps_url: @json($item["maps_url"] ?? ""),
                        rating: {{ (float)$item["rating"] }},
                        reviews_count: {{ (int)$item["reviews_count"] }}
                    });'>
                        <img src="{{ !empty($item['image_url']) ? $item['image_url'] : 'https://placehold.co/600x600?text=' . urlencode($item['name']) }}" alt="{{ $item['name'] }}" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/600x600?text=Zacatecas';">
                        <span class="visited-badge-visits">🔥 {{ number_format($item['visits_count']) }} visitas</span>
                        <span class="visited-badge-store">🏬 {{ $item['store_name'] }}</span>
                    </div>

                    <div class="visited-product-body">
                        <span class="visited-product-cat">{{ $item['store_category'] }}</span>
                        <h3 class="visited-product-title" onclick='openCentralProductModal({
                            id: @json($item["id"]),
                            slug: @json($item["slug"]),
                            store_id: @json($item["store_id"]),
                            name: @json($item["name"]),
                            price: {{ (float)$item["price"] }},
                            image_url: @json($item["image_url"] ?? ""),
                            description: @json($item["description"] ?? ""),
                            stock: {{ (int)($item["stock"] ?? 15) }},
                            url: @json($item["url"]),
                            store_name: @json($item["store_name"]),
                            store_url: @json($item["store_url"]),
                            address: @json($item["address"]),
                            hours: @json($item["hours"]),
                            whatsapp: @json($item["whatsapp"] ?? ""),
                            maps_url: @json($item["maps_url"] ?? ""),
                            rating: {{ (float)$item["rating"] }},
                            reviews_count: {{ (int)$item["reviews_count"] }}
                        });'>{{ $item['name'] }}</h3>

                        <!-- Star Rating Summary -->
                        <div class="visited-product-rating" onclick='openProductReviewsTab({
                            id: @json($item["id"]),
                            slug: @json($item["slug"]),
                            store_id: @json($item["store_id"]),
                            name: @json($item["name"]),
                            price: {{ (float)$item["price"] }},
                            image_url: @json($item["image_url"] ?? ""),
                            description: @json($item["description"] ?? ""),
                            stock: {{ (int)($item["stock"] ?? 15) }},
                            url: @json($item["url"]),
                            store_name: @json($item["store_name"]),
                            store_url: @json($item["store_url"]),
                            address: @json($item["address"]),
                            hours: @json($item["hours"]),
                            whatsapp: @json($item["whatsapp"] ?? ""),
                            maps_url: @json($item["maps_url"] ?? ""),
                            rating: {{ (float)$item["rating"] }},
                            reviews_count: {{ (int)$item["reviews_count"] }}
                        })' title="Ver opiniones y calificar">
                            <span class="stars-gold">★★★★★</span>
                            <span class="rating-val">{{ number_format($item['rating'], 1) }}</span>
                            <span class="rating-qty">({{ $item['reviews_count'] }} opiniones)</span>
                        </div>

                        <div class="visited-product-price-row">
                            <span class="visited-product-price">${{ number_format($item['price'], 0) }} MXN</span>
                            <span class="visited-product-stock">✓ En existencia</span>
                        </div>
                    </div>

                    <div class="visited-product-footer">
                        <button type="button" class="btn-visited-add-cart" onclick='quickAddProductToRouteCart({
                            id: @json($item["id"]),
                            store_id: @json($item["store_id"]),
                            store_name: @json($item["store_name"]),
                            name: @json($item["name"]),
                            price: {{ (float)$item["price"] }},
                            image_url: @json($item["image_url"] ?? "")
                        })'>
                            <span>+ 🛒</span> Añadir
                        </button>
                        <button type="button" class="btn-visited-view" onclick='openCentralProductModal({
                            id: @json($item["id"]),
                            slug: @json($item["slug"]),
                            store_id: @json($item["store_id"]),
                            name: @json($item["name"]),
                            price: {{ (float)$item["price"] }},
                            image_url: @json($item["image_url"] ?? ""),
                            description: @json($item["description"] ?? ""),
                            stock: {{ (int)($item["stock"] ?? 15) }},
                            url: @json($item["url"]),
                            store_name: @json($item["store_name"]),
                            store_url: @json($item["store_url"]),
                            address: @json($item["address"]),
                            hours: @json($item["hours"]),
                            whatsapp: @json($item["whatsapp"] ?? ""),
                            maps_url: @json($item["maps_url"] ?? ""),
                            rating: {{ (float)$item["rating"] }},
                            reviews_count: {{ (int)$item["reviews_count"] }}
                        })'>
                            Ver y Calificar
                        </button>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    </div> <!-- /#panelFeed -->

    <!-- TAB 2: MAPA & CERCANÍA -->
    <div id="panelMap" class="tab-panel-content" style="display: none;">
    <!-- GUÍA INTUITIVA: CÓMO FUNCIONA EL PORTAL (3 PASOS) -->
    <section class="how-it-works-strip">
        <div class="how-it-works-header">
            <span class="section-eyebrow" style="font-size: 11px;">✦ Guía Rápida del Portal</span>
            <h2 style="font-size: 19px; font-weight: 800; margin: 4px 0; color: var(--ink);">¿Cómo Explorar y Comprar en Zacatecas Centro?</h2>
            <p style="font-size: 13px; color: var(--muted); margin: 0;">Descubre comercios locales de cantera y plata, consulta productos y planea tus compras fácilmente:</p>
        </div>
        <div class="how-steps-grid">
            <div class="how-step-card">
                <div class="how-step-badge">Paso 1</div>
                <div class="how-step-icon">🔍</div>
                <h3>Explora Comercios &amp; Catálogos</h3>
                <p>Navega por el mapa interactivo o directorio para ver productos, precios y horarios en tiempo real.</p>
            </div>
            <div class="how-step-card">
                <div class="how-step-badge">Paso 2</div>
                <div class="how-step-icon">🛒</div>
                <h3>Agrega al Carrito o Pide Directo</h3>
                <p>Guarda artículos de diferentes tiendas en tu carrito o contacta a la tienda oficial vía WhatsApp.</p>
            </div>
            <div class="how-step-card">
                <div class="how-step-badge">Paso 3</div>
                <div class="how-step-icon">🚶‍♂️</div>
                <h3>Visita con la Ruta Recomendada</h3>
                <p>Calcula el recorrido más corto por las calles del Centro para ver tus artículos o solicita envío a domicilio.</p>
            </div>
        </div>
    </section>

    <!-- TIENDAS CERCANAS EN ZACATECAS CENTRO & MAPA INTERACTIVO -->
    <section class="companies-section" id="cercanas">
        <div class="section-intro">
            <span class="section-eyebrow">📍 Geolocalización y Proximidad</span>
            <h2 class="section-title">Tiendas Cercanas en Zacatecas Centro</h2>
            <p style="color: var(--muted); font-size: 14.5px; margin-top: 6px;">
                Descubre los comercios más cercanos en el Centro Histórico de Zacatecas. Activa tu GPS para calcular la distancia en tiempo real o filtra por zona comercial:
            </p>
        </div>

        <!-- Proximity Toolbar -->
        <div class="proximity-toolbar">
            <div class="proximity-actions-row">
                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <button type="button" class="btn-use-gps" id="btnGpsProximity" onclick="requestUserLocation()">
                        <span>🎯</span> Activar Mi Ubicación (GPS)
                    </button>
                    <span class="gps-status-indicator" id="gpsStatusText">Centro de Zacatecas (Plaza de Armas)</span>
                </div>
                <div style="font-size: 12px; color: var(--muted); font-weight: 600;">
                    🗺️ Mapa interactivo con sucursales físicas y cálculo de cercanía
                </div>
            </div>

            <!-- Zacatecas Zone Filter Pills -->
            <div class="zac-zones-pills">
                <span style="font-size: 11.5px; font-weight: 700; color: var(--muted); display: inline-flex; align-items: center; gap: 4px; margin-right: 4px;">
                    <span>📍</span> <span>Zona:</span>
                </span>
                <button type="button" class="zone-pill active" onclick="filterByZone('all', this)">✦ Todas las Zonas</button>
                <button type="button" class="zone-pill" onclick="filterByZone('Hidalgo', this)">🚶 Av. Hidalgo</button>
                <button type="button" class="zone-pill" onclick="filterByZone('Tacuba', this)">🛍️ Calle Tacuba</button>
                <button type="button" class="zone-pill" onclick="filterByZone('Juárez', this)">🏬 Av. Juárez</button>
                <button type="button" class="zone-pill" onclick="filterByZone('Portal de Rosales', this)">☕ Portal de Rosales</button>
                <button type="button" class="zone-pill" onclick="filterByZone('González Ortega', this)">🏛️ Mercado González Ortega</button>
            </div>

            <!-- Walking Distance Radius Filter Pills & Open Now Toggle -->
            <div class="walking-radius-row">
                <span style="font-size: 11.5px; font-weight: 700; color: var(--muted); display: flex; align-items: center; gap: 4px;">
                    <span>🚶‍♂️</span> <span data-i18n="label_walking">Distancia a pie:</span>
                </span>
                <button type="button" class="radius-pill active" onclick="filterByDistance(999, this)" data-i18n="radius_all">✦ Todo el Centro</button>
                <button type="button" class="radius-pill" onclick="filterByDistance(0.2, this)" data-i18n="radius_200">⚡ Menos de 200 m (2 min)</button>
                <button type="button" class="radius-pill" onclick="filterByDistance(0.5, this)" data-i18n="radius_500">🚶‍♀️ Menos de 500 m (5 min)</button>
                <button type="button" class="radius-pill" onclick="filterByDistance(1.0, this)" data-i18n="radius_1k">🏃‍♂️ Menos de 1 km</button>

                <button type="button" class="filter-only-open" id="btnToggleOnlyOpen" onclick="toggleFilterOnlyOpen(this)">
                    <span>🟢</span> <span data-i18n="btn_only_open">Solo Abiertos Ahora</span>
                </button>
            </div>
        </div>

        <!-- Leaflet Map Container -->
        <div class="zac-map-section">
            <div id="zacatecasMap" class="zac-map-box"></div>

            <!-- Botón Desplegable Minimalista para la Ruta de Compras -->
            <div class="route-panel-toggle-wrapper">
                <button type="button" class="btn-toggle-route-panel" id="btnToggleRoutePanel" onclick="toggleRoutePanel()">
                    <span class="route-toggle-left">
                        <span class="toggle-icon">🗺️</span>
                        <span class="toggle-title">Ruta de Compras según tu Carrito</span>
                        <span class="route-cart-badge-pill" id="routeCartBadgePill" style="display: none;">0 productos</span>
                    </span>
                    <span class="route-toggle-right">
                        <span id="routeToggleActionText" class="toggle-action-text">Configurar y Ver Ruta</span>
                        <span id="toggleRouteArrow" class="toggle-arrow">▾</span>
                    </span>
                </button>
            </div>

            <!-- Panel Desplegable de Ruta de Compras -->
            <div class="route-optimizer-box" id="routeOptimizerPanel" style="display: none; margin-top: 12px;">
                <div class="route-opt-header-minimal">
                    <div>
                        <h3 style="font-size: 15px; font-weight: 800; margin: 0; color: var(--ink); display: flex; align-items: center; gap: 8px;">
                            <span>🗺️</span> Ruta de Compras
                        </h3>
                        <p style="font-size: 12px; color: var(--muted); margin: 2px 0 0;">Visita las tiendas físicas de los artículos en tu carrito por Zacatecas Centro.</p>
                    </div>
                    <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                        <button type="button" class="btn-opt-clear-min" onclick="clearCartRouteItems()" id="btnClearRouteCart" style="display: none;">🗑️ Vaciar</button>
                        <button type="button" class="btn-opt-close-min" onclick="toggleRoutePanel(false)">✕ Ocultar</button>
                    </div>
                </div>

                <!-- Live Cart Items for Route Container -->
                <div id="cartRouteItemsContainer" class="cart-route-items-container">
                    <!-- Dynamically rendered by renderCartForRoute() -->
                </div>

                <!-- Selector de Ubicación de Origen / Tu Ubicación -->
                <div class="route-origin-bar" id="routeOriginBar">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 22px;">📍</span>
                        <div>
                            <strong style="font-size: 13px; color: var(--ink);">Tu Punto de Partida:</strong>
                            <div style="font-size: 12px; color: var(--muted);" id="routeOriginLabel">Obteniendo ubicación GPS actual...</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <button type="button" class="btn-route-origin-pill active" id="btnRouteUseGps" onclick="requestUserLocationForRoute(true)" title="Usar coordenadas GPS en tiempo real">
                            <span>📡</span> Mi Ubicación GPS
                        </button>
                        <button type="button" class="btn-route-origin-pill" id="btnRoutePlazaArmas" onclick="setOriginPlazaDeArmas()" title="Fijar punto de partida en Plaza de Armas">
                            <span>🏛️</span> Plaza de Armas
                        </button>
                        <button type="button" class="btn-route-origin-pill" id="btnClickMapOrigin" onclick="enableMapPickOrigin()" title="Hacer clic en cualquier parte del mapa para fijar tu hotel o punto de partida">
                            <span>🗺️</span> Elegir en Mapa
                        </button>
                    </div>
                </div>

                <!-- Manual Stores Selector (Collapsible) -->
                <div class="route-stores-selector" id="routeStoresSelector" style="display: none; margin-top: 14px;">
                    <div style="width: 100%; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center;">
                        <small style="color: var(--muted); font-size: 12px; font-weight: 700;">Selección manual de tiendas para agregar a la ruta:</small>
                        <div style="display: flex; gap: 6px;">
                            <button type="button" class="btn-route-gps-origin" onclick="selectAllStoresForRoute()" style="padding: 4px 10px; font-size: 11px;">✦ Todas</button>
                            <button type="button" class="btn-route-gps-origin" onclick="clearRouteSelection()" style="padding: 4px 10px; font-size: 11px;">↺ Ninguna</button>
                        </div>
                    </div>
                    @foreach($businesses as $b)
                        <div class="route-store-chip" 
                             id="routeChip_{{ $b['id'] }}"
                             data-store-id="{{ $b['id'] }}" 
                             onclick="toggleStoreRouteSelection('{{ $b['id'] }}', this)">
                            <div class="route-chip-icon" style="background: {{ $b['primary_color'] ?? '#c86d63' }};">
                                {{ match($b['business_category'] ?? '') {
                                    'Moda y Lujo' => '👗',
                                    'Bebidas y Alimentos' => '☕',
                                    'Joyería y Platería', 'Platería y Joyería' => '💍',
                                    'Artesanías y Recuerdos', 'Arte y Souvenirs' => '🏺',
                                    'Librería y Cultura', 'Libros y Café' => '📚',
                                    'Cantinas Tradicionales', 'Gastronomía y Tradición' => '🍷',
                                    default => '🏬'
                                } }}
                            </div>
                            <div class="route-chip-info">
                                <strong>{{ $b['store_name'] }}</strong>
                                <small>{{ $b['neighborhood_zone'] ?? 'Centro Histórico' }}</small>
                            </div>
                            <div class="route-chip-check">✓</div>
                        </div>
                    @endforeach
                </div>

                <div class="route-opt-trigger-row" style="margin-top: 14px;">
                    <button type="button" class="btn-calculate-route" id="btnCalculateRoute" onclick="optimizeShoppingRoute(true)">
                        <span>🚶‍♂️</span> Calcular Ruta Recomendada
                    </button>
                </div>

                <!-- Itinerary Result Output -->
                <div id="routeItineraryResult" style="display: none;"></div>
            </div>
        </div>
    </section>
    </div> <!-- /#panelMap -->

    <!-- TAB 3: DIRECTORIO DE EMPRESAS -->
    <div id="panelStores" class="tab-panel-content" style="display: none;">
    <section class="companies-section" id="seccionDirectorio" style="padding-top: 10px;">
        <!-- Category Filter Pills for Businesses -->
        <div id="empresas" style="padding-top: 16px;">
            <div class="section-intro" style="margin-bottom: 16px;">
                <span class="section-eyebrow">Directorio Oficial de Empresas</span>
                <h2 class="section-title">Empresas Disponibles en la App</h2>
                <p style="color: var(--muted); font-size: 14px; margin-top: 4px;">Filtra las empresas por su categoría comercial y descubre sus catálogos independientes:</p>
            </div>
            <div class="category-filter-pills">
                <a href="{{ url('/?categoria=all' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) }}#empresas" class="filter-pill {{ $selectedCategory === 'all' ? 'active' : '' }}">
                    ✦ Todas las Empresas ({{ count($allBusinesses) }})
                </a>
                @foreach($businessCategories as $catName)
                    @php
                        $countInCat = count(array_filter($allBusinesses, fn($b) => strtolower($b['business_category']) === strtolower($catName)));
                    @endphp
                    <a href="{{ url('/?categoria=' . urlencode($catName) . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) }}#empresas" class="filter-pill {{ strtolower($selectedCategory) === strtolower($catName) ? 'active' : '' }}">
                        {{ match($catName) {
                            'Moda y Lujo' => '👗',
                            'Tecnología y Gadgets' => '💻',
                            'Bebidas y Alimentos' => '🥤',
                            'Hogar y Decoración' => '🏺',
                            'Salud y Belleza' => '🌿',
                            default => '🏬'
                        } }} {{ $catName }} ({{ $countInCat }})
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Grid of Businesses with Location Chips and Distance Badges -->
        <div class="companies-grid" id="companiesGrid">
            @forelse($businesses as $company)
                <div class="company-card" 
                     data-company-id="{{ $company['id'] }}"
                     data-lat="{{ $company['latitude'] }}" 
                     data-lng="{{ $company['longitude'] }}" 
                     data-zone="{{ $company['neighborhood_zone'] }}"
                     data-name="{{ $company['store_name'] }}"
                     data-hours="{{ $company['opening_hours'] }}">
                    <div>
                        <div class="company-header">
                            <div class="company-badge-logo" style="background: {{ $company['primary_color'] }};">
                                {{ strtoupper(substr($company['store_name'], 0, 1)) }}
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                <span class="company-cat-tag">
                                    {{ $company['business_category'] }}
                                </span>
                                <span class="distance-badge-pill" id="dist-badge-{{ $company['id'] }}" style="display: none;">
                                    📍 <span class="dist-val">--</span> km
                                </span>
                            </div>
                        </div>

                        <div class="company-info">
                            <h3>{{ $company['store_name'] }}</h3>

                            <!-- Star Rating & Tradition Badge -->
                            <div class="store-rating-row" style="flex-wrap: wrap; gap: 6px;">
                                <span class="stars-gold">★★★★★</span>
                                <span class="rating-num" id="companyRatingNum_{{ $company['id'] }}">{{ number_format($company['rating'] ?? 4.9, 1) }}</span>
                                <span class="rating-count" id="companyReviewsCount_{{ $company['id'] }}">({{ $company['reviews_count'] ?? 180 }} <span data-i18n="reviews">reseñas</span>)</span>
                                <button type="button" class="btn-company-reviews-trigger" onclick='openCompanyReviewsModal({
                                    id: @json($company["id"]),
                                    name: @json($company["store_name"]),
                                    rating: {{ (float)($company["rating"] ?? 4.9) }},
                                    reviews_count: {{ (int)($company["reviews_count"] ?? 180) }}
                                })'>
                                    💬 Opiniones (1 a 5 ★)
                                </button>
                            </div>
                            @if(!empty($company['tradition_badge']))
                                <div>
                                    <span class="tradition-pill">{{ $company['tradition_badge'] }}</span>
                                </div>
                            @endif

                            <p>{{ $company['tagline'] }}</p>

                            <!-- Physical Location in Zacatecas Centro -->
                            <div class="store-location-chip" title="Dirección física en Zacatecas Centro">
                                <span>📍</span>
                                <span><strong>{{ $company['address'] }}</strong> ({{ $company['neighborhood_zone'] }})</span>
                            </div>
                            @if(!empty($company['location_reference']))
                                <div style="font-size: 11.5px; color: var(--muted); margin-bottom: 8px; display: flex; align-items: center; gap: 5px;">
                                    <span>🧭</span> <em>Ref: {{ $company['location_reference'] }}</em>
                                </div>
                            @endif

                            <!-- Real-time dynamic Open / Closed status -->
                            <div class="store-hours-bar">
                                <div class="store-hours-info">
                                    <span>⏰</span> <span class="hours-text">{{ $company['opening_hours'] }}</span>
                                </div>
                                <span class="store-open-badge badge-closed" id="badge-open-{{ $company['id'] }}">
                                    <span class="dot"></span>
                                    <span class="status-text">...</span>
                                </span>
                            </div>
                        </div>

                        <!-- Top 3 Preview Products of this Company -->
                        @if(count($company['sample_products']) > 0)
                            <div class="company-preview-strip">
                                <div class="preview-strip-label">
                                    <span data-i18n="featured_items">Artículos destacados</span>
                                    <span>{{ $company['products_count'] }} <span data-i18n="products_count_label">productos</span></span>
                                </div>
                                <div class="preview-products-grid">
                                    @foreach(collect($company['sample_products'])->take(3) as $prod)
                                        <div class="preview-thumb-box" title="{{ $prod['name'] }}">
                                            <a href="{{ $prod['url'] }}" style="display: block; width: 100%; height: 100%; text-decoration: none;"
                                                onclick='event.preventDefault(); openCentralProductModal({
                                                    id: @json($prod["id"] ?? (string)\Illuminate\Support\Str::slug($prod["name"])),
                                                    store_id: @json($company["id"]),
                                                    name: @json($prod["name"]),
                                                    price: {{ (float)$prod["price"] }},
                                                    image_url: @json($prod["image_url"] ?? ""),
                                                    description: @json($prod["description"] ?? ""),
                                                    stock: {{ (int)($prod["stock"] ?? 15) }},
                                                    url: @json($prod["url"]),
                                                    store_name: @json($company["store_name"]),
                                                    store_url: @json($company["store_url"]),
                                                    address: @json($company["address"]),
                                                    hours: @json($company["opening_hours"]),
                                                    whatsapp: @json($company["whatsapp_number"] ?? ""),
                                                    maps_url: @json($company["maps_url"] ?? "")
                                                });'>
                                                <img src="{{ !empty($prod['image_url']) ? $prod['image_url'] : 'https://placehold.co/200x200?text=Prod' }}" alt="{{ $prod['name'] }}" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/200x200?text=Zacatecas';">
                                                <span class="preview-thumb-price">${{ number_format($prod['price'], 0) }}</span>
                                            </a>
                                            <button type="button" class="preview-quick-add-btn" title="Añadir a mi Carrito de Ruta" onclick='event.stopPropagation(); event.preventDefault(); quickAddProductToRouteCart({
                                                id: @json($prod["id"] ?? (string)\Illuminate\Support\Str::slug($prod["name"])),
                                                store_id: @json($company["id"]),
                                                store_name: @json($company["store_name"]),
                                                name: @json($prod["name"]),
                                                price: {{ (float)$prod["price"] }},
                                                image_url: @json($prod["image_url"] ?? "")
                                            });'>+ 🛒</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Redes Sociales y Enlaces Oficiales -->
                        @if(!empty($company['whatsapp_number']) || !empty($company['facebook_url']) || !empty($company['instagram_url']) || !empty($company['official_website_url']) || !empty($company['maps_url']))
                            <div class="company-social-bar">
                                <span class="company-social-label" data-i18n="social_label">Redes & Contacto</span>
                                <div class="company-social-links">
                                    @if(!empty($company['whatsapp_number']))
                                        @php $compWa = preg_replace('/[^0-9]/', '', $company['whatsapp_number']); @endphp
                                        <a href="https://wa.me/{{ $compWa }}?text={{ urlencode('¡Hola! Me comunico desde el portal para ' . $company['store_name']) }}" target="_blank" class="social-icon-btn btn-wa" title="WhatsApp: {{ $company['whatsapp_number'] }}">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                            <span>WhatsApp</span>
                                        </a>
                                    @endif
                                    @if(!empty($company['facebook_url']))
                                        <a href="{{ $company['facebook_url'] }}" target="_blank" class="social-icon-btn btn-fb" title="Facebook de {{ $company['store_name'] }}">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            <span>Facebook</span>
                                        </a>
                                    @endif
                                    @if(!empty($company['instagram_url']))
                                        <a href="{{ $company['instagram_url'] }}" target="_blank" class="social-icon-btn btn-ig" title="Instagram de {{ $company['store_name'] }}">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                            <span>Instagram</span>
                                        </a>
                                    @endif
                                    @if(!empty($company['official_website_url']))
                                        <a href="{{ $company['official_website_url'] }}" target="_blank" class="social-icon-btn btn-web" title="Sitio Web Oficial">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                            <span>Web</span>
                                        </a>
                                    @endif
                                    @if(!empty($company['maps_url']))
                                        <a href="{{ $company['maps_url'] }}" target="_blank" class="social-icon-btn btn-map" title="Ver en Google Maps">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                            <span>Mapa</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="company-actions-footer">
                        <button type="button" class="btn-focus-map-card" onclick="focusStoreOnMap('{{ $company['id'] }}')" title="Ubicar sucursal física en el mapa de Zacatecas Centro">
                            <span>📍 Ver en Mapa</span>
                        </button>
                        <a href="{{ $company['store_url'] }}" target="_blank" class="btn-visit-company">
                            <span data-i18n="enter_store">Entrar a la Tienda</span> <span>↗</span>
                        </a>
                        <button type="button" class="btn-share-card" onclick="shareStore('{{ addslashes($company['store_name']) }}', '{{ $company['store_url'] }}', '{{ addslashes($company['tagline']) }}')" title="Compartir comercio" aria-label="Compartir {{ $company['store_name'] }}">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: var(--card); border-radius: 18px;">
                    <h3>No hay empresas en esta categoría</h3>
                    <p style="color: var(--muted); margin: 8px 0 16px;">Elige otra categoría en los filtros superiores.</p>
                    <a href="{{ url('/?categoria=all') }}#empresas" class="filter-pill active">Ver todas</a>
                </div>
            @endforelse
        </div>
    </section>
    </div> <!-- /#panelStores -->

    <!-- FLOATING STICKY ROUTE CART BAR (VISIBLE WHEN ITEMS IN CART) -->
    <div class="floating-route-cart-bar" id="floatingRouteCartBar" onclick="goToCartRoutePlanner()" style="display: none;">
        <div class="floating-cart-inner">
            <div class="floating-cart-info">
                <span class="floating-cart-icon">🛒</span>
                <div>
                    <strong id="floatingCartText">0 productos en tu Carrito</strong>
                    <small id="floatingCartSub">Calcula tu ruta recomendada desde tu ubicación</small>
                </div>
            </div>
            <div class="floating-cart-action">
                <span class="floating-cart-total" id="floatingCartTotal">$0.00 MXN</span>
                <button type="button" class="btn-floating-route-cta">
                    <span>🗺️ Ver Ruta Recomendada ➔</span>
                </button>
            </div>
        </div>
    </div>

</main>

<!-- FOOTER -->
<footer class="portal-footer">
    <div class="shell">
        <div class="portal-footer-grid">
            <div>
                <div class="portal-brand" style="margin-bottom: 12px;">
                    <div class="brand-badge">✦</div>
                    <strong style="font-size: 16px;">Atelier Marketplace Multi-Empresa</strong>
                </div>
                <p>Plataforma SaaS con arquitectura Multi-Database (stancl/tenancy), paneles Filament PHP y soporte para consumo desde aplicaciones web y móviles con Laravel Sanctum.</p>
            </div>
            <div>
                <h4>Categorías de Empresas</h4>
                <ul>
                    @foreach($businessCategories as $cat)
                        <li><a href="{{ url('/?categoria=' . urlencode($cat)) }}#empresas">{{ $cat }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4>Administración</h4>
                <ul>
                    <li><a href="{{ url('/admin') }}" target="_blank">Panel Super Admin</a></li>
                    <li><a href="{{ url('/admin/tenants') }}" target="_blank">Gestión de Empresas</a></li>
                    <li><a href="javascript:void(0)" onclick="openAuthModal('login')">Inicio de Sesión</a></li>
                </ul>
            </div>
        </div>
        <div class="portal-footer-bottom">
            <span>© {{ date('Y') }} Atelier Marketplace. Todos los derechos reservados.</span>
            <span>Laravel 12 · Stancl Tenancy · Filament v3</span>
        </div>
    </div>
</footer>

<!-- AUTH MODAL (INICIO DE SESIÓN CON GOOGLE, FACEBOOK Y CORREO) -->
<div class="modal-backdrop" id="authModal">
    <div class="auth-modal-card">
        <button class="modal-close-x" onclick="closeAuthModal()" aria-label="Cerrar modal">✕</button>

        <!-- Tab 1: LOGIN -->
        <div id="loginView">
            <h3 class="auth-modal-title">Iniciar Sesión</h3>
            <p class="auth-modal-subtitle">Accede con tu cuenta preferida para navegar por las tiendas.</p>

            <div class="social-login-group">
                <!-- 1. GOOGLE LOGIN -->
                @if($hasGoogleKeys)
                    <a href="{{ url('/auth/google') }}" class="btn-social-auth btn-google-auth">
                        <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                        <span>Continuar con Google</span>
                    </a>
                @else
                    <button type="button" onclick="switchAuthTab('googleChooser')" class="btn-social-auth btn-google-auth">
                        <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                        <span>Continuar con Google</span>
                    </button>
                @endif

                <!-- 2. FACEBOOK LOGIN -->
                @if($hasFacebookKeys)
                    <a href="{{ url('/auth/facebook') }}" class="btn-social-auth btn-facebook-auth">
                        <svg width="20" height="20" fill="#ffffff" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Continuar con Facebook</span>
                    </a>
                @else
                    <button type="button" onclick="switchAuthTab('facebookChooser')" class="btn-social-auth btn-facebook-auth">
                        <svg width="20" height="20" fill="#ffffff" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Continuar con Facebook</span>
                    </button>
                @endif
            </div>

            <div class="auth-separator">
                <span>o con tu correo</span>
            </div>

            <!-- 3. EMAIL LOGIN -->
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="auth-field">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" placeholder="ejemplo@correo.com" required value="{{ old('email') }}">
                </div>
                <div class="auth-field">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="Tu contraseña" required>
                </div>
                <button type="submit" class="btn-submit-email-auth">
                    Iniciar Sesión con Correo
                </button>
            </form>

            <p class="auth-modal-switch-text">
                ¿No tienes cuenta? <a onclick="switchAuthTab('register')">Crear cuenta gratuita</a>
            </p>
        </div>

        <!-- Tab 2: REGISTER -->
        <div id="registerView" style="display: none;">
            <h3 class="auth-modal-title">Crear Cuenta</h3>
            <p class="auth-modal-subtitle">Regístrate para comprar en todas las tiendas oficiales.</p>

            <form action="{{ url('/register') }}" method="POST">
                @csrf
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
                    Crear Cuenta con Correo
                </button>
            </form>

            <p class="auth-modal-switch-text">
                ¿Ya tienes cuenta? <a onclick="switchAuthTab('login')">Iniciar sesión</a>
            </p>
        </div>

        <!-- Tab 3: GOOGLE CHOOSER -->
        <div id="googleChooserView" style="display: none;">
            <button type="button" onclick="switchAuthTab('login')" class="social-back-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Volver
            </button>

            <div style="text-align: center; margin-bottom: 20px;">
                <svg width="36" height="36" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                <h3 class="auth-modal-title" style="margin-top: 8px;">Elegir cuenta de Google</h3>
                <p class="auth-modal-subtitle">para continuar en Zacatecas Centro Marketplace</p>
            </div>

            <!-- Cuentas rápidas de 1 toque -->
            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                <form action="{{ url('/auth/social/login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="provider" value="google">
                    <input type="hidden" name="name" value="Manuel González">
                    <input type="hidden" name="email" value="manuel.zacatecas@gmail.com">
                    <input type="hidden" name="avatar_url" value="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80">
                    <button type="submit" class="social-account-item">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80" alt="Avatar" class="social-account-avatar">
                        <div class="social-account-info">
                            <strong>Manuel González</strong>
                            <small>manuel.zacatecas@gmail.com</small>
                        </div>
                    </button>
                </form>

                <form action="{{ url('/auth/social/login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="provider" value="google">
                    <input type="hidden" name="name" value="Comercio Zacatecas">
                    <input type="hidden" name="email" value="contacto.tienda@gmail.com">
                    <input type="hidden" name="avatar_url" value="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=120&q=80">
                    <button type="submit" class="social-account-item">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=120&q=80" alt="Avatar" class="social-account-avatar">
                        <div class="social-account-info">
                            <strong>Comercio Zacatecas</strong>
                            <small>contacto.tienda@gmail.com</small>
                        </div>
                    </button>
                </form>
            </div>

            <!-- Opción: Ingresar tu cuenta real de Google -->
            <details style="border: 1px solid var(--line); border-radius: 12px; padding: 10px 14px; background: #fafaf9; margin-bottom: 12px;">
                <summary style="font-size: 12.5px; font-weight: 700; color: var(--ink); cursor: pointer;">
                    ✍️ Usar tu propio correo de Google (Gmail)
                </summary>
                <form action="{{ url('/auth/social/login') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <input type="hidden" name="provider" value="google">
                    <input type="hidden" name="avatar_url" value="">
                    <div class="auth-field" style="margin-bottom: 8px;">
                        <label style="font-size: 11px;">Tu Nombre Completo</label>
                        <input type="text" name="name" placeholder="Ej. Manuel González" required style="padding: 8px 12px; font-size: 13px;">
                    </div>
                    <div class="auth-field" style="margin-bottom: 10px;">
                        <label style="font-size: 11px;">Tu Correo Gmail</label>
                        <input type="email" name="email" placeholder="ejemplo@gmail.com" required style="padding: 8px 12px; font-size: 13px;">
                    </div>
                    <button type="submit" class="btn-submit-email-auth" style="padding: 10px; font-size: 13px; background: #4285F4;">
                        Entrar con mi Gmail
                    </button>
                </form>
            </details>

            <div class="social-env-notice">
                <span>💡 <strong>Modo pruebas móviles activado:</strong> Puedes ingresar de inmediato con 1 toque. Cuando configures <code>GOOGLE_CLIENT_ID</code> y <code>GOOGLE_CLIENT_SECRET</code> en tu archivo <code>.env</code>, este botón abrirá la pantalla de consentimiento oficial de Google.</span>
            </div>
        </div>

        <!-- Tab 4: FACEBOOK CHOOSER -->
        <div id="facebookChooserView" style="display: none;">
            <button type="button" onclick="switchAuthTab('login')" class="social-back-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Volver
            </button>

            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 42px; height: 42px; background: #1877F2; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin: 0 auto 6px;">
                    <svg width="24" height="24" fill="#ffffff" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </div>
                <h3 class="auth-modal-title">Iniciar sesión con Facebook</h3>
                <p class="auth-modal-subtitle">para continuar en Zacatecas Centro Marketplace</p>
            </div>

            <!-- Cuentas rápidas de 1 toque -->
            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                <form action="{{ url('/auth/social/login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="provider" value="facebook">
                    <input type="hidden" name="name" value="Manuel G. (Facebook)">
                    <input type="hidden" name="email" value="manuel.fb@facebook.com">
                    <input type="hidden" name="avatar_url" value="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=120&q=80">
                    <button type="submit" class="social-account-item">
                        <img src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=120&q=80" alt="Avatar" class="social-account-avatar">
                        <div class="social-account-info">
                            <strong>Manuel G. (Facebook)</strong>
                            <small>manuel.fb@facebook.com</small>
                        </div>
                    </button>
                </form>

                <form action="{{ url('/auth/social/login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="provider" value="facebook">
                    <input type="hidden" name="name" value="Cliente Zacatecas">
                    <input type="hidden" name="email" value="cliente.fb@facebook.com">
                    <input type="hidden" name="avatar_url" value="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80">
                    <button type="submit" class="social-account-item">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80" alt="Avatar" class="social-account-avatar">
                        <div class="social-account-info">
                            <strong>Cliente Zacatecas</strong>
                            <small>cliente.fb@facebook.com</small>
                        </div>
                    </button>
                </form>
            </div>

            <!-- Opción: Ingresar tu cuenta real de Facebook -->
            <details style="border: 1px solid var(--line); border-radius: 12px; padding: 10px 14px; background: #fafaf9; margin-bottom: 12px;">
                <summary style="font-size: 12.5px; font-weight: 700; color: var(--ink); cursor: pointer;">
                    ✍️ Usar tu propio nombre/cuenta de Facebook
                </summary>
                <form action="{{ url('/auth/social/login') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <input type="hidden" name="provider" value="facebook">
                    <input type="hidden" name="avatar_url" value="">
                    <div class="auth-field" style="margin-bottom: 8px;">
                        <label style="font-size: 11px;">Tu Nombre en Facebook</label>
                        <input type="text" name="name" placeholder="Ej. Manuel González" required style="padding: 8px 12px; font-size: 13px;">
                    </div>
                    <div class="auth-field" style="margin-bottom: 10px;">
                        <label style="font-size: 11px;">Tu Correo o Usuario</label>
                        <input type="email" name="email" placeholder="tu_correo@facebook.com" required style="padding: 8px 12px; font-size: 13px;">
                    </div>
                    <button type="submit" class="btn-submit-email-auth" style="padding: 10px; font-size: 13px; background: #1877F2;">
                        Entrar con Facebook
                    </button>
                </form>
            </details>

            <div class="social-env-notice">
                <span>💡 <strong>Modo pruebas móviles activado:</strong> Puedes ingresar de inmediato con 1 toque. Cuando configures <code>FACEBOOK_CLIENT_ID</code> y <code>FACEBOOK_CLIENT_SECRET</code> en tu archivo <code>.env</code>, este botón abrirá la pantalla de consentimiento oficial de Meta / Facebook.</span>
            </div>
        </div>
    </div>
</div>

<!-- CENTRAL PRODUCT DETAIL QUICK VIEW MODAL -->
<div class="modal-backdrop" id="centralProductModal">
    <div class="central-product-modal-card">
        <div class="modal-drag-indicator"></div>
        <div class="modal-header-actions">
            <button class="modal-close-btn" onclick="closeCentralProductModal()" aria-label="Cerrar modal" title="Cerrar">✕</button>
        </div>
        <div class="modal-main-layout">
            <!-- Left: Product Image & Store Badge -->
            <div class="modal-img-col">
                <div class="modal-img-wrap">
                    <img id="centralModalImg" src="" alt="Producto" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/600x600?text=Zacatecas+Producto';">
                </div>
                <div class="modal-badges-row">
                    <span class="modal-chip modal-chip-store" id="centralModalStoreBadge">🏬 Tienda</span>
                    <span class="modal-chip modal-chip-stock" id="centralModalStock">✓ En existencia</span>
                </div>
            </div>

            <!-- Right: Product Info, Store & Actions -->
            <div class="modal-content-col">
                <span class="modal-cat-tag" id="centralModalStoreTag">Comercio Oficial</span>
                <h3 class="modal-title" id="centralModalTitle">Nombre del Producto</h3>
                
                <div class="modal-price-row">
                    <div class="modal-price" id="centralModalPrice">$0.00</div>
                    <span class="modal-price-currency">MXN / Zacatecas Centro</span>
                </div>

                <p class="modal-desc" id="centralModalDesc">Descripción del producto.</p>

                <!-- Store Info in Zacatecas Centro -->
                <div class="modal-zac-location-box">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 4px;">
                        <span style="font-size: 11.5px; font-weight: 800; color: var(--accent); text-transform: uppercase; letter-spacing: .06em; display: flex; align-items: center; gap: 5px;">
                            <span>📍</span> <span id="centralModalStoreLocName">Sucursal Zacatecas Centro</span>
                        </span>
                        <a id="centralModalMapsLink" href="#" target="_blank" style="font-size: 11px; font-weight: 700; color: var(--accent); text-decoration: underline;">
                            Ver Mapa ↗
                        </a>
                    </div>
                    <div id="centralModalAddress" style="font-size: 12.5px; font-weight: 600; color: var(--ink);">Centro Histórico, Zacatecas</div>
                    <div id="centralModalHours" style="font-size: 11px; color: var(--muted); margin-top: 3px;">
                        ⏰ Lunes a Sábado: 10:00 AM - 8:30 PM
                    </div>
                </div>

                <!-- REVIEWS & 1-5 STAR COMMENTS SECTION FOR THIS PRODUCT -->
                <div class="reviews-section-box">
                    <div class="reviews-header-row">
                        <div class="reviews-summary-badge">
                            <span class="stars-gold">★★★★★</span>
                            <span id="productModalRatingVal">5.0</span>
                            <span id="productModalReviewCount">(0 reseñas)</span>
                        </div>
                        <button type="button" class="btn-toggle-review-form" onclick="toggleProductReviewForm()">
                            ✍️ Dejar Opinión (1 a 5 ★)
                        </button>
                    </div>

                    <!-- Collapsible Review Form -->
                    <div class="review-form-card" id="productReviewFormCard" style="display: none;">
                        <h4 style="font-size: 13px; font-weight: 800; margin: 0 0 4px; color: var(--ink);">Calificar este Producto</h4>
                        <div style="margin-bottom: 6px;">
                            <label style="font-size: 11px; color: var(--muted); font-weight: 700;">Selecciona tus estrellas:</label>
                            <div class="star-rating-selector" id="productStarPicker">
                                <button type="button" class="star-pick-btn active" data-val="1" onclick="setProductStarRating(1)">★</button>
                                <button type="button" class="star-pick-btn active" data-val="2" onclick="setProductStarRating(2)">★</button>
                                <button type="button" class="star-pick-btn active" data-val="3" onclick="setProductStarRating(3)">★</button>
                                <button type="button" class="star-pick-btn active" data-val="4" onclick="setProductStarRating(4)">★</button>
                                <button type="button" class="star-pick-btn active" data-val="5" onclick="setProductStarRating(5)">★</button>
                            </div>
                        </div>
                        <div class="auth-field" style="margin-bottom: 8px;">
                            <label style="font-size: 11px;">Tu Nombre</label>
                            <input type="text" id="productReviewAuthorInput" placeholder="Ej. Roberto L." required style="padding: 8px 12px; font-size: 12.5px;">
                        </div>
                        <div class="auth-field" style="margin-bottom: 10px;">
                            <label style="font-size: 11px;">Tu Opinión sobre el Producto</label>
                            <textarea id="productReviewCommentInput" rows="2" placeholder="¿Qué te pareció el sabor, calidad, presentación o textura?" required style="width: 100%; padding: 8px 12px; border-radius: 10px; border: 1.5px solid var(--card-border); background: var(--card); color: var(--ink); font-size: 12.5px; resize: vertical;"></textarea>
                        </div>
                        <button type="button" id="btnSubmitProductReview" onclick="submitProductReview()" class="btn-submit-email-auth" style="margin-top: 0; padding: 9px; font-size: 12.5px;">
                            Publicar Calificación de Producto
                        </button>
                    </div>

                    <!-- Reviews List for Product -->
                    <div id="productReviewsContainer" style="max-height: 220px; overflow-y: auto;">
                        <!-- Dynamically populated -->
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="modal-actions-row">
                    <button type="button" id="centralModalAddCartBtn" class="btn-add-cart-route-modal" onclick="addCurrentModalProductToRouteCart()">
                        <span>🛒</span> Añadir a mi Carrito para Ruta
                    </button>
                    <a id="centralModalWaBtn" href="#" target="_blank" class="btn-whatsapp-order">
                        <svg style="width:20px; height:20px; fill:#fff;" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.769.814 2.797.814 3.18 0 5.767-2.587 5.768-5.766 0-3.18-2.588-5.766-5.769-5.766zm0 10.355c-.886 0-1.616-.242-2.348-.675l-.168-.1-1.745.458.466-1.701-.11-.175c-.476-.757-.728-1.503-.728-2.399 0-2.531 2.059-4.59 4.635-4.59 2.576 0 4.635 2.059 4.635 4.59 0 2.531-2.059 4.592-4.535 4.592zm-8.031-4.589c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12z"/></svg>
                        Pedir por WhatsApp (<span id="centralModalBtnPrice">$0.00</span>)
                    </a>
                    <a id="centralModalStoreBtn" href="#" class="btn-visit-store-modal">
                        <span>🏬</span> Ir a la Tienda Oficial Completa ↗
                    </a>
                </div>
                    <button type="button" class="btn-return-home-modal" onclick="closeCentralProductModal(); goToPortalHome();" style="width: 100%; margin-top: 10px; padding: 12px; border-radius: 12px; background: rgba(200, 109, 99, 0.12); color: var(--accent); border: 1.5px solid rgba(200, 109, 99, 0.3); font-weight: 700; font-size: 13.5px; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer;">
                        <span>🏠</span> Volver al Inicio de Zacatecas
                    </button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Back to Top Button -->
<button type="button" class="btn-back-to-top" id="btnBackToTop" onclick="scrollToTop()" title="Volver arriba" aria-label="Volver arriba">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
</button>

<!-- Global Toast Notification -->
<div class="toast-popup" id="toastPopup" role="status" aria-live="polite"></div>

<!-- MODAL: CALIFICACIONES Y COMENTARIOS DE EMPRESA (1 A 5 ESTRELLAS) -->
<div class="modal-backdrop" id="companyReviewsModal" onclick="handleCompanyReviewsBackdrop(event)">
    <div class="modal-card create-story-modal-card" style="max-width: 540px;">
        <button type="button" class="modal-close-x" onclick="closeCompanyReviewsModal()" aria-label="Cerrar modal">✕</button>

        <div style="text-align: center; margin-bottom: 16px;">
            <span class="section-eyebrow" style="color: var(--accent);">✦ Opiniones y Calificaciones de Clientes</span>
            <h3 id="companyReviewStoreTitle" style="font-size: 21px; font-weight: 800; margin: 4px 0; color: var(--ink);">Nombre de la Empresa</h3>
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 6px;">
                <span class="stars-gold" style="font-size: 16px;">★★★★★</span>
                <strong id="companyReviewAvgRating" style="font-size: 15px; color: var(--ink);">5.0</strong>
                <span id="companyReviewCountText" style="font-size: 12px; color: var(--muted);">(0 opiniones)</span>
            </div>
        </div>

        <!-- Review Submission Card -->
        <div class="review-form-card">
            <h4 style="font-size: 13.5px; font-weight: 800; margin: 0 0 4px; color: var(--ink);">✍️ Deja tu Calificación (1 a 5 Estrellas)</h4>
            <p style="font-size: 12px; color: var(--muted); margin: 0 0 10px;">Tu experiencia ayuda a otros compradores y a los comercios de Zacatecas Centro.</p>

            <form id="companyReviewForm" onsubmit="submitCompanyReview(event)">
                <input type="hidden" id="companyReviewStoreId" value="">
                
                <div style="margin-bottom: 8px;">
                    <label style="font-size: 11px; font-weight: 700; color: var(--muted); display: block;">Calificación:</label>
                    <div class="star-rating-selector" id="companyStarPicker">
                        <button type="button" class="star-pick-btn active" data-val="1" onclick="setCompanyStarRating(1)">★</button>
                        <button type="button" class="star-pick-btn active" data-val="2" onclick="setCompanyStarRating(2)">★</button>
                        <button type="button" class="star-pick-btn active" data-val="3" onclick="setCompanyStarRating(3)">★</button>
                        <button type="button" class="star-pick-btn active" data-val="4" onclick="setCompanyStarRating(4)">★</button>
                        <button type="button" class="star-pick-btn active" data-val="5" onclick="setCompanyStarRating(5)">★</button>
                    </div>
                </div>

                <div class="auth-field" style="margin-bottom: 8px;">
                    <label style="font-size: 11px;">Tu Nombre o Alias</label>
                    <input type="text" id="companyReviewAuthorInput" placeholder="Ej. Mariana González" required style="padding: 9px 12px; font-size: 13px;">
                </div>

                <div class="auth-field" style="margin-bottom: 12px;">
                    <label style="font-size: 11px;">Tu Comentario u Opinión</label>
                    <textarea id="companyReviewCommentInput" rows="2" placeholder="Cuéntanos tu experiencia con sus productos, atención y calidad..." required style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1.5px solid var(--card-border); background: var(--card); color: var(--ink); font-size: 13px; resize: vertical;"></textarea>
                </div>

                <button type="submit" id="btnSubmitCompanyReview" class="btn-submit-email-auth" style="margin-top: 0; padding: 10px; font-size: 13px;">
                    Publicar Mi Opinión (1 a 5 ★)
                </button>
            </form>
        </div>

        <!-- List of Reviews -->
        <div>
            <h4 style="font-size: 14px; font-weight: 800; margin: 0 0 10px; color: var(--ink);">Opiniones de Clientes Verificados</h4>
            <div id="companyReviewsContainer">
                <!-- Dynamically populated via AJAX -->
            </div>
                <button type="button" class="btn-return-home-modal" onclick="closeCompanyReviewsModal(); goToPortalHome();" style="width: 100%; margin-top: 14px; padding: 11px; border-radius: 12px; background: rgba(200, 109, 99, 0.12); color: var(--accent); border: 1.5px solid rgba(200, 109, 99, 0.3); font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer;">
            <span>🏠</span> Volver al Inicio de Zacatecas
        </button>
</div>
    </div>
</div>

<!-- NATIVE MOBILE BOTTOM NAVIGATION BAR -->
<nav class="mobile-bottom-nav" id="mobileBottomNav" aria-label="Navegación Móvil Principal">
    <button type="button" class="bottom-nav-tab active" id="bnavFeed" onclick="goToPortalHome()" aria-label="Inicio">
        <span class="bottom-nav-icon">🏠</span>
        <span class="bottom-nav-label">Inicio</span>
    </button>
    <button type="button" class="bottom-nav-tab" id="bnavStores" onclick="switchMainTab('stores')" aria-label="Tiendas">
        <span class="bottom-nav-icon">🏢</span>
        <span class="bottom-nav-label">Tiendas</span>
    </button>
    <button type="button" class="bottom-nav-tab" id="bnavMap" onclick="switchMainTab('map')" aria-label="Mapa GPS">
        <span class="bottom-nav-icon">🗺️</span>
        <span class="bottom-nav-label">Mapa GPS</span>
    </button>
    <button type="button" class="bottom-nav-tab" id="bnavRoute" onclick="toggleShoppingRouteOptimizer()" aria-label="Mi Ruta">
        <span class="bottom-nav-icon">🛍️</span>
        <span class="bottom-nav-label">Mi Ruta</span>
        <span class="bottom-nav-badge" id="bnavRouteBadge" style="display: none;">0</span>
    </button>
    <button type="button" class="bottom-nav-tab" id="bnavSearch" onclick="focusGlobalSearch()" aria-label="Buscar">
        <span class="bottom-nav-icon">🔍</span>
        <span class="bottom-nav-label">Buscar</span>
    </button>
</nav>

<!-- FLOATING RETURN HOME PILL -->
<button type="button" class="pwa-floating-home-pill" id="pwaFloatingHomePill" onclick="goToPortalHome()" aria-label="Volver al Inicio" title="Volver al Inicio">
    <span class="pwa-pill-icon">🏠</span>
    <span class="pwa-pill-text">Inicio Zacatecas</span>
</button>

<!-- JAVASCRIPT FOR LIVE SEARCH & MODAL -->
<script>
// ========================================================
// 1 TO 5 STARS RATING & COMMENTS SYSTEM (PRODUCTS & COMPANIES)
// ========================================================
let currentProductReviewSlug = null;
let currentSelectedProductStars = 5;
let currentCompanyReviewStoreId = null;
let currentSelectedCompanyStars = 5;

// Open product modal with review data and fetch reviews
const origOpenCentralProductModal = window.openCentralProductModal;

function openProductReviewsTab(prod) {
    openCentralProductModal(prod);
    const formCard = document.getElementById('productReviewFormCard');
    if (formCard) formCard.style.display = 'block';
}

function setProductStarRating(stars) {
    currentSelectedProductStars = stars;
    const picker = document.getElementById('productStarPicker');
    if (!picker) return;
    const buttons = picker.querySelectorAll('.star-pick-btn');
    buttons.forEach((btn, idx) => {
        btn.classList.toggle('active', idx < stars);
    });
}

function toggleProductReviewForm() {
    const card = document.getElementById('productReviewFormCard');
    if (card) {
        card.style.display = (card.style.display === 'none' || card.style.display === '') ? 'block' : 'none';
    }
}

function loadProductReviews(prodSlug, defaultAvg = 5.0, defaultCount = 0) {
    currentProductReviewSlug = prodSlug;
    const container = document.getElementById('productReviewsContainer');
    const ratingVal = document.getElementById('productModalRatingVal');
    const countVal = document.getElementById('productModalReviewCount');
    if (!container) return;

    container.innerHTML = '<div style="font-size: 12px; color: var(--muted); padding: 8px 0;">Cargando opiniones...</div>';

    fetch('/api/reviews?type=product&id=' + encodeURIComponent(prodSlug))
        .then(res => res.json())
        .then(data => {
            if (data.success && data.reviews.length > 0) {
                if (ratingVal) ratingVal.textContent = parseFloat(data.average_rating).toFixed(1);
                if (countVal) countVal.textContent = `(${data.count} reseñas)`;
                renderReviewsList(container, data.reviews);
            } else {
                if (ratingVal) ratingVal.textContent = parseFloat(defaultAvg).toFixed(1);
                if (countVal) countVal.textContent = `(${defaultCount} reseñas)`;
                container.innerHTML = '<div style="font-size: 12px; color: var(--muted); padding: 8px 0;">Sé el primero en calificar este producto en Zacatecas Centro.</div>';
            }
        })
        .catch(() => {
            container.innerHTML = '<div style="font-size: 12px; color: var(--muted); padding: 8px 0;">No se pudieron cargar las opiniones.</div>';
        });
}

function submitProductReview() {
    const authorInput = document.getElementById('productReviewAuthorInput');
    const commentInput = document.getElementById('productReviewCommentInput');
    const btn = document.getElementById('btnSubmitProductReview');

    if (!authorInput.value.trim()) {
        showToast('Por favor escribe tu nombre');
        authorInput.focus();
        return;
    }
    if (!commentInput.value.trim() || commentInput.value.trim().length < 4) {
        showToast('Por favor escribe un comentario de al menos 4 letras');
        commentInput.focus();
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Publicando opinión...';

    fetch('/api/reviews', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            reviewable_type: 'product',
            reviewable_id: currentProductReviewSlug,
            rating: currentSelectedProductStars,
            author_name: authorInput.value.trim(),
            comment: commentInput.value.trim(),
        })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.textContent = 'Publicar Calificación de Producto';

        if (data.success) {
            showToast('⭐ ' + data.message);
            commentInput.value = '';
            toggleProductReviewForm();

            // Refresh reviews
            loadProductReviews(currentProductReviewSlug);
        } else {
            showToast('Error: ' + (data.message || 'Verifica los datos'));
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Publicar Calificación de Producto';
        showToast('Error al enviar la calificación.');
    });
}

// --- COMPANY REVIEWS SYSTEM ---
function openCompanyReviewsModal(comp) {
    currentCompanyReviewStoreId = comp.id;
    const modal = document.getElementById('companyReviewsModal');
    const title = document.getElementById('companyReviewStoreTitle');
    const avg = document.getElementById('companyReviewAvgRating');
    const count = document.getElementById('companyReviewCountText');
    const storeInput = document.getElementById('companyReviewStoreId');

    if (title) title.textContent = comp.name;
    if (avg) avg.textContent = parseFloat(comp.rating || 4.9).toFixed(1);
    if (count) count.textContent = `(${comp.reviews_count || 0} opiniones)`;
    if (storeInput) storeInput.value = comp.id;

    loadCompanyReviews(comp.id, comp.rating, comp.reviews_count);

    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        if (window.history && window.history.pushState) {
            window.history.pushState({ pwaModal: 'companyReviews' }, '');
        }
    }
}

function closeCompanyReviewsModal() {
    const modal = document.getElementById('companyReviewsModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

function handleCompanyReviewsBackdrop(event) {
    if (event.target && event.target.id === 'companyReviewsModal') {
        closeCompanyReviewsModal();
    }
}

function setCompanyStarRating(stars) {
    currentSelectedCompanyStars = stars;
    const picker = document.getElementById('companyStarPicker');
    if (!picker) return;
    const buttons = picker.querySelectorAll('.star-pick-btn');
    buttons.forEach((btn, idx) => {
        btn.classList.toggle('active', idx < stars);
    });
}

function loadCompanyReviews(storeId, defaultAvg = 4.9, defaultCount = 0) {
    const container = document.getElementById('companyReviewsContainer');
    const avg = document.getElementById('companyReviewAvgRating');
    const count = document.getElementById('companyReviewCountText');
    if (!container) return;

    container.innerHTML = '<div style="font-size: 12px; color: var(--muted); padding: 8px 0;">Cargando opiniones de clientes...</div>';

    fetch('/api/reviews?type=company&id=' + encodeURIComponent(storeId))
        .then(res => res.json())
        .then(data => {
            if (data.success && data.reviews.length > 0) {
                if (avg) avg.textContent = parseFloat(data.average_rating).toFixed(1);
                if (count) count.textContent = `(${data.count} opiniones)`;
                renderReviewsList(container, data.reviews);
            } else {
                if (avg) avg.textContent = parseFloat(defaultAvg).toFixed(1);
                if (count) count.textContent = `(${defaultCount} opiniones)`;
                container.innerHTML = '<div style="font-size: 12px; color: var(--muted); padding: 8px 0;">Esta empresa aún no tiene comentarios. ¡Sé el primero en calificarla!</div>';
            }
        })
        .catch(() => {
            container.innerHTML = '<div style="font-size: 12px; color: var(--muted); padding: 8px 0;">No se pudieron cargar las opiniones.</div>';
        });
}

function submitCompanyReview(event) {
    event.preventDefault();
    const authorInput = document.getElementById('companyReviewAuthorInput');
    const commentInput = document.getElementById('companyReviewCommentInput');
    const btn = document.getElementById('btnSubmitCompanyReview');

    if (!authorInput.value.trim() || !commentInput.value.trim()) return;

    btn.disabled = true;
    btn.textContent = 'Guardando opinión...';

    fetch('/api/reviews', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            reviewable_type: 'company',
            reviewable_id: currentCompanyReviewStoreId,
            rating: currentSelectedCompanyStars,
            author_name: authorInput.value.trim(),
            comment: commentInput.value.trim(),
        })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.textContent = 'Publicar Mi Opinión (1 a 5 ★)';

        if (data.success) {
            showToast('⭐ ' + data.message);
            commentInput.value = '';

            // Update badge on company card in directory
            const cardRatingNum = document.getElementById('companyRatingNum_' + currentCompanyReviewStoreId);
            const cardCount = document.getElementById('companyReviewsCount_' + currentCompanyReviewStoreId);
            if (cardRatingNum) cardRatingNum.textContent = parseFloat(data.average_rating).toFixed(1);
            if (cardCount) cardCount.textContent = `(${data.reviews_count} reseñas)`;

            loadCompanyReviews(currentCompanyReviewStoreId);
        } else {
            showToast('Error: ' + (data.message || 'Verifica los datos'));
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Publicar Mi Opinión (1 a 5 ★)';
        showToast('Error de conexión al enviar la reseña.');
    });
}

function renderReviewsList(container, reviews) {
    container.innerHTML = '';
    reviews.forEach(r => {
        const item = document.createElement('div');
        item.className = 'review-item-card';

        let starsStr = '★'.repeat(r.rating) + '☆'.repeat(5 - r.rating);

        item.innerHTML = `
            <div class="review-item-header">
                <div class="review-author-name">
                    <span>${r.author_name}</span>
                    <span class="review-verified-tag">✓ Verificado</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="stars-gold">${starsStr}</span>
                    <span class="review-item-date">${r.time_ago}</span>
                </div>
            </div>
            <p class="review-item-text">${r.comment}</p>
        `;
        container.appendChild(item);
    });
}

// ========================================================
// PWA NAVIGATION, GO TO HOME & HISTORY GUARD
// ========================================================
function goToPortalHome() {
    closeCentralProductModal();
    closeCompanyReviewsModal();
    if (typeof closeAuthModal === 'function') closeAuthModal();
    if (typeof closeRentModal === 'function') closeRentModal();
    if (typeof closeMobileMenu === 'function') closeMobileMenu();
    const pwaModal = document.getElementById('pwaGuideModal');
    if (pwaModal) pwaModal.style.display = 'none';

    // Clear search
    const sInput = document.getElementById('globalSearchInput');
    if (sInput && sInput.value) {
        sInput.value = '';
        const clearBtn = document.getElementById('searchClearBtn');
        if (clearBtn) clearBtn.style.display = 'none';
        const liveDropdown = document.getElementById('liveSearchResults');
        if (liveDropdown) liveDropdown.style.display = 'none';
    }

    switchMainTab('feed', false);
    window.scrollTo({ top: 0, behavior: 'smooth' });

    if (window.history && window.history.pushState) {
        window.history.pushState({ portalHomeRoot: true }, '', '/');
    }
}

function focusGlobalSearch() {
    closeCentralProductModal();
    closeCompanyReviewsModal();
    const sInput = document.getElementById('globalSearchInput');
    if (sInput) {
        sInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => sInput.focus(), 300);
    }
}

(function initCentralPwaHistoryGuard() {
    if (!window.history || !window.history.pushState) return;

    window.history.pushState({ portalHomeViewing: true }, '');

    window.addEventListener('popstate', function(e) {
        const pModal = document.getElementById('centralProductModal');
        if (pModal && (pModal.classList.contains('open') || pModal.classList.contains('active') || pModal.style.display === 'flex')) {
            closeCentralProductModal();
            window.history.pushState({ portalHomeViewing: true }, '');
            return;
        }

        const rModal = document.getElementById('companyReviewsModal');
        if (rModal && (rModal.classList.contains('open') || rModal.classList.contains('active') || rModal.style.display === 'flex')) {
            closeCompanyReviewsModal();
            window.history.pushState({ portalHomeViewing: true }, '');
            return;
        }

        const authModal = document.getElementById('authModal');
        if (authModal && (authModal.classList.contains('open') || authModal.classList.contains('active') || authModal.style.display === 'flex')) {
            if (typeof closeAuthModal === 'function') closeAuthModal();
            window.history.pushState({ portalHomeViewing: true }, '');
            return;
        }

        const rentModal = document.getElementById('rentModal');
        if (rentModal && (rentModal.classList.contains('open') || rentModal.classList.contains('active') || rentModal.style.display === 'flex')) {
            if (typeof closeRentModal === 'function') closeRentModal();
            window.history.pushState({ portalHomeViewing: true }, '');
            return;
        }

        const mobileMenu = document.getElementById('portalMobileMenu');
        if (mobileMenu && mobileMenu.classList.contains('open')) {
            if (typeof closeMobileMenu === 'function') closeMobileMenu();
            window.history.pushState({ portalHomeViewing: true }, '');
            return;
        }

        // If in another tab, return to feed tab!
        const savedTab = sessionStorage.getItem('active_portal_tab') || 'feed';
        if (savedTab !== 'feed') {
            switchMainTab('feed', true);
            window.history.pushState({ portalHomeViewing: true }, '');
            return;
        }

        // If at feed, smooth scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();

// MAIN TAB SWITCHER (PARATI, MAPA, TIENDAS, PLANES)
function switchMainTab(tabName, shouldScroll = true) {
    if (tabName === 'plans') {
        window.location.href = "{{ url('/planes') }}";
        return;
    }
    const tabs = ['feed', 'map', 'stores'];
    if (!tabs.includes(tabName)) tabName = 'feed';

    tabs.forEach(t => {
        const panelId = 'panel' + t.charAt(0).toUpperCase() + t.slice(1);
        const btnId = 'tabBtn' + t.charAt(0).toUpperCase() + t.slice(1);
        const panel = document.getElementById(panelId);
        const btn = document.getElementById(btnId);

        if (panel) {
            panel.style.display = (t === tabName) ? 'block' : 'none';
        }
        if (btn) {
            btn.classList.toggle('active', t === tabName);
        }
    });

    // Update Bottom Nav Active State
    const bnavFeed = document.getElementById('bnavFeed');
    const bnavMap = document.getElementById('bnavMap');
    const bnavStores = document.getElementById('bnavStores');
    if (bnavFeed) bnavFeed.classList.toggle('active', tabName === 'feed');
    if (bnavMap) bnavMap.classList.toggle('active', tabName === 'map');
    if (bnavStores) bnavStores.classList.toggle('active', tabName === 'stores');

    // Invalidate Leaflet Map Size so tiles re-render properly
    if (tabName === 'map' && typeof map !== 'undefined' && map) {
        setTimeout(() => {
            map.invalidateSize();
        }, 120);
    }

    if (shouldScroll) {
        const targetEl = document.getElementById('mainTabNavWrapper') || document.getElementById('productosPopulares');
        if (targetEl) {
            targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    try {
        sessionStorage.setItem('active_portal_tab', tabName);
    } catch(e) {}
}

// SOCIAL FEED: DOUBLE TAP LIKE & HEART POP ANIMATION
const userLikes = new Set();

function likeFeedPost(postId, isDoubleTap) {
    const btn = document.getElementById('btnLike-' + postId);
    const icon = document.getElementById('likeIcon-' + postId);
    const countEl = document.getElementById('likeCount-' + postId);
    const heartPop = document.getElementById('heartPop-' + postId);

    const isLiked = userLikes.has(postId);

    if (isDoubleTap) {
        if (!isLiked) {
            userLikes.add(postId);
            if (icon) icon.textContent = '❤️';
            if (btn) btn.classList.add('liked');
            if (countEl) countEl.textContent = (parseInt(countEl.textContent) || 0) + 1;
        }
        if (heartPop) {
            heartPop.classList.remove('active');
            void heartPop.offsetWidth; // trigger reflow
            heartPop.classList.add('active');
            setTimeout(() => heartPop.classList.remove('active'), 750);
        }
    } else {
        if (isLiked) {
            userLikes.delete(postId);
            if (icon) icon.textContent = '🤍';
            if (btn) btn.classList.remove('liked');
            if (countEl) countEl.textContent = Math.max(0, (parseInt(countEl.textContent) || 1) - 1);
        } else {
            userLikes.add(postId);
            if (icon) icon.textContent = '❤️';
            if (btn) btn.classList.add('liked');
            if (countEl) countEl.textContent = (parseInt(countEl.textContent) || 0) + 1;
            if (heartPop) {
                heartPop.classList.remove('active');
                void heartPop.offsetWidth;
                heartPop.classList.add('active');
                setTimeout(() => heartPop.classList.remove('active'), 750);
            }
        }
    }
}

// BILLING CYCLE MANAGEMENT (MONTHLY VS ANNUAL)
let currentBillingCycle = 'annual'; // default to annual with 20% discount

function switchBillingCycle(cycle) {
    currentBillingCycle = cycle;
    const btnMonthly = document.getElementById('btnMonthly');
    const btnAnnual = document.getElementById('btnAnnual');
    const badge = document.getElementById('annualSavingsBadge');

    if (cycle === 'annual') {
        btnAnnual.classList.add('active');
        btnMonthly.classList.remove('active');
        if (badge) badge.style.opacity = '1';
        document.querySelectorAll('.price-annual-box').forEach(el => el.style.display = 'block');
        document.querySelectorAll('.price-monthly-box').forEach(el => el.style.display = 'none');
    } else {
        btnMonthly.classList.add('active');
        btnAnnual.classList.remove('active');
        if (badge) badge.style.opacity = '0.4';
        document.querySelectorAll('.price-annual-box').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.price-monthly-box').forEach(el => el.style.display = 'block');
    }

    // Sync modal cycle select if modal exists
    const modalCycleSelect = document.getElementById('modalCycleSelect');
    if (modalCycleSelect) {
        modalCycleSelect.value = cycle;
        updateModalSummary();
    }
}

// Initial cycle display trigger
document.addEventListener('DOMContentLoaded', () => {
    switchBillingCycle('annual');
});

// RENTAL MODAL HANDLERS (REDIRECTS TO DEDICATED /planes PAGE)
function openRentModal(planSlug = 'crecimiento', cycle = null) {
    window.location.href = "{{ url('/planes') }}";
}

function closeRentModal() {
    // No-op
}


// Close modals when clicking backdrop
window.addEventListener('click', (e) => {
    const authModal = document.getElementById('authModal');
    const rentModal = document.getElementById('rentModal');
    if (e.target === authModal) closeAuthModal();
    if (e.target === rentModal) closeRentModal();
});

// ESC key closes modals
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeAuthModal();
        closeRentModal();
        closeCentralProductModal();
    }
});

// Backdrop click closes centralProductModal
const centralProdModalEl = document.getElementById('centralProductModal');
if (centralProdModalEl) {
    centralProdModalEl.addEventListener('click', (e) => {
        if (e.target === centralProdModalEl) {
            closeCentralProductModal();
        }
    });
}

let currentCentralProduct = null;

function addCurrentModalProductToRouteCart() {
    if (!currentCentralProduct) return;
    addGlobalCartItem(currentCentralProduct);
    closeCentralProductModal();
    showToast(`🛒 "${currentCentralProduct.name}" añadido a tu carrito para la ruta`);
    renderCartForRoute();
    const routeBox = document.getElementById('routeOptimizerPanel');
    if (routeBox) {
        routeBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function openCentralProductModal(item) {
    if (!item) return;
    currentCentralProduct = item;
    const prodSlug = item.slug || String(item.name || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    loadProductReviews(prodSlug, item.rating || 5.0, item.reviews_count || 12);
    const modal = document.getElementById('centralProductModal');
    if (!modal) return;

    const imgEl = document.getElementById('centralModalImg');
    if (imgEl) {
        imgEl.src = item.image_url || 'https://placehold.co/600x600?text=Zacatecas';
        imgEl.alt = item.name || 'Producto';
    }

    const titleEl = document.getElementById('centralModalTitle');
    if (titleEl) titleEl.textContent = item.name || '';

    const storeTagEl = document.getElementById('centralModalStoreTag');
    if (storeTagEl) storeTagEl.textContent = item.store_name ? ('🏬 ' + item.store_name) : 'Comercio Oficial';

    const storeBadgeEl = document.getElementById('centralModalStoreBadge');
    if (storeBadgeEl) storeBadgeEl.textContent = '🏬 ' + (item.store_name || 'Comercio');

    const stockEl = document.getElementById('centralModalStock');
    if (stockEl) {
        if (item.stock > 0) {
            stockEl.textContent = `✓ En existencia (${item.stock} disp.)`;
            stockEl.style.background = '#dcfce7';
            stockEl.style.color = '#166534';
        } else {
            stockEl.textContent = '✕ Agotado temporalmente';
            stockEl.style.background = '#fee2e2';
            stockEl.style.color = '#991b1b';
        }
    }

    const priceFormatted = '$' + parseFloat(item.price || 0).toFixed(2);
    const priceEl = document.getElementById('centralModalPrice');
    if (priceEl) priceEl.textContent = priceFormatted;

    const btnPriceEl = document.getElementById('centralModalBtnPrice');
    if (btnPriceEl) btnPriceEl.textContent = priceFormatted;

    const descEl = document.getElementById('centralModalDesc');
    if (descEl) descEl.textContent = item.description || 'Artículo exclusivo y certificado del Centro Histórico de Zacatecas.';

    const locNameEl = document.getElementById('centralModalStoreLocName');
    if (locNameEl) locNameEl.textContent = item.store_name || 'Sucursal Centro';

    const addrEl = document.getElementById('centralModalAddress');
    if (addrEl) addrEl.textContent = item.address || 'Centro Histórico, Zacatecas, Zac.';

    const hoursEl = document.getElementById('centralModalHours');
    if (hoursEl) hoursEl.textContent = '⏰ ' + (item.hours || 'Lunes a Sábado: 10:00 AM - 8:30 PM');

    const mapsLink = document.getElementById('centralModalMapsLink');
    if (mapsLink) mapsLink.href = item.maps_url || 'https://maps.google.com/?q=22.7753,-102.5724';

    // WhatsApp Order Button
    const waBtn = document.getElementById('centralModalWaBtn');
    if (waBtn) {
        const cleanWa = item.whatsapp ? item.whatsapp.replace(/[^0-9]/g, '') : '';
        const msg = encodeURIComponent(`¡Hola! Me interesa comprar el siguiente producto en ${item.store_name}:\n• Producto: ${item.name}\n• Precio: ${priceFormatted} MXN\n• Sucursal: ${item.address || 'Zacatecas Centro'}\n\n¿Tienen entrega en Zacatecas o recogida en sucursal?`);
        if (cleanWa) {
            waBtn.href = `https://wa.me/${cleanWa}?text=${msg}`;
        } else {
            waBtn.href = `https://wa.me/?text=${msg}`;
        }
    }

    // Go to store full catalog button
    const storeBtn = document.getElementById('centralModalStoreBtn');
    if (storeBtn) {
        storeBtn.href = item.store_url || item.url || '#';
        storeBtn.innerHTML = `<span>🏬</span> Visitar Tienda de ${item.store_name || 'Comercio'} ↗`;
    }

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';
    if (window.history && window.history.pushState) {
        window.history.pushState({ pwaModal: 'centralProduct' }, '');
    }

    const card = modal.querySelector('.central-product-modal-card');
    if (card) card.scrollTop = 0;
}

function closeCentralProductModal() {
    const modal = document.getElementById('centralProductModal');
    if (modal) modal.classList.remove('open');
    document.body.style.overflow = '';
    document.documentElement.style.overflow = '';
}

function openAuthModal(view = 'login') {
    switchAuthTab(view);
    const modal = document.getElementById('authModal');
    if (modal) modal.classList.add('open');
}

function closeAuthModal() {
    const modal = document.getElementById('authModal');
    if (modal) modal.classList.remove('open');
}

function switchAuthTab(view) {
    const loginEl = document.getElementById('loginView');
    const registerEl = document.getElementById('registerView');
    const googleEl = document.getElementById('googleChooserView');
    const fbEl = document.getElementById('facebookChooserView');

    if (loginEl) loginEl.style.display = view === 'login' ? 'block' : 'none';
    if (registerEl) registerEl.style.display = view === 'register' ? 'block' : 'none';
    if (googleEl) googleEl.style.display = view === 'googleChooser' ? 'block' : 'none';
    if (fbEl) fbEl.style.display = view === 'facebookChooser' ? 'block' : 'none';
}

// LIVE INSTANT SEARCH ACROSS ALL STORES
const searchInput = document.getElementById('globalSearchInput');
const liveDropdown = document.getElementById('liveSearchDropdown');
let debounceTimer = null;

if (searchInput && liveDropdown) {
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();
        clearTimeout(debounceTimer);

        if (query.length < 2) {
            liveDropdown.classList.remove('open');
            liveDropdown.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`/api/global-search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        let html = `<div style="padding: 6px 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--line);">Productos encontrados en todas las tiendas (${data.count}):</div>`;
                        data.results.forEach(item => {
                            html += `
                                <a href="${item.url}" target="_blank" class="live-search-item">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <img src="${item.image_url || 'https://placehold.co/100x100?text=Prod'}" class="live-search-thumb" alt="${item.name}">
                                        <div class="live-search-details">
                                            <strong>${item.name}</strong>
                                            <small><span class="live-search-store-badge">🏬 ${item.store_name}</span> · ${item.category_name}</small>
                                        </div>
                                    </div>
                                    <div class="live-search-price">
                                        $${parseFloat(item.price).toFixed(2)}
                                    </div>
                                </a>
                            `;
                        });
                        liveDropdown.innerHTML = html;
                        liveDropdown.classList.add('open');
                    } else {
                        liveDropdown.innerHTML = `<div style="padding: 16px; font-size: 13px; color: var(--muted); text-align: center;">No se encontraron productos en ninguna tienda para "${query}".</div>`;
                        liveDropdown.classList.add('open');
                    }
                })
                .catch(() => {
                    liveDropdown.classList.remove('open');
                });
        }, 250);
    });

    // Close live search dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !liveDropdown.contains(e.target)) {
            liveDropdown.classList.remove('open');
        }
    });
}

// ========================================================
// PWA INSTALL PROMPT HANDLER & SERVICE WORKER
// ========================================================
let deferredPrompt = null;
const pwaBar = document.getElementById('pwaInstallBar');
const floatingPwaBadge = document.getElementById('floatingPwaBadge');

// If already running as installed PWA app, hide install banners
if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
    if (pwaBar) pwaBar.style.display = 'none';
    if (floatingPwaBadge) floatingPwaBadge.style.display = 'none';
}

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    if (pwaBar) {
        pwaBar.style.display = 'block';
    }
});

function triggerPwaInstall() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('El usuario aceptó e instaló la PWA de Zacatecas Centro');
                if (pwaBar) pwaBar.style.display = 'none';
                if (floatingPwaBadge) floatingPwaBadge.style.display = 'none';
            }
            deferredPrompt = null;
        });
    } else {
        openPwaModal();
    }
}

function openPwaModal() {
    const modal = document.getElementById('pwaGuideModal');
    if (modal) modal.style.display = 'flex';
}

function closePwaModal() {
    const modal = document.getElementById('pwaGuideModal');
    if (modal) modal.style.display = 'none';
}

function dismissPwaBanner() {
    if (pwaBar) pwaBar.style.display = 'none';
}

// ========================================================
// PWA AUTO-UPDATE MANAGER (ACTUALIZACIÓN AUTOMÁTICA EN SEGUNDO PLANO)
// ========================================================
if ('serviceWorker' in navigator) {
    let isRefreshing = false;
    let hadController = Boolean(navigator.serviceWorker.controller);

    // Cuando el nuevo Service Worker toma el control, solo recargar si ya había un controller anterior
    navigator.serviceWorker.addEventListener('controllerchange', () => {
        if (!hadController) {
            hadController = true;
            return;
        }
        if (!isRefreshing) {
            isRefreshing = true;
            console.log('[PWA] Nueva versión de la app activada. Recargando con los cambios más recientes...');
            window.location.reload();
        }
    });

    // Escuchar mensajes de actualización desde el Service Worker
    navigator.serviceWorker.addEventListener('message', (event) => {
        if (event.data && event.data.type === 'SW_UPDATED') {
            console.log('[PWA] Actualización exitosa a versión:', event.data.version);
            if (!isRefreshing && hadController) {
                isRefreshing = true;
                window.location.reload();
            }
        }
    });

    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js', { updateViaCache: 'none' })
            .then((registration) => {
                console.log('[PWA] Service Worker Zacatecas activo:', registration.scope);

                // 1. Buscar actualización inmediatamente al abrir la app
                registration.update().catch(() => {});

                // 2. Si ya hay un worker nuevo esperando en segundo plano, activarlo de inmediato
                if (registration.waiting) {
                    registration.waiting.postMessage({ type: 'SKIP_WAITING' });
                }

                // 3. Detectar cuando se descarga una nueva versión
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    if (newWorker) {
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                console.log('[PWA] Nueva versión descargada, activando sin reiniciar...');
                                newWorker.postMessage({ type: 'SKIP_WAITING' });
                            }
                        });
                    }
                });

                // 4. Buscar actualizaciones cada vez que el usuario vuelve a la app en su teléfono
                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'visible') {
                        registration.update().catch(() => {});
                    }
                });

                window.addEventListener('focus', () => {
                    registration.update().catch(() => {});
                });

                // 5. Verificación periódica cada 15 minutos mientras la app permanezca abierta
                setInterval(() => {
                    registration.update().catch(() => {});
                }, 15 * 60 * 1000);
            })
            .catch((err) => console.log('[PWA] Error en registro de ServiceWorker:', err));
    });
}

// ========================================================
// INTERACTIVE MAP & PROXIMITY SORTING (ZACATECAS CENTRO)
// ========================================================
const businessesData = @json($businesses);
const ZACATECAS_CENTER = [22.7753, -102.5724]; // Plaza de Armas, Zacatecas Centro
let map = null;
let mapMarkers = [];
let userLocationMarker = null;
let userCoords = null;

function initZacatecasMap() {
    const mapEl = document.getElementById('zacatecasMap');
    if (!mapEl || typeof L === 'undefined') return;

    const isMobile = window.innerWidth < 768;
    map = L.map('zacatecasMap', {
        scrollWheelZoom: false,
        touchZoom: true
    }).setView(ZACATECAS_CENTER, isMobile ? 14.5 : 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap Zacatecas'
    }).addTo(map);

    // Place store markers
    renderStoreMarkers(businessesData);

    // Support picking custom origin on map click
    map.on('click', function(e) {
        if (typeof mapPickOriginActive !== 'undefined' && mapPickOriginActive) {
            setCustomMapOrigin(e.latlng.lat, e.latlng.lng);
        }
    });
}

function renderStoreMarkers(stores) {
    if (!map) return;
    mapMarkers.forEach(m => map.removeLayer(m));
    mapMarkers = [];

    stores.forEach(store => {
        const lat = parseFloat(store.latitude) || 22.7753;
        const lng = parseFloat(store.longitude) || -102.5724;

        const customIcon = L.divIcon({
            className: 'custom-map-pin',
            html: `<div style="background: ${store.primary_color || '#c86d63'}; color: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; box-shadow: 0 4px 10px rgba(0,0,0,.35); border: 2.5px solid #ffffff;">📍</div>`,
            iconSize: [34, 34],
            iconAnchor: [17, 34],
            popupAnchor: [0, -32]
        });

        const waClean = store.whatsapp_number ? store.whatsapp_number.replace(/[^0-9]/g, '') : '';
        const waBtn = waClean ? `<a href="https://wa.me/${waClean}?text=${encodeURIComponent('¡Hola! Me comunico desde el portal de Zacatecas para ' + store.store_name)}" target="_blank" style="background: #25d366; color: #fff; padding: 5px 9px; border-radius: 999px; font-size: 11px; font-weight: 700; text-decoration: none;" title="WhatsApp">WA</a>` : '';
        const fbBtn = store.facebook_url ? `<a href="${store.facebook_url}" target="_blank" style="background: #1877f2; color: #fff; padding: 5px 9px; border-radius: 999px; font-size: 11px; font-weight: 700; text-decoration: none;" title="Facebook">FB</a>` : '';
        const igBtn = store.instagram_url ? `<a href="${store.instagram_url}" target="_blank" style="background: #e1306c; color: #fff; padding: 5px 9px; border-radius: 999px; font-size: 11px; font-weight: 700; text-decoration: none;" title="Instagram">IG</a>` : '';

        const openStatus = checkStoreOpen(store.opening_hours);
        const openBadgeHtml = openStatus.isOpen 
            ? `<span style="display:inline-flex; align-items:center; gap:4px; font-size:10.5px; font-weight:700; color:#059669; background:rgba(16,185,129,0.12); padding:2px 7px; border-radius:999px;"><span style="width:6px; height:6px; border-radius:50%; background:#10b981;"></span> ${openStatus.label}</span>`
            : `<span style="display:inline-flex; align-items:center; gap:4px; font-size:10.5px; font-weight:700; color:#dc2626; background:rgba(239,68,68,0.12); padding:2px 7px; border-radius:999px;"><span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span> ${openStatus.label}</span>`;

        const traditionHtml = store.tradition_badge 
            ? `<div style="font-size:10px; font-weight:700; color:#c86d63; margin-bottom:4px; display:inline-block; background:rgba(200,109,99,0.1); padding:2px 6px; border-radius:6px;">🏛️ ${store.tradition_badge}</div>` 
            : '';

        const popupContent = `
            <div style="font-family: 'Plus Jakarta Sans', sans-serif; min-width: 220px; padding: 4px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px; gap:8px;">
                    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; color: ${store.primary_color || 'var(--accent)'}; letter-spacing: .06em;">${store.business_category}</span>
                    ${openBadgeHtml}
                </div>
                <h4 style="font-size: 15px; margin: 2px 0 3px; font-weight: 800;">${store.store_name}</h4>
                <div style="font-size:11px; color:#d97706; font-weight:700; margin-bottom:4px;">★ ${Number(store.rating || 4.9).toFixed(1)} <span style="color:#6b7280; font-weight:500;">(${store.reviews_count || 180} ${currentLang === 'en' ? 'reviews' : 'reseñas'})</span></div>
                ${traditionHtml}
                <p style="font-size: 11.5px; color: #555; margin: 0 0 6px; line-height: 1.35;">📍 ${store.address}</p>
                <div style="font-size: 11px; color: #059669; font-weight: 700; margin-bottom: 8px;">⏰ ${store.opening_hours}</div>
                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                    <a href="${store.store_url}" target="_blank" style="flex: 1; text-align: center; background: #c86d63; color: #fff; padding: 6px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; text-decoration: none;">${currentLang === 'en' ? 'Visit Store ↗' : 'Ver Tienda ↗'}</a>
                    <a href="${store.maps_url}" target="_blank" style="background: #f3f4f6; color: #111; padding: 6px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; text-decoration: none;">Mapa</a>
                    ${waBtn}
                    ${fbBtn}
                    ${igBtn}
                </div>
            </div>
        `;

        const marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
        marker.storeId = String(store.id);
        marker.bindPopup(popupContent);
        mapMarkers.push(marker);
    });
}

// FOCUS AND HIGHLIGHT STORE ON MAP
function focusStoreOnMap(storeId) {
    const sId = String(storeId);
    const store = businessesData.find(b => String(b.id) === sId);
    if (!store) return;

    const mapBox = document.getElementById('zacatecasMap');
    if (mapBox) {
        mapBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    setTimeout(() => {
        if (map && store.latitude && store.longitude) {
            map.flyTo([parseFloat(store.latitude), parseFloat(store.longitude)], 17, {
                animate: true,
                duration: 1.0
            });
            const marker = mapMarkers.find(m => m.storeId === sId);
            if (marker) {
                marker.openPopup();
            }
        }
    }, 450);
}

// ACTIVE HIGHLIGHT FOR QUICK JUMP BAR ON SCROLL
window.addEventListener('scroll', () => {
    const jumpBar = document.getElementById('portalQuickJumpBar');
    if (!jumpBar) return;

    const sections = [
        { id: 'buscar', link: jumpBar.querySelector('a[href="#buscar"]') },
        { id: 'cercanas', link: jumpBar.querySelector('a[href="#cercanas"]') },
        { id: 'empresas', link: jumpBar.querySelector('a[href="#empresas"]') },
        { id: 'planes', link: jumpBar.querySelector('a[href="#planes"]') }
    ];

    const scrollY = window.scrollY + 140;
    let currentActive = null;

    for (const sec of sections) {
        const el = document.getElementById(sec.id);
        if (el && el.offsetTop <= scrollY) {
            currentActive = sec.link;
        }
    }

    if (currentActive) {
        jumpBar.querySelectorAll('.jump-pill').forEach(p => p.classList.remove('active'));
        currentActive.classList.add('active');
    }
}, { passive: true });

// HAVERSINE DISTANCE IN KILOMETERS
function calculateDistanceKm(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth's radius in km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

// REQUEST USER GEOLOCATION
function requestUserLocation() {
    const btn = document.getElementById('btnGpsProximity');
    const statusText = document.getElementById('gpsStatusText');

    if (!navigator.geolocation) {
        alert('Tu navegador o dispositivo no soporta geolocalización.');
        return;
    }

    if (btn) {
        btn.innerHTML = '<span>⏳</span> Obteniendo ubicación...';
        btn.disabled = true;
    }
    if (statusText) {
        statusText.textContent = 'Calculando cercanía a tiendas de Zacatecas Centro...';
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            userCoords = { lat: userLat, lng: userLng };

            if (btn) {
                btn.classList.add('active');
                btn.innerHTML = '<span>✓</span> ' + (i18nDictionary[currentLang] || i18nDictionary.es).gps_active;
                btn.disabled = false;
            }
            if (statusText) {
                statusText.textContent = `📍 Ubicación detectada (${userLat.toFixed(4)}, ${userLng.toFixed(4)})`;
            }

            // Update Map Center and add user marker
            if (map) {
                if (userLocationMarker) map.removeLayer(userLocationMarker);

                const userIcon = L.divIcon({
                    className: 'user-map-pin',
                    html: `<div style="background: #2563eb; color: #fff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 4px 14px rgba(37,99,235,.5); border: 3px solid #fff;">👤</div>`,
                    iconSize: [36, 36],
                    iconAnchor: [18, 36],
                    popupAnchor: [0, -34]
                });

                userLocationMarker = L.marker([userLat, userLng], { icon: userIcon }).addTo(map);
                userLocationMarker.bindPopup("<strong>Tu Ubicación Actual</strong>").openPopup();
                map.setView([userLat, userLng], 15);
            }

            // Update distance badges and sort company cards by proximity
            sortCardsByProximity(userLat, userLng);
        },
        (error) => {
            console.warn('Geolocation error:', error);
            if (btn) {
                btn.innerHTML = '<span>🎯</span> Activar Mi Ubicación (GPS)';
                btn.disabled = false;
            }
            // Fallback: use downtown Zacatecas (Plaza de Armas) as user center
            const fallbackLat = 22.7753;
            const fallbackLng = -102.5724;
            if (statusText) {
                statusText.textContent = (i18nDictionary[currentLang] || i18nDictionary.es).gps_default_notice;
            }
            sortCardsByProximity(fallbackLat, fallbackLng);
        },
        { enableHighAccuracy: true, timeout: 8000 }
    );
}

function sortCardsByProximity(originLat, originLng) {
    const grid = document.getElementById('companiesGrid');
    if (!grid) return;

    const cards = Array.from(grid.querySelectorAll('.company-card'));

    cards.forEach(card => {
        const cLat = parseFloat(card.dataset.lat) || 22.7753;
        const cLng = parseFloat(card.dataset.lng) || -102.5724;
        const distKm = calculateDistanceKm(originLat, originLng, cLat, cLng);

        card.dataset.distance = distKm;
        const badge = card.querySelector('.distance-badge-pill');
        const badgeVal = card.querySelector('.dist-val');
        if (badge && badgeVal) {
            badgeVal.textContent = distKm < 1 ? `${(distKm * 1000).toFixed(0)} m` : `${distKm.toFixed(2)} km`;
            badge.style.display = 'inline-flex';
        }
    });

    // Sort cards in DOM from closest to furthest
    cards.sort((a, b) => parseFloat(a.dataset.distance) - parseFloat(b.dataset.distance));
    cards.forEach(c => grid.appendChild(c));
}

// ========================================================
// SMART SHOPPING ROUTE OPTIMIZER (ZACATECAS CENTRO) - DRIVEN BY SHOPPING CART
// ========================================================
let selectedRouteStoreIds = new Set();
let currentRoutePolyline = null;
let currentRouteMarkers = [];
let routeOrigin = null;

function matchCategoryIcon(category) {
    switch(category) {
        case 'Moda y Lujo': return '👗';
        case 'Bebidas y Alimentos': return '☕';
        case 'Joyería y Platería':
        case 'Platería y Joyería': return '💍';
        case 'Artesanías y Recuerdos':
        case 'Arte y Souvenirs': return '🏺';
        case 'Librería y Cultura':
        case 'Libros y Café': return '📚';
        case 'Cantinas Tradicionales':
        case 'Gastronomía y Tradición': return '🍷';
        default: return '🏬';
    }
}

// UNIFIED CART STORAGE FOR PHYSICAL SHOPPING ROUTE
function getUnifiedCart() {
    let registry = {};
    try {
        registry = JSON.parse(localStorage.getItem('atelier_unified_cart') || '{}');
    } catch (e) {
        registry = {};
    }

    // Also scan any tenant-specific localStorage keys (e.g. atelier_cart_acropolis)
    try {
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key && key.startsWith('atelier_cart_') && key !== 'atelier_cart_') {
                const tenantId = key.replace('atelier_cart_', '');
                const items = JSON.parse(localStorage.getItem(key) || '[]');
                if (Array.isArray(items) && items.length > 0) {
                    const storeObj = businessesData.find(b => String(b.id) === String(tenantId));
                    const storeName = storeObj ? storeObj.store_name : (tenantId.charAt(0).toUpperCase() + tenantId.slice(1));
                    registry[tenantId] = {
                        store_id: tenantId,
                        store_name: storeName,
                        address: storeObj?.address || 'Centro Histórico, Zacatecas',
                        items: items
                    };
                }
            }
        }
    } catch (err) {}

    return registry;
}

function saveUnifiedCart(cart) {
    try {
        localStorage.setItem('atelier_unified_cart', JSON.stringify(cart));
        businessesData.forEach(b => {
            const key = 'atelier_cart_' + b.id;
            if (cart[b.id] && cart[b.id].items && cart[b.id].items.length > 0) {
                localStorage.setItem(key, JSON.stringify(cart[b.id].items));
            } else {
                localStorage.removeItem(key);
            }
        });
    } catch (e) {}
    updateHeaderCartBadge();
}

function addGlobalCartItem(prod) {
    const cart = getUnifiedCart();
    let storeId = prod.store_id || '';
    if (!storeId && prod.store_name) {
        const found = businessesData.find(b => b.store_name === prod.store_name || String(b.id) === String(prod.store_id));
        if (found) storeId = found.id;
    }
    if (!storeId) {
        storeId = businessesData[0]?.id || 'acropolis';
    }
    const storeObj = businessesData.find(b => String(b.id) === String(storeId));
    const storeName = storeObj ? storeObj.store_name : (prod.store_name || 'Comercio Zacatecas');

    if (!cart[storeId]) {
        cart[storeId] = {
            store_id: storeId,
            store_name: storeName,
            address: storeObj?.address || 'Centro Histórico, Zacatecas',
            items: []
        };
    }

    const prodId = prod.id || prod.slug || prod.name;
    const existing = cart[storeId].items.find(it => String(it.id) === String(prodId));
    if (existing) {
        existing.quantity = (parseInt(existing.quantity) || 1) + 1;
    } else {
        cart[storeId].items.push({
            id: prodId,
            name: prod.name,
            price: parseFloat(prod.price) || 0,
            quantity: 1,
            image_url: prod.image_url || 'https://placehold.co/100x100?text=Zac',
            slug: prod.slug || ''
        });
    }

    saveUnifiedCart(cart);
}

function quickAddProductToRouteCart(prod) {
    if (!prod) return;
    addGlobalCartItem(prod);
    renderCartForRoute();
    updateHeaderCartBadge();
    showToast(`🛒 ¡"${prod.name}" añadido a tu Carrito de Ruta!`);
    if (currentRoutePolyline) {
        optimizeShoppingRoute(false);
    }
}

function updateRouteCartQty(storeId, prodId, delta) {
    const cart = getUnifiedCart();
    if (!cart[storeId] || !cart[storeId].items) return;
    const item = cart[storeId].items.find(it => String(it.id) === String(prodId));
    if (!item) return;

    item.quantity = (parseInt(item.quantity) || 1) + delta;
    if (item.quantity <= 0) {
        cart[storeId].items = cart[storeId].items.filter(it => String(it.id) !== String(prodId));
    }
    if (cart[storeId].items.length === 0) {
        delete cart[storeId];
    }
    saveUnifiedCart(cart);
    renderCartForRoute();
    if (currentRoutePolyline) {
        optimizeShoppingRoute(false);
    }
}

function removeRouteCartItem(storeId, prodId) {
    const cart = getUnifiedCart();
    if (!cart[storeId] || !cart[storeId].items) return;
    cart[storeId].items = cart[storeId].items.filter(it => String(it.id) !== String(prodId));
    if (cart[storeId].items.length === 0) {
        delete cart[storeId];
    }
    saveUnifiedCart(cart);
    renderCartForRoute();
    if (currentRoutePolyline) {
        optimizeShoppingRoute(false);
    }
}

function clearCartRouteItems() {
    localStorage.removeItem('atelier_unified_cart');
    businessesData.forEach(b => localStorage.removeItem('atelier_cart_' + b.id));
    saveUnifiedCart({});
    renderCartForRoute();
    resetMapRoute();
    showToast('🗑️ Carrito vaciado con éxito');
}

function loadSampleCartForRouteDemo() {
    const sampleItems = {
        'acropolis': {
            store_id: 'acropolis',
            store_name: 'Café Acrópolis',
            address: 'Av. Hidalgo 101, Centro Histórico',
            items: [
                {
                    id: 'cafe-platero',
                    name: 'Café Platero Especial',
                    price: 95.00,
                    quantity: 1,
                    image_url: 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=200&q=80',
                    slug: 'cafe-platero'
                },
                {
                    id: 'pay-zarzamora',
                    name: 'Pay Tradicional de Zarzamora',
                    price: 85.00,
                    quantity: 2,
                    image_url: 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=200&q=80',
                    slug: 'pay-zarzamora'
                }
            ]
        },
        'donajulia': {
            store_id: 'donajulia',
            store_name: 'Gorditas Doña Julia',
            address: 'Calle Allende 204, Centro Histórico',
            items: [
                {
                    id: 'gorditas-chicharron',
                    name: 'Gorditas Tradicionales Rellenas (Orden)',
                    price: 80.00,
                    quantity: 1,
                    image_url: 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=200&q=80',
                    slug: 'gorditas-chicharron'
                }
            ]
        },
        'rosadeplata': {
            store_id: 'rosadeplata',
            store_name: 'Joyería Rosa de Plata',
            address: 'Portal de Rosales 12, Centro Histórico',
            items: [
                {
                    id: 'dije-plata-cantera',
                    name: 'Dije de Plata Ley .925 con Cantera',
                    price: 480.00,
                    quantity: 1,
                    image_url: 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=200&q=80',
                    slug: 'dije-plata-cantera'
                }
            ]
        }
    };
    saveUnifiedCart(sampleItems);
    renderCartForRoute();
    showToast('✦ 3 productos de prueba cargados en el carrito');
    optimizeShoppingRoute(true);
}

function updateHeaderCartBadge(count) {
    if (typeof count !== 'number') {
        const cart = getUnifiedCart();
        count = 0;
        Object.values(cart).forEach(s => {
            if (s.items) s.items.forEach(it => count += (parseInt(it.quantity) || 1));
        });
    }
    const badge = document.getElementById('centralCartBadge');
    if (badge) badge.textContent = count;
    const drawerBadge = document.getElementById('drawerCartBadge');
    if (drawerBadge) drawerBadge.textContent = count;
    const bottomNavBadge = document.getElementById('bottomNavCartBadge');
    if (bottomNavBadge) {
        bottomNavBadge.textContent = count;
        bottomNavBadge.style.display = count > 0 ? 'inline-flex' : 'none';
    }
}

function toggleManualStoreSelector(forceShow) {
    const el = document.getElementById('routeStoresSelector');
    if (!el) return;
    const isHidden = el.style.display === 'none';
    const show = forceShow !== undefined ? forceShow : isHidden;
    el.style.display = show ? 'grid' : 'none';
    const btn = document.getElementById('btnToggleManualStores');
    if (btn) {
        btn.innerHTML = show ? '<span>✕</span> Ocultar Catálogo de Tiendas' : '<span>⚙</span> Ver Catálogo de Tiendas ▾';
    }
}

function toggleRoutePanel(forceOpen) {
    const panel = document.getElementById('routeOptimizerPanel');
    const btn = document.getElementById('btnToggleRoutePanel');
    const arrow = document.getElementById('toggleRouteArrow');
    const actionText = document.getElementById('routeToggleActionText');
    if (!panel) return;

    const isHidden = (panel.style.display === 'none' || panel.style.display === '');
    const shouldShow = forceOpen !== undefined ? forceOpen : isHidden;

    panel.style.display = shouldShow ? 'block' : 'none';
    if (arrow) arrow.textContent = shouldShow ? '▴' : '▾';
    if (actionText) actionText.textContent = shouldShow ? 'Ocultar Opciones' : 'Configurar y Ver Ruta';
    if (btn) btn.classList.toggle('active', shouldShow);

    if (shouldShow) {
        renderCartForRoute();
    }
}

function goToCartRoutePlanner() {
    switchMainTab('map', false);
    toggleRoutePanel(true);
    const panel = document.getElementById('routeOptimizerPanel');
    if (panel) {
        panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function renderCartForRoute() {
    const container = document.getElementById('cartRouteItemsContainer');
    if (!container) return;

    const cart = getUnifiedCart();
    const storeIds = Object.keys(cart).filter(sId => cart[sId]?.items?.length > 0);

    let totalItems = 0;
    let grandTotal = 0;
    storeIds.forEach(sId => {
        cart[sId].items.forEach(it => {
            const q = parseInt(it.quantity) || 1;
            totalItems += q;
            grandTotal += (parseFloat(it.price) || 0) * q;
        });
    });

    updateHeaderCartBadge(totalItems);

    const badgePill = document.getElementById('routeCartBadgePill');
    if (badgePill) {
        if (totalItems > 0) {
            badgePill.style.display = 'inline-block';
            badgePill.textContent = `${totalItems} prod${totalItems > 1 ? 's' : ''}`;
        } else {
            badgePill.style.display = 'none';
        }
    }

    const clearBtn = document.getElementById('btnClearRouteCart');
    if (clearBtn) clearBtn.style.display = storeIds.length > 0 ? 'inline-flex' : 'none';

    // Update chips badges and selected state
    businessesData.forEach(b => {
        const chip = document.getElementById('routeChip_' + b.id);
        if (chip) {
            const storeCart = cart[b.id];
            let badge = chip.querySelector('.route-chip-cart-badge');
            if (storeCart && storeCart.items && storeCart.items.length > 0) {
                const count = storeCart.items.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'route-chip-cart-badge';
                    chip.appendChild(badge);
                }
                badge.textContent = `🛒 ${count}`;
                chip.classList.add('selected');
                selectedRouteStoreIds.add(String(b.id));
            } else {
                if (badge) badge.remove();
                if (storeIds.length > 0) {
                    chip.classList.remove('selected');
                    selectedRouteStoreIds.delete(String(b.id));
                }
            }
        }
    });

    const floatBar = document.getElementById('floatingRouteCartBar');

    if (storeIds.length === 0) {
        if (floatBar) floatBar.style.display = 'none';
        container.innerHTML = `
            <div class="cart-route-empty-min">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 20px;">🛒</span>
                    <div>
                        <strong style="font-size: 13px; color: var(--ink);">Tu carrito está vacío</strong>
                        <div style="font-size: 11.5px; color: var(--muted);">Agrega artículos desde las tiendas o carga una muestra para ver la ruta recomendada.</div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                    <button type="button" class="btn-seed-sample-cart-min" onclick="loadSampleCartForRouteDemo()">
                        <span>✦</span> Cargar 3 Productos de Muestra
                    </button>
                    <button type="button" class="btn-route-origin-pill" onclick="toggleManualStoreSelector(true)">
                        <span>⚙</span> Elegir Tiendas ▾
                    </button>
                </div>
            </div>
        `;
        return;
    }

    if (floatBar) {
        floatBar.style.display = 'flex';
        const textEl = document.getElementById('floatingCartText');
        if (textEl) textEl.textContent = `${totalItems} producto(s) en ${storeIds.length} tienda(s)`;
        const totalEl = document.getElementById('floatingCartTotal');
        if (totalEl) totalEl.textContent = `$${grandTotal.toFixed(2)} MXN`;
    }

    let storesHtml = '';
    storeIds.forEach(sId => {
        const storeGroup = cart[sId];
        const storeObj = businessesData.find(b => String(b.id) === String(sId));
        const catIcon = matchCategoryIcon(storeObj?.business_category);

        let prodsHtml = '';
        let storeSubtotal = 0;
        storeGroup.items.forEach(it => {
            const q = parseInt(it.quantity) || 1;
            const itemSub = (parseFloat(it.price) || 0) * q;
            storeSubtotal += itemSub;
            prodsHtml += `
                <div class="cart-prod-row">
                    <img src="${it.image_url || 'https://placehold.co/40x40?text=Zac'}" alt="${it.name}" onerror="this.onerror=null; this.src='https://placehold.co/40x40?text=Prod';">
                    <div class="cart-prod-meta">
                        <span class="cart-prod-name">${it.name}</span>
                        <span class="cart-prod-price">$${parseFloat(it.price).toFixed(2)} MXN c/u</span>
                    </div>
                    <div class="cart-prod-qty-ctrl">
                        <button type="button" onclick="updateRouteCartQty('${sId}', '${it.id}', -1)" title="Reducir">−</button>
                        <span>${q}</span>
                        <button type="button" onclick="updateRouteCartQty('${sId}', '${it.id}', 1)" title="Aumentar">+</button>
                        <button type="button" class="btn-del-item" onclick="removeRouteCartItem('${sId}', '${it.id}')" title="Quitar">🗑️</button>
                    </div>
                </div>
            `;
        });

        storesHtml += `
            <div class="cart-store-group">
                <div class="cart-store-group-header">
                    <div class="cart-store-info">
                        <strong>${catIcon} ${storeGroup.store_name}</strong>
                        <small>📍 ${storeGroup.address || storeObj?.address || 'Zacatecas Centro'}</small>
                    </div>
                    <span style="font-size: 11.5px; font-weight: 800; color: var(--accent);">
                        Subtotal tienda: $${storeSubtotal.toFixed(2)} MXN
                    </span>
                </div>
                <div class="cart-store-products-grid">
                    ${prodsHtml}
                </div>
            </div>
        `;
    });

    container.innerHTML = `
        <div class="cart-route-card">
            <div class="cart-route-card-header">
                <div class="cart-badge-count">
                    <span>🛍️</span> ${totalItems} producto(s) en ${storeIds.length} tienda(s)
                </div>
                <div class="cart-subtotal-text">
                    Total a pagar/ver en tiendas: <strong>$${grandTotal.toFixed(2)} MXN</strong>
                </div>
            </div>
            <div style="font-size: 12.5px; color: var(--muted); margin-bottom: 12px;">
                📍 Sucursales físicas en Zacatecas Centro que contienen tus artículos:
            </div>
            <div class="cart-route-stores-list">
                ${storesHtml}
            </div>
            <div style="margin-top: 14px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <button type="button" class="btn-calculate-route" onclick="optimizeShoppingRoute(true)" style="padding: 10px 22px; font-size: 13.5px;">
                    <span>🚶‍♂️</span> Calcular Ruta Recomendada (${storeIds.length} tiendas)
                </button>
            </div>
        </div>
    `;
}

function toggleStoreRouteSelection(storeId, el) {
    storeId = String(storeId);
    if (selectedRouteStoreIds.has(storeId)) {
        selectedRouteStoreIds.delete(storeId);
        el.classList.remove('selected');
    } else {
        selectedRouteStoreIds.add(storeId);
        el.classList.add('selected');
    }
}

function selectAllStoresForRoute() {
    businessesData.forEach(b => {
        selectedRouteStoreIds.add(String(b.id));
        const el = document.getElementById('routeChip_' + b.id);
        if (el) el.classList.add('selected');
    });
}

function clearRouteSelection() {
    selectedRouteStoreIds.clear();
    businessesData.forEach(b => {
        const el = document.getElementById('routeChip_' + b.id);
        if (el) el.classList.remove('selected');
    });
    resetMapRoute();
}

// ========================================================
// ORIGIN & GEOLOCATION CONTROLS (TU UBICACIÓN / CENTRO)
// ========================================================
let mapPickOriginActive = false;

function updateOriginBarUI(activeType, labelText) {
    const lbl = document.getElementById('routeOriginLabel');
    if (lbl && labelText) lbl.innerHTML = labelText;

    const btnGps = document.getElementById('btnRouteUseGps');
    const btnPlaza = document.getElementById('btnRoutePlazaArmas');
    const btnMap = document.getElementById('btnClickMapOrigin');

    if (btnGps) btnGps.classList.toggle('active', activeType === 'gps');
    if (btnPlaza) btnPlaza.classList.toggle('active', activeType === 'plaza');
    if (btnMap) btnMap.classList.toggle('active', activeType === 'map' || activeType === 'custom');
}

function requestUserLocationForRoute(andOptimize = false) {
    if (!navigator.geolocation) {
        setOriginPlazaDeArmas();
        showToast('⚠️ Tu dispositivo no soporta GPS, usando Plaza de Armas');
        return;
    }

    updateOriginBarUI('gps', '📡 Obteniendo coordenadas GPS en tiempo real...');

    navigator.geolocation.getCurrentPosition(
        (pos) => {
            userCoords = { lat: pos.coords.latitude, lng: pos.coords.longitude };
            routeOrigin = {
                lat: pos.coords.latitude,
                lng: pos.coords.longitude,
                name: 'Tu Ubicación Actual (GPS)'
            };
            updateOriginBarUI('gps', `<span style="color:#059669; font-weight:700;">✓ Tu Ubicación Actual (GPS)</span> · Coords: ${userCoords.lat.toFixed(4)}, ${userCoords.lng.toFixed(4)}`);
            showToast('📍 Origen configurado en tu ubicación GPS actual');
            if (andOptimize || selectedRouteStoreIds.size > 0) {
                optimizeShoppingRoute(true);
            }
        },
        (err) => {
            setOriginPlazaDeArmas();
            showToast('⚠️ No se pudo obtener GPS, usando Plaza de Armas');
        },
        { enableHighAccuracy: true, timeout: 8000, maximumAge: 30000 }
    );
}

function setOriginPlazaDeArmas() {
    routeOrigin = { lat: ZACATECAS_CENTER[0], lng: ZACATECAS_CENTER[1], name: 'Plaza de Armas (Centro Histórico)' };
    updateOriginBarUI('plaza', '🏛️ Plaza de Armas (Centro Histórico)');
    showToast('🏛️ Origen configurado en Plaza de Armas');
    if (selectedRouteStoreIds.size > 0 && currentRoutePolyline) {
        optimizeShoppingRoute(false);
    }
}

function enableMapPickOrigin() {
    mapPickOriginActive = true;
    updateOriginBarUI('map', '👉 Haz clic en cualquier punto del mapa para fijar tu ubicación...');
    showToast('📍 Haz clic en cualquier punto del mapa para fijar tu hotel o punto de partida');
}

function setCustomMapOrigin(lat, lng) {
    mapPickOriginActive = false;
    routeOrigin = {
        lat: lat,
        lng: lng,
        name: `Punto en el Mapa (${lat.toFixed(4)}, ${lng.toFixed(4)})`
    };
    updateOriginBarUI('custom', `<span style="color:#2563eb; font-weight:700;">📍 Punto Fijado en el Mapa</span> (${lat.toFixed(4)}, ${lng.toFixed(4)})`);
    showToast('📍 Punto de partida actualizado en el mapa. Recalculando ruta recomendada...');
    optimizeShoppingRoute(false);
}

function autoDetectUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                userCoords = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                if (!routeOrigin || routeOrigin.name.includes('Plaza de Armas')) {
                    routeOrigin = {
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude,
                        name: 'Tu Ubicación Actual (GPS)'
                    };
                    updateOriginBarUI('gps', `<span style="color:#059669; font-weight:700;">✓ Tu Ubicación Actual (GPS)</span> · Coords: ${userCoords.lat.toFixed(4)}, ${userCoords.lng.toFixed(4)}`);
                }
            },
            () => {
                if (!routeOrigin) {
                    routeOrigin = { lat: ZACATECAS_CENTER[0], lng: ZACATECAS_CENTER[1], name: 'Plaza de Armas (Centro)' };
                    updateOriginBarUI('plaza', 'Plaza de Armas (Centro Histórico)');
                }
            },
            { enableHighAccuracy: true, timeout: 6000, maximumAge: 60000 }
        );
    } else {
        if (!routeOrigin) {
            routeOrigin = { lat: ZACATECAS_CENTER[0], lng: ZACATECAS_CENTER[1], name: 'Plaza de Armas (Centro)' };
            updateOriginBarUI('plaza', 'Plaza de Armas (Centro Histórico)');
        }
    }
}

// ========================================================
// EXACT TRAVELING SALESPERSON ROUTING ALGORITHM
// (MATHEMATICALLY SHORTEST WALKING ROUTE FROM USER COORDS)
// ========================================================
function computeExactShortestRoute(startPoint, storesList) {
    if (!storesList || storesList.length === 0) return { orderedRoute: [], totalKm: 0 };
    if (storesList.length === 1) {
        const s = storesList[0];
        const sLat = parseFloat(s.latitude) || 22.7753;
        const sLng = parseFloat(s.longitude) || -102.5724;
        const dist = calculateDistanceKm(startPoint.lat, startPoint.lng, sLat, sLng);
        return {
            orderedRoute: [{ store: s, legDistanceKm: dist, accumulatedKm: dist }],
            totalKm: dist
        };
    }

    // Exact permutation solver for minimum total walking distance from startPoint
    let bestPermutation = null;
    let minTotalDist = Infinity;

    function generatePermutations(arr, current = []) {
        if (arr.length === 0) {
            let dist = 0;
            let cLat = startPoint.lat;
            let cLng = startPoint.lng;
            for (let i = 0; i < current.length; i++) {
                const s = current[i];
                const sLat = parseFloat(s.latitude) || 22.7753;
                const sLng = parseFloat(s.longitude) || -102.5724;
                dist += calculateDistanceKm(cLat, cLng, sLat, sLng);
                cLat = sLat;
                cLng = sLng;
            }
            if (dist < minTotalDist) {
                minTotalDist = dist;
                bestPermutation = current;
            }
            return;
        }
        for (let i = 0; i < arr.length; i++) {
            const nextArr = arr.slice(0, i).concat(arr.slice(i + 1));
            generatePermutations(nextArr, current.concat([arr[i]]));
        }
    }

    generatePermutations(storesList);

    let orderedRoute = [];
    let curLat = startPoint.lat;
    let curLng = startPoint.lng;
    let accumulated = 0;

    for (let i = 0; i < bestPermutation.length; i++) {
        const store = bestPermutation[i];
        const sLat = parseFloat(store.latitude) || 22.7753;
        const sLng = parseFloat(store.longitude) || -102.5724;
        const legDist = calculateDistanceKm(curLat, curLng, sLat, sLng);
        accumulated += legDist;
        orderedRoute.push({
            store: store,
            legDistanceKm: legDist,
            accumulatedKm: accumulated
        });
        curLat = sLat;
        curLng = sLng;
    }

    return {
        orderedRoute: orderedRoute,
        totalKm: minTotalDist
    };
}

function optimizeShoppingRoute(scroll = true) {
    const cart = getUnifiedCart();
    const cartStoreIds = Object.keys(cart).filter(sId => cart[sId]?.items?.length > 0);

    // Prioritize stores where user has cart items
    if (cartStoreIds.length > 0) {
        selectedRouteStoreIds = new Set(cartStoreIds);
    }

    if (selectedRouteStoreIds.size === 0) {
        alert('Tu carrito está vacío. Agrega productos al carrito o pulsa "Cargar 3 Productos de Muestra" para trazar la ruta recomendada.');
        goToCartRoutePlanner();
        return;
    }

    const startPoint = routeOrigin || (userCoords 
        ? { lat: userCoords.lat, lng: userCoords.lng, name: 'Tu Ubicación Actual' }
        : { lat: ZACATECAS_CENTER[0], lng: ZACATECAS_CENTER[1], name: 'Plaza de Armas (Centro)' });

    const storesToVisit = businessesData.filter(b => selectedRouteStoreIds.has(String(b.id)));

    // Calculate exact shortest route from startPoint
    const { orderedRoute, totalKm } = computeExactShortestRoute(startPoint, storesToVisit);

    // Attach cart items for each store
    orderedRoute.forEach(leg => {
        leg.cartItems = cart[leg.store.id]?.items || [];
    });

    window.__currentOrderedRoute = orderedRoute;

    renderRouteOnMap(startPoint, orderedRoute);
    renderRouteItineraryUI(startPoint, orderedRoute, totalKm);

    if (scroll) {
        const mapSection = document.getElementById('zacatecasMap');
        if (mapSection) {
            mapSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

function renderRouteOnMap(startPoint, orderedRoute) {
    if (!map) return;

    if (currentRoutePolyline) {
        map.removeLayer(currentRoutePolyline);
        currentRoutePolyline = null;
    }
    currentRouteMarkers.forEach(m => map.removeLayer(m));
    currentRouteMarkers = [];

    const latLngs = [[startPoint.lat, startPoint.lng]];

    const startIcon = L.divIcon({
        className: 'route-start-pin',
        html: `<div style="background: #2563eb; color: #fff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 17px; font-weight: 800; border: 3px solid #fff; box-shadow: 0 4px 14px rgba(37,99,235,.6); animation: pulseGps 2s infinite;">🏁</div>`,
        iconSize: [36, 36],
        iconAnchor: [18, 36],
        popupAnchor: [0, -34]
    });
    const startMarker = L.marker([startPoint.lat, startPoint.lng], {
        icon: startIcon,
        draggable: true
    }).addTo(map);
    startMarker.bindPopup(`<strong>Punto de Partida (Arrastrable):</strong><br>${startPoint.name}<br><small style="color:#555;">💡 Arrastra este pin en el mapa si deseas cambiar tu ubicación</small>`);
    startMarker.on('dragend', function(e) {
        const newPos = e.target.getLatLng();
        setCustomMapOrigin(newPos.lat, newPos.lng);
    });
    currentRouteMarkers.push(startMarker);

    orderedRoute.forEach((leg, index) => {
        const store = leg.store;
        const sLat = parseFloat(store.latitude) || 22.7753;
        const sLng = parseFloat(store.longitude) || -102.5724;
        latLngs.push([sLat, sLng]);

        const stopNum = index + 1;
        const stopIcon = L.divIcon({
            className: 'route-stop-pin',
            html: `<div style="background: ${store.primary_color || '#c86d63'}; color: #fff; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 900; border: 2.5px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,.35);">${stopNum}</div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -30]
        });

        const stopDistStr = leg.legDistanceKm < 1 
            ? `${Math.round(leg.legDistanceKm * 1000)} m` 
            : `${leg.legDistanceKm.toFixed(2)} km`;

        let popupProdsHtml = '';
        if (leg.cartItems && leg.cartItems.length > 0) {
            const storeSub = leg.cartItems.reduce((acc, it) => acc + (parseFloat(it.price) || 0) * (parseInt(it.quantity) || 1), 0);
            popupProdsHtml = `
                <div style="background: rgba(200,109,99,0.08); border: 1px solid rgba(200,109,99,0.25); border-radius: 8px; padding: 6px; margin: 6px 0;">
                    <span style="font-size: 10.5px; font-weight: 800; color: #b45b51;">🛍️ Productos a ver en esta tienda (${leg.cartItems.length}):</span>
                    <ul style="margin: 3px 0 0 14px; padding: 0; font-size: 11px; color: #333; line-height: 1.35;">
                        ${leg.cartItems.map(i => `<li><strong>${i.quantity}x</strong> ${i.name} ($${((parseFloat(i.price)||0)*(parseInt(i.quantity)||1)).toFixed(2)})</li>`).join('')}
                    </ul>
                    <div style="font-size: 11px; font-weight: 800; color: #111; margin-top: 4px; text-align: right;">
                        Subtotal: $${storeSub.toFixed(2)} MXN
                    </div>
                </div>
            `;
        }

        const marker = L.marker([sLat, sLng], { icon: stopIcon }).addTo(map);
        marker.bindPopup(`
            <div style="font-family: 'Plus Jakarta Sans', sans-serif; padding: 3px; min-width: 190px;">
                <span style="font-size: 10px; font-weight: 800; color: ${store.primary_color || '#c86d63'};">PARADA #${stopNum} (+${stopDistStr})</span>
                <h4 style="margin: 2px 0 4px; font-size: 14px; font-weight: 800;">${store.store_name}</h4>
                <p style="margin: 0 0 4px; font-size: 11px; color: #555;">📍 ${store.address}</p>
                ${popupProdsHtml}
                <a href="${store.store_url}" target="_blank" style="display: block; text-align: center; background: #c86d63; color: #fff; padding: 5px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; text-decoration: none; margin-top: 4px;">Ver Tienda Online ↗</a>
            </div>
        `);
        currentRouteMarkers.push(marker);
    });

    currentRoutePolyline = L.polyline(latLngs, {
        color: '#c86d63',
        weight: 5,
        opacity: 0.9,
        dashArray: '8, 8',
        lineCap: 'round',
        lineJoin: 'round'
    }).addTo(map);

    map.fitBounds(currentRoutePolyline.getBounds(), { padding: [45, 45] });
}

function renderRouteItineraryUI(startPoint, orderedRoute, totalKm) {
    const container = document.getElementById('routeItineraryResult');
    if (!container) return;

    const totalMeters = Math.round(totalKm * 1000);
    const totalDistStr = totalKm < 1 ? `${totalMeters} metros` : `${totalKm.toFixed(2)} km`;
    const walkingMinutes = Math.max(1, Math.round((totalKm / 4.2) * 60));

    const originStr = `${startPoint.lat},${startPoint.lng}`;
    const lastStore = orderedRoute[orderedRoute.length - 1].store;
    const destStr = `${lastStore.latitude},${lastStore.longitude}`;
    const intermediateWaypoints = orderedRoute.slice(0, -1).map(leg => `${leg.store.latitude},${leg.store.longitude}`).join('|');

    let gmapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${originStr}&destination=${destStr}&travelmode=walking`;
    if (intermediateWaypoints) {
        gmapsUrl += `&waypoints=${encodeURIComponent(intermediateWaypoints)}`;
    }

    let stopsHtml = `
        <div class="itinerary-stop" style="background: rgba(37,99,235,0.06); border-color: rgba(37,99,235,0.25);">
            <div class="stop-number-badge" style="background: #2563eb;">🏁</div>
            <div class="stop-info">
                <div class="stop-title">Punto de Partida: ${startPoint.name}</div>
                <div class="stop-meta">Inicio del recorrido por el Centro Histórico de Zacatecas</div>
            </div>
        </div>
    `;

    orderedRoute.forEach((leg, idx) => {
        const store = leg.store;
        const legDist = leg.legDistanceKm < 1 
            ? `${Math.round(leg.legDistanceKm * 1000)} m` 
            : `${leg.legDistanceKm.toFixed(2)} km`;
        const legTimeMin = Math.max(1, Math.round((leg.legDistanceKm / 4.2) * 60));

        let cartItemsHtml = '';
        if (leg.cartItems && leg.cartItems.length > 0) {
            const storeSub = leg.cartItems.reduce((acc, it) => acc + (parseFloat(it.price) || 0) * (parseInt(it.quantity) || 1), 0);
            cartItemsHtml = `
                <div class="itinerary-cart-box">
                    <div class="itinerary-cart-header">
                        <span>🛍️ Artículos en tu carrito a ver en esta tienda (${leg.cartItems.length}):</span>
                        <span class="itinerary-cart-subtotal">$${storeSub.toFixed(2)} MXN</span>
                    </div>
                    <ul class="itinerary-cart-list">
                        ${leg.cartItems.map(p => `
                            <li>
                                <img src="${p.image_url || 'https://placehold.co/40x40?text=Zac'}" alt="${p.name}" class="itinerary-prod-thumb" onerror="this.onerror=null; this.src='https://placehold.co/40x40?text=Prod';">
                                <div class="itinerary-prod-info">
                                    <strong>${p.name}</strong>
                                    <span style="color:var(--muted); font-size:11px;">${p.quantity} pza(s) × $${parseFloat(p.price).toFixed(2)}</span>
                                </div>
                                <span class="itinerary-prod-total">$${((parseFloat(p.price) || 0) * (parseInt(p.quantity) || 1)).toFixed(2)}</span>
                            </li>
                        `).join('')}
                    </ul>
                </div>
            `;
        }

        stopsHtml += `
            <div class="itinerary-stop">
                <div class="stop-number-badge" style="background: ${store.primary_color || '#c86d63'};">${idx + 1}</div>
                <div class="stop-info">
                    <div class="stop-title">${store.store_name}</div>
                    <div class="stop-meta">
                        <span>📍 ${store.address}</span><br>
                        <span style="color:#059669; font-weight:600;">⏰ ${store.opening_hours}</span>
                    </div>
                    ${cartItemsHtml}
                    <div style="display:flex; gap:8px; align-items:center; margin-top:8px; flex-wrap:wrap;">
                        <span class="stop-distance-pill">🚶‍♂️ +${legDist} (~${legTimeMin} min)</span>
                        <a href="${store.store_url}" target="_blank" style="font-size:11.5px; font-weight:700; color:var(--accent); text-decoration:underline;">Ver Tienda Online ↗</a>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = `
        <div class="route-itinerary-card">
            <div class="itinerary-header">
                <div>
                    <span class="itinerary-tag">✓ RUTA CALCULADA</span>
                    <h4>Itinerario de Compras</h4>
                    <small style="color:var(--muted); font-size:12px;">Ordenadas para minimizar tu recorrido por el Centro</small>
                </div>
                <div class="itinerary-metrics">
                    <div class="metric-box">
                        <span class="metric-label">Distancia Total</span>
                        <span class="metric-val">${totalDistStr}</span>
                    </div>
                    <div class="metric-box">
                        <span class="metric-label">Tiempo Estimado</span>
                        <span class="metric-val">~${walkingMinutes} min</span>
                    </div>
                    <div class="metric-box">
                        <span class="metric-label">Paradas</span>
                        <span class="metric-val">${orderedRoute.length} tiendas</span>
                    </div>
                </div>
            </div>

            <div class="itinerary-timeline">
                ${stopsHtml}
            </div>

            <div class="itinerary-actions-row">
                <a href="${gmapsUrl}" target="_blank" class="btn-itinerary-gmaps">
                    <span>🗺️</span> Abrir Ruta Paso a Paso en Google Maps ↗
                </a>
                <button type="button" class="btn-itinerary-wa" onclick="shareShoppingRouteWhatsApp('${totalDistStr}', ${walkingMinutes}, ${orderedRoute.length})">
                    <span>💬</span> Compartir Ruta por WhatsApp
                </button>
                <button type="button" class="btn-itinerary-reset" onclick="resetMapRoute()">
                    ↺ Quitar Trazado del Mapa
                </button>
            </div>
        </div>
    `;

    container.style.display = 'block';
}

function shareShoppingRouteWhatsApp(distStr, minutes, numStops) {
    let text = `*🗺️ Mi Ruta de Compras en Zacatecas Centro*\n`;
    text += `• Distancia total a pie: ${distStr}\n`;
    text += `• Tiempo estimado de caminata: ~${minutes} min\n`;
    text += `• Paradas: ${numStops} tiendas a visitar\n\n`;
    text += `*Itinerario y Productos a Ver:*\n`;

    if (window.__currentOrderedRoute && window.__currentOrderedRoute.length > 0) {
        window.__currentOrderedRoute.forEach((leg, i) => {
            text += `\n${i + 1}. *${leg.store.store_name}* (📍 ${leg.store.address})`;
            if (leg.cartItems && leg.cartItems.length > 0) {
                leg.cartItems.forEach(it => {
                    text += `\n   • ${it.quantity}x ${it.name} ($${parseFloat(it.price).toFixed(2)} MXN)`;
                });
            }
        });
    } else {
        const chips = document.querySelectorAll('.route-store-chip.selected');
        let idx = 1;
        chips.forEach(chip => {
            const title = chip.querySelector('strong')?.textContent || '';
            text += `${idx}. ${title}\n`;
            idx++;
        });
    }

    text += `\n\nPlanificado con Atelier Zacatecas: ${window.location.href.split('#')[0]}`;
    window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
}

function resetMapRoute() {
    if (currentRoutePolyline && map) {
        map.removeLayer(currentRoutePolyline);
        currentRoutePolyline = null;
    }
    currentRouteMarkers.forEach(m => {
        if (map) map.removeLayer(m);
    });
    currentRouteMarkers = [];

    const container = document.getElementById('routeItineraryResult');
    if (container) container.style.display = 'none';

    if (map) {
        map.setView(ZACATECAS_CENTER, window.innerWidth < 768 ? 14.5 : 15);
    }
}

// INITIALIZE CART-DRIVEN ROUTE SYSTEM
function initCartRouteSystem() {
    renderCartForRoute();
    updateHeaderCartBadge();
    autoDetectUserLocation();

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('action') === 'cart_route' || urlParams.get('action') === 'route') {
        const targetStore = urlParams.get('store');
        if (targetStore) {
            selectedRouteStoreIds.add(String(targetStore));
        }
        setTimeout(() => {
            goToCartRoutePlanner();
            optimizeShoppingRoute(true);
        }, 500);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCartRouteSystem);
} else {
    initCartRouteSystem();
}

// ========================================================
// REAL-TIME OPERATING HOURS PARSER (ZACATECAS TIMEZONE UTC-6)
// ========================================================
function getZacatecasNow() {
    try {
        const parts = new Intl.DateTimeFormat('en-US', {
            timeZone: 'America/Mexico_City',
            weekday: 'short',
            hour: 'numeric',
            minute: 'numeric',
            hour12: false
        }).formatToParts(new Date());
        
        let weekday = '', hour = 0, minute = 0;
        parts.forEach(p => {
            if (p.type === 'weekday') weekday = p.value;
            if (p.type === 'hour') hour = parseInt(p.value, 10);
            if (p.type === 'minute') minute = parseInt(p.value, 10);
        });
        if (hour === 24) hour = 0;
        return { weekday, minutesNow: hour * 60 + minute };
    } catch(e) {
        const d = new Date();
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        return { weekday: days[d.getDay()], minutesNow: d.getHours() * 60 + d.getMinutes() };
    }
}

function parseTimeToMinutes(h, m, ampm) {
    let hours = parseInt(h, 10);
    const mins = parseInt(m || 0, 10);
    ampm = (ampm || '').toUpperCase();
    if (ampm === 'PM' && hours < 12) hours += 12;
    if (ampm === 'AM' && hours === 12) hours = 0;
    return hours * 60 + mins;
}

function checkStoreOpen(hoursStr) {
    const dict = i18nDictionary[currentLang] || i18nDictionary.es;
    if (!hoursStr) return { isOpen: true, label: dict.open_now };

    const { weekday, minutesNow } = getZacatecasNow();
    const isSunday = (weekday === 'Sun');
    const segments = hoursStr.split('|');

    for (let segment of segments) {
        segment = segment.trim();
        let applies = false;
        const lower = segment.toLowerCase();

        if (lower.includes('domingo') && !lower.includes('lunes a domingo')) {
            if (isSunday) applies = true;
        } else if (lower.includes('lunes a sábado') || lower.includes('lunes a sabado')) {
            if (!isSunday) applies = true;
        } else if (lower.includes('lunes a domingo') || lower.includes('todos los días')) {
            applies = true;
        } else {
            applies = true;
        }

        if (applies) {
            const timeMatch = segment.match(/(\d{1,2}):(\d{2})\s*(AM|PM)\s*-\s*(\d{1,2}):(\d{2})\s*(AM|PM)/i);
            if (timeMatch) {
                const startMin = parseTimeToMinutes(timeMatch[1], timeMatch[2], timeMatch[3]);
                const endMin = parseTimeToMinutes(timeMatch[4], timeMatch[5], timeMatch[6]);
                if (minutesNow >= startMin && minutesNow < endMin) {
                    return { isOpen: true, label: dict.open_now };
                }
            }
        }
    }

    return { isOpen: false, label: dict.closed };
}

function updateAllStoresOpenStatus() {
    const cards = document.querySelectorAll('.company-card');
    cards.forEach(card => {
        const hours = card.dataset.hours || '';
        const id = card.dataset.companyId;
        const status = checkStoreOpen(hours);
        card.dataset.isOpen = status.isOpen ? '1' : '0';

        const badge = document.getElementById(`badge-open-${id}`);
        if (badge) {
            badge.className = `store-open-badge ${status.isOpen ? 'badge-open' : 'badge-closed'}`;
            const statusTextEl = badge.querySelector('.status-text');
            if (statusTextEl) {
                statusTextEl.textContent = status.label;
            }
        }
    });
}

// ========================================================
// COMBINED FILTERS: DISTANCE RADIUS, ZONE & OPEN NOW
// ========================================================
let activeRadiusKm = null;
let onlyOpenFilterActive = false;
let currentZoneFilter = 'all';

function filterByDistance(maxKm, btnEl) {
    if (maxKm >= 900) {
        activeRadiusKm = null;
    } else {
        activeRadiusKm = parseFloat(maxKm);
    }

    document.querySelectorAll('.radius-pill').forEach(b => b.classList.remove('active'));
    if (btnEl) btnEl.classList.add('active');

    ensureDistancesCalculated();
    applyAllFilters();
}

function toggleFilterOnlyOpen(btnEl) {
    onlyOpenFilterActive = !onlyOpenFilterActive;
    if (btnEl) {
        btnEl.classList.toggle('active', onlyOpenFilterActive);
    }
    applyAllFilters();
}

function ensureDistancesCalculated() {
    const grid = document.getElementById('companiesGrid');
    if (!grid) return;
    const firstCard = grid.querySelector('.company-card');
    if (!firstCard || !firstCard.dataset.distance) {
        const originLat = userCoords ? userCoords.lat : 22.7753;
        const originLng = userCoords ? userCoords.lng : -102.5724;
        sortCardsByProximity(originLat, originLng);
        if (!userCoords) {
            const dict = i18nDictionary[currentLang] || i18nDictionary.es;
            showToast(dict.gps_default_notice);
        }
    }
}

function filterByZone(zoneName, btnEl) {
    currentZoneFilter = zoneName || 'all';
    document.querySelectorAll('.zone-pill').forEach(b => b.classList.remove('active'));
    if (btnEl) btnEl.classList.add('active');
    applyAllFilters();
}

function applyAllFilters() {
    const cards = document.querySelectorAll('.company-card');
    let visibleStores = [];

    cards.forEach(card => {
        const cardZone = (card.dataset.zone || '').toLowerCase();
        const dist = parseFloat(card.dataset.distance || '0');
        const isOpen = card.dataset.isOpen === '1';

        const matchZone = (currentZoneFilter === 'all' || cardZone.includes(currentZoneFilter.toLowerCase()));
        const matchRadius = (!activeRadiusKm || dist <= activeRadiusKm);
        const matchOpen = (!onlyOpenFilterActive || isOpen);

        if (matchZone && matchRadius && matchOpen) {
            card.style.display = 'flex';
            const companyId = card.dataset.companyId;
            const foundStore = businessesData.find(b => String(b.id) === String(companyId));
            if (foundStore) visibleStores.push(foundStore);
        } else {
            card.style.display = 'none';
        }
    });

    renderStoreMarkers(visibleStores.length > 0 ? visibleStores : (onlyOpenFilterActive || activeRadiusKm ? [] : businessesData));
    if (visibleStores.length > 0 && map && currentZoneFilter !== 'all') {
        const first = visibleStores[0];
        map.setView([parseFloat(first.latitude) || 22.7753, parseFloat(first.longitude) || -102.5724], 17);
        if (mapMarkers.length > 0) {
            mapMarkers[0].openPopup();
        }
    } else if (map && currentZoneFilter === 'all') {
        map.setView(ZACATECAS_CENTER, window.innerWidth < 768 ? 14.5 : 15);
    }
}

// ========================================================
// NATIVE WEB SHARE & CLIPBOARD TOAST
// ========================================================
function showToast(message) {
    const toast = document.getElementById('toastPopup');
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    clearTimeout(window.__toastTimer);
    window.__toastTimer = setTimeout(() => {
        toast.classList.remove('show');
    }, 3200);
}

function copyToClipboard(text, successMessage) {
    const dict = i18nDictionary[currentLang] || i18nDictionary.es;
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(() => {
            showToast(successMessage || dict.copied_portal);
        }).catch(() => {
            fallbackPromptCopy(text);
        });
    } else {
        fallbackPromptCopy(text);
    }
}

function fallbackPromptCopy(text) {
    window.prompt(currentLang === 'en' ? 'Copy link:' : 'Copia el enlace:', text);
}

function sharePortal() {
    const dict = i18nDictionary[currentLang] || i18nDictionary.es;
    const shareData = {
        title: 'Atelier Zacatecas · Tiendas del Centro Histórico',
        text: currentLang === 'en' 
            ? 'Discover heritage stores, authentic silver, local handcrafts & dining in Zacatecas Downtown.'
            : 'Explora platerías, artesanías, cafés y tiendas emblemáticas en el Centro de Zacatecas.',
        url: window.location.href.split('#')[0]
    };
    if (navigator.share) {
        navigator.share(shareData).catch(err => {
            if (err.name !== 'AbortError') {
                copyToClipboard(shareData.url, dict.copied_portal);
            }
        });
    } else {
        copyToClipboard(shareData.url, dict.copied_portal);
    }
}

function shareStore(name, url, tagline) {
    const dict = i18nDictionary[currentLang] || i18nDictionary.es;
    const shareData = {
        title: `${name} · Zacatecas Centro`,
        text: `${name}: ${tagline || ''} · Zacatecas Centro Histórico`,
        url: url
    };
    if (navigator.share) {
        navigator.share(shareData).catch(err => {
            if (err.name !== 'AbortError') {
                copyToClipboard(url, dict.copied_store);
            }
        });
    } else {
        copyToClipboard(url, dict.copied_store);
    }
}

// ========================================================
// FLOATING BACK TO TOP BUTTON
// ========================================================
function initBackToTop() {
    const btn = document.getElementById('btnBackToTop');
    if (!btn) return;
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    }, { passive: true });
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ========================================================
// BILINGUAL i18n SUPPORT (ESPAÑOL 🇲🇽 / ENGLISH 🇺🇸)
// ========================================================
const i18nDictionary = {
    es: {
        nav_cercanas: "Tiendas Cercanas",
        nav_cercanas_sub: "Zacatecas Centro Histórico & Mapa",
        nav_empresas: "Directorio de Empresas",
        nav_empresas_sub: "Bitácora oficial de comercios locales",
        nav_buscar: "Búsqueda Global de Productos",
        nav_buscar_sub: "Catálogo completo de todas las tiendas",
        nav_planes: "Planes de Renta de Tiendas",
        nav_planes_sub: "Abre tu sucursal en línea hoy",
        nav_admin: "Panel Super Admin Central",
        nav_admin_sub: "Administración multi-tenant del sistema",
        label_walking: "Distancia a pie:",
        radius_all: "✦ Todo el Centro",
        radius_200: "⚡ Menos de 200 m (2 min)",
        radius_500: "🚶‍♀️ Menos de 500 m (5 min)",
        radius_1k: "🏃‍♂️ Menos de 1 km",
        btn_only_open: "Solo Abiertos Ahora",
        reviews: "reseñas",
        featured_items: "Artículos destacados",
        products_count_label: "productos",
        social_label: "Redes & Contacto",
        enter_store: "Entrar a la Tienda",
        btn_share: "Compartir",
        btn_rent_cta: "Rentar Tienda Online (-20% Anual)",
        open_now: "Abierto Ahora",
        closed: "Cerrado",
        lang_switch_label: "ES",
        lang_drawer_label: "Español (ES)",
        copied_portal: "¡Enlace del portal copiado al portapapeles!",
        copied_store: "¡Enlace del comercio copiado!",
        gps_active: "Ubicación GPS Activa",
        gps_default_notice: "Calculado desde Plaza de Armas. Activa tu GPS para distancia exacta."
    },
    en: {
        nav_cercanas: "Nearby Stores",
        nav_cercanas_sub: "Zacatecas Downtown & Map",
        nav_empresas: "Business Directory",
        nav_empresas_sub: "Official log of local merchants",
        nav_buscar: "Global Product Search",
        nav_buscar_sub: "Full catalog across all stores",
        nav_planes: "Store Rental Plans",
        nav_planes_sub: "Launch your online branch today",
        nav_admin: "Super Admin Panel",
        nav_admin_sub: "Multi-tenant system management",
        label_walking: "Walking distance:",
        radius_all: "✦ All Downtown",
        radius_200: "⚡ Under 200 m (2 min)",
        radius_500: "🚶‍♀️ Under 500 m (5 min)",
        radius_1k: "🏃‍♂️ Under 1 km",
        btn_only_open: "Open Now Only",
        reviews: "reviews",
        featured_items: "Featured items",
        products_count_label: "products",
        social_label: "Social & Contact",
        enter_store: "Visit Store",
        btn_share: "Share",
        btn_rent_cta: "Rent Online Store (-20% Annual)",
        open_now: "Open Now",
        closed: "Closed",
        lang_switch_label: "EN",
        lang_drawer_label: "English (US)",
        copied_portal: "Portal link copied to clipboard!",
        copied_store: "Store link copied!",
        gps_active: "GPS Location Active",
        gps_default_notice: "Calculated from Plaza de Armas. Enable GPS for exact distance."
    }
};

let currentLang = localStorage.getItem('portal_lang') || 'es';

function toggleLanguage() {
    currentLang = currentLang === 'es' ? 'en' : 'es';
    localStorage.setItem('portal_lang', currentLang);
    applyLanguage(currentLang);
}

function applyLanguage(lang) {
    currentLang = lang || 'es';
    const dict = i18nDictionary[currentLang] || i18nDictionary.es;

    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (dict[key]) {
            el.textContent = dict[key];
        }
    });

    document.querySelectorAll('.lang-label-text').forEach(el => el.textContent = dict.lang_switch_label);
    document.querySelectorAll('.lang-drawer-text').forEach(el => el.textContent = dict.lang_drawer_label);

    updateAllStoresOpenStatus();

    if (map) {
        applyAllFilters();
    }
}

// Mobile Navigation Drawer Toggle, Open & Close
function toggleMobileMenu() {
    const menu = document.getElementById('portalMobileMenu');
    const isOpen = menu && menu.classList.contains('open');
    if (isOpen) {
        closeMobileMenu();
    } else {
        openMobileMenu();
    }
}

function openMobileMenu() {
    const menu = document.getElementById('portalMobileMenu');
    const backdrop = document.getElementById('mobileDrawerBackdrop');
    const toggle = document.getElementById('mobileMenuToggle');
    if (menu) menu.classList.add('open');
    if (backdrop) backdrop.classList.add('active');
    if (toggle) toggle.classList.add('active');
    document.body.style.overflow = 'hidden'; // Lock background scroll on mobile
}

function closeMobileMenu() {
    const menu = document.getElementById('portalMobileMenu');
    const backdrop = document.getElementById('mobileDrawerBackdrop');
    const toggle = document.getElementById('mobileMenuToggle');
    if (menu) menu.classList.remove('open');
    if (backdrop) backdrop.classList.remove('active');
    if (toggle) toggle.classList.remove('active');
    document.body.style.overflow = ''; // Restore background scroll
}

// Close mobile drawer on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeMobileMenu();
    }
});

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

// Initialize map, theme icons, language, hours, back-to-top on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    initZacatecasMap();
    const activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
    updateThemeIcons(activeTheme);
    initBackToTop();
    applyLanguage(currentLang);
    updateAllStoresOpenStatus();

    // Auto-update hours status every 60 seconds
    setInterval(updateAllStoresOpenStatus, 60000);

    // Initial Tab Selection based on Hash or URL
    const initialHash = window.location.hash;
    const urlParams = new URLSearchParams(window.location.search);
    if (initialHash === '#cercanas' || initialHash === '#zacatecasMap') {
        switchMainTab('map', false);
    } else if (initialHash === '#empresas' || urlParams.has('categoria')) {
        switchMainTab('stores', false);
    } else if (initialHash === '#planes') {
        window.location.href = "{{ url('/planes') }}";
    } else {
        const savedTab = sessionStorage.getItem('active_portal_tab');
        if (savedTab && ['feed', 'map', 'stores', 'plans'].includes(savedTab)) {
            switchMainTab(savedTab, false);
        } else {
            switchMainTab('feed', false);
        }
    }
});
</script>

</body>
</html>