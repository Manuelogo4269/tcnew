<div x-data="{
    blocks: $wire.entangle('data.layout_blocks'),
    sectionMeta: {
        'banner_carousel': { icon: '🎠', name: 'Carrusel de Portada (Hero)', desc: 'Banner de impacto visual, título, subtítulo y botón de compra.', color: '#3b82f6' },
        'trust_bar': { icon: '🛡️', name: 'Barra de Beneficios', desc: 'Insignias de envío protegido, garantía de calidad y pagos seguros.', color: '#10b981' },
        'flash_deals': { icon: '⚡', name: 'Ofertas Relámpago', desc: 'Promociones con cuenta regresiva y temporizador de urgencia.', color: '#f59e0b' },
        'categories': { icon: '📂', name: 'Explorador de Categorías', desc: 'Filtro interactivo para navegar por departamentos de la tienda.', color: '#8b5cf6' },
        'featured_products': { icon: '⭐', name: 'Tendencias y Destacados', desc: 'Escaparate con los productos más cotizados de la semana.', color: '#ec4899' },
        'full_catalog': { icon: '📦', name: 'Catálogo Completo', desc: 'Cuadrícula con buscador en vivo, precios y botón de carrito.', color: '#d96b45' },
        'about_story': { icon: '📖', name: 'Historia y Quiénes Somos', desc: 'Narrativa del negocio, tradición en Zacatecas y fotografía del local.', color: '#06b6d4' },
        'map_location': { icon: '📍', name: 'Ubicación y Horarios', desc: 'Dirección física en Zacatecas Centro, horarios y mapa interactivo.', color: '#ef4444' },
        'testimonials': { icon: '💬', name: 'Reseñas de Clientes', desc: 'Calificaciones de 1 a 5 estrellas y opiniones verificadas.', color: '#eab308' },
        'contact_box': { icon: '✉️', name: 'Contacto y WhatsApp', desc: 'Caja de atención para pedidos especiales y chat directo.', color: '#22c55e' },
        'official_stores': { icon: '🏬', name: 'Red de Tiendas Aliadas', desc: 'Directorio interconectado para recomendación de negocios.', color: '#6366f1' }
    },
    toggleVisibility(index) {
        if (!this.blocks || !this.blocks[index]) return;
        this.blocks[index].is_visible = !this.blocks[index].is_visible;
    },
    moveUp(index) {
        if (index <= 0 || !this.blocks) return;
        const temp = this.blocks[index];
        this.blocks.splice(index, 1);
        this.blocks.splice(index - 1, 0, temp);
    },
    moveDown(index) {
        if (!this.blocks || index >= this.blocks.length - 1) return;
        const temp = this.blocks[index];
        this.blocks.splice(index, 1);
        this.blocks.splice(index + 1, 0, temp);
    },
    applyPreset(presetKey) {
        if (!this.blocks) return;
        let order = [];
        if (presetKey === 'comercial') {
            order = ['banner_carousel', 'flash_deals', 'trust_bar', 'categories', 'featured_products', 'full_catalog', 'contact_box', 'about_story', 'map_location', 'testimonials', 'official_stores'];
        } else if (presetKey === 'boutique') {
            order = ['banner_carousel', 'about_story', 'categories', 'featured_products', 'full_catalog', 'testimonials', 'trust_bar', 'flash_deals', 'map_location', 'contact_box', 'official_stores'];
        } else if (presetKey === 'gastro') {
            order = ['banner_carousel', 'trust_bar', 'full_catalog', 'map_location', 'contact_box', 'flash_deals', 'categories', 'featured_products', 'about_story', 'testimonials', 'official_stores'];
        } else {
            // Default full
            order = ['banner_carousel', 'trust_bar', 'flash_deals', 'categories', 'featured_products', 'full_catalog', 'about_story', 'map_location', 'official_stores', 'testimonials', 'contact_box'];
        }

        const reordered = [];
        order.forEach(type => {
            const found = this.blocks.find(b => b.type === type);
            if (found) {
                found.is_visible = true;
                reordered.push(found);
            }
        });
        // Append any remaining
        this.blocks.forEach(b => {
            if (!reordered.find(r => r.type === b.type)) {
                reordered.push(b);
            }
        });
        this.blocks = reordered;
    }
}" class="visual-layout-builder-box">
    <style>
        .visual-layout-builder-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px -5px rgba(0,0,0,0.05);
        }
        .vlb-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .vlb-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .vlb-subtitle {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
        }
        .vlb-presets {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .vlb-preset-btn {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 13px;
            border-radius: 999px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #334155;
            cursor: pointer;
            transition: all .15s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .vlb-preset-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .vlb-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 14px;
        }
        .vlb-card {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            background: #ffffff;
            transition: all .2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }
        .vlb-card.active {
            border-color: #9333ea;
            box-shadow: 0 4px 12px rgba(147, 51, 234, 0.08);
            background: #ffffff;
        }
        .vlb-card.hidden-block {
            border-color: #e2e8f0;
            background: #f8fafc;
            opacity: 0.65;
        }
        .vlb-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }
        .vlb-card-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .vlb-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: rgba(147, 51, 234, 0.08);
            flex-shrink: 0;
        }
        .vlb-card-name {
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
        }
        .vlb-card-pos {
            font-size: 11px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #475569;
        }
        .vlb-card-desc {
            font-size: 12px;
            color: #64748b;
            line-height: 1.4;
            margin-bottom: 12px;
            flex-grow: 1;
        }
        .vlb-card-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
        }
        .vlb-btn-toggle {
            font-size: 11.5px;
            font-weight: 700;
            padding: 5px 11px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all .15s ease;
        }
        .vlb-btn-toggle.is-on {
            background: #dcfce7;
            color: #15803d;
        }
        .vlb-btn-toggle.is-off {
            background: #fee2e2;
            color: #b91c1c;
        }
        .vlb-order-btns {
            display: flex;
            gap: 4px;
        }
        .vlb-order-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            transition: all .15s ease;
        }
        .vlb-order-btn:hover:not(:disabled) {
            background: #ffffff;
            border-color: #9333ea;
            color: #9333ea;
        }
        .vlb-order-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }
    </style>

    <div class="vlb-header">
        <div>
            <div class="vlb-title">
                <span>🎨</span> Constructor Gráfico y Modular de la Tienda
            </div>
            <div class="vlb-subtitle">
                Organiza visualmente las secciones de tu página pública. Activa o desactiva módulos y define su orden con un solo clic.
            </div>
        </div>

        <div class="vlb-presets">
            <span style="font-size: 11.5px; font-weight: 700; color: #64748b; align-self: center;">Plantillas Rápidas:</span>
            <button type="button" class="vlb-preset-btn" @click="applyPreset('comercial')">
                <span>⚡</span> Ofertas y Ventas
            </button>
            <button type="button" class="vlb-preset-btn" @click="applyPreset('boutique')">
                <span>💎</span> Boutique & Lujo
            </button>
            <button type="button" class="vlb-preset-btn" @click="applyPreset('gastro')">
                <span>🍽️</span> Gastronomía
            </button>
            <button type="button" class="vlb-preset-btn" @click="applyPreset('default')">
                <span>🏬</span> Catálogo Completo
            </button>
        </div>
    </div>

    <div class="vlb-grid">
        <template x-for="(block, idx) in blocks" :key="block.type || idx">
            <div class="vlb-card" :class="{ 'active': block.is_visible, 'hidden-block': !block.is_visible }">
                <div class="vlb-card-top">
                    <div class="vlb-card-left">
                        <div class="vlb-icon-box" :style="{ backgroundColor: (sectionMeta[block.type]?.color || '#9333ea') + '18' }">
                            <span x-text="sectionMeta[block.type]?.icon || '📦'"></span>
                        </div>
                        <div>
                            <div class="vlb-card-name" x-text="sectionMeta[block.type]?.name || block.title || 'Sección'"></div>
                            <div style="font-size: 11px; color: #94a3b8;" x-text="block.type"></div>
                        </div>
                    </div>
                    <span class="vlb-card-pos" x-text="'#' + (idx + 1)"></span>
                </div>

                <div class="vlb-card-desc" x-text="sectionMeta[block.type]?.desc || 'Módulo configurable de la tienda.'"></div>

                <div class="vlb-card-actions">
                    <button type="button" class="vlb-btn-toggle" :class="block.is_visible ? 'is-on' : 'is-off'" @click="toggleVisibility(idx)">
                        <span x-text="block.is_visible ? '👁️ Visible' : '🙈 Oculto'"></span>
                    </button>

                    <div class="vlb-order-btns">
                        <button type="button" class="vlb-order-btn" title="Subir sección" :disabled="idx === 0" @click="moveUp(idx)">
                            ▲
                        </button>
                        <button type="button" class="vlb-order-btn" title="Bajar sección" :disabled="idx === blocks.length - 1" @click="moveDown(idx)">
                            ▼
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
