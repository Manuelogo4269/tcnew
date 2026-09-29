<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\MembershipPlanResource\Pages;
use App\Models\MembershipPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MembershipPlanResource extends Resource
{
    protected static ?string $model = MembershipPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Membresías';

    protected static ?string $navigationLabel = 'Planes de Membresía';

    protected static ?string $modelLabel = 'plan de membresía';

    protected static ?string $pluralModelLabel = 'planes de membresía';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configuración del Plan')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre del Plan')
                            ->required()
                            ->maxLength(120)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('price')
                            ->label('Precio de Venta ($ MXN)')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                        Forms\Components\TextInput::make('duration_days')
                            ->label('Vigencia (Días)')
                            ->numeric()
                            ->default(30)
                            ->helperText('Ej: 30 (mensual), 90 (trimestral), 365 (anual)')
                            ->required(),
                        Forms\Components\TextInput::make('visits_included')
                            ->label('Visitas / Sesiones Incluidas')
                            ->numeric()
                            ->default(0)
                            ->helperText('0 = Visitas ilimitadas. >0 = Paquete de N sesiones.')
                            ->required(),
                        Forms\Components\TextInput::make('points_multiplier')
                            ->label('Multiplicador de Puntos')
                            ->numeric()
                            ->default(1.00)
                            ->helperText('Puntos ganados por cada peso o visita (ej: 1.5x, 2.0x)')
                            ->required(),
                        Forms\Components\ColorPicker::make('badge_color')
                            ->label('Color Distintivo de Tarjeta')
                            ->default('#d96b45'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Plan Disponible al Público')
                            ->default(true),
                        Forms\Components\TagsInput::make('perks_json')
                            ->label('Beneficios y Perks (Lista)')
                            ->placeholder('Escribe un beneficio y presiona Enter')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Descripción / Condiciones del Plan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('badge_color')
                    ->label('Color'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('MXN')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('Vigencia')
                    ->formatStateUsing(fn ($state) => "{$state} días")
                    ->sortable(),
                Tables\Columns\TextColumn::make('visits_included')
                    ->label('Sesiones')
                    ->formatStateUsing(fn ($state) => $state == 0 ? 'Ilimitadas' : "{$state} sesiones"),
                Tables\Columns\TextColumn::make('customer_memberships_count')
                    ->label('Socios')
                    ->counts('customerMemberships')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Estado Activo'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMembershipPlans::route('/'),
            'create' => Pages\CreateMembershipPlan::route('/create'),
            'edit' => Pages\EditMembershipPlan::route('/{record}/edit'),
        ];
    }
}
