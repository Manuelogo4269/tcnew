<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\StoreSettingResource\Pages;
use App\Models\StoreSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StoreSettingResource extends Resource
{
    protected static ?string $model = StoreSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $navigationGroup = 'Personalización';

    protected static ?string $navigationLabel = 'Diseño y Marca';

    protected static ?string $modelLabel = 'diseño de tienda';

    protected static ?string $pluralModelLabel = 'diseño de tienda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Paleta de Colores y Estilo')
                    ->description('Personaliza los tonos principales y la identidad cromática de tu tienda pública.')
                    ->icon('heroicon-o-swatch')
                    ->collapsible()
                    ->schema([
                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Color Primario / Acento')
                            ->helperText('Utilizado en botones, detalles destacados, insignias y elementos principales.')
                            ->default('#d96b45')
                            ->required(),

                        Forms\Components\ColorPicker::make('secondary_color')
                            ->label('Color de Fondo / Secundario')
                            ->helperText('Color base del sitio web (ej. #f4efe7 crema, #ffffff blanco o #0f172a modo oscuro).')
                            ->default('#f4efe7'),

                        Forms\Components\Select::make('font_family')
                            ->label('Tipografía Principal')
                            ->helperText('Define el estilo tipográfico de los títulos y textos de la tienda.')
                            ->options([
                                'DM Sans' => 'DM Sans + Playfair (Editorial / Elegante)',
                                'Inter' => 'Inter (Minimalista / Moderno)',
                                'Poppins' => 'Poppins (Dinámico / Comercial)',
                                'Plus Jakarta Sans' => 'Plus Jakarta Sans (Tech / Contemporáneo)',
                                'Cinzel' => 'Cinzel + Cormorant (Lujo / Sofisticado)',
                            ])
                            ->default('DM Sans')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Identidad de Marca')
                    ->description('Nombre comercial, eslogan, logo y correo principal.')
                    ->icon('heroicon-o-sparkles')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('store_name')
                            ->label('Nombre de la Tienda')
                            ->placeholder('Ej. Boutique Atelier')
                            ->required()
                            ->maxLength(120),

                        Forms\Components\Select::make('business_category')
                            ->label('Categoría / Giro del Negocio')
                            ->options([
                                'Moda y Lujo' => '👗 Moda, Lujo & Accesorios',
                                'Tecnología y Gadgets' => '💻 Tecnología, Audio & Dispositivos',
                                'Bebidas y Alimentos' => '🥤 Bebidas, Refrescos & Gourmet',
                                'Hogar y Decoración' => '🏺 Hogar, Mobiliario & Diseño',
                                'Salud y Belleza' => '🌿 Belleza, Cuidado & Fragancias',
                                'Comercio General' => '🏬 Tienda Departamental / General',
                            ])
                            ->default('Comercio General')
                            ->required(),

                        Forms\Components\TextInput::make('tagline')
                            ->label('Eslogan / Subtítulo Corto')
                            ->placeholder('Ej. Hecho a mano, diseñado para durar')
                            ->maxLength(180),

                        Forms\Components\TextInput::make('contact_email')
                            ->label('Correo Electrónico de Contacto')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('logo_url')
                            ->label('URL del Logo')
                            ->url()
                            ->placeholder('https://.../logo.png')
                            ->helperText('Enlace directo a la imagen de tu logotipo.')
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Portada y Banner Principal (Hero)')
                    ->description('Configura el impacto visual al entrar a la tienda pública.')
                    ->icon('heroicon-o-photo')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('banner_url')
                            ->label('URL del Banner / Imagen de Portada')
                            ->url()
                            ->placeholder('https://.../banner.jpg')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('hero_title')
                            ->label('Título Principal de Portada')
                            ->placeholder('Ej. Calidad y diseño. Hecho para ti.')
                            ->maxLength(150),

                        Forms\Components\TextInput::make('hero_button_text')
                            ->label('Texto del Botón de Compra')
                            ->placeholder('Ver productos')
                            ->default('Ver productos')
                            ->maxLength(60),

                        Forms\Components\Textarea::make('hero_subtitle')
                            ->label('Subtítulo o Párrafo de Bienvenida')
                            ->placeholder('Explora nuestra colección seleccionada con total garantía y privacidad.')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Barra Superior de Anuncios')
                    ->description('Muestra avisos importantes, promociones u ofertas de envío en la parte superior.')
                    ->icon('heroicon-o-megaphone')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Toggle::make('show_announcement')
                            ->label('Mostrar Barra de Anuncios')
                            ->default(true),

                        Forms\Components\TextInput::make('announcement_text')
                            ->label('Texto del Anuncio')
                            ->placeholder('¡Envíos gratis en compras mayores a $50! · Tienda Oficial')
                            ->columnSpan(2),
                    ])->columns(3),

                Forms\Components\Section::make('WhatsApp Flotante y Redes Sociales')
                    ->description('Canales directos para que los clientes se comuniquen o sigan tus redes.')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('Número de WhatsApp')
                            ->placeholder('+52 55 1234 5678')
                            ->helperText('Si se completa, aparecerá un botón flotante de WhatsApp en la tienda para chat directo.')
                            ->maxLength(30),

                        Forms\Components\TextInput::make('instagram_url')
                            ->label('Perfil de Instagram (URL)')
                            ->url()
                            ->placeholder('https://instagram.com/tutienda'),

                        Forms\Components\TextInput::make('facebook_url')
                            ->label('Página de Facebook (URL)')
                            ->url()
                            ->placeholder('https://facebook.com/tutienda'),

                        Forms\Components\TextInput::make('official_website_url')
                            ->label('Página Web Oficial del Negocio (URL Externa)')
                            ->url()
                            ->placeholder('https://www.minegocio.com')
                            ->helperText('Enlace al sitio web corporativo o portal oficial de la marca.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('footer_text')
                            ->label('Texto de Pie de Página')
                            ->placeholder('© 2026 Tu Tienda. Todos los derechos reservados.')
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Ubicación Física en Zacatecas Centro')
                    ->description('Dirección de la sucursal física, horarios y coordenadas para el mapa de cercanías y pedidos por WhatsApp.')
                    ->icon('heroicon-o-map-pin')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Dirección Física de la Tienda')
                            ->placeholder('Ej. Av. Hidalgo #305, Centro Histórico')
                            ->maxLength(255)
                            ->helperText('Aparece en la tienda pública y en el mensaje de pedido por WhatsApp.'),

                        Forms\Components\Select::make('neighborhood_zone')
                            ->label('Zona Comercial / Corredor')
                            ->options([
                                'Centro Histórico' => '🏛️ Centro Histórico',
                                'Av. Hidalgo' => '🚶 Av. Hidalgo',
                                'Calle Tacuba' => '🛍️ Calle Tacuba',
                                'Av. Juárez' => '🏬 Av. Juárez',
                                'Portal de Rosales' => '☕ Portal de Rosales',
                                'Av. González Ortega' => '🌳 Av. González Ortega',
                                'Zona Centro General' => '📍 Zona Centro General',
                            ])
                            ->default('Centro Histórico')
                            ->required(),

                        Forms\Components\TextInput::make('city')
                            ->label('Ciudad')
                            ->default('Zacatecas')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitud GPS')
                            ->numeric()
                            ->placeholder('22.7753')
                            ->helperText('Coordenada decimal (ej. 22.7753)'),

                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitud GPS')
                            ->numeric()
                            ->placeholder('-102.5724')
                            ->helperText('Coordenada decimal (ej. -102.5724)'),

                        Forms\Components\TextInput::make('opening_hours')
                            ->label('Horario de Atención')
                            ->placeholder('Lun - Sáb: 10:00 AM - 8:30 PM')
                            ->maxLength(150),

                        Forms\Components\TextInput::make('location_reference')
                            ->label('Punto de Referencia Local')
                            ->placeholder('A media cuadra de Plaza de Armas')
                            ->maxLength(255)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('maps_url')
                            ->label('Enlace Directo de Google Maps')
                            ->url()
                            ->placeholder('https://maps.google.com/?q=22.7753,-102.5724')
                            ->helperText('Se incluye en el mensaje automático de WhatsApp para guiar al cliente hasta la sucursal.')
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl('https://placehold.co/100x100?text=Logo'),
                Tables\Columns\TextColumn::make('store_name')
                    ->label('Nombre de la Tienda')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('contact_email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('primary_color')
                    ->label('Color')
                    ->badge(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Modificación')
                    ->dateTime('d M Y, H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('preview')
                    ->label('Ver Tienda')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url('/')
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoreSettings::route('/'),
            'create' => Pages\CreateStoreSetting::route('/create'),
            'edit' => Pages\EditStoreSetting::route('/{record}/edit'),
        ];
    }
}
