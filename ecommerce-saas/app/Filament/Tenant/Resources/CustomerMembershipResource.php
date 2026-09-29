<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\CustomerMembershipResource\Pages;
use App\Models\CustomerMembership;
use App\Models\MembershipPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CustomerMembershipResource extends Resource
{
    protected static ?string $model = CustomerMembership::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Membresías';

    protected static ?string $navigationLabel = 'Socios y Credenciales';

    protected static ?string $modelLabel = 'membresía de socio';

    protected static ?string $pluralModelLabel = 'membresías de socios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del Socio')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nombre del Socio')
                            ->required()
                            ->maxLength(120),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->maxLength(120),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Teléfono / WhatsApp')
                            ->tel()
                            ->maxLength(30),
                        Forms\Components\TextInput::make('membership_code')
                            ->label('Código Digital de Membresía')
                            ->default(fn () => 'MEM-' . strtoupper(Str::random(6)))
                            ->required()
                            ->unique(ignoreRecord: true),
                    ])->columns(2),

                Forms\Components\Section::make('Plan y Vigencia')
                    ->schema([
                        Forms\Components\Select::make('membership_plan_id')
                            ->label('Plan Asignado')
                            ->relationship('plan', 'name')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?int $state, Forms\Get $get) {
                                if ($state) {
                                    $plan = MembershipPlan::find($state);
                                    if ($plan) {
                                        $startDate = $get('start_date') ? \Carbon\Carbon::parse($get('start_date')) : now();
                                        $set('end_date', $startDate->copy()->addDays($plan->duration_days)->toDateString());
                                    }
                                }
                            }),
                        Forms\Components\Select::make('status')
                            ->label('Estado de Membresía')
                            ->options([
                                'active' => 'Activa (Vigente)',
                                'expired' => 'Vencida',
                                'suspended' => 'Suspendida',
                                'cancelled' => 'Cancelada',
                            ])
                            ->default('active')
                            ->required(),
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Fecha de Inicio')
                            ->default(now()->toDateString())
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Fecha de Vencimiento')
                            ->default(now()->addDays(30)->toDateString())
                            ->required(),
                        Forms\Components\TextInput::make('visits_used')
                            ->label('Visitas / Sesiones Registradas')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('accumulated_points')
                            ->label('Puntos Acumulados')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notas / Observaciones del Cliente')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('membership_code')
                    ->label('Folio / QR')
                    ->badge()
                    ->color('primary')
                    ->copyable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Socio')
                    ->searchable()
                    ->description(fn (CustomerMembership $r) => $r->customer_email),
                Tables\Columns\TextColumn::make('plan.name')
                    ->label('Plan')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Vence')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn (CustomerMembership $r) => now()->gt($r->end_date) ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('visits_used')
                    ->label('Visitas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('accumulated_points')
                    ->label('Puntos')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'expired',
                        'warning' => 'suspended',
                        'gray' => 'cancelled',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Activas',
                        'expired' => 'Vencidas',
                        'suspended' => 'Suspendidas',
                    ]),
                Tables\Filters\SelectFilter::make('membership_plan_id')
                    ->relationship('plan', 'name')
                    ->label('Plan'),
            ])
            ->actions([
                Tables\Actions\Action::make('recordVisit')
                    ->label('Registrar Visita')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Registrar Visita del Socio')
                    ->modalDescription('Se sumará 1 visita utilizada y se otorgarán puntos de recompensa automáticamente.')
                    ->action(function (CustomerMembership $record) {
                        $record->recordVisit();
                        \Filament\Notifications\Notification::make()
                            ->title('Visita Registrada')
                            ->body("Se registró la visita para {$record->customer_name}. Puntos acumulados: {$record->accumulated_points}")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('renew')
                    ->label('Renovar (+30d)')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(function (CustomerMembership $record) {
                        $newEnd = ($record->end_date && $record->end_date->isFuture()) 
                            ? $record->end_date->copy()->addDays(30)
                            : now()->addDays(30);

                        $record->update([
                            'end_date' => $newEnd,
                            'status' => 'active',
                        ]);

                        $record->logs()->create([
                            'type' => 'renewal',
                            'description' => 'Renovación de membresía por 30 días adicionales',
                            'performed_at' => now(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Membresía Renovada')
                            ->body("Nueva fecha de vencimiento: {$newEnd->format('d/m/Y')}")
                            ->success()
                            ->send();
                    }),

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
            'index' => Pages\ListCustomerMemberships::route('/'),
            'create' => Pages\CreateCustomerMembership::route('/create'),
            'edit' => Pages\EditCustomerMembership::route('/{record}/edit'),
        ];
    }
}
