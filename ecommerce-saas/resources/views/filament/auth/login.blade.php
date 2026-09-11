@php
    $isTenant = filament()->getCurrentPanel()->getId() === 'tenant';
    $brand = $isTenant ? 'Atelier · Tienda' : 'Atelier Commerce';
    $initial = $isTenant ? 'E' : 'A';
@endphp

<x-filament-panels::page.simple heading="" :logo="false">
    <div class="atelier-login">
        <section class="atelier-login__aside">
            <div class="atelier-login__grain"></div>
            <div class="atelier-login__brand"><span>{{ $initial }}</span>{{ $brand }}</div>
            <div class="atelier-login__message">
                <div class="atelier-login__eyebrow">{{ $isTenant ? 'Espacio de tu tienda' : 'Gestión de tu plataforma' }}</div>
                <h2>{{ $isTenant ? 'Todo lo que tu tienda necesita, en un solo lugar.' : 'Haz crecer negocios extraordinarios.' }}</h2>
                <p>{{ $isTenant ? 'Gestiona productos, pedidos y clientes con una experiencia tan cuidada como tu marca.' : 'Una vista clara para acompañar a cada empresa en su camino de crecimiento.' }}</p>
            </div>
            <div class="atelier-login__quote">“Las mejores experiencias empiezan detrás de escena.”</div>
        </section>

        <section class="atelier-login__form">
            <div class="atelier-login__form-head">
                <div class="atelier-login__mobile-brand"><span>{{ $initial }}</span>{{ $brand }}</div>
                <div class="atelier-login__eyebrow">Acceso seguro</div>
                <h1>{{ $isTenant ? 'Bienvenido de vuelta' : 'Hola, administrador' }}</h1>
                <p>Introduce tus datos para continuar.</p>
            </div>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}


            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}
                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </x-filament-panels::form>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
            <div class="atelier-login__footer">Protegido por Atelier Commerce <span>✦</span></div>
        </section>
    </div>
<style>
    .fi-simple-main { width:min(100% - 2rem, 980px) !important; max-width:980px !important; }
    .atelier-login { display:grid; grid-template-columns:minmax(300px,.86fr) minmax(380px,1.14fr); min-height:560px; overflow:hidden; background:#fffdf9; border:1px solid rgba(32,33,30,.1); border-radius:22px; box-shadow:0 24px 60px rgba(32,33,30,.09); }
    .atelier-login__aside { position:relative; display:flex; min-height:560px; flex-direction:column; justify-content:space-between; overflow:hidden; padding:34px; color:#fffaf3; background:#20211e; }
    .atelier-login__aside:after { position:absolute; right:-90px; bottom:-130px; width:300px; height:300px; border:1px solid rgba(226,112,78,.45); border-radius:50%; box-shadow:0 0 0 28px rgba(226,112,78,.08),0 0 0 58px rgba(226,112,78,.04); content:''; }
    .atelier-login__grain { position:absolute; inset:0; opacity:.06; background-image:radial-gradient(#fff 1px,transparent 1px); background-size:7px 7px; pointer-events:none; }
    .atelier-login__brand,.atelier-login__mobile-brand { position:relative; z-index:1; display:flex; align-items:center; gap:10px; font-size:14px; font-weight:700; letter-spacing:-.03em; }
    .atelier-login__brand span,.atelier-login__mobile-brand span { display:grid; width:34px; height:34px; place-items:center; color:#20211e; background:#e2704e; border-radius:50%; font-family:Georgia,serif; font-size:18px; }
    .atelier-login__message { position:relative; z-index:1; max-width:300px; }
    .atelier-login__eyebrow { color:#d96b45; font-size:10px; font-weight:700; letter-spacing:.16em; text-transform:uppercase; }
    .atelier-login__aside h2 { margin:15px 0 16px; color:#fffaf3; font-family:Georgia,serif; font-size:34px; font-weight:500; letter-spacing:-.06em; line-height:1.05; }
    .atelier-login__aside p { margin:0; color:rgba(255,250,243,.62); font-size:12px; line-height:1.7; }
    .atelier-login__quote { position:relative; z-index:1; max-width:230px; color:rgba(255,250,243,.7); font-family:Georgia,serif; font-size:13px; font-style:italic; line-height:1.5; }
    .atelier-login__form { display:flex; flex-direction:column; justify-content:center; padding:52px clamp(30px,6vw,76px); }
    .atelier-login__form-head { margin-bottom:28px; }
    .atelier-login__form-head h1 { margin:13px 0 8px; color:#20211e; font-family:Georgia,serif; font-size:36px; font-weight:500; letter-spacing:-.06em; line-height:1; }
    .atelier-login__form-head p { margin:0; color:#77756d; font-size:13px; }
    .atelier-login__mobile-brand { display:none; margin-bottom:28px; color:#20211e; }
    .atelier-login__footer { margin-top:28px; color:#aaa79f; font-size:10px; text-align:center; }
    .atelier-login__footer span { margin-left:4px; color:#e2704e; }
    @media (max-width:760px) { .atelier-login { display:block; border-radius:16px; }.atelier-login__aside { display:none; }.atelier-login__form { min-height:560px; padding:38px 26px; }.atelier-login__mobile-brand { display:flex; } }
</style>
</x-filament-panels::page.simple>
