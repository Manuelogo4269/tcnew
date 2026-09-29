<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use App\Models\Product;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Citas y Servicios';

    protected static ?string $navigationLabel = 'Agenda y Citas';

    protected static ?string $modelLabel = 'cita';

    protected static ?string $pluralModelLabel = 'citas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles de la Cita')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Servicio Ofrecido')
                            ->options(Product::where('is_service', true)->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?int $state) {
                                if ($state) {
                                    $product = Product::find($state);
                                    if ($product) {
                                        $set('service_name', $product->name);
                                        $set('price', $product->price);
                                        $set('duration_minutes', $product->duration_minutes ?? 30);
                                    }
                                }
                            }),
                        Forms\Components\TextInput::make('service_name')
                            ->label('Nombre del Servicio')
                            ->required()
                            ->maxLength(150),
                        Forms\Components\Select::make('staff_id')
                            ->label('Especialista / Profesional')
                            ->relationship('staff', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\DateTimePicker::make('scheduled_at')
                            ->label('Fecha y Hora de Inicio')
                            ->required()
                            ->seconds(false)
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state, Forms\Get $get) {
                                if ($state) {
                                    $dur = (int) ($get('duration_minutes') ?: 30);
                                    $start = \Carbon\Carbon::parse($state);
                                    $set('end_at', $start->copy()->addMinutes($dur)->toDateTimeString());
                                }
                            }),
                        Forms\Components\DateTimePicker::make('end_at')
                            ->label('Hora de Finalización Estimada')
                            ->required()
                            ->seconds(false),
                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('Duración (minutos)')
                            ->numeric()
                            ->default(30)
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->label('Precio ($ MXN)')
                            ->numeric()
                            ->prefix('$')
                            ->default(0.00)
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('Estado de la Cita')
                            ->options(Appointment::statusLabels())
                            ->default(Appointment::STATUS_CONFIRMED)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Información del Cliente')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nombre del Cliente')
                            ->required()
                            ->maxLength(120),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Teléfono / WhatsApp')
                            ->tel()
                            ->required()
                            ->maxLength(30),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->maxLength(120),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notas Adicionales / Requerimientos')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->description(fn (Appointment $record) => $record->customer_phone),
                Tables\Columns\TextColumn::make('service_name')
                    ->label('Servicio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('staff.name')
                    ->label('Especialista')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('MXN')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Appointment::statusLabels()[$state] ?? ucfirst($state))
                    ->color(fn (string $state) => Appointment::statusColors()[$state] ?? 'gray'),
            ])
            ->defaultSort('scheduled_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options(Appointment::statusLabels()),
                Tables\Filters\SelectFilter::make('staff_id')
                    ->label('Especialista')
                    ->relationship('staff', 'name'),
            ])
            ->actions([
                // Quick status action buttons
                Tables\Actions\Action::make('markInService')
                    ->label('En Servicio')
                    ->icon('heroicon-o-play')
                    ->color('primary')
                    ->visible(fn (Appointment $r) => in_array($r->status, [Appointment::STATUS_PENDING, Appointment::STATUS_CONFIRMED]))
                    ->action(fn (Appointment $r) => $r->update(['status' => Appointment::STATUS_IN_SERVICE])),

                Tables\Actions\Action::make('markCompleted')
                    ->label('Completar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Appointment $r) => in_array($r->status, [Appointment::STATUS_CONFIRMED, Appointment::STATUS_IN_SERVICE]))
                    ->action(fn (Appointment $r) => $r->update(['status' => Appointment::STATUS_COMPLETED])),

                Tables\Actions\Action::make('markCancelled')
                    ->label('Cancelar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Appointment $r) => in_array($r->status, [Appointment::STATUS_PENDING, Appointment::STATUS_CONFIRMED]))
                    ->action(fn (Appointment $r) => $r->update(['status' => Appointment::STATUS_CANCELLED])),

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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
