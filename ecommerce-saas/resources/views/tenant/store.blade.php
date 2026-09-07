<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f4efe7">
    <title>{{ $storeName }} — selección consciente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #20211e;
            --muted: #77756d;
            --paper: #f4efe7;
            --card: #fffdf9;
            --accent: #d96b45;
            --accent-dark: #a94d31;
            --sage: #c9d3bd;
            --line: rgba(32, 33, 30, .12);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            background: var(--paper);
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        .page { overflow: hidden; }
        .shell { width: min(1180px, calc(100% - 48px)); margin: 0 auto; }
        .announcement {
            padding: 11px 20px;
            color: #fffaf3;
            background: var(--ink);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .12em;
            text-align: center;
            text-transform: uppercase;
        }
        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 84px;
            border-bottom: 1px solid var(--line);
        }
        .brand { display: flex; align-items: center; gap: 12px; font-weight: 700; letter-spacing: -.04em; }
        .brand-mark {
            display: grid;
            width: 36px;
            height: 36px;
            place-items: center;
            color: #fffaf3;
            background: var(--accent);
            border-radius: 50%;
            font-family: 'Playfair Display', serif;
            font-size: 18px;
        }
        .brand-name { font-size: 17px; }
        .nav-links { display: flex; gap: 28px; color: var(--muted); font-size: 13px; }
        .nav-links a { transition: color .2s ease; }
        .nav-links a:hover { color: var(--accent-dark); }
        .nav-actions { display: flex; align-items: center; gap: 12px; }
        .icon-button {
            display: grid;
            width: 40px;
            height: 40px;
            place-items: center;
            border: 1px solid var(--line);
            border-radius: 50%;
            background: rgba(255,255,255,.28);
            cursor: pointer;
            transition: transform .2s ease, background .2s ease;
        }
        .icon-button:hover { background: var(--card); transform: translateY(-2px); }
        .hero { display: grid; grid-template-columns: 1.02fr .98fr; gap: 72px; align-items: center; padding: 84px 0 102px; }
        .eyebrow { display: flex; align-items: center; gap: 9px; color: var(--accent-dark); font-size: 11px; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; }
        .eyebrow::before { width: 28px; height: 1px; background: var(--accent); content: ''; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; font-weight: 600; }
        h1 { max-width: 620px; margin: 19px 0 22px; font-size: clamp(49px, 6.3vw, 82px); letter-spacing: -.065em; line-height: .98; }
        .hero-copy { max-width: 470px; color: var(--muted); font-size: 16px; line-height: 1.75; }
        .hero-actions { display: flex; align-items: center; gap: 18px; margin-top: 32px; }
        .button { display: inline-flex; align-items: center; gap: 12px; padding: 15px 22px; border-radius: 999px; font-size: 13px; font-weight: 700; transition: transform .2s ease, box-shadow .2s ease; }
        .button:hover { transform: translateY(-3px); box-shadow: 0 13px 25px rgba(32,33,30,.12); }
        .button-primary { color: #fffaf3; background: var(--ink); }
        .button-light { padding-right: 0; color: var(--ink); }
        .button-light span { display: grid; width: 34px; height: 34px; place-items: center; border: 1px solid var(--line); border-radius: 50%; }
        .hero-visual { position: relative; min-height: 520px; }
        .hero-image { width: 82%; height: 500px; margin-left: auto; overflow: hidden; border-radius: 46% 46% 8px 8px; background: #d9d0c1; box-shadow: 20px 25px 60px rgba(91, 67, 44, .15); }
        .hero-image img { width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform .8s ease; }
        .hero-visual:hover img { transform: scale(1.04); }
        .stamp { position: absolute; top: 37px; left: 0; display: grid; width: 115px; height: 115px; place-items: center; padding: 20px; color: #fffaf3; background: var(--accent); border-radius: 50%; font-size: 11px; font-weight: 700; letter-spacing: .08em; line-height: 1.35; text-align: center; text-transform: uppercase; transform: rotate(-12deg); }
        .floating-note { position: absolute; right: -5px; bottom: 23px; width: 180px; padding: 16px; background: rgba(255,253,249,.88); border: 1px solid rgba(255,255,255,.7); border-radius: 13px; box-shadow: 0 16px 30px rgba(32,33,30,.11); backdrop-filter: blur(14px); }
        .floating-note strong { display: block; margin-bottom: 6px; font-family: 'Playfair Display', serif; font-size: 19px; }
        .floating-note small { color: var(--muted); font-size: 11px; line-height: 1.4; }
        .ticker { padding: 19px 0; color: #fffaf3; background: var(--accent); }
        .ticker-inner { display: flex; justify-content: space-between; gap: 22px; overflow: hidden; font-size: 11px; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; white-space: nowrap; }
        .ticker span { display: flex; align-items: center; gap: 22px; }
        .ticker span::after { color: #f5b195; content: '✦'; }
        .section { padding: 96px 0; }
        .section-heading { display: flex; align-items: end; justify-content: space-between; margin-bottom: 35px; }
        .section-heading h2 { max-width: 400px; margin: 13px 0 0; font-size: clamp(34px, 4vw, 51px); letter-spacing: -.055em; line-height: 1.02; }
        .section-heading p { max-width: 245px; margin: 0; color: var(--muted); font-size: 13px; line-height: 1.6; }
        .products { display: grid; grid-template-columns: repeat(4, 1fr); gap: 17px; }
        .product-card { position: relative; }
        .product-image { position: relative; aspect-ratio: .82; overflow: hidden; border-radius: 9px; background: #ddd5c9; }
        .product-image img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
        .product-card:hover .product-image img { transform: scale(1.06); }
        .product-tag { position: absolute; top: 12px; left: 12px; padding: 6px 10px; color: var(--ink); background: #fffaf3; border-radius: 999px; font-size: 10px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
        .product-info { display: flex; justify-content: space-between; gap: 10px; padding-top: 14px; }
        .product-info h3 { margin: 0 0 5px; font-size: 18px; letter-spacing: -.025em; }
        .product-info p { margin: 0; color: var(--muted); font-size: 12px; }
        .price { font-size: 13px; font-weight: 700; }
        .story { display: grid; grid-template-columns: .9fr 1.1fr; gap: 80px; align-items: center; padding: 10px 0 105px; }
        .story-image { height: 430px; overflow: hidden; border-radius: 10px 120px 10px 10px; }
        .story-image img { width: 100%; height: 100%; object-fit: cover; }
        .story-copy h2 { max-width: 470px; margin: 15px 0 20px; font-size: clamp(36px, 4.5vw, 58px); letter-spacing: -.06em; line-height: 1; }
        .story-copy p { max-width: 420px; color: var(--muted); font-size: 15px; line-height: 1.8; }
        .benefits { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--line); border: 1px solid var(--line); }
        .benefit { padding: 32px 28px; background: var(--paper); }
        .benefit-number { color: var(--accent); font-family: 'Playfair Display', serif; font-size: 24px; }
        .benefit h3 { margin: 13px 0 8px; font-size: 21px; }
        .benefit p { margin: 0; color: var(--muted); font-size: 12px; line-height: 1.6; }
        footer { padding: 32px 0; border-top: 1px solid var(--line); color: var(--muted); font-size: 12px; }
        .footer-inner { display: flex; justify-content: space-between; gap: 18px; }
        @media (max-width: 800px) {
            .shell { width: min(100% - 32px, 600px); }
            .nav-links { display: none; }
            .hero { grid-template-columns: 1fr; gap: 38px; padding: 58px 0 70px; }
            .hero-visual { min-height: 400px; }
            .hero-image { height: 390px; }
            .stamp { left: -8px; top: 18px; width: 92px; height: 92px; font-size: 9px; }
            .floating-note { right: 0; bottom: 5px; }
            .ticker-inner span:nth-child(2) { display: none; }
            .section { padding: 70px 0; }
            .section-heading { display: block; }
            .section-heading p { margin-top: 20px; }
            .products { grid-template-columns: repeat(2, 1fr); gap: 28px 13px; }
            .story { grid-template-columns: 1fr; gap: 38px; padding-bottom: 75px; }
            .story-image { height: 320px; border-radius: 8px 80px 8px 8px; }
            .benefits { grid-template-columns: 1fr; }
            .footer-inner { display: block; line-height: 1.8; }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="announcement">Envío gratuito en pedidos superiores a $80 · Hecho para disfrutar</div>
    <header class="shell nav">
        <a class="brand" href="{{ url('/') }}">
            <span class="brand-mark">{{ str($storeName)->substr(0, 1) }}</span>
            <span class="brand-name">{{ $storeName }}</span>
        </a>
        <nav class="nav-links" aria-label="Navegación principal">
            <a href="#coleccion">Colección</a>
            <a href="#historia">Nuestra historia</a>
            <a href="#contacto">Contacto</a>
        </nav>
        <div class="nav-actions">
            <button class="icon-button" aria-label="Buscar">⌕</button>
            <button class="icon-button" aria-label="Carrito">◌</button>
        </div>
    </header>

    <main>
        <section class="shell hero">
            <div>
                <div class="eyebrow">Nueva temporada · 2026</div>
                <h1>Lo esencial,<br><em>bien hecho.</em></h1>
                <p class="hero-copy">Una selección honesta de objetos para elevar tus días. Diseño atemporal, materiales que cuentan historias y detalles pensados para quedarse.</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="#coleccion">Explorar colección <span>↗</span></a>
                    <a class="button button-light" href="#historia">Conócenos <span>→</span></a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="stamp">Diseñado<br>para durar<br>✦</div>
                <div class="hero-image"><img src="https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?auto=format&fit=crop&w=1000&q=85" alt="Selección de productos de {{ $storeName }}"></div>
                <div class="floating-note"><strong>Pequeños rituales</strong><small>Encuentra piezas que convierten lo cotidiano en algo especial.</small></div>
            </div>
        </section>

        <div class="ticker"><div class="shell ticker-inner"><span>Calidad sin prisa</span><span>Compra con intención</span><span>Hecho para ti</span><span>Envíos a todo el país</span></div></div>

        <section class="shell section" id="coleccion">
            <div class="section-heading">
                <div><div class="eyebrow">Nuestros favoritos</div><h2>Piezas que hablan<br>por sí solas.</h2></div>
                <p>Descubre los esenciales de esta semana, seleccionados con calma y mucho criterio.</p>
            </div>
            <div class="products">
                <article class="product-card"><div class="product-image"><span class="product-tag">Nuevo</span><img src="https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=700&q=85" alt="Bolso de cuero"></div><div class="product-info"><div><h3>Bolso Nómada</h3><p>Cuero natural · Miel</p></div><span class="price">$129</span></div></article>
                <article class="product-card"><div class="product-image"><span class="product-tag">Favorito</span><img src="https://images.unsplash.com/photo-1523779917675-b6ed3a42a561?auto=format&fit=crop&w=700&q=85" alt="Objeto artesanal"></div><div class="product-info"><div><h3>Forma Serena</h3><p>Cerámica · Arena</p></div><span class="price">$48</span></div></article>
                <article class="product-card"><div class="product-image"><img src="https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?auto=format&fit=crop&w=700&q=85" alt="Ramo de flores secas"></div><div class="product-info"><div><h3>Ritual de calma</h3><p>Edición limitada</p></div><span class="price">$36</span></div></article>
                <article class="product-card"><div class="product-image"><span class="product-tag">Esencial</span><img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=700&q=85" alt="Zapatillas minimalistas"></div><div class="product-info"><div><h3>Andar ligero</h3><p>Lino y algodón · Crudo</p></div><span class="price">$89</span></div></article>
            </div>
        </section>

        <section class="shell story" id="historia">
            <div class="story-image"><img src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1000&q=85" alt="Detalle de materiales y diseño"></div>
            <div class="story-copy"><div class="eyebrow">Nuestra manera</div><h2>Menos ruido.<br>Más intención.</h2><p>Creemos que comprar mejor empieza por elegir menos, pero elegir bien. Trabajamos con marcas y artesanos que comparten nuestra obsesión por los materiales honestos y los objetos que envejecen bonito.</p><a class="button button-light" href="#contacto">Leer nuestra historia <span>→</span></a></div>
        </section>

        <section class="shell benefits" id="contacto">
            <div class="benefit"><span class="benefit-number">01</span><h3>Envío cuidado</h3><p>Cada pedido sale de nuestro estudio envuelto con cariño y llega listo para regalar.</p></div>
            <div class="benefit"><span class="benefit-number">02</span><h3>Compra tranquila</h3><p>30 días para decidir. Si no es para ti, te ayudamos a encontrar algo que sí.</p></div>
            <div class="benefit"><span class="benefit-number">03</span><h3>Estamos cerca</h3><p>Escríbenos a hola-{{ $tenantId }}@mail.com. Respondemos de persona a persona.</p></div>
        </section>
    </main>

    <footer class="shell"><div class="footer-inner"><span>© {{ date('Y') }} {{ $storeName }}. Hecho con intención.</span><span>Privacidad · Términos · Instagram</span></div></footer>
</div>
</body>
</html>
