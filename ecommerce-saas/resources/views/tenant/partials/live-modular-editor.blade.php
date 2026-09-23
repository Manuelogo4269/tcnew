@php
    $isTenantAdmin = (session('tenant_admin_tenant_id') === ($tenantId ?? '')) 
        || auth()->guard('tenant')->check() 
        || (auth()->guard('web')->user() && str_contains(auth()->guard('web')->user()->email ?? '', 'admin'));
@endphp

@if($isTenantAdmin)
<div id="liveModularEditorApp">
    <!-- FLOATING TRIGGER BUTTON -->
    <button type="button" class="btn-floating-visual-editor" id="btnOpenVisualEditor" onclick="toggleLiveEditorDrawer()" title="Modo Editor Gráfico Modular">
        <span class="v-editor-icon">🎨</span>
        <span class="v-editor-text">Personalizar Diseño</span>
        <span class="v-editor-pill">{{ count($layoutBlocks ?? []) }} bloques</span>
    </button>

    <!-- BACKDROP & SIDEBAR DRAWER -->
    <div class="visual-editor-backdrop" id="visualEditorBackdrop" onclick="closeLiveEditorDrawer()"></div>

    <aside class="visual-editor-drawer" id="visualEditorDrawer" aria-label="Editor Visual de Secciones">
        <div class="ved-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div class="ved-icon">🎨</div>
                <div>
                    <h3 style="font-size: 15px; font-weight: 800; color: var(--ink); margin: 0;">Constructor Visual</h3>
                    <span style="font-size: 11.5px; color: var(--muted);">Organiza las secciones de {{ $storeTitle ?? 'tu tienda' }}</span>
                </div>
            </div>
            <button type="button" class="ved-close" onclick="closeLiveEditorDrawer()" aria-label="Cerrar editor">✕</button>
        </div>

        <!-- QUICK PRESETS -->
        <div class="ved-presets-bar">
            <span style="font-size: 11px; font-weight: 800; color: var(--muted); text-transform: uppercase;">Plantillas Rápidas:</span>
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 6px;">
                <button type="button" class="ved-preset-chip" onclick="applyLivePreset('comercial')">⚡ Ofertas</button>
                <button type="button" class="ved-preset-chip" onclick="applyLivePreset('boutique')">💎 Boutique</button>
                <button type="button" class="ved-preset-chip" onclick="applyLivePreset('gastro')">🍽️ Menú</button>
                <button type="button" class="ved-preset-chip" onclick="applyLivePreset('default')">🏬 Catálogo</button>
            </div>
        </div>

        <!-- REORDERABLE SECTION LIST -->
        <div class="ved-body" id="vedSectionsList">
            <!-- Populated dynamically by JS from current DOM sections -->
        </div>

        <div class="ved-footer">
            <button type="button" class="btn-save-layout" id="btnSaveLiveLayout" onclick="saveLiveLayoutChanges()">
                <span>💾</span> Guardar Diseño en Vivo
            </button>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                <a href="{{ url('/tienda/' . ($tenantId ?? '') . '/admin') }}" class="ved-admin-link">
                    ⚙️ Abrir Panel Completo
                </a>
                <span id="vedSaveStatus" style="font-size: 11px; color: var(--muted);">Sin cambios pendientes</span>
            </div>
        </div>
    </aside>
</div>

<style>
    .btn-floating-visual-editor {
        position: fixed;
        bottom: 24px;
        left: 24px;
        z-index: 9999;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0f172a;
        color: #ffffff;
        border: 2px solid rgba(147, 51, 234, 0.6);
        padding: 9px 18px;
        border-radius: 999px;
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.4), 0 0 15px rgba(147, 51, 234, 0.35);
        transition: all .2s ease;
    }
    .btn-floating-visual-editor:hover {
        transform: translateY(-2px) scale(1.03);
        background: #1e293b;
        border-color: #9333ea;
    }
    .v-editor-icon { font-size: 16px; }
    .v-editor-pill {
        background: rgba(147, 51, 234, 0.35);
        color: #e9d5ff;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 999px;
    }

    .visual-editor-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(3px);
        z-index: 10000;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s ease;
    }
    .visual-editor-backdrop.open {
        opacity: 1;
        pointer-events: auto;
    }

    .visual-editor-drawer {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 380px;
        max-width: 90vw;
        background: #ffffff;
        box-shadow: 10px 0 35px rgba(0,0,0,0.15);
        z-index: 10001;
        transform: translateX(-100%);
        transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }
    .visual-editor-drawer.open {
        transform: translateX(0);
    }
    .ved-header {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
    }
    .ved-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: rgba(147, 51, 234, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .ved-close {
        background: transparent;
        border: none;
        font-size: 18px;
        cursor: pointer;
        color: #64748b;
        padding: 4px;
    }
    .ved-presets-bar {
        padding: 12px 18px;
        background: #fdfbf7;
        border-bottom: 1px solid #f1f5f9;
    }
    .ved-preset-chip {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all .15s ease;
    }
    .ved-preset-chip:hover {
        background: #9333ea;
        color: #ffffff;
        border-color: #9333ea;
    }
    .ved-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .ved-card-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        transition: all .2s ease;
    }
    .ved-card-item.hidden-item {
        background: #f8fafc;
        opacity: 0.55;
        border-style: dashed;
    }
    .ved-card-item:hover {
        border-color: #9333ea;
        box-shadow: 0 2px 8px rgba(147,51,234,0.06);
    }
    .ved-item-left {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow: hidden;
    }
    .ved-item-icon { font-size: 18px; flex-shrink: 0; }
    .ved-item-name {
        font-size: 12.5px;
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ved-item-controls {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-shrink: 0;
    }
    .ved-btn-action {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        transition: all .15s ease;
    }
    .ved-btn-action:hover:not(:disabled) {
        background: #9333ea;
        color: #fff;
        border-color: #9333ea;
    }
    .ved-btn-action:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    .ved-footer {
        padding: 16px 20px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
    }
    .btn-save-layout {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #9333ea;
        color: #ffffff;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13.5px;
        cursor: pointer;
        transition: all .2s ease;
    }
    .btn-save-layout:hover {
        background: #7e22ce;
        box-shadow: 0 4px 12px rgba(147,51,234,0.3);
    }
    .ved-admin-link {
        font-size: 11.5px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
    }
    .ved-admin-link:hover { color: #9333ea; text-decoration: underline; }
</style>

<script>
let liveLayoutBlocks = @json($layoutBlocks ?? []);
const LIVE_TENANT_ID = @json($tenantId ?? '');

const BLOCK_META_DICT = {
    'banner_carousel': { icon: '🎠', name: 'Carrusel de Banners' },
    'trust_bar': { icon: '🛡️', name: 'Barra de Beneficios' },
    'flash_deals': { icon: '⚡', name: 'Ofertas Relámpago' },
    'categories': { icon: '📂', name: 'Explorador Categorías' },
    'featured_products': { icon: '⭐', name: 'Tendencias Destacadas' },
    'full_catalog': { icon: '📦', name: 'Catálogo de Productos' },
    'about_story': { icon: '📖', name: 'Historia del Negocio' },
    'map_location': { icon: '📍', name: 'Ubicación y Horarios' },
    'testimonials': { icon: '💬', name: 'Reseñas de Clientes' },
    'contact_box': { icon: '✉️', name: 'Contacto y WhatsApp' },
    'official_stores': { icon: '🏬', name: 'Red de Tiendas' }
};

function toggleLiveEditorDrawer() {
    const drawer = document.getElementById('visualEditorDrawer');
    const backdrop = document.getElementById('visualEditorBackdrop');
    if (!drawer) return;
    const isOpen = drawer.classList.contains('open');
    if (isOpen) {
        closeLiveEditorDrawer();
    } else {
        renderLiveEditorBlocks();
        drawer.classList.add('open');
        if (backdrop) backdrop.classList.add('open');
    }
}

function closeLiveEditorDrawer() {
    const drawer = document.getElementById('visualEditorDrawer');
    const backdrop = document.getElementById('visualEditorBackdrop');
    if (drawer) drawer.classList.remove('open');
    if (backdrop) backdrop.classList.remove('open');
}

function renderLiveEditorBlocks() {
    const container = document.getElementById('vedSectionsList');
    if (!container) return;

    container.innerHTML = '';
    liveLayoutBlocks.forEach((block, idx) => {
        const meta = BLOCK_META_DICT[block.type] || { icon: '📦', name: block.title || block.type };
        const isVis = (block.is_visible !== false);

        const card = document.createElement('div');
        card.className = `ved-card-item ${isVis ? '' : 'hidden-item'}`;
        card.innerHTML = `
            <div class="ved-item-left">
                <span class="ved-item-icon">${meta.icon}</span>
                <div>
                    <div class="ved-item-name">${meta.name}</div>
                    <small style="color: ${isVis ? '#15803d' : '#94a3b8'}; font-weight: 700; font-size: 10px;">
                        ${isVis ? '● Visible en tienda' : '○ Oculto'}
                    </small>
                </div>
            </div>
            <div class="ved-item-controls">
                <button type="button" class="ved-btn-action" title="${isVis ? 'Ocultar sección' : 'Mostrar sección'}" onclick="toggleLiveBlockVis(${idx})">
                    ${isVis ? '👁️' : '🙈'}
                </button>
                <button type="button" class="ved-btn-action" title="Subir sección" ${idx === 0 ? 'disabled' : ''} onclick="moveLiveBlock(${idx}, -1)">
                    ▲
                </button>
                <button type="button" class="ved-btn-action" title="Bajar sección" ${idx === liveLayoutBlocks.length - 1 ? 'disabled' : ''} onclick="moveLiveBlock(${idx}, 1)">
                    ▼
                </button>
            </div>
        `;
        container.appendChild(card);
    });
}

function toggleLiveBlockVis(idx) {
    if (!liveLayoutBlocks[idx]) return;
    liveLayoutBlocks[idx].is_visible = (liveLayoutBlocks[idx].is_visible === false);
    applyDomRearrangement();
    renderLiveEditorBlocks();
    markPendingChanges();
}

function moveLiveBlock(idx, delta) {
    const targetIdx = idx + delta;
    if (targetIdx < 0 || targetIdx >= liveLayoutBlocks.length) return;
    const item = liveLayoutBlocks.splice(idx, 1)[0];
    liveLayoutBlocks.splice(targetIdx, 0, item);
    applyDomRearrangement();
    renderLiveEditorBlocks();
    markPendingChanges();
}

function applyLivePreset(presetKey) {
    let order = [];
    if (presetKey === 'comercial') {
        order = ['banner_carousel', 'flash_deals', 'trust_bar', 'categories', 'featured_products', 'full_catalog', 'contact_box', 'about_story', 'map_location', 'testimonials', 'official_stores'];
    } else if (presetKey === 'boutique') {
        order = ['banner_carousel', 'about_story', 'categories', 'featured_products', 'full_catalog', 'testimonials', 'trust_bar', 'flash_deals', 'map_location', 'contact_box', 'official_stores'];
    } else if (presetKey === 'gastro') {
        order = ['banner_carousel', 'trust_bar', 'full_catalog', 'map_location', 'contact_box', 'flash_deals', 'categories', 'featured_products', 'about_story', 'testimonials', 'official_stores'];
    } else {
        order = ['banner_carousel', 'trust_bar', 'flash_deals', 'categories', 'featured_products', 'full_catalog', 'about_story', 'map_location', 'official_stores', 'testimonials', 'contact_box'];
    }

    const reordered = [];
    order.forEach(type => {
        const found = liveLayoutBlocks.find(b => b.type === type);
        if (found) {
            found.is_visible = true;
            reordered.push(found);
        }
    });
    liveLayoutBlocks.forEach(b => {
        if (!reordered.find(r => r.type === b.type)) reordered.push(b);
    });
    liveLayoutBlocks = reordered;

    applyDomRearrangement();
    renderLiveEditorBlocks();
    markPendingChanges();
}

function applyDomRearrangement() {
    const mainShell = document.getElementById('inicio');
    if (!mainShell) return;

    // Rearrange sections inside main according to liveLayoutBlocks
    liveLayoutBlocks.forEach(block => {
        let sel = '';
        if (block.type === 'banner_carousel') sel = '.hero-carousel-container';
        else if (block.type === 'trust_bar') sel = '.trust-bar';
        else if (block.type === 'flash_deals') sel = '.flash-deals-section';
        else if (block.type === 'categories') sel = '#categorias';
        else if (block.type === 'featured_products') sel = '#destacados';
        else if (block.type === 'full_catalog') sel = '#catalogo';
        else if (block.type === 'about_story') sel = '#historia';
        else if (block.type === 'map_location') sel = '#ubicacion';
        else if (block.type === 'testimonials') sel = '#opiniones';
        else if (block.type === 'contact_box') sel = '#contacto';
        else if (block.type === 'official_stores') sel = '#negocios';

        if (sel) {
            const el = document.querySelector(sel);
            if (el && el.parentElement === mainShell) {
                if (block.is_visible === false) {
                    el.style.display = 'none';
                } else {
                    el.style.display = '';
                }
                mainShell.appendChild(el);
            }
        }
    });
}

function markPendingChanges() {
    const st = document.getElementById('vedSaveStatus');
    if (st) {
        st.textContent = '● Cambios sin guardar';
        st.style.color = '#d97706';
        st.style.fontWeight = '700';
    }
}

async function saveLiveLayoutChanges() {
    const btn = document.getElementById('btnSaveLiveLayout');
    const st = document.getElementById('vedSaveStatus');
    if (btn) btn.disabled = true;
    if (st) st.textContent = '⏳ Guardando en la tienda...';

    try {
        const res = await fetch(`/api/tienda/${encodeURIComponent(LIVE_TENANT_ID)}/layout`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                layout_blocks: liveLayoutBlocks
            })
        });

        const data = await res.json();
        if (data.success) {
            if (st) {
                st.textContent = '✓ Guardado exitosamente';
                st.style.color = '#15803d';
            }
            if (typeof showToast === 'function') {
                showToast('🎨 ¡Diseño modular actualizado y guardado con éxito!');
            } else {
                alert('¡Diseño modular actualizado y guardado con éxito!');
            }
        } else {
            throw new Error(data.message || 'Error al guardar');
        }
    } catch (err) {
        if (st) {
            st.textContent = '✕ Error al guardar';
            st.style.color = '#b91c1c';
        }
        alert('No se pudo guardar el diseño: ' + err.message);
    } finally {
        if (btn) btn.disabled = false;
    }
}
</script>
@endif
