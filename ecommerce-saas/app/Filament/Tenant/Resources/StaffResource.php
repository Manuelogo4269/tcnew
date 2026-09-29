<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\StaffResource\Pages;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Citas y Servicios';

    protected static ?string $navigationLabel = 'Personal / Especialistas';

    protected static ?string $modelLabel = 'especialista';

    protected static ?string $pluralModelLabel = 'especialistas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Especialista')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre Completo')
                            ->required()
                            ->maxLength(120),
                        Forms\Components\TextInput::make('role')
                            ->label('Cargo / Especialidad')
                            ->required()
                            ->default('Especialista')
                            ->placeholder('Ej: Estilista Master, Barbero, Terapeuta'),
                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->maxLength(120),
                        Forms\Components\TextInput::make('phone')
                            ->label('Teléfono / WhatsApp')
                            ->tel()
                            ->maxLength(30),
                        Forms\Components\TextInput::make('photo_url')
                            ->label('URL de Fotografía')
                            ->url()
                            ->placeholder('https://.../foto.jpg'),
                        Forms\Components\Textarea::make('bio')
                            ->label('Biografía / Experiencia')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('services')
                            ->label('Servicios que Atiende')
                            ->relationship('services', 'name')
                            ->multiple()
                            ->preload()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Activo para Citas')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('/app-icons/icon-192.png'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('role')
                    ->label('Especialidad')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Contacto'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Disponible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('appointments_count')
                    ->label('Citas')
                    ->counts('appointments')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Disponibilidad'),
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
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
        ];
    }
}
