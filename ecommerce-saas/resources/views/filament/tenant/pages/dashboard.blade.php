@php
    $tenantId = (string) tenant('id');
    $settings = \App\Models\StoreSetting::first();
    $tenantName = $settings?->store_name ?? str($tenantId)->replace(['-', '_'], ' ')->title()->toString();
    $productCount = \App\Models\Product::count();
    $orderCount = \App\Models\Order::count();
    $customerCount = \App\Models\TenantUser::count();
    $revenue = \App\Models\Order::sum('total_amount');
    $categoryCount = \App\Models\Category::count();
@endphp

<x-filament-panels::page>
    <div class="atelier-dashboard">
        <!-- Hero Section -->
        <section class="atelier-dashboard__hero">
            <div class="atelier-dashboard__hero-copy">
                <div class="atelier-dashboard__eyebrow">Panel de control · {{ now()->format('d M Y') }}</div>
                <h1>Buenos días,<br><em>{{ $tenantName }}</em>.</h1>
                <p>Todo lo que necesitas para llevar tu tienda a la siguiente etapa, en un vistazo.</p>
                <div class="atelier-dashboard__actions">
                    <a href="{{ url('/') }}" target="_blank" class="atelier-dashboard__button atelier-dashboard__button--light">
                        Ver mi tienda pública <span>↗</span>
                    </a>
                    <a href="{{ url('/tenant-admin/products/create') }}" class="atelier-dashboard__button atelier-dashboard__button--ghost">
                        <span>＋</span> Añadir producto
                    </a>
                    <a href="{{ url('/tenant-admin/orders') }}" class="atelier-dashboard__button atelier-dashboard__button--ghost">
                        Ver pedidos <span>→</span>
                    </a>
                </div>
            </div>
            <div class="atelier-dashboard__orb">
                <span>✦</span>
                <small>tu tienda<br>en movimiento</small>
            </div>
        </section>

        <!-- Stats Grid (Clickable) -->
        <section class="atelier-dashboard__stats" aria-label="Resumen de la tienda">
            <a href="{{ url('/tenant-admin/orders') }}" class="atelier-dashboard__stat" title="Ver lista de pedidos">
                <div class="atelier-dashboard__stat-icon">◈</div>
                <div>
                    <span>Ventas totales</span>
                    <strong>${{ number_format((float) $revenue, 2) }}</strong>
                    <small>Ingresos acumulados ↗</small>
                </div>
            </a>
            
            <a href="{{ url('/tenant-admin/orders') }}" class="atelier-dashboard__stat" title="Gestionar pedidos">
                <div class="atelier-dashboard__stat-icon">◌</div>
                <div>
                    <span>Pedidos</span>
                    <strong>{{ number_format($orderCount) }}</strong>
                    <small>Pedidos recibidos ↗</small>
                </div>
            </a>
            
            <a href="{{ url('/tenant-admin/products') }}" class="atelier-dashboard__stat" title="Ver catálogo de productos">
                <div class="atelier-dashboard__stat-icon">◇</div>
                <div>
                    <span>Productos</span>
                    <strong>{{ number_format($productCount) }}</strong>
                    <small>En tu catálogo ↗</small>
                </div>
            </a>
            
            <a href="{{ url('/tenant-admin/customers') }}" class="atelier-dashboard__stat" title="Ver clientes">
                <div class="atelier-dashboard__stat-icon">✧</div>
                <div>
                    <span>Clientes</span>
                    <strong>{{ number_format($customerCount) }}</strong>
                    <small>Comunidad y compradores ↗</small>
                </div>
            </a>
        </section>

        <!-- Quick Access Section -->
        <section class="atelier-dashboard__grid" id="actividad">
            <div class="atelier-dashboard__panel atelier-dashboard__panel--activity">
                <div class="atelier-dashboard__panel-head">
                    <div>
                        <span class="atelier-dashboard__eyebrow">Tu espacio</span>
                        <h2>Accesos rápidos</h2>
                    </div>
                    <span class="atelier-dashboard__panel-mark">01</span>
                </div>
                
                <div class="atelier-dashboard__quick-grid">
                    <a href="{{ url('/tenant-admin/products/create') }}" class="atelier-dashboard__quick">
                        <span class="atelier-dashboard__quick-symbol">＋</span>
                        <strong>Nuevo producto</strong>
                        <small>Añade una pieza al catálogo</small>
                        <span class="atelier-dashboard__arrow">→</span>
                    </a>

                    <a href="{{ url('/tenant-admin/orders') }}" class="atelier-dashboard__quick">
                        <span class="atelier-dashboard__quick-symbol">▱</span>
                        <strong>Ver pedidos</strong>
                        <small>Revisa ventas y prepara envíos</small>
                        <span class="atelier-dashboard__arrow">→</span>
                    </a>

                    <a href="{{ url('/tenant-admin/categories') }}" class="atelier-dashboard__quick">
                        <span class="atelier-dashboard__quick-symbol">🏷</span>
                        <strong>Categorías</strong>
                        <small>{{ $categoryCount }} categorías organizadas</small>
                        <span class="atelier-dashboard__arrow">→</span>
                    </a>

                    <a href="{{ url('/tenant-admin/customers') }}" class="atelier-dashboard__quick">
                        <span class="atelier-dashboard__quick-symbol">👥</span>
                        <strong>Clientes</strong>
                        <small>Usuarios y cuentas móviles</small>
                        <span class="atelier-dashboard__arrow">→</span>
                    </a>

                    <a href="{{ url('/tenant-admin/store-settings') }}" class="atelier-dashboard__quick">
                        <span class="atelier-dashboard__quick-symbol">🎨</span>
                        <strong>Diseño y Colores</strong>
                        <small>Personaliza paleta, fuentes, portada y redes</small>
                        <span class="atelier-dashboard__arrow">→</span>
                    </a>

                    <a href="{{ url('/') }}" target="_blank" class="atelier-dashboard__quick">
                        <span class="atelier-dashboard__quick-symbol">◌</span>
                        <strong>Ver escaparate</strong>
                        <small>Así te ven tus clientes en vivo</small>
                        <span class="atelier-dashboard__arrow">↗</span>
                    </a>
                </div>
            </div>

            <!-- Advice Card -->
            <aside class="atelier-dashboard__panel atelier-dashboard__panel--note">
                <div class="atelier-dashboard__note-shape">🎨</div>
                <span class="atelier-dashboard__eyebrow">Personalización Visual</span>
                <h2>Tu tienda, con tu propio estilo.</h2>
                <p>Modifica la paleta de colores, tipografías, el banner de portada y el botón de WhatsApp en tiempo real. Los cambios se reflejan inmediatamente en tu escaparate.</p>
                <a href="{{ url('/tenant-admin/store-settings') }}">Personalizar diseño <span>→</span></a>
            </aside>
        </section>

        <div class="atelier-dashboard__footer-note">
            <span>Atelier Commerce SaaS</span>
            <span>Tienda: {{ $tenantName }} ({{ $tenantId }}.localhost)</span>
            <span>✦</span>
        </div>
    </div>

    <style>
        @php
            $brandPrimary = $settings?->primary_color ?? '#d96b45';
        @endphp
        .atelier-dashboard { 
            --ink:#20211e; 
            --muted:#77756d; 
            --paper:#f4efe7; 
            --card:#fffdf9; 
            --orange: var(--tenant-brand-primary, {{ $brandPrimary }}); 
            --rose: var(--tenant-brand-primary, {{ $brandPrimary }}); 
            color:var(--ink); 
        }
        .atelier-dashboard__hero { position:relative; display:flex; min-height:285px; align-items:center; justify-content:space-between; overflow:hidden; padding:42px 52px; color:#fffaf3; background:var(--ink); border-radius:18px; border-left: 5px solid var(--orange); }
        .atelier-dashboard__hero:after { position:absolute; right:105px; bottom:-220px; width:420px; height:420px; border:1px solid rgba(226,112,78,.38); border-radius:50%; box-shadow:0 0 0 35px rgba(226,112,78,.08),0 0 0 70px rgba(226,112,78,.04); content:''; }
        .atelier-dashboard__hero-copy { position:relative; z-index:1; }
        .atelier-dashboard__eyebrow { color:var(--orange); font-size:10px; font-weight:700; letter-spacing:.15em; text-transform:uppercase; }
        .atelier-dashboard h1 { margin:14px 0 15px; color:#fffaf3; font-family:Georgia,serif; font-size:clamp(34px,4vw,54px); font-weight:500; letter-spacing:-.07em; line-height:.98; }
        .atelier-dashboard h1 em { color:var(--orange); font-style:normal; }
        .atelier-dashboard__hero p { max-width:410px; margin:0; color:rgba(255,250,243,.62); font-size:13px; line-height:1.6; }
        .atelier-dashboard__actions { display:flex; flex-wrap:wrap; gap:10px; margin-top:25px; }
        .atelier-dashboard__button { display:inline-flex; align-items:center; gap:10px; padding:11px 17px; border-radius:999px; font-size:11px; font-weight:700; text-decoration:none; transition:transform .2s ease, box-shadow .2s ease; }
        .atelier-dashboard__button:hover { transform:translateY(-2px); box-shadow:0 6px 15px rgba(0,0,0,.15); }
        .atelier-dashboard__button--light { color:var(--ink); background:#fffaf3; }
        .atelier-dashboard__button--ghost { color:#fffaf3; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.05); }
        .atelier-dashboard__button--ghost:hover { background:rgba(255,255,255,.15); }
        .atelier-dashboard__orb { position:relative; z-index:1; display:grid; width:125px; height:125px; place-items:center; align-content:center; margin-right:55px; color:var(--ink); background:var(--orange); border-radius:50%; transform:rotate(10deg); flex-shrink:0; }
        .atelier-dashboard__orb span { font-size:26px; }
        .atelier-dashboard__orb small { margin-top:8px; font-size:9px; font-weight:700; line-height:1.3; text-align:center; text-transform:uppercase; }

        .atelier-dashboard__stats { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-top:15px; }
        .atelier-dashboard__stat { display:flex; gap:13px; align-items:flex-start; padding:20px 17px; background:var(--card); border:1px solid rgba(32,33,30,.09); border-radius:13px; text-decoration:none; color:inherit; transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease; cursor:pointer; }
        .atelier-dashboard__stat:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,.06); border-color:rgba(226,112,78,.4); }
        .atelier-dashboard__stat-icon { display:grid; width:32px; height:32px; flex:none; place-items:center; color:var(--orange); background:rgba(226,112,78,.1); border-radius:9px; font-size:17px; }
        .atelier-dashboard__stat span, .atelier-dashboard__stat small { display:block; color:var(--muted); font-size:10px; }
        .atelier-dashboard__stat small { margin-top:3px; color:var(--orange); font-weight:600; }
        .atelier-dashboard__stat strong { display:block; margin:5px 0 3px; font-family:Georgia,serif; font-size:22px; font-weight:500; letter-spacing:-.04em; color:var(--ink); }

        .atelier-dashboard__grid { display:grid; grid-template-columns:1.45fr .8fr; gap:15px; margin-top:15px; }
        .atelier-dashboard__panel { padding:27px; background:var(--card); border:1px solid rgba(32,33,30,.09); border-radius:13px; }
        .atelier-dashboard__panel-head { display:flex; align-items:start; justify-content:space-between; }
        .atelier-dashboard__panel h2 { margin:9px 0 23px; font-family:Georgia,serif; font-size:28px; font-weight:500; letter-spacing:-.06em; }
        .atelier-dashboard__panel-mark { color:#c7c2b9; font-family:Georgia,serif; font-size:22px; }
        
        .atelier-dashboard__quick-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:10px; }
        .atelier-dashboard__quick { position:relative; display:block; min-height:115px; padding:16px; background:var(--paper); border-radius:10px; text-decoration:none; color:inherit; transition:transform .2s ease, background .2s ease, box-shadow .2s ease; cursor:pointer; }
        .atelier-dashboard__quick:hover { background:#eee5d9; transform:translateY(-3px); box-shadow:0 8px 18px rgba(0,0,0,.05); }
        .atelier-dashboard__quick-symbol { display:block; margin-bottom:10px; color:var(--orange); font-size:20px; }
        .atelier-dashboard__quick strong { display:block; font-family:Georgia,serif; font-size:15px; font-weight:600; color:var(--ink); }
        .atelier-dashboard__quick small { display:block; margin-top:4px; color:var(--muted); font-size:11px; }
        .atelier-dashboard__arrow { position:absolute; right:14px; bottom:13px; color:var(--orange); font-weight:bold; }

        .atelier-dashboard__panel--note { position:relative; overflow:hidden; color:#fffaf3; background:var(--rose); }
        .atelier-dashboard__panel--note:after { position:absolute; right:-65px; bottom:-65px; width:190px; height:190px; border:1px solid rgba(255,255,255,.28); border-radius:50%; content:''; }
        .atelier-dashboard__panel--note .atelier-dashboard__eyebrow { color:rgba(255,250,243,.7); }
        .atelier-dashboard__panel--note h2 { position:relative; z-index:1; max-width:260px; margin-top:18px; color:#fffaf3; font-size:27px; line-height:1.1; }
        .atelier-dashboard__panel--note p { position:relative; z-index:1; color:rgba(255,250,243,.85); font-size:12px; line-height:1.7; margin-top:10px; }
        .atelier-dashboard__panel--note a { position:relative; z-index:1; display:inline-flex; align-items:center; gap:8px; margin-top:20px; color:#fffaf3; font-size:11px; font-weight:700; text-decoration:none; padding:8px 16px; background:rgba(255,255,255,.2); border-radius:999px; transition:background .2s ease; }
        .atelier-dashboard__panel--note a:hover { background:rgba(255,255,255,.35); }
        .atelier-dashboard__note-shape { position:absolute; top:22px; right:25px; color:rgba(255,255,255,.35); font-size:26px; }
        .atelier-dashboard__footer-note { display:flex; justify-content:space-between; margin-top:22px; color:#aaa59c; font-size:11px; }
        .atelier-dashboard__footer-note span:last-child { color:var(--orange); }

        @media(max-width:900px) { 
            .atelier-dashboard__hero { padding:32px; }
            .atelier-dashboard__orb { margin-right:0; }
            .atelier-dashboard__stats { grid-template-columns:repeat(2,1fr); }
            .atelier-dashboard__grid { grid-template-columns:1fr; } 
        }
        @media(max-width:600px) { 
            .atelier-dashboard__hero { min-height:340px; padding:24px; }
            .atelier-dashboard__orb { position:absolute; right:15px; bottom:20px; width:75px; height:75px; }
            .atelier-dashboard__orb span{font-size:16px}
            .atelier-dashboard__orb small{font-size:7px}
            .atelier-dashboard__stats { grid-template-columns:1fr 1fr; gap:8px; }
            .atelier-dashboard__stat { display:block; padding:15px 12px; }
            .atelier-dashboard__stat-icon{margin-bottom:8px}
            .atelier-dashboard__stat strong{font-size:18px}
            .atelier-dashboard__panel{padding:20px}
            .atelier-dashboard__quick-grid{grid-template-columns:1fr}
            .atelier-dashboard__footer-note{display:block;line-height:2}
        }
    </style>
</x-filament-panels::page>
