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

        /* STANDALONE PWA OPTIMIZATIONS (INSTALLED ON MOBILE) */
        @media all and (display-mode: standalone) {
            .pwa-install-bar,
            .floating-pwa-badge {
                display: none !important;
            }
            .portal-header {
                padding-top: max(10px, env(safe-area-inset-top));
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
            <a href="#cercanas" style="color: var(--accent); font-weight: 700;">📍 Tiendas Cercanas</a>
            <a href="#empresas">Empresas</a>
            <a href="#buscar">Búsqueda Global</a>
            <a href="#planes">💎 Planes de Renta</a>
            <a href="{{ url('/admin') }}" target="_blank">Super Admin</a>
        </nav>

        <div class="portal-auth-actions">
            <button type="button" class="btn-rent-nav" onclick="openRentModal('crecimiento', 'annual')">
                <span>✨</span> <span class="rent-btn-long-text">Rentar Tienda</span>
            </button>

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
        <a href="#cercanas" class="drawer-nav-item" onclick="closeMobileMenu()">
            <div class="nav-item-icon" style="background: rgba(200, 109, 99, 0.15); color: #c86d63;">📍</div>
            <div class="nav-item-text">
                <div class="nav-item-title" data-i18n="nav_cercanas">Tiendas Cercanas</div>
                <div class="nav-item-sub" data-i18n="nav_cercanas_sub">Zacatecas Centro Histórico &amp; Mapa</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#empresas" class="drawer-nav-item" onclick="closeMobileMenu()">
            <div class="nav-item-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">🏢</div>
            <div class="nav-item-text">
                <div class="nav-item-title" data-i18n="nav_empresas">Directorio de Empresas</div>
                <div class="nav-item-sub" data-i18n="nav_empresas_sub">Bitácora oficial de comercios locales</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#buscar" class="drawer-nav-item" onclick="closeMobileMenu()">
            <div class="nav-item-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">🔍</div>
            <div class="nav-item-text">
                <div class="nav-item-title" data-i18n="nav_buscar">Búsqueda Global de Productos</div>
                <div class="nav-item-sub" data-i18n="nav_buscar_sub">Catálogo completo de todas las tiendas</div>
            </div>
            <span class="nav-item-arrow">›</span>
        </a>

        <a href="#planes" class="drawer-nav-item" onclick="closeMobileMenu()">
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
        <button type="button" class="btn-rent-drawer" onclick="closeMobileMenu(); openRentModal('crecimiento', 'annual')">
            ✨ <span data-i18n="btn_rent_cta">Rentar Tienda Online (-20% Anual)</span>
        </button>

        <div class="drawer-brand-footer">
            <span>Atelier Zacatecas · Cantera Rosa &amp; Plata</span>
            <small>Plataforma PWA Offline Ready v2.2.0</small>
        </div>
    </div>
</aside>

<main class="shell">

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

            <!-- Smart Shopping Route Optimizer Panel -->
            <div class="route-optimizer-box" id="routeOptimizerPanel">
                <div class="route-opt-header">
                    <div>
                        <span class="route-opt-badge">⚡ RUTA INTELIGENTE DE COMPRAS</span>
                        <h3 style="font-size: 18px; font-weight: 800; margin: 4px 0; color: var(--ink);">Planificador de Compras en Zacatecas Centro</h3>
                        <p style="font-size: 13px; color: var(--muted); margin: 0;">Selecciona las tiendas que deseas visitar para comprar. El sistema calculará automáticamente la <strong>ruta peatonal más corta y eficiente</strong> por las calles del Centro Histórico.</p>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        <button type="button" class="btn-route-gps-origin" onclick="selectAllStoresForRoute()" style="padding: 6px 12px; font-size: 12px;">✦ Seleccionar Todas</button>
                        <button type="button" class="btn-route-gps-origin" onclick="clearRouteSelection()" style="padding: 6px 12px; font-size: 12px;">↺ Limpiar</button>
                    </div>
                </div>

                <div class="route-stores-selector" id="routeStoresSelector">
                    @foreach($businesses as $b)
                        <div class="route-store-chip selected" 
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

                <div class="route-opt-trigger-row">
                    <button type="button" class="btn-calculate-route" id="btnCalculateRoute" onclick="optimizeShoppingRoute()">
                        <span>🗺️</span> Calcular Ruta Recomendada
                    </button>
                    <button type="button" class="btn-route-gps-origin" id="btnRouteUseGps" onclick="requestUserLocationForRoute()">
                        <span>📍</span> <span id="routeOriginLabel">Origen: Plaza de Armas (Centro)</span>
                    </button>
                </div>

                <!-- Itinerary Result Output -->
                <div id="routeItineraryResult" style="display: none;"></div>
            </div>
        </div>

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
                            <div class="store-rating-row">
                                <span class="stars-gold">★★★★★</span>
                                <span class="rating-num">{{ number_format($company['rating'] ?? 4.9, 1) }}</span>
                                <span class="rating-count">({{ $company['reviews_count'] ?? 180 }} <span data-i18n="reviews">reseñas</span>)</span>
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
                                        <a href="{{ $prod['url'] }}" class="preview-thumb-box" title="{{ $prod['name'] }}"
                                            onclick='event.preventDefault(); openCentralProductModal({
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

    <!-- ============================================== -->
    <!-- SECTION: PLANES Y PRECIOS DE RENTA SAAS        -->
    <!-- ============================================== -->
    <section class="portal-section plans-section" id="planes">
        <div class="section-header" style="text-align: center; max-width: 820px; margin: 0 auto 20px;">
            <div class="section-eyebrow" style="justify-content: center;">Renta tu Tienda SaaS B2B</div>
            <h2 class="section-title">Planes de Renta para Empresas</h2>
            <p style="color: var(--muted); font-size: 15px; margin-top: 10px; line-height: 1.6;">
                Digitaliza tu marca con una tienda e-commerce completamente autónoma: base de datos SQLite aislada en modo WAL de alta velocidad, subdominio personalizado, panel privado Filament v3 y <strong>0% comisiones por venta</strong>.
            </p>

            <!-- INTERACTIVE BILLING CYCLE TOGGLE -->
            <div class="billing-toggle-container">
                <div class="billing-toggle-box">
                    <button type="button" class="billing-toggle-btn active" id="btnMonthly" onclick="switchBillingCycle('monthly')">
                        📅 Facturación Mensual
                    </button>
                    <button type="button" class="billing-toggle-btn" id="btnAnnual" onclick="switchBillingCycle('annual')">
                        💎 Facturación Anual
                    </button>
                </div>
                <div class="annual-badge-pill" id="annualSavingsBadge">
                    <span>🎉 Ahorra 20% anual (2 meses gratis de renta)</span>
                </div>
            </div>
        </div>

        <!-- PLANS CARDS GRID -->
        <div class="plans-grid">
            @foreach($subscriptionPlans as $plan)
                <div class="plan-card {{ $plan->is_popular ? 'plan-card-popular' : '' }}" id="card-plan-{{ $plan->slug }}">
                    @if($plan->badge)
                        <div class="plan-popular-badge">{{ $plan->badge }}</div>
                    @endif

                    <div>
                        <div class="plan-header">
                            <h3 class="plan-name">{{ $plan->name }}</h3>
                            <p class="plan-tagline">{{ $plan->tagline }}</p>
                        </div>

                        <div class="plan-price-wrapper">
                            <!-- Dynamic Monthly Price Display -->
                            <div class="price-display price-monthly-box" id="price-monthly-{{ $plan->slug }}" style="display: block;">
                                <span class="price-currency">$</span>
                                <span class="price-amount">{{ number_format($plan->monthly_price, 0) }}</span>
                                <span class="price-period">USD / mes</span>
                                <div class="price-subnote">Facturación mes a mes</div>
                            </div>

                            <!-- Dynamic Annual Price Display -->
                            <div class="price-display price-annual-box" id="price-annual-{{ $plan->slug }}" style="display: none;">
                                <span class="price-currency">$</span>
                                <span class="price-amount">{{ number_format($plan->annual_price_per_month, 0) }}</span>
                                <span class="price-period">USD / mes</span>
                                <div class="price-subnote" style="color: #047857; font-weight: 700;">
                                    Facturado anual: ${{ number_format($plan->annual_total, 0) }} USD (Ahorras ${{ number_format($plan->annual_savings, 0) }} USD/año)
                                </div>
                            </div>
                        </div>

                        <div class="plan-divider"></div>

                        <!-- Highlight Meta -->
                        <div class="plan-highlights">
                            <div class="highlight-item">
                                <span class="hl-icon">📦</span>
                                <span>{{ $plan->product_limit ? "Hasta {$plan->product_limit} productos activos" : 'Productos y categorías ILIMITADOS' }}</span>
                            </div>
                            <div class="highlight-item">
                                <span class="hl-icon">🌐</span>
                                <span>{{ $plan->has_custom_domain ? 'Subdominio + Dominio propio' : 'Subdominio exclusivo incluido' }}</span>
                            </div>
                            <div class="highlight-item">
                                <span class="hl-icon">🏷️</span>
                                <span>0% de comisiones por tus ventas</span>
                            </div>
                        </div>

                        <!-- Features List -->
                        <ul class="plan-features-list">
                            @foreach($plan->features ?? [] as $feat)
                                <li>
                                    <svg class="check-icon" width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $feat }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="plan-footer">
                        <button type="button" 
                                class="btn-plan-cta {{ $plan->is_popular ? 'btn-popular' : '' }}"
                                onclick="openRentModal('{{ $plan->slug }}', currentBillingCycle)">
                            Rentar {{ $plan->name }} <span>→</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

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

<!-- MODAL: RENTA TU TIENDA ONLINE -->
<div class="modal-backdrop" id="rentModal">
    <div class="auth-modal-card rent-modal-card">
        <button class="modal-close-x" onclick="closeRentModal()" aria-label="Cerrar modal">✕</button>

        <div class="rent-modal-header">
            <span class="rent-modal-pill">✦ Alta Rápida de Empresa</span>
            <h3 class="auth-modal-title">Renta tu Tienda Virtual</h3>
            <p class="auth-modal-subtitle">Tu catálogo e infraestructura multi-tenant quedarán configurados en segundos.</p>
        </div>

        <form action="{{ route('central.rent.tenant') }}" method="POST" id="rentForm" onsubmit="handleRentSubmit()">
            @csrf

            <!-- Plan & Billing Selector in Modal -->
            <div class="rent-summary-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <strong id="modalPlanLabel" style="font-size: 15px; color: var(--ink);">Plan Crecimiento</strong>
                    <span id="modalCycleLabel" class="rent-cycle-tag">💎 Anual (-20% Ahorro)</span>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <select name="plan_slug" id="modalPlanSelect" class="rent-select" onchange="updateModalSummary()">
                        @foreach($subscriptionPlans as $p)
                            <option value="{{ $p->slug }}" 
                                    data-name="{{ $p->name }}" 
                                    data-monthly="{{ $p->monthly_price }}" 
                                    data-annual="{{ $p->annual_price_per_month }}" 
                                    data-total="{{ $p->annual_total }}"
                                    data-savings="{{ $p->annual_savings }}"
                                    {{ $p->slug === 'crecimiento' ? 'selected' : '' }}>
                                {{ $p->name }} (${{ number_format($p->monthly_price, 0) }}/m o ${{ number_format($p->annual_price_per_month, 0) }}/m anual)
                            </option>
                        @endforeach
                    </select>
                    <select name="billing_cycle" id="modalCycleSelect" class="rent-select" onchange="updateModalSummary()">
                        <option value="annual" selected>💎 Anual (-20% Ahorro)</option>
                        <option value="monthly">📅 Mensual</option>
                    </select>
                </div>
                <div id="modalPriceSummary" style="margin-top: 10px; font-size: 12px; color: var(--muted); font-weight: 600;">
                    Total a pagar: $372 USD / año ($31 USD/mes) · ¡Ahorras $96 USD!
                </div>
            </div>

            <!-- Company Details -->
            <div class="auth-field">
                <label for="rentCompanyName">Nombre de tu Empresa o Marca *</label>
                <input type="text" name="company_name" id="rentCompanyName" placeholder="Ej. Zapatería Verona" required oninput="autoGenerateSubdomain(this.value)">
            </div>

            <div class="auth-field">
                <label for="rentSubdomain">Subdominio para tu Tienda *</label>
                <div class="subdomain-input-wrap">
                    <input type="text" name="subdomain" id="rentSubdomain" placeholder="verona" required pattern="[a-z0-9-]+" minlength="3" maxlength="30" oninput="updateSubdomainPreview(this.value)">
                    <span class="subdomain-suffix">.localhost:8000</span>
                </div>
                <div class="subdomain-preview-text" id="subdomainLivePreview">
                    🌐 Tu tienda estará en: <strong>http://verona.localhost:8000</strong>
                </div>
            </div>

            <div class="auth-field">
                <label for="rentCategory">Giro o Categoría del Negocio</label>
                <select name="business_category" id="rentCategory" class="rent-select" style="width: 100%;">
                    <option value="Moda y Lujo">👗 Moda, Lujo & Accesorios</option>
                    <option value="Tecnología y Gadgets">💻 Tecnología, Audio & Dispositivos</option>
                    <option value="Bebidas y Alimentos">🥤 Bebidas, Refrescos & Gourmet</option>
                    <option value="Hogar y Decoración">🏺 Hogar, Mobiliario & Diseño</option>
                    <option value="Salud y Belleza">🌿 Belleza, Cuidado & Fragancias</option>
                    <option value="Comercio General" selected>🏬 Tienda Departamental / General</option>
                </select>
            </div>

            <!-- Owner Credentials -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="auth-field">
                    <label for="rentOwnerName">Nombre del Propietario *</label>
                    <input type="text" name="owner_name" id="rentOwnerName" placeholder="Carlos Mendoza" required>
                </div>
                <div class="auth-field">
                    <label for="rentOwnerEmail">Correo de Administrador *</label>
                    <input type="email" name="owner_email" id="rentOwnerEmail" placeholder="admin@verona.com" required>
                </div>
            </div>

            <div class="auth-field">
                <label for="rentOwnerPassword">Contraseña del Panel Admin *</label>
                <input type="password" name="owner_password" id="rentOwnerPassword" placeholder="Mínimo 6 caracteres" minlength="6" required>
                <small style="font-size: 11px; color: var(--muted); display: block; margin-top: 4px;">Usarás este correo y contraseña para entrar a tu panel de control Filament.</small>
            </div>

            <button type="submit" class="btn-submit-email-auth" id="btnRentSubmit" style="background: linear-gradient(135deg, #d47a6f 0%, #ba584d 100%); margin-top: 14px; border: 1px solid rgba(255, 255, 255, 0.25); box-shadow: 0 4px 14px rgba(200, 109, 99, 0.4);">
                🚀 Confirmar Renta y Activar Tienda Ahora
            </button>
            <div id="rentLoadingState" style="display: none; text-align: center; margin-top: 14px; font-size: 13px; font-weight: 700; color: var(--accent);">
                ⏳ Creando base de datos SQLite aislada y configurando catálogo... Por favor espera unos segundos.
            </div>
        </form>
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

                <!-- Action Buttons -->
                <div class="modal-actions-row">
                    <a id="centralModalWaBtn" href="#" target="_blank" class="btn-whatsapp-order">
                        <svg style="width:20px; height:20px; fill:#fff;" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.971.53 1.769.814 2.797.814 3.18 0 5.767-2.587 5.768-5.766 0-3.18-2.588-5.766-5.769-5.766zm0 10.355c-.886 0-1.616-.242-2.348-.675l-.168-.1-1.745.458.466-1.701-.11-.175c-.476-.757-.728-1.503-.728-2.399 0-2.531 2.059-4.59 4.635-4.59 2.576 0 4.635 2.059 4.635 4.59 0 2.531-2.059 4.592-4.535 4.592zm-8.031-4.589c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12z"/></svg>
                        Pedir por WhatsApp (<span id="centralModalBtnPrice">$0.00</span>)
                    </a>
                    <a id="centralModalStoreBtn" href="#" class="btn-visit-store-modal">
                        <span>🏬</span> Ir a la Tienda Oficial Completa ↗
                    </a>
                </div>
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

<!-- JAVASCRIPT FOR LIVE SEARCH & MODAL -->
<script>
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

// RENTAL MODAL HANDLERS
let hasCustomSubdomain = false;

function openRentModal(planSlug = 'crecimiento', cycle = null) {
    const modal = document.getElementById('rentModal');
    if (!modal) return;

    if (cycle) {
        currentBillingCycle = cycle;
    }

    const planSelect = document.getElementById('modalPlanSelect');
    const cycleSelect = document.getElementById('modalCycleSelect');

    if (planSelect && planSlug) {
        planSelect.value = planSlug;
    }
    if (cycleSelect) {
        cycleSelect.value = currentBillingCycle;
    }

    updateModalSummary();
    modal.classList.add('open');
}

function closeRentModal() {
    const modal = document.getElementById('rentModal');
    if (modal) modal.classList.remove('open');
}

function updateModalSummary() {
    const planSelect = document.getElementById('modalPlanSelect');
    const cycleSelect = document.getElementById('modalCycleSelect');
    const planLabel = document.getElementById('modalPlanLabel');
    const cycleLabel = document.getElementById('modalCycleLabel');
    const priceSummary = document.getElementById('modalPriceSummary');

    if (!planSelect || !cycleSelect) return;

    const selectedOption = planSelect.options[planSelect.selectedIndex];
    if (!selectedOption) return;

    const planName = selectedOption.getAttribute('data-name');
    const monthlyPrice = parseFloat(selectedOption.getAttribute('data-monthly') || 0);
    const annualMonthly = parseFloat(selectedOption.getAttribute('data-annual') || 0);
    const annualTotal = parseFloat(selectedOption.getAttribute('data-total') || 0);
    const savings = parseFloat(selectedOption.getAttribute('data-savings') || 0);
    const isAnnual = cycleSelect.value === 'annual';

    if (planLabel) planLabel.textContent = planName;
    if (cycleLabel) {
        cycleLabel.textContent = isAnnual ? '💎 Anual (-20% Ahorro)' : '📅 Mensual';
        cycleLabel.style.background = isAnnual ? '#d1fae5' : '#e0e7ff';
        cycleLabel.style.color = isAnnual ? '#059669' : '#3730a3';
    }

    if (priceSummary) {
        if (isAnnual) {
            priceSummary.innerHTML = `Total de la renta: <strong>$${annualTotal.toFixed(0)} USD / año</strong> ($${annualMonthly.toFixed(0)} USD/mes) · <span style="color: #059669;">¡Ahorras $${savings.toFixed(0)} USD al año!</span>`;
        } else {
            priceSummary.innerHTML = `Total de la renta: <strong>$${monthlyPrice.toFixed(0)} USD / mes</strong> (Facturación recurrente mensual)`;
        }
    }
}

function autoGenerateSubdomain(companyName) {
    if (hasCustomSubdomain) return;
    const subInput = document.getElementById('rentSubdomain');
    if (!subInput) return;

    const clean = companyName
        .toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/[^a-z0-9]/g, "");

    subInput.value = clean.substring(0, 25);
    updateSubdomainPreview(subInput.value);
}

function updateSubdomainPreview(val) {
    const clean = val.toLowerCase().replace(/[^a-z0-9-]/g, '');
    const preview = document.getElementById('subdomainLivePreview');
    if (preview) {
        preview.innerHTML = `🌐 Tu tienda estará en: <strong>http://${clean || 'mi-tienda'}.localhost:8000</strong>`;
    }
}

document.getElementById('rentSubdomain')?.addEventListener('focus', () => {
    hasCustomSubdomain = true;
});

function handleRentSubmit() {
    const btn = document.getElementById('btnRentSubmit');
    const loading = document.getElementById('rentLoadingState');
    if (btn) {
        btn.disabled = true;
        btn.style.opacity = '0.6';
    }
    if (loading) loading.style.display = 'block';
    return true;
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

function openCentralProductModal(item) {
    if (!item) return;
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

    // Cuando el nuevo Service Worker toma el control, recargar suavemente para mostrar los cambios
    navigator.serviceWorker.addEventListener('controllerchange', () => {
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
            if (!isRefreshing) {
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
        marker.bindPopup(popupContent);
        mapMarkers.push(marker);
    });
}

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
// SMART SHOPPING ROUTE OPTIMIZER (ZACATECAS CENTRO)
// ========================================================
let selectedRouteStoreIds = new Set(businessesData.map(b => String(b.id)));
let currentRoutePolyline = null;
let currentRouteMarkers = [];
let routeOrigin = null;

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

function requestUserLocationForRoute() {
    if (!navigator.geolocation) {
        alert('Tu dispositivo no soporta geolocalización GPS.');
        return;
    }
    const lbl = document.getElementById('routeOriginLabel');
    if (lbl) lbl.textContent = 'Obteniendo GPS...';

    navigator.geolocation.getCurrentPosition(
        (pos) => {
            userCoords = { lat: pos.coords.latitude, lng: pos.coords.longitude };
            routeOrigin = { lat: pos.coords.latitude, lng: pos.coords.longitude, name: 'Mi Ubicación Actual' };
            if (lbl) lbl.textContent = `Origen: Mi Ubicación (${userCoords.lat.toFixed(4)}, ${userCoords.lng.toFixed(4)})`;
            showToast('📍 Origen configurado en tu ubicación actual');
            if (selectedRouteStoreIds.size > 0) {
                optimizeShoppingRoute();
            }
        },
        (err) => {
            routeOrigin = { lat: ZACATECAS_CENTER[0], lng: ZACATECAS_CENTER[1], name: 'Plaza de Armas (Centro)' };
            if (lbl) lbl.textContent = 'Origen: Plaza de Armas (Centro)';
            showToast('⚠️ No se pudo obtener GPS, usando Plaza de Armas');
        },
        { enableHighAccuracy: true, timeout: 8000 }
    );
}

function optimizeShoppingRoute() {
    if (selectedRouteStoreIds.size === 0) {
        alert('Por favor selecciona al menos una tienda para calcular tu ruta de compras.');
        return;
    }

    const startPoint = routeOrigin || (userCoords 
        ? { lat: userCoords.lat, lng: userCoords.lng, name: 'Mi Ubicación Actual' }
        : { lat: ZACATECAS_CENTER[0], lng: ZACATECAS_CENTER[1], name: 'Plaza de Armas (Centro)' });

    let unvisited = businessesData.filter(b => selectedRouteStoreIds.has(String(b.id)));
    let orderedRoute = [];
    let currentPoint = { lat: startPoint.lat, lng: startPoint.lng };
    let totalKm = 0;

    while (unvisited.length > 0) {
        let bestIndex = 0;
        let bestDistance = Infinity;

        for (let i = 0; i < unvisited.length; i++) {
            const sLat = parseFloat(unvisited[i].latitude) || 22.7753;
            const sLng = parseFloat(unvisited[i].longitude) || -102.5724;
            const d = calculateDistanceKm(currentPoint.lat, currentPoint.lng, sLat, sLng);
            if (d < bestDistance) {
                bestDistance = d;
                bestIndex = i;
            }
        }

        const nextStore = unvisited[bestIndex];
        unvisited.splice(bestIndex, 1);

        totalKm += bestDistance;
        orderedRoute.push({
            store: nextStore,
            legDistanceKm: bestDistance,
            accumulatedKm: totalKm
        });

        currentPoint = {
            lat: parseFloat(nextStore.latitude) || 22.7753,
            lng: parseFloat(nextStore.longitude) || -102.5724
        };
    }

    renderRouteOnMap(startPoint, orderedRoute);
    renderRouteItineraryUI(startPoint, orderedRoute, totalKm);

    const mapSection = document.getElementById('zacatecasMap');
    if (mapSection) {
        mapSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
        html: `<div style="background: #2563eb; color: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800; border: 3px solid #fff; box-shadow: 0 4px 12px rgba(37,99,235,.5);">🏁</div>`,
        iconSize: [34, 34],
        iconAnchor: [17, 34],
        popupAnchor: [0, -32]
    });
    const startMarker = L.marker([startPoint.lat, startPoint.lng], { icon: startIcon }).addTo(map);
    startMarker.bindPopup(`<strong>Punto de Partida:</strong><br>${startPoint.name}`);
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

        const marker = L.marker([sLat, sLng], { icon: stopIcon }).addTo(map);
        marker.bindPopup(`
            <div style="font-family: 'Plus Jakarta Sans', sans-serif; padding: 3px;">
                <span style="font-size: 10px; font-weight: 800; color: ${store.primary_color || '#c86d63'};">PARADA #${stopNum} (+${stopDistStr})</span>
                <h4 style="margin: 2px 0 4px; font-size: 14px; font-weight: 800;">${store.store_name}</h4>
                <p style="margin: 0 0 6px; font-size: 11px; color: #555;">📍 ${store.address}</p>
                <a href="${store.store_url}" target="_blank" style="display: inline-block; background: #c86d63; color: #fff; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; text-decoration: none;">Ver Catálogo ↗</a>
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
                <div class="stop-meta">Inicio del recorrido peatonal por el Centro Histórico de Zacatecas</div>
            </div>
        </div>
    `;

    orderedRoute.forEach((leg, idx) => {
        const store = leg.store;
        const legDist = leg.legDistanceKm < 1 
            ? `${Math.round(leg.legDistanceKm * 1000)} m` 
            : `${leg.legDistanceKm.toFixed(2)} km`;
        const legTimeMin = Math.max(1, Math.round((leg.legDistanceKm / 4.2) * 60));

        stopsHtml += `
            <div class="itinerary-stop">
                <div class="stop-number-badge" style="background: ${store.primary_color || '#c86d63'};">${idx + 1}</div>
                <div class="stop-info">
                    <div class="stop-title">${store.store_name}</div>
                    <div class="stop-meta">
                        <span>📍 ${store.address}</span><br>
                        <span style="color:#059669; font-weight:600;">⏰ ${store.opening_hours}</span>
                    </div>
                    <div style="display:flex; gap:8px; align-items:center; margin-top:6px; flex-wrap:wrap;">
                        <span class="stop-distance-pill">🚶‍♂️ +${legDist} (~${legTimeMin} min)</span>
                        <a href="${store.store_url}" target="_blank" style="font-size:11.5px; font-weight:700; color:var(--accent); text-decoration:underline;">Ver Catálogo ↗</a>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = `
        <div class="route-itinerary-card">
            <div class="itinerary-header">
                <div>
                    <span class="itinerary-tag">✓ RUTA MÁS CORTA CALCULADA</span>
                    <h4>Itinerario Óptimo de Compras</h4>
                    <small style="color:var(--muted); font-size:12px;">Ordenadas de la más cercana a la más lejana para ahorrar pasos</small>
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
    let text = `*🗺️ Ruta de Compras Recomendada en Zacatecas Centro*\n`;
    text += `• Paradas: ${numStops} tiendas seleccionadas\n`;
    text += `• Distancia total: ${distStr}\n`;
    text += `• Tiempo a pie estimado: ~${minutes} min\n\n`;
    text += `*Orden del recorrido:*\n`;

    const chips = document.querySelectorAll('.route-store-chip.selected');
    let idx = 1;
    chips.forEach(chip => {
        const title = chip.querySelector('strong')?.textContent || '';
        text += `${idx}. ${title}\n`;
        idx++;
    });

    text += `\nPlanificado con Atelier Zacatecas: ${window.location.href.split('#')[0]}`;
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
});
</script>

</body>
</html>