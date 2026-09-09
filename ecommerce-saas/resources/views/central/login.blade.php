<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Iniciar Sesión — Atelier Hub Multi-Tienda</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f7f5f0;
            color: #111210;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            transition: background .25s ease, color .25s ease;
        }
        .card {
            background: #ffffff;
            border-radius: 26px;
            width: min(450px, 100%);
            padding: 40px 32px;
            box-shadow: 0 20px 50px rgba(0,0,0,.08);
            border: 1px solid rgba(0,0,0,.06);
            text-align: center;
            position: relative;
            transition: all .25s ease;
        }

        /* Dark Theme */
        [data-theme="dark"] body {
            background: #0b0d11;
            color: #f3f4f6;
        }
        [data-theme="dark"] .card {
            background: #15181f;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 60px rgba(0,0,0,0.55);
        }
        [data-theme="dark"] .brand-badge {
            background: #c86d63;
        }
        [data-theme="dark"] h1 {
            color: #f3f4f6;
        }
        [data-theme="dark"] p {
            color: #9ca3af;
        }
        [data-theme="dark"] .btn-google {
            background: #1e232e;
            color: #f3f4f6;
            border-color: rgba(255, 255, 255, 0.12);
        }
        [data-theme="dark"] .sep {
            color: #6b7280;
        }
        [data-theme="dark"] .sep::before, [data-theme="dark"] .sep::after {
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }
        [data-theme="dark"] .field label {
            color: #d1d5db;
        }
        [data-theme="dark"] .field input {
            background: #1a1e27;
            color: #f3f4f6;
            border-color: rgba(255, 255, 255, 0.12);
        }
        [data-theme="dark"] .btn-submit {
            background: #2563eb;
        }
        [data-theme="dark"] .btn-submit:hover {
            background: #1d4ed8;
        }
        [data-theme="dark"] .back-link {
            color: #9ca3af;
        }
        [data-theme="dark"] .back-link:hover {
            color: #dc7e74;
        }

        .btn-theme-toggle {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(0,0,0,0.1);
            background: transparent;
            font-size: 16px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
        }
        [data-theme="dark"] .btn-theme-toggle {
            border-color: rgba(255,255,255,0.15);
        }
        .btn-theme-toggle:hover {
            transform: scale(1.1);
        }
        .brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #111210;
            color: #ffffff;
            display: grid;
            place-items: center;
            font-size: 22px;
            margin: 0 auto 16px;
        }
        h1 { font-size: 24px; margin-bottom: 8px; }
        p { font-size: 13.5px; color: #6b6a64; margin-bottom: 24px; }
        .social-group { display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; }
        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 12px 20px;
            border-radius: 999px;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            transition: transform .2s ease;
        }
        .btn-google { background: #ffffff; color: #1f2937; border: 1.5px solid #e5e7eb; }
        .btn-facebook { background: #1877f2; color: #ffffff; }
        .btn-social:hover { transform: translateY(-2px); }
        .sep {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #9ca3af;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .sep::before, .sep::after { content: ''; flex: 1; border-bottom: 1px solid #e5e7eb; }
        .sep span { padding: 0 10px; }
        .field { text-align: left; margin-bottom: 14px; }
        .field label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 6px; }
        .field input {
            width: 100%;
            padding: 11px 16px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            background: #f9fafb;
            font-size: 14px;
            outline: none;
        }
        .field input:focus { border-color: #c86d63; }
        .btn-submit {
            width: 100%;
            padding: 13px;
            border-radius: 999px;
            background: #111210;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-submit:hover { background: #c86d63; }
        .back-link { display: inline-block; margin-top: 20px; font-size: 13px; color: #6b6a64; }
        .back-link:hover { color: #c86d63; }
        .error-box { background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; font-size: 12px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand-badge" style="padding: 0; overflow: hidden; background: linear-gradient(135deg, #c86d63, #b45b51); border: 1.5px solid #cbd5e1; display: grid; place-items: center; position: relative;">
            <img src="/app-icons/icon.svg" alt="Minimapa Zacatecas" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px; display: block;" onerror="this.onerror=null; this.src='/icons/icon.svg'; this.onerror=function(){this.style.display='none'; this.nextElementSibling.style.display='grid';};">
            <span style="display: none; width: 100%; height: 100%; place-items: center; font-size: 24px; color: #fff;">🏛️</span>
        </div>
        <h1>Iniciar Sesión</h1>
        <p>Accede con Google, Facebook o tu correo electrónico para comprar en las tiendas oficiales.</p>

        @if($errors->any())
            <div class="error-box" style="background: #fef2f2; border: 1.5px solid #f87171; color: #991b1b; padding: 14px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; text-align: left; line-height: 1.5;">
                <strong>⚠️ {{ $errors->first() }}</strong>
                @if(str_contains($errors->first(), 'Google') || str_contains($errors->first(), 'oauth') || str_contains($errors->first(), 'redireccionamiento'))
                    <div style="margin-top: 10px; font-size: 12px; color: #7f1d1d; border-top: 1px solid rgba(248, 113, 113, 0.4); padding-top: 8px;">
                        💡 <strong>Para autorizar este dominio en Google Cloud:</strong>
                        <ol style="margin-left: 18px; margin-top: 4px;">
                            <li>Abre <a href="https://console.cloud.google.com/apis/credentials" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 700;">Google Cloud Console</a>.</li>
                            <li>Edita tu <em>Cliente de OAuth 2.0</em>.</li>
                            <li>En <strong>URIs de redireccionamiento autorizados</strong>, agrega:<br>
                                <code style="background: rgba(0,0,0,0.06); padding: 3px 6px; border-radius: 4px; display: inline-block; margin-top: 4px; font-size: 11.5px; word-break: break-all;">https://atelier-zacatecas.onrender.com/auth/google/callback</code>
                            </li>
                            <li style="margin-top: 4px;">En <strong>Orígenes de JavaScript autorizados</strong>, agrega:<br>
                                <code style="background: rgba(0,0,0,0.06); padding: 3px 6px; border-radius: 4px; display: inline-block; margin-top: 4px; font-size: 11.5px; word-break: break-all;">https://atelier-zacatecas.onrender.com</code>
                            </li>
                        </ol>
                    </div>
                @endif
            </div>
        @endif

        <div class="social-group">
            <a href="{{ url('/auth/google') }}" class="btn-social btn-google">
                <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                <span>Continuar con Google</span>
            </a>
            <a href="{{ url('/auth/facebook') }}" class="btn-social btn-facebook">
                <svg width="20" height="20" fill="#ffffff" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                <span>Continuar con Facebook</span>
            </a>
        </div>

        <!-- Acceso Directo con Gmail -->
        <details style="border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; padding: 10px 14px; background: rgba(0,0,0,0.02); margin-bottom: 16px; text-align: left;">
            <summary style="font-size: 12.5px; font-weight: 700; cursor: pointer; color: #2563eb;">
                ✍️ ¿Problemas con el pop-up de Google? Entrar con tu Gmail
            </summary>
            <form action="{{ url('/auth/social/login') }}" method="POST" style="margin-top: 10px;">
                @csrf
                <input type="hidden" name="provider" value="google">
                <div class="field" style="margin-bottom: 8px;">
                    <label style="font-size: 11px;">Tu Nombre Completo</label>
                    <input type="text" name="name" placeholder="Ej. Manuel Moreno" required style="padding: 8px 12px; font-size: 13px;">
                </div>
                <div class="field" style="margin-bottom: 10px;">
                    <label style="font-size: 11px;">Tu Correo Gmail</label>
                    <input type="email" name="email" placeholder="tu.cuenta@gmail.com" required style="padding: 8px 12px; font-size: 13px;">
                </div>
                <button type="submit" class="btn-submit" style="padding: 10px; font-size: 13px; background: #2563eb; border-radius: 8px; margin-top: 4px;">
                    Iniciar Sesión con mi Gmail
                </button>
            </form>
        </details>

        <div class="sep"><span>o con tu correo</span></div>

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="field">
                <label>Correo Electrónico</label>
                <input type="email" name="email" placeholder="ejemplo@correo.com" required value="{{ old('email') }}">
            </div>
            <div class="field">
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="Tu contraseña" required>
            </div>
            <button type="submit" class="btn-submit">Iniciar Sesión con Correo</button>
        </form>

        <button type="button" class="btn-theme-toggle" id="themeToggleBtn" onclick="toggleTheme()" aria-label="Cambiar modo oscuro/claro" title="Modo Oscuro / Claro">
            <span class="theme-icon-light">🌙</span>
            <span class="theme-icon-dark" style="display: none;">☀️</span>
        </button>

        <a href="{{ url('/') }}" class="back-link">← Volver al Portal Principal</a>
    </div>

    <script>
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

        document.addEventListener('DOMContentLoaded', () => {
            const activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
            updateThemeIcons(activeTheme);
        });
    </script>
</body>
</html>