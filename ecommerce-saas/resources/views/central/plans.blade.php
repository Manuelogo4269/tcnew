<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
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
    <title>Planes de Renta para Empresas — Atelier Zacatecas SaaS</title>
    <meta name="description" content="Renta tu propia tienda online multi-tenant en Zacatecas Centro. Catálogo autónomo, subdominio personalizado, panel privado y 0% de comisiones.">
    <link rel="icon" type="image/svg+xml" href="/app-icons/icon.svg">
    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        :root {
            --bg: #f8f6f0;
            --card: #ffffff;
            --card-border: rgba(30, 41, 59, 0.08);
            --ink: #1e293b;
            --muted: #64748b;
            --accent: #c86d63;
            --accent-hover: #b45b51;
            --line: rgba(30, 41, 59, 0.1);
            --primary: #c86d63;
        }

        [data-theme="dark"] {
            --bg: #0f172a;
            --card: #1e293b;
            --card-border: rgba(255, 255, 255, 0.08);
            --ink: #f8fafc;
            --muted: #94a3b8;
            --line: rgba(255, 255, 255, 0.12);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.5;
            transition: background .2s ease, color .2s ease;
        }

        /* TOP NAVIGATION HEADER */
        .plans-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--card);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .header-shell {
            max-width: 1200px;
            margin: 0 auto;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn-return-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(200, 109, 99, 0.12);
            color: var(--accent);
            font-weight: 800;
            font-size: 13px;
            text-decoration: none;
            border: 1px solid rgba(200, 109, 99, 0.25);
            transition: all .2s ease;
            white-space: nowrap;
        }
        .btn-return-home:hover {
            background: var(--accent);
            color: #ffffff;
            transform: translateX(-2px);
        }
        .header-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--ink);
        }
        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #c86d63, #b45b51);
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 18px;
            overflow: hidden;
        }
        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .header-title-box strong {
            display: block;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.2;
        }
        .header-title-box small {
            color: var(--muted);
            font-size: 11.5px;
            display: block;
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-theme-toggle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 16px;
            transition: background .2s ease;
        }

        /* HERO SECTION */
        .plans-hero {
            padding: 48px 20px 32px;
            text-align: center;
            max-width: 860px;
            margin: 0 auto;
        }
        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 999px;
            background: rgba(200, 109, 99, 0.12);
            color: var(--accent);
            font-size: 12.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }
        .hero-title {
            font-size: clamp(28px, 5vw, 42px);
            font-weight: 800;
            color: var(--ink);
            line-height: 1.15;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }
        .hero-desc {
            font-size: clamp(14px, 2.5vw, 16.5px);
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        /* BILLING CYCLE TOGGLE */
        .billing-toggle-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }
        .billing-toggle-box {
            display: inline-flex;
            background: var(--card);
            padding: 5px;
            border-radius: 999px;
            border: 1.5px solid var(--line);
            box-shadow: 0 4px 14px rgba(0,0,0,0.04);
        }
        .billing-toggle-btn {
            border: none;
            background: transparent;
            padding: 10px 22px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 700;
            color: var(--muted);
            cursor: pointer;
            transition: all .2s ease;
        }
        .billing-toggle-btn.active {
            background: var(--accent);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(200, 109, 99, 0.35);
        }
        .annual-savings-pill {
            background: #dcfce7;
            color: #166534;
            font-size: 12px;
            font-weight: 800;
            padding: 5px 14px;
            border-radius: 999px;
            border: 1px solid #86efac;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        [data-theme="dark"] .annual-savings-pill {
            background: rgba(22, 101, 52, 0.3);
            color: #86efac;
            border-color: rgba(134, 239, 172, 0.25);
        }

        /* PLANS GRID */
        .plans-shell {
            max-width: 1200px;
            margin: 0 auto 60px;
            padding: 0 20px;
            width: 100%;
        }
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            align-items: stretch;
        }
        .plan-card {
            background: var(--card);
            border: 1.5px solid var(--card-border);
            border-radius: 24px;
            padding: 32px 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }
        .plan-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.08);
            border-color: rgba(200, 109, 99, 0.4);
        }
        .plan-card.popular {
            border-color: var(--accent);
            box-shadow: 0 14px 40px rgba(200, 109, 99, 0.12);
        }
        .popular-badge {
            position: absolute;
            top: -13px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--accent);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 14px;
            border-radius: 999px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(200, 109, 99, 0.4);
        }
        .plan-header {
            margin-bottom: 20px;
        }
        .plan-name {
            font-size: 22px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 6px;
        }
        .plan-tagline {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.4;
        }

        /* PRICE DISPLAY */
        .plan-price-wrapper {
            margin-bottom: 24px;
            padding: 16px 0;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }
        .price-display {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }
        .price-currency {
            font-size: 24px;
            font-weight: 800;
            color: var(--ink);
        }
        .price-amount {
            font-size: 42px;
            font-weight: 900;
            color: var(--ink);
            line-height: 1;
        }
        .price-period {
            font-size: 14px;
            color: var(--muted);
            font-weight: 600;
        }
        .price-subnote {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px;
        }

        /* PLAN HIGHLIGHTS */
        .plan-highlights {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
            background: rgba(30, 41, 59, 0.03);
            padding: 14px;
            border-radius: 14px;
        }
        [data-theme="dark"] .plan-highlights {
            background: rgba(255, 255, 255, 0.03);
        }
        .highlight-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
        }

        /* FEATURES LIST */
        .plan-features-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 28px;
        }
        .plan-features-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13.5px;
            color: var(--ink);
            line-height: 1.4;
        }
        .check-icon {
            color: #10b981;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* CTA BUTTON */
        .btn-plan-cta {
            width: 100%;
            padding: 14px 20px;
            border-radius: 14px;
            border: none;
            background: var(--ink);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .2s ease;
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        }
        [data-theme="dark"] .btn-plan-cta {
            background: #ffffff;
            color: #0f172a;
        }
        .btn-plan-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.16);
        }
        .plan-card.popular .btn-plan-cta {
            background: var(--accent);
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(200, 109, 99, 0.4);
        }
        .plan-card.popular .btn-plan-cta:hover {
            background: var(--accent-hover);
        }

        /* PERKS / COMPARISON SECTION */
        .perks-section {
            background: var(--card);
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            padding: 60px 20px;
        }
        .perks-shell {
            max-width: 1100px;
            margin: 0 auto;
        }
        .perks-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 40px;
        }
        .perks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 28px;
        }
        .perk-card {
            padding: 24px;
            border-radius: 18px;
            border: 1px solid var(--line);
            background: var(--bg);
        }
        .perk-icon {
            font-size: 32px;
            margin-bottom: 14px;
            display: block;
        }
        .perk-card h4 {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--ink);
        }
        .perk-card p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.5;
        }

        /* MODAL STYLES FOR RENT */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .modal-backdrop.open {
            display: flex;
        }
        .rent-modal-card {
            background: var(--card);
            border: 1.5px solid var(--card-border);
            border-radius: 24px;
            width: min(540px, 100%);
            max-height: 90vh;
            overflow-y: auto;
            padding: 32px 28px;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        .modal-close-x {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: transparent;
            color: var(--muted);
            font-size: 16px;
            cursor: pointer;
            display: grid;
            place-items: center;
        }
        .rent-modal-header {
            margin-bottom: 20px;
        }
        .rent-modal-pill {
            font-size: 11px;
            font-weight: 800;
            color: var(--accent);
            text-transform: uppercase;
        }
        .rent-modal-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--ink);
            margin: 4px 0 6px;
        }
        .rent-modal-subtitle {
            font-size: 13px;
            color: var(--muted);
        }
        .rent-summary-box {
            background: rgba(200, 109, 99, 0.08);
            border: 1.5px solid rgba(200, 109, 99, 0.25);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 20px;
        }
        .rent-select, .auth-field input, .auth-field select {
            width: 100%;
            padding: 11px 14px;
            border-radius: 12px;
            border: 1.5px solid var(--line);
            background: var(--bg);
            color: var(--ink);
            font-size: 13.5px;
            font-family: inherit;
            outline: none;
            transition: border-color .2s ease;
        }
        .rent-select:focus, .auth-field input:focus {
            border-color: var(--accent);
        }
        .auth-field {
            margin-bottom: 16px;
        }
        .auth-field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--ink);
        }
        .subdomain-input-wrap {
            display: flex;
            align-items: center;
            background: var(--bg);
            border: 1.5px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
        }
        .subdomain-input-wrap input {
            border: none;
            background: transparent;
            padding: 11px 14px;
            flex: 1;
        }
        .subdomain-suffix {
            padding: 11px 14px;
            background: rgba(30, 41, 59, 0.05);
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            border-left: 1px solid var(--line);
        }
        .subdomain-preview-text {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 5px;
        }
        .btn-submit-rent {
            width: 100%;
            padding: 14px;
            border-radius: 14px;
            border: none;
            background: var(--accent);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 800;
            cursor: pointer;
            margin-top: 8px;
            box-shadow: 0 4px 14px rgba(200, 109, 99, 0.4);
            transition: background .2s ease;
        }
        .btn-submit-rent:hover {
            background: var(--accent-hover);
        }

        /* FLOATING PWA RETURN HOME BUTTON */
        .pwa-floating-home-pill {
            position: fixed;
            bottom: max(16px, env(safe-area-inset-bottom));
            left: 16px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 18px;
            border-radius: 999px;
            background: rgba(32, 33, 30, 0.9);
            color: #ffffff;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            font-size: 13.5px;
            font-weight: 800;
            box-shadow: 0 10px 28px rgba(0,0,0,0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 9980;
            text-decoration: none;
            cursor: pointer;
            transition: transform .2s ease;
        }
        [data-theme="dark"] .pwa-floating-home-pill {
            background: rgba(255, 255, 255, 0.94);
            color: #111210;
            border-color: rgba(255, 255, 255, 0.4);
        }
        .pwa-floating-home-pill:active {
            transform: scale(0.96);
        }

        /* FOOTER */
        .plans-footer {
            margin-top: auto;
            background: var(--card);
            border-top: 1px solid var(--line);
            padding: 32px 20px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }
        .plans-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <!-- TOP HEADER -->
    <header class="plans-header">
        <div class="header-shell">
            <div class="header-left">
                <a href="{{ url('/') }}" class="btn-return-home" id="btnReturnHomeHeader" title="Volver al Portal Central">
                    <span>‹</span> <span>Inicio Zacatecas</span>
                </a>
                <a href="{{ url('/') }}" class="header-brand">
                    <div class="brand-icon">
                        <img src="/app-icons/icon.svg" alt="Atelier Zacatecas" onerror="this.style.display='none';">
                        <span>🏛️</span>
                    </div>
                    <div class="header-title-box">
                        <strong>Atelier Zacatecas</strong>
                        <small>Planes de Renta SaaS</small>
                    </div>
                </a>
            </div>

            <div class="header-actions">
                <a href="{{ url('/admin') }}" target="_blank" class="btn-superadmin-header" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 999px; background: rgba(99, 102, 241, 0.12); color: #6366f1; border: 1px solid rgba(99, 102, 241, 0.25); text-decoration: none; font-size: 13px; font-weight: 700; transition: all .2s ease;">
                    <span>⚙️</span> <span>Super Admin</span>
                </a>
                <button type="button" class="btn-theme-toggle" onclick="toggleTheme()" aria-label="Cambiar tema">
                    <span class="theme-icon-light">🌙</span>
                    <span class="theme-icon-dark" style="display: none;">☀️</span>
                </button>
            </div>
        </div>
    </header>

    @if(session('success_store_created'))
        @php $newStore = session('success_store_created'); @endphp
        <div style="max-width: 800px; margin: 24px auto 0; padding: 20px; background: #dcfce7; border: 1.5px solid #86efac; border-radius: 16px; color: #166534; text-align: center;">
            <div style="font-size: 20px; font-weight: 800; margin-bottom: 6px;">🎉 ¡Felicitaciones! Tu tienda "{{ $newStore['name'] }}" ha sido dada de alta.</div>
            <p style="font-size: 14px; margin-bottom: 14px;">Plan: <strong>{{ $newStore['plan_name'] }}</strong> ({{ $newStore['billing_cycle'] }}). Ya puedes comenzar a subir productos.</p>
            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ $newStore['store_url'] }}" target="_blank" style="padding: 10px 18px; border-radius: 10px; background: #166534; color: #fff; font-weight: 800; text-decoration: none; font-size: 13px;">Visitar Tienda Pública ↗</a>
                <a href="{{ $newStore['admin_url'] }}" target="_blank" style="padding: 10px 18px; border-radius: 10px; background: #fff; color: #166534; border: 1.5px solid #166534; font-weight: 800; text-decoration: none; font-size: 13px;">Acceder al Panel Admin ⚙</a>
            </div>
        </div>
    @endif

    <!-- HERO SECTION -->
    <main>
        <section class="plans-hero">
            <span class="hero-pill">✦ Renta tu Tienda Virtual</span>
            <h1 class="hero-title">Planes de Renta para Empresas</h1>
            <p class="hero-desc">
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
                <div class="annual-savings-pill" id="annualSavingsBadge">
                    <span>🎉 Ahorra 20% anual (2 meses gratis de renta)</span>
                </div>
            </div>
        </section>

        <!-- PLANS CARDS GRID -->
        <div class="plans-shell">
            <div class="plans-grid">
                @foreach($subscriptionPlans as $plan)
                    <div class="plan-card {{ $plan->is_popular ? 'popular' : '' }}" id="card-plan-{{ $plan->slug }}">
                        @if($plan->badge)
                            <div class="popular-badge">{{ $plan->badge }}</div>
                        @endif

                        <div>
                            <div class="plan-header">
                                <h2 class="plan-name">{{ $plan->name }}</h2>
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

                            <!-- Highlight Meta -->
                            <div class="plan-highlights">
                                <div class="highlight-item">
                                    <span>📦</span>
                                    <span>{{ $plan->product_limit ? "Hasta {$plan->product_limit} productos activos" : 'Productos y categorías ILIMITADOS' }}</span>
                                </div>
                                <div class="highlight-item">
                                    <span>🌐</span>
                                    <span>{{ $plan->has_custom_domain ? 'Subdominio + Dominio propio' : 'Subdominio exclusivo incluido' }}</span>
                                </div>
                                <div class="highlight-item">
                                    <span>🏷️</span>
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

                        <div>
                            <button type="button" 
                                    class="btn-plan-cta"
                                    onclick="openRentModal('{{ $plan->slug }}', currentBillingCycle)">
                                Rentar {{ $plan->name }} <span>→</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- PERKS SECTION -->
        <section class="perks-section">
            <div class="perks-shell">
                <div class="perks-header">
                    <span class="hero-pill">✦ Ventajas Exclusivas</span>
                    <h2 style="font-size: 28px; font-weight: 800; color: var(--ink); margin-bottom: 10px;">¿Por qué abrir tu tienda con Atelier Zacatecas?</h2>
                    <p style="color: var(--muted); font-size: 15px;">Infraestructura cloud moderna diseñada para empresas que buscan autonomía, rendimiento y control total de sus ingresos.</p>
                </div>

                <div class="perks-grid">
                    <div class="perk-card">
                        <span class="perk-icon">⚡</span>
                        <h4>0% Comisiones por Venta</h4>
                        <p>No cobramos comisiones porcentuales sobre tus ventas. Todo el dinero de tus compras va directamente a tus cuentas bancarias o pagos en efectivo.</p>
                    </div>
                    <div class="perk-card">
                        <span class="perk-icon">🛡️</span>
                        <h4>Base de Datos SQLite Privada</h4>
                        <p>Cada tienda opera en su propia base de datos aislada con modo WAL de altísima velocidad, garantizando privacidad total y cero interferencias entre comercios.</p>
                    </div>
                    <div class="perk-card">
                        <span class="perk-icon">📲</span>
                        <h4>Pedidos Directos por WhatsApp</h4>
                        <p>Tus clientes pueden generar pedidos con un solo clic con el resumen completo del carrito y sucursal de recogida en Zacatecas Centro.</p>
                    </div>
                    <div class="perk-card">
                        <span class="perk-icon">🗺️</span>
                        <h4>Presencia en el Mapa Interactivo</h4>
                        <p>Tu comercio aparecerá en el mapa oficial con geolocalización GPS y cálculo de distancia a pie para que los visitantes lleguen fácilmente a tu local físico.</p>
                    </div>
                    <div class="perk-card">
                        <span class="perk-icon">⚙️</span>
                        <h4>Panel Filament v3 Completo</h4>
                        <p>Panel privado para gestionar productos, fotos, categorías, pedidos, cupones de descuento y personalización de colores de tu marca.</p>
                    </div>
                    <div class="perk-card">
                        <span class="perk-icon">📱</span>
                        <h4>PWA Instalable en Teléfonos</h4>
                        <p>Tus clientes pueden agregar tu tienda directamente a la pantalla de inicio de su teléfono como una app nativa ultrarrápida.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- MODAL: RENTA TU TIENDA ONLINE -->
    <div class="modal-backdrop" id="rentModal">
        <div class="rent-modal-card">
            <button type="button" class="modal-close-x" onclick="closeRentModal()" aria-label="Cerrar modal">✕</button>

            <div class="rent-modal-header">
                <span class="rent-modal-pill">✦ Alta Rápida de Empresa</span>
                <h3 class="rent-modal-title">Renta tu Tienda Virtual</h3>
                <p class="rent-modal-subtitle">Tu catálogo e infraestructura multi-tenant quedarán configurados en segundos.</p>
            </div>

            <form action="{{ route('central.rent.tenant') }}" method="POST" id="rentForm">
                @csrf

                <!-- Plan & Billing Selector in Modal -->
                <div class="rent-summary-box">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <strong id="modalPlanLabel" style="font-size: 15px; color: var(--ink);">Plan Crecimiento</strong>
                        <span id="modalCycleLabel" class="annual-savings-pill">💎 Anual (-20% Ahorro)</span>
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
                    <select name="business_category" id="rentCategory" class="rent-select">
                        <option value="Moda y Lujo">👗 Moda, Lujo & Accesorios</option>
                        <option value="Tecnología y Gadgets">💻 Tecnología, Audio & Dispositivos</option>
                        <option value="Bebidas y Alimentos">🥤 Bebidas, Refrescos & Gourmet</option>
                        <option value="Hogar y Decoración">🏺 Hogar, Mobiliario & Diseño</option>
                        <option value="Salud y Belleza">🌿 Belleza, Cuidado & Fragancias</option>
                        <option value="Comercio General" selected>🏬 Tienda Departamental / General</option>
                    </select>
                </div>

                <div class="auth-field">
                    <label for="rentOwnerName">Nombre del Administrador / Dueño *</label>
                    <input type="text" name="owner_name" id="rentOwnerName" placeholder="Tu nombre completo" required>
                </div>

                <div class="auth-field">
                    <label for="rentOwnerEmail">Correo Electrónico Oficial *</label>
                    <input type="email" name="owner_email" id="rentOwnerEmail" placeholder="contacto@tuempresa.com" required>
                </div>

                <div class="auth-field">
                    <label for="rentOwnerPassword">Contraseña del Panel de Control *</label>
                    <input type="password" name="owner_password" id="rentOwnerPassword" placeholder="Crea una contraseña segura (mín. 6 carácteres)" required minlength="6">
                </div>

                <button type="submit" class="btn-submit-rent" id="btnRentSubmit">
                    🚀 Activar Mi Tienda Ahora
                </button>
            </form>
        </div>
    </div>

    <!-- FLOATING RETURN HOME BUTTON (MOBILE & STANDALONE PWA) -->
    <a href="{{ url('/') }}" class="pwa-floating-home-pill" id="pwaFloatingHomePill" title="Volver al Inicio de Zacatecas">
        <span>🏠</span>
        <span>Inicio Zacatecas</span>
    </a>

    <!-- FOOTER -->
    <footer class="plans-footer">
        <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 12px; font-weight: 700; font-size: 13.5px;">
            <a href="{{ url('/') }}" style="color: var(--accent);">← Volver al Directorio de Zacatecas</a>
            <span style="color: var(--line);">|</span>
            <a href="{{ url('/admin') }}" target="_blank" style="color: var(--ink);">⚙️ Panel Super Admin</a>
            <span style="color: var(--line);">|</span>
            <a href="{{ url('/admin/tenants') }}" target="_blank" style="color: var(--ink);">🏢 Gestión de Empresas</a>
        </div>
        <p>&copy; {{ date('Y') }} Atelier Zacatecas · Plataforma SaaS Multi-Empresa. Todos los derechos reservados.</p>
    </footer>

    <script>
        let currentBillingCycle = 'annual';

        function switchBillingCycle(cycle) {
            currentBillingCycle = cycle;
            const btnMonthly = document.getElementById('btnMonthly');
            const btnAnnual = document.getElementById('btnAnnual');
            const monthlyBoxes = document.querySelectorAll('.price-monthly-box');
            const annualBoxes = document.querySelectorAll('.price-annual-box');
            const annualBadge = document.getElementById('annualSavingsBadge');

            if (cycle === 'annual') {
                if (btnAnnual) btnAnnual.classList.add('active');
                if (btnMonthly) btnMonthly.classList.remove('active');
                monthlyBoxes.forEach(el => el.style.display = 'none');
                annualBoxes.forEach(el => el.style.display = 'block');
                if (annualBadge) annualBadge.style.display = 'inline-flex';
            } else {
                if (btnMonthly) btnMonthly.classList.add('active');
                if (btnAnnual) btnAnnual.classList.remove('active');
                monthlyBoxes.forEach(el => el.style.display = 'block');
                annualBoxes.forEach(el => el.style.display = 'none');
                if (annualBadge) annualBadge.style.display = 'none';
            }

            const cycleSelect = document.getElementById('modalCycleSelect');
            if (cycleSelect) {
                cycleSelect.value = cycle;
                updateModalSummary();
            }
        }

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
            document.body.style.overflow = 'hidden';

            if (window.history && window.history.pushState) {
                window.history.pushState({ pwaModal: 'rent' }, '');
            }
        }

        function closeRentModal() {
            const modal = document.getElementById('rentModal');
            if (modal) modal.classList.remove('open');
            document.body.style.overflow = '';
        }

        function updateModalSummary() {
            const planSelect = document.getElementById('modalPlanSelect');
            const cycleSelect = document.getElementById('modalCycleSelect');
            if (!planSelect || !cycleSelect) return;

            const selectedOpt = planSelect.options[planSelect.selectedIndex];
            const planName = selectedOpt.getAttribute('data-name') || 'Plan Crecimiento';
            const monthlyPrice = selectedOpt.getAttribute('data-monthly') || '39';
            const annualPrice = selectedOpt.getAttribute('data-annual') || '31';
            const annualTotal = selectedOpt.getAttribute('data-total') || '372';
            const annualSavings = selectedOpt.getAttribute('data-savings') || '96';

            const planLabel = document.getElementById('modalPlanLabel');
            const cycleLabel = document.getElementById('modalCycleLabel');
            const priceSummary = document.getElementById('modalPriceSummary');

            if (planLabel) planLabel.textContent = planName;

            if (cycleSelect.value === 'annual') {
                if (cycleLabel) cycleLabel.textContent = '💎 Anual (-20% Ahorro)';
                if (priceSummary) priceSummary.textContent = `Total a pagar: $${annualTotal} USD / año ($${annualPrice} USD/mes) · ¡Ahorras $${annualSavings} USD!`;
            } else {
                if (cycleLabel) cycleLabel.textContent = '📅 Mensual';
                if (priceSummary) priceSummary.textContent = `Total a pagar: $${monthlyPrice} USD / mes · Facturación mes a mes sin plazos forzosos.`;
            }
        }

        function autoGenerateSubdomain(name) {
            const subdomainInput = document.getElementById('rentSubdomain');
            if (!subdomainInput) return;

            const clean = name.toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '')
                .substring(0, 25);

            subdomainInput.value = clean;
            updateSubdomainPreview(clean);
        }

        function updateSubdomainPreview(val) {
            const preview = document.getElementById('subdomainLivePreview');
            if (!preview) return;

            const clean = val.toLowerCase().replace(/[^a-z0-9-]/g, '');
            const host = window.location.hostname;
            const port = window.location.port ? ':' + window.location.port : '';
            preview.innerHTML = `🌐 Tu tienda estará en: <strong>http://${clean || 'mi-tienda'}.${host}${port}</strong>`;
        }

        // Theme toggle
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
        }

        // PWA History Guard
        (function initPlansHistoryGuard() {
            if (!window.history || !window.history.pushState) return;

            window.history.pushState({ pwaPlansViewing: true }, '');

            window.addEventListener('popstate', function(e) {
                const rentModal = document.getElementById('rentModal');
                if (rentModal && rentModal.classList.contains('open')) {
                    closeRentModal();
                    window.history.pushState({ pwaPlansViewing: true }, '');
                    return;
                }

                // If user hits back from plans root, return to central home
                window.location.href = "{{ url('/') }}";
            });
        })();

        document.addEventListener('DOMContentLoaded', () => {
            const activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
            updateThemeIcons(activeTheme);
            switchBillingCycle('annual');
            const suffix = document.querySelector('.subdomain-suffix');
            if (suffix) {
                suffix.textContent = '.' + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
            }
        });
    </script>
</body>
</html>
