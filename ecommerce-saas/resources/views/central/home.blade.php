<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#171815">
    <title>Atelier Commerce — comercio que crece contigo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#20211e; --paper:#f4efe7; --cream:#fffaf3; --muted:#aaa99f; --orange:#e2704e; --line:rgba(255,255,255,.16); }
        * { box-sizing:border-box; } body { margin:0; color:var(--cream); background:var(--ink); font-family:'DM Sans',sans-serif; -webkit-font-smoothing:antialiased; }
        a { color:inherit; text-decoration:none; } .shell { width:min(1160px,calc(100% - 48px)); margin:auto; }
        .nav { display:flex; align-items:center; justify-content:space-between; min-height:84px; border-bottom:1px solid var(--line); }
        .brand { display:flex; align-items:center; gap:12px; font-size:16px; font-weight:700; letter-spacing:-.04em; }.mark { display:grid; width:34px; height:34px; place-items:center; color:var(--ink); background:var(--orange); border-radius:50%; font-family:'Playfair Display',serif; font-size:19px; }
        .nav-links { display:flex; gap:30px; color:var(--muted); font-size:12px; }.nav-links a:hover { color:#fff; }.nav-button { padding:12px 19px; border:1px solid var(--line); border-radius:999px; font-size:12px; transition:background .2s ease; }.nav-button:hover { background:#fff; color:var(--ink); }
        .hero { display:grid; grid-template-columns:1.03fr .97fr; gap:70px; align-items:center; min-height:650px; padding:72px 0 100px; }.eyebrow { display:flex; align-items:center; gap:10px; color:#f19b7e; font-size:10px; font-weight:700; letter-spacing:.18em; text-transform:uppercase; }.eyebrow:before { width:27px; height:1px; background:currentColor; content:''; }.hero h1 { max-width:650px; margin:20px 0 26px; font-family:'Playfair Display',serif; font-size:clamp(48px,6.3vw,82px); font-weight:600; letter-spacing:-.07em; line-height:.96; }.hero h1 em { color:var(--orange); font-style:normal; }.hero-copy { max-width:460px; color:var(--muted); font-size:16px; line-height:1.75; }.actions { display:flex; gap:14px; align-items:center; margin-top:34px; }.button { display:inline-flex; align-items:center; gap:12px; padding:15px 21px; border-radius:999px; font-size:12px; font-weight:700; }.button-primary { color:var(--ink); background:var(--cream); }.button-secondary { color:var(--cream); border:1px solid var(--line); }.button span { font-size:17px; }.visual { position:relative; height:470px; }.visual-image { width:84%; height:100%; margin-left:auto; overflow:hidden; border-radius:160px 9px 9px 9px; background:#544e45; }.visual-image img { width:100%; height:100%; object-fit:cover; opacity:.86; }.badge { position:absolute; left:0; bottom:38px; display:grid; width:115px; height:115px; place-items:center; padding:18px; color:var(--ink); background:var(--orange); border-radius:50%; font-size:10px; font-weight:700; line-height:1.4; text-align:center; text-transform:uppercase; transform:rotate(-12deg); }.mini-card { position:absolute; right:-16px; top:32px; padding:18px; color:var(--ink); background:var(--cream); border-radius:10px; box-shadow:0 18px 38px rgba(0,0,0,.2); }.mini-card strong { display:block; font-family:'Playfair Display',serif; font-size:23px; }.mini-card small { color:#77756d; font-size:10px; }
        .strip { padding:18px 0; color:var(--ink); background:var(--orange); font-size:10px; font-weight:700; letter-spacing:.15em; text-align:center; text-transform:uppercase; }.section { padding:95px 0; color:var(--ink); background:var(--paper); }.section-head { display:flex; align-items:end; justify-content:space-between; margin-bottom:32px; }.section h2 { margin:13px 0 0; font-family:'Playfair Display',serif; font-size:clamp(34px,4vw,52px); letter-spacing:-.06em; line-height:1; }.section-head p { max-width:270px; margin:0; color:#77756d; font-size:12px; line-height:1.65; }.features { display:grid; grid-template-columns:repeat(3,1fr); gap:1px; background:rgba(32,33,30,.12); border:1px solid rgba(32,33,30,.12); }.feature { min-height:210px; padding:28px; background:var(--paper); }.feature-number { color:var(--orange); font-family:'Playfair Display',serif; font-size:24px; }.feature h3 { margin:21px 0 9px; font-family:'Playfair Display',serif; font-size:22px; }.feature p { max-width:220px; margin:0; color:#77756d; font-size:12px; line-height:1.6; }
        footer { padding:32px 0; color:var(--muted); background:var(--ink); font-size:11px; }.footer-inner { display:flex; justify-content:space-between; gap:15px; }
        @media(max-width:760px) { .shell{width:calc(100% - 32px)} .nav-links{display:none}.hero{grid-template-columns:1fr;gap:48px;padding:60px 0 75px}.visual{height:380px}.visual-image{width:88%;}.mini-card{right:0}.section{padding:70px 0}.section-head{display:block}.section-head p{margin-top:20px}.features{grid-template-columns:1fr}.feature{min-height:auto}.footer-inner{display:block;line-height:2} }
    </style>
</head>
<body>
    <header class="shell nav">
        <a class="brand" href="{{ url('/') }}"><span class="mark">A</span><span>Atelier Commerce</span></a>
        <nav class="nav-links"><a href="#solucion">La plataforma</a><a href="#principios">Principios</a><a href="mailto:hola@ateliercommerce.test">Contacto</a></nav>
        <a class="nav-button" href="{{ url('/admin/login') }}">Acceder al panel ↗</a>
    </header>
    <main>
        <section class="shell hero">
            <div><div class="eyebrow">La nueva forma de vender online</div><h1>Tu tienda.<br><em>Tu mundo.</em></h1><p class="hero-copy">Una plataforma elegante para empresas que quieren vender mejor, crecer sin límites y crear una experiencia que sus clientes recuerden.</p><div class="actions"><a class="button button-primary" href="{{ url('/admin/login') }}">Entrar al panel <span>↗</span></a><a class="button button-secondary" href="#solucion">Descubrir más <span>↓</span></a></div></div>
            <div class="visual"><div class="mini-card"><strong>∞</strong><small>crecimiento<br>sin fronteras</small></div><div class="visual-image"><img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1000&q=85" alt="Experiencia de compra online"></div><div class="badge">Una plataforma<br>para hacer<br>las cosas bien ✦</div></div>
        </section>
        <div class="strip">Multi-empresa · Multi-dispositivo · Una experiencia extraordinaria</div>
        <section class="section" id="solucion"><div class="shell"><div class="section-head"><div><div class="eyebrow">Todo en un solo lugar</div><h2>Hecha para tu<br>próximo capítulo.</h2></div><p>Desde el primer producto hasta el pedido número mil, las herramientas que necesitas están aquí.</p></div><div class="features" id="principios"><article class="feature"><span class="feature-number">01</span><h3>Tu marca, primero</h3><p>Personaliza cada detalle de tu tienda y conviértela en una extensión auténtica de tu negocio.</p></article><article class="feature"><span class="feature-number">02</span><h3>Datos bajo control</h3><p>Una base de datos aislada para cada empresa. Privacidad y seguridad desde el diseño.</p></article><article class="feature"><span class="feature-number">03</span><h3>Crece con libertad</h3><p>Panel web, APIs y futuras apps móviles conectadas a la misma experiencia.</p></article></div></div></section>
    </main>
    <footer><div class="shell footer-inner"><span>© {{ date('Y') }} Atelier Commerce</span><span>Diseñado para negocios con intención.</span></div></footer>
</body>
</html>
