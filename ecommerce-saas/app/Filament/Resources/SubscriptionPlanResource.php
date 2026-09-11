<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionPlanResource\Pages;
use App\Models\SubscriptionPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class SubscriptionPlanResource extends Resource
{
    protected static ?string $model = SubscriptionPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Planes de Suscripción';

    protected static ?string $modelLabel = 'plan de suscripción';

    protected static ?string $pluralModelLabel = 'planes de suscripción';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Plan')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre del Plan')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Ej. Plan Crecimiento'),

                        Forms\Components\TextInput::make('slug')
                            ->label('Identificador (Slug)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->alphaDash()
                            ->maxLength(60)
                            ->placeholder('crecimiento'),

                        Forms\Components\TextInput::make('badge')
                            ->label('Insignia / Distintivo')
                            ->placeholder('Ej. Más Popular, Más Económico'),

                        Forms\Components\TextInput::make('tagline')
                            ->label('Descripción Corta')
                            ->placeholder('Para negocios en expansión')
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Precios y Descuentos')
                    ->schema([
                        Forms\Components\TextInput::make('monthly_price')
                            ->label('Precio Mensual (USD)')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->placeholder('39.00'),

                        Forms\Components\TextInput::make('annual_price_per_month')
                            ->label('Precio Mensual en Pago Anual (USD)')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->placeholder('31.00'),

                        Forms\Components\TextInput::make('annual_discount_percentage')
                            ->label('% Descuento Anual')
                            ->numeric()
                            ->default(20)
                            ->suffix('%'),

                        Forms\Components\TextInput::make('currency')
                            ->label('Moneda')
                            ->default('USD')
                            ->maxLength(10),
                    ])->columns(4),

                Forms\Components\Section::make('Límites y Características Técnicas')
                    ->schema([
                        Forms\Components\TextInput::make('product_limit')
                            ->label('Límite de Productos')
                            ->numeric()
                            ->placeholder('Dejar vacío para ilimitados')
                            ->helperText('Dejar vacío si el plan incluye productos ilimitados.'),

                        Forms\Components\Toggle::make('has_custom_domain')
                            ->label('Permite Dominio Propio')
                            ->default(false),

                        Forms\Components\Toggle::make('has_priority_support')
                            ->label('Soporte Prioritario')
                            ->default(false),

                        Forms\Components\Toggle::make('has_analytics')
                            ->label('Métricas y Analíticas')
                            ->default(true),

                        Forms\Components\Toggle::make('has_api_access')
                            ->label('Acceso a API / Sanctum')
                            ->default(true),

                        Forms\Components\Toggle::make('is_popular')
                            ->label('Destacar como Popular')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Plan Activo para Nuevas Rentas')
                            ->default(true),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Orden de Visualización')
                            ->numeric()
                            ->default(0),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Plan')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('badge')
                    ->label('Insignia')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('monthly_price')
                    ->label('Precio Mensual')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('annual_price_per_month')
                    ->label('Mes (Anual)')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('product_limit')
                    ->label('Productos')
                    ->formatStateUsing(fn ($state) => $state ? "{$state} máx." : 'Ilimitados'),

                IconColumn::make('is_popular')
                    ->label('Popular')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptionPlans::route('/'),
            'create' => Pages\CreateSubscriptionPlan::route('/create'),
            'edit' => Pages\EditSubscriptionPlan::route('/{record}/edit'),
        ];
    }
}