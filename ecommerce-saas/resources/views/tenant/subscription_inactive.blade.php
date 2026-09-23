<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $storeName ?? 'Tienda Inactiva' }} · Suscripción Requerida · Atelier Zacatecas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --ink: #0f172a;
            --muted: #64748b;
            --primary: #9333ea;
            --primary-light: rgba(147, 51, 234, 0.08);
            --amber: #d97706;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fdfbf7 0%, #f1f5f9 100%);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .inactive-card {
            background: var(--card);
            border: 1px solid var(--border);
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.07);
            border-radius: 24px;
            max-width: 580px;
            width: 100%;
            padding: 44px 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .inactive-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #d97706, #9333ea, #3b82f6);
        }
        .icon-badge {
            width: 76px;
            height: 76px;
            background: rgba(217, 119, 6, 0.12);
            color: var(--amber);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-bottom: 22px;
            border: 1px solid rgba(217, 119, 6, 0.25);
        }
        h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }
        .store-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: var(--primary);
            font-size: 13px;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 999px;
            margin-bottom: 18px;
            border: 1px solid rgba(147, 51, 234, 0.2);
        }
        p {
            font-size: 14.5px;
            line-height: 1.6;
            color: var(--muted);
            margin-bottom: 24px;
        }
        .plans-mini-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 28px;
            text-align: left;
        }
        .plans-mini-title {
            font-size: 12.5px;
            font-weight: 800;
            color: var(--ink);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .plans-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 13px;
            color: var(--muted);
        }
        .plans-list li {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .actions-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--primary);
            color: #ffffff;
            font-weight: 700;
            font-size: 14.5px;
            padding: 14px 24px;
            border-radius: 14px;
            text-decoration: none;
            transition: all .2s ease;
            box-shadow: 0 4px 12px rgba(147, 51, 234, 0.25);
        }
        .btn-primary:hover {
            background: #7e22ce;
            transform: translateY(-1px);
        }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #f1f5f9;
            color: var(--ink);
            font-weight: 600;
            font-size: 13.5px;
            padding: 12px 20px;
            border-radius: 12px;
            text-decoration: none;
            border: 1px solid var(--border);
            transition: background .2s ease;
        }
        .btn-secondary:hover {
            background: #e2e8f0;
        }
        .footer-note {
            margin-top: 24px;
            font-size: 12px;
            color: #94a3b8;
        }
        .footer-note a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="inactive-card">
        <div class="icon-badge">🔒</div>
        
        <div class="store-pill">
            <span>🏬</span> {{ $storeName ?? ($tenant->id ?? 'Tienda') }}
        </div>

        <h1>Tienda en Pausa de Suscripción</h1>
        
        <p>
            Esta tienda virtual requiere contar con una de las <strong>3 suscripciones oficiales activas</strong> para permanecer en línea, recibir visitas y procesar pedidos del público.
        </p>

        <div class="plans-mini-box">
            <div class="plans-mini-title">
                <span>✦</span> Planes Disponibles para Activar la Tienda
            </div>
            <ul class="plans-list">
                <li>🚀 <strong>Plan Emprendedor:</strong> $19/mes ($15/mes anual) · Catálogo esencial para pequeñas empresas.</li>
                <li>⭐ <strong>Plan Crecimiento:</strong> $39/mes ($31/mes anual) · Productos ilimitados y analíticas avanzadas.</li>
                <li>👑 <strong>Plan Corporativo:</strong> $89/mes ($71/mes anual) · Soporte VIP, roles y máxima velocidad.</li>
            </ul>
        </div>

        <div class="actions-group">
            <a href="{{ url('/planes') }}" class="btn-primary">
                <span>💎</span> Ver Planes y Activar Suscripción
            </a>
            <a href="{{ url('/tienda/' . ($tenant->id ?? '') . '/admin') }}" class="btn-secondary">
                <span>⚙️</span> Iniciar Sesión en el Panel de Administrador
            </a>
            <a href="{{ url('/') }}" class="btn-secondary">
                <span>🏠</span> Volver al Portal de Comercios de Zacatecas
            </a>
        </div>

        <div class="footer-note">
            ¿Eres el propietario de esta empresa? Inicia sesión en tu panel o comunícate con soporte en <a href="{{ url('/') }}">Atelier Zacatecas</a>.
        </div>
    </div>
</body>
</html>
