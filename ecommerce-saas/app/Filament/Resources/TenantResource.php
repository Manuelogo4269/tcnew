<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
use App\Filament\Resources\TenantResource\RelationManagers;
use App\Models\StoreSetting;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Empresas';

    protected static ?string $modelLabel = 'empresa';

    protected static ?string $pluralModelLabel = 'empresas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identificación de la Empresa')
                    ->schema([
                        Forms\Components\TextInput::make('id')
                            ->label('Identificador Técnico')
                            ->placeholder('empresa-nueva')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->alphaDash()
                            ->maxLength(80)
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->helperText(fn (string $operation): ?string => $operation === 'edit'
                                ? 'El identificador no puede modificarse porque corresponde al nombre de la base de datos física aislada.'
                                : 'Se utilizará como subdominio y nombre de base de datos aislada (ej. tenant_empresa.sqlite).'),
                    ]),

                Forms\Components\Section::make('👤 Administrador de la Empresa (Credenciales de Acceso)')
                    ->description('Define el correo y contraseña exclusivos que utilizará el administrador para acceder al panel privado de esta empresa (/tenant-admin).')
                    ->icon('heroicon-o-user-plus')
                    ->schema([
                        Forms\Components\TextInput::make('admin_name')
                            ->label('Nombre del Administrador')
                            ->placeholder('Ej. Elena Rostova')
                            ->default(fn (?Tenant $record) => $record ? $record->run(fn () => \App\Models\TenantUser::first()?->name) : null)
                            ->maxLength(100),

                        Forms\Components\TextInput::make('admin_email')
                            ->label('Correo Electrónico del Administrador')
                            ->email()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->placeholder('admin@tuempresa.com')
                            ->default(fn (?Tenant $record) => $record ? $record->run(fn () => \App\Models\TenantUser::first()?->email) : null)
                            ->maxLength(150),

                        Forms\Components\TextInput::make('admin_password')
                            ->label('Contraseña de Acceso')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->placeholder('Mínimo 6 caracteres')
                            ->minLength(6)
                            ->helperText(fn (string $operation): ?string => $operation === 'edit'
                                ? 'Deja este campo en blanco si no deseas cambiar la contraseña actual del administrador.'
                                : 'Contraseña obligatoria para el primer inicio de sesión del administrador.')
                            ->maxLength(100),
                    ])->columns(3),

                Forms\Components\Section::make('Plan de Renta SaaS y Suscripción')
                    ->description('Gestiona el plan contratado, ciclo de facturación y vigencia del alquiler de la tienda.')
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Forms\Components\Select::make('plan_name')
                            ->label('Plan Contratado')
                            ->options([
                                'Emprendedor' => '🚀 Plan Emprendedor ($19/mes - $15/mes anual)',
                                'Crecimiento' => '⭐ Plan Crecimiento ($39/mes - $31/mes anual - Más Popular)',
                                'Corporativo' => '👑 Plan Corporativo ($89/mes - $71/mes anual)',
                            ])
                            ->default('Emprendedor')
                            ->required(),

                        Forms\Components\Select::make('billing_cycle')
                            ->label('Ciclo de Facturación')
                            ->options([
                                'monthly' => '📅 Mensual (Facturación mes a mes)',
                                'annual' => '💎 Anual (Pago de 12 meses con 20% descuento)',
                            ])
                            ->default('monthly')
                            ->required(),

                        Forms\Components\Select::make('subscription_status')
                            ->label('Estado de la Renta')
                            ->options([
                                'active' => '✅ Activa / Al corriente',
                                'trial' => '⏳ En período de prueba',
                                'past_due' => '⚠️ Pago pendiente / Vencido',
                                'cancelled' => '❌ Cancelada / Suspendida',
                            ])
                            ->default('active')
                            ->required(),

                        Forms\Components\TextInput::make('subscription_amount')
                            ->label('Monto de la Renta (USD)')
                            ->numeric()
                            ->prefix('$')
                            ->placeholder('39.00'),

                        Forms\Components\DateTimePicker::make('subscription_ends_at')
                            ->label('Fecha de Vencimiento de la Renta'),
                    ])->columns(3),

                Forms\Components\Section::make('Paleta de Colores y Tipografía de la Tienda')
                    ->description('Personaliza los colores corporativos y la fuente de la tienda pública de esta empresa.')
                    ->icon('heroicon-o-swatch')
                    ->collapsible()
                    ->schema([
                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Color Primario / Acento')
                            ->helperText('Botones, insignias y elementos principales.')
                            ->default('#d96b45'),

                        Forms\Components\ColorPicker::make('secondary_color')
                            ->label('Color de Fondo / Secundario')
                            ->helperText('Color base del sitio (ej. #f4efe7 crema, #ffffff blanco o #0f172a oscuro).')
                            ->default('#f4efe7'),

                        Forms\Components\Select::make('font_family')
                            ->label('Tipografía')
                            ->options([
                                'DM Sans' => 'DM Sans + Playfair (Editorial / Sofisticado)',
                                'Inter' => 'Inter (Minimalista / Moderno)',
                                'Poppins' => 'Poppins (Dinámico / Comercial)',
                                'Plus Jakarta Sans' => 'Plus Jakarta Sans (Tech / Vanguardista)',
                                'Cinzel' => 'Cinzel + Cormorant (Lujo / Joyería)',
                            ])
                            ->default('DM Sans'),
                    ])->columns(3),

                Forms\Components\Section::make('Identidad y Logotipo')
                    ->description('Nombre comercial, eslogan y enlaces directos de la empresa.')
                    ->icon('heroicon-o-sparkles')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('store_name')
                            ->label('Nombre Comercial de la Tienda')
                            ->placeholder('Ej. Boutique Vintage')
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
                            ->label('Eslogan')
                            ->placeholder('Ej. Exclusividad y estilo a tu alcance')
                            ->maxLength(180),

                        Forms\Components\TextInput::make('contact_email')
                            ->label('Correo Electrónico de Contacto')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\Placeholder::make('current_logo_preview')
                            ->label('Logotipo Actual')
                            ->visible(fn (?Tenant $record) => !empty($record?->run(fn () => StoreSetting::first()?->logo_url)))
                            ->content(function (?Tenant $record) {
                                $url = $record ? $record->run(fn () => StoreSetting::first()?->logo_url) : null;
                                return $url ? new \Illuminate\Support\HtmlString(
                                    '<div style="display:flex;align-items:center;gap:14px;padding:8px 0;">' .
                                    '<div style="width:72px;height:72px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;display:flex;align-items:center;justify-content:center;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.06);">' .
                                    '<img src="' . e($url) . '" style="max-width:100%;max-height:100%;object-fit:contain;" alt="Logotipo actual">' .
                                    '</div>' .
                                    '<div>' .
                                    '<strong style="display:block;font-size:13px;color:#1e293b;font-weight:600;">Logotipo activo de la empresa</strong>' .
                                    '<span style="font-size:12px;color:#64748b;">Si deseas reemplazarlo, selecciona o arrastra una nueva imagen a continuación.</span>' .
                                    '</div>' .
                                    '</div>'
                                ) : null;
                            })
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('logo_url')
                            ->label('Subir Logotipo de la Empresa')
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public')
                            ->maxSize(15360)
                            ->helperText('Selecciona o arrastra la imagen de tu logotipo (PNG, JPG, SVG o WEBP, hasta 15MB).')
                            ->hintIcon('heroicon-m-photo')
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Portada, Banner y Anuncios')
                    ->description('Imágenes de impacto y mensajes destacados.')
                    ->icon('heroicon-o-photo')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('banner_url')
                            ->label('URL del Banner / Imagen de Cabecera')
                            ->url()
                            ->placeholder('https://.../banner.jpg')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('hero_title')
                            ->label('Título de Portada')
                            ->placeholder('Calidad y diseño. Hecho para ti.')
                            ->maxLength(150),

                        Forms\Components\TextInput::make('hero_button_text')
                            ->label('Texto de Botón de Portada')
                            ->placeholder('Ver productos')
                            ->default('Ver productos')
                            ->maxLength(60),

                        Forms\Components\Textarea::make('hero_subtitle')
                            ->label('Subtítulo de Portada')
                            ->placeholder('Descripción introductoria del catálogo.')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('show_announcement')
                            ->label('Mostrar Barra de Anuncio Superior')
                            ->default(true),

                        Forms\Components\TextInput::make('announcement_text')
                            ->label('Texto de la Barra Superior')
                            ->placeholder('Envío sin costo en compras mayores a $50')
                            ->columnSpan(2),
                    ])->columns(3),

                Forms\Components\Section::make('Canales de Atención y Redes Sociales')
                    ->description('Número de WhatsApp para pedidos directos y perfiles sociales.')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('WhatsApp de la Tienda')
                            ->placeholder('+52 55 1234 5678')
                            ->helperText('Habilita el botón flotante de WhatsApp en la tienda pública.')
                            ->maxLength(30),

                        Forms\Components\TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->placeholder('https://instagram.com/...'),

                        Forms\Components\TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->placeholder('https://facebook.com/...'),

                        Forms\Components\TextInput::make('official_website_url')
                            ->label('Página Web Oficial del Negocio')
                            ->url()
                            ->placeholder('https://www.minegocio.com')
                            ->helperText('Enlace directo a la página web o portal oficial de la empresa.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('footer_text')
                            ->label('Pie de Página Personalizado')
                            ->placeholder('Todos los derechos reservados.')
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Ubicación Física en Zacatecas Centro')
                    ->description('Dirección física, zona comercial y coordenadas GPS para el mapa interactivo y pedidos por WhatsApp.')
                    ->icon('heroicon-o-map-pin')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Dirección Física')
                            ->placeholder('Av. Hidalgo #305, Centro Histórico')
                            ->maxLength(255),

                        Forms\Components\Select::make('neighborhood_zone')
                            ->label('Zona / Corredor Comercial')
                            ->options([
                                'Centro Histórico' => '🏛️ Centro Histórico',
                                'Av. Hidalgo' => '🚶 Av. Hidalgo',
                                'Calle Tacuba' => '🛍️ Calle Tacuba',
                                'Av. Juárez' => '🏬 Av. Juárez',
                                'Portal de Rosales' => '☕ Portal de Rosales',
                                'Av. González Ortega' => '🌳 Av. González Ortega',
                                'Zona Centro General' => '📍 Zona Centro General',
                            ])
                            ->default('Centro Histórico'),

                        Forms\Components\TextInput::make('city')
                            ->label('Ciudad')
                            ->default('Zacatecas')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitud GPS')
                            ->numeric()
                            ->placeholder('22.7753')
                            ->helperText('Ej: 22.7753 (Plaza de Armas)'),

                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitud GPS')
                            ->numeric()
                            ->placeholder('-102.5724')
                            ->helperText('Ej: -102.5724 (Plaza de Armas)'),

                        Forms\Components\TextInput::make('opening_hours')
                            ->label('Horario de Atención')
                            ->placeholder('Lun - Sáb: 9:00 AM - 8:30 PM')
                            ->maxLength(150),

                        Forms\Components\TextInput::make('location_reference')
                            ->label('Punto de Referencia')
                            ->placeholder('A media cuadra del Portal de Rosales')
                            ->maxLength(255)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('maps_url')
                            ->label('Enlace Directo Google Maps')
                            ->url()
                            ->placeholder('https://maps.google.com/?q=22.7753,-102.5724')
                            ->helperText('Enlace que se adjunta automáticamente en los pedidos enviados por WhatsApp.')
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Empresa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('domains.domain')
                    ->label('Subdominio')
                    ->badge()
                    ->placeholder('Sin dominio'),
                TextColumn::make('plan_name')
                    ->label('Plan Contratado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Corporativo' => 'warning',
                        'Crecimiento' => 'success',
                        default => 'info',
                    })
                    ->sortable(),
                TextColumn::make('neighborhood_zone')
                    ->label('Zona Zacatecas')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('billing_cycle')
                    ->label('Ciclo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'annual' => '💎 Anual (-20%)',
                        default => '📅 Mensual',
                    })
                    ->color(fn (string $state): string => $state === 'annual' ? 'success' : 'gray')
                    ->sortable(),
                TextColumn::make('subscription_status')
                    ->label('Estado Renta')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Activa',
                        'trial' => 'Prueba',
                        'past_due' => 'Vencida',
                        'cancelled' => 'Cancelada',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'trial' => 'info',
                        'past_due' => 'warning',
                        default => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Alta')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('plan_name')
                    ->label('Filtrar por Plan')
                    ->options([
                        'Emprendedor' => 'Plan Emprendedor',
                        'Crecimiento' => 'Plan Crecimiento',
                        'Corporativo' => 'Plan Corporativo',
                    ]),
                Tables\Filters\SelectFilter::make('billing_cycle')
                    ->label('Ciclo de Facturación')
                    ->options([
                        'monthly' => 'Mensual',
                        'annual' => 'Anual',
                    ]),
                Tables\Filters\SelectFilter::make('subscription_status')
                    ->label('Estado de la Renta')
                    ->options([
                        'active' => 'Activa',
                        'trial' => 'Prueba',
                        'past_due' => 'Vencida',
                        'cancelled' => 'Cancelada',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('visit_store')
                    ->label('Ver Tienda')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (Tenant $record): string => url('/tienda/' . strtolower($record->id)))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('visit_admin')
                    ->label('Panel Tienda')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->color('primary')
                    ->url(fn (Tenant $record): string => url('/tienda/' . strtolower($record->id) . '/admin'))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DomainsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
