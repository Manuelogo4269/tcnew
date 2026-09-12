<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'store_name',
        'business_category',
        'tagline',
        'logo_url',
        'logo_data',
        'contact_email',
        'primary_color',
        'secondary_color',
        'font_family',
        'banner_url',
        'hero_title',
        'hero_subtitle',
        'hero_button_text',
        'show_announcement',
        'announcement_text',
        'whatsapp_number',
        'instagram_url',
        'facebook_url',
        'official_website_url',
        'address',
        'neighborhood_zone',
        'city',
        'latitude',
        'longitude',
        'maps_url',
        'opening_hours',
        'location_reference',
        'footer_text',
        'layout_blocks',
        'stripe_enabled',
        'stripe_publishable_key',
        'stripe_secret_key',
    ];

    protected static function booted(): void
    {
        static::saving(function (StoreSetting $setting) {
            $val = $setting->attributes['logo_url'] ?? null;
            if (!empty($val) && !str_starts_with($val, 'http://') && !str_starts_with($val, 'https://') && !str_starts_with($val, '//') && !str_starts_with($val, 'data:')) {
                $possiblePaths = [
                    storage_path('app/public/' . ltrim($val, '/')),
                    public_path('storage/' . ltrim($val, '/')),
                ];
                foreach ($possiblePaths as $p) {
                    if (file_exists($p) && is_file($p)) {
                        $mime = mime_content_type($p) ?: 'image/png';
                        $data = file_get_contents($p);
                        if ($data !== false && strlen($data) > 0 && strlen($data) <= 15000000) {
                            $setting->logo_data = 'data:' . $mime . ';base64,' . base64_encode($data);
                            break;
                        }
                    }
                }
            }
        });
    }

    public function getLogoUrlAttribute(?string $value): ?string
    {
        if (blank($value)) {
            return !empty($this->attributes['logo_data']) ? $this->attributes['logo_data'] : null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '//') || str_starts_with($value, 'data:')) {
            return $value;
        }

        // If local file exists (or is faked in tests), serve via asset URL
        $path = storage_path('app/public/' . ltrim($value, '/'));
        if (file_exists($path) || \Illuminate\Support\Facades\Storage::disk('public')->exists(ltrim($value, '/'))) {
            return asset('storage/' . ltrim($value, '/'));
        }

        // If local file is missing (e.g. after container redeploy), fallback to persisted base64 image data
        if (!empty($this->attributes['logo_data'])) {
            return $this->attributes['logo_data'];
        }

        return asset('storage/' . ltrim($value, '/'));
    }

    protected $casts = [
        'show_announcement' => 'boolean',
        'stripe_enabled' => 'boolean',
        'layout_blocks' => 'array',
    ];

    /**
     * Default ordered layout blocks for any storefront.
     */
    public static function defaultLayoutBlocks(): array
    {
        return [
            [
                'type' => 'banner_carousel',
                'is_visible' => true,
                'title' => 'Carrusel de Banners',
                'data' => [
                    'eyebrow' => 'Colección 2026',
                    'title' => 'Calidad y diseño. Hecho para ti.',
                    'subtitle' => 'Explora nuestra cuidada selección de piezas y productos de alta gama con garantía de satisfacción.',
                    'btn_text' => 'Explorar Catálogo',
                    'btn_link' => '#catalogo',
                ],
            ],
            [
                'type' => 'trust_bar',
                'is_visible' => true,
                'title' => 'Barra de Beneficios',
                'data' => [
                    'item1' => 'Envíos Express Protegidos',
                    'item2' => 'Garantía de Calidad',
                    'item3' => 'Pagos 100% Cifrados',
                    'item4' => 'Atención por WhatsApp',
                ],
            ],
            [
                'type' => 'flash_deals',
                'is_visible' => true,
                'title' => 'Descuentos & Ofertas Relámpago',
                'data' => [
                    'eyebrow' => '¡Oferta de Temporada!',
                    'title' => 'Descuentos Especiales de la Semana',
                    'subtitle' => 'Aprovecha hasta 30% de descuento en piezas seleccionadas antes de que termine el temporizador.',
                    'discount_badge' => '30% OFF',
                    'hours_duration' => 8,
                    'btn_text' => 'Ver Ofertas Disponibles',
                ],
            ],
            [
                'type' => 'categories',
                'is_visible' => true,
                'title' => 'Explorar por Categoría',
                'data' => [
                    'eyebrow' => 'Navegación Interactiva',
                ],
            ],
            [
                'type' => 'featured_products',
                'is_visible' => true,
                'title' => 'Tendencias de la Semana',
                'data' => [
                    'eyebrow' => 'Selección Especial',
                    'limit' => 8,
                ],
            ],
            [
                'type' => 'full_catalog',
                'is_visible' => true,
                'title' => 'Nuestra Colección de Productos',
                'data' => [
                    'eyebrow' => 'Catálogo Completo',
                ],
            ],
            [
                'type' => 'about_story',
                'is_visible' => true,
                'title' => 'Nuestra Historia en el Centro Histórico',
                'data' => [
                    'eyebrow' => 'Tradición y Pasión',
                    'title' => 'Hecho a mano en Zacatecas',
                    'content' => 'Nos apasiona ofrecer productos auténticos con la mejor atención. Con raíces en el corazón de Zacatecas, trabajamos cada día para llevar piezas excepcionales a nuestros clientes.',
                    'image_url' => 'https://images.unsplash.com/photo-1513151233558-d860c5398176?auto=format&fit=crop&w=800&q=80',
                    'badge' => 'Tradición Zacatecana',
                ],
            ],
            [
                'type' => 'map_location',
                'is_visible' => true,
                'title' => 'Ubicación y Horarios de Atención',
                'data' => [
                    'eyebrow' => 'Punto de Encuentro',
                    'title' => 'Visítanos en Zacatecas Centro',
                    'note' => 'Atención presencial y entrega inmediata de tus compras.',
                ],
            ],
            [
                'type' => 'official_stores',
                'is_visible' => true,
                'title' => 'Directorio de Negocios',
                'data' => [
                    'eyebrow' => 'Ecosistema Multi-Tienda',
                ],
            ],
            [
                'type' => 'testimonials',
                'is_visible' => true,
                'title' => 'Lo que dicen nuestros clientes',
                'data' => [
                    'eyebrow' => 'Experiencias Reales',
                ],
            ],
            [
                'type' => 'contact_box',
                'is_visible' => true,
                'title' => '¿Deseas una cotización o pedido especial?',
                'data' => [
                    'eyebrow' => 'Atención Directa',
                    'subtitle' => 'Estamos disponibles para responder cualquier duda sobre catálogo, personalizaciones o envíos nacionales e internacionales.',
                ],
            ],
        ];
    }

    /**
     * Get effective layout blocks, merging with defaults if not configured.
     */
    public function getEffectiveLayoutBlocks(): array
    {
        if (!empty($this->layout_blocks) && is_array($this->layout_blocks) && count($this->layout_blocks) > 0) {
            return $this->layout_blocks;
        }

        return static::defaultLayoutBlocks();
    }
}
