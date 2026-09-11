<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Reseñas & Opiniones';

    protected static ?string $modelLabel = 'reseña';

    protected static ?string $pluralModelLabel = 'reseñas';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalle de la Reseña')
                    ->schema([
                        Forms\Components\TextInput::make('author_name')
                            ->label('Cliente / Autor')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('rating')
                            ->label('Calificación (Estrellas 1 a 5)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->required(),

                        Forms\Components\Select::make('reviewable_type')
                            ->label('Tipo de Destino')
                            ->options([
                                'company' => 'Empresa / Tienda',
                                'product' => 'Producto Específico',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('reviewable_id')
                            ->label('ID de Empresa o Slug del Producto')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\Textarea::make('comment')
                            ->label('Comentario / Opinión')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('verified_purchase')
                            ->label('Compra Verificada')
                            ->default(true),

                        Forms\Components\Toggle::make('is_approved')
                            ->label('Aprobada / Visible en la Plataforma')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('author_name')
                    ->label('Cliente')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('rating')
                    ->label('Puntaje')
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state) . str_repeat('☆', 5 - (int) $state))
                    ->sortable(),

                TextColumn::make('reviewable_type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn ($state) => $state === 'company' ? 'info' : 'success'),

                TextColumn::make('reviewable_id')
                    ->label('Destino')
                    ->searchable(),

                TextColumn::make('comment')
                    ->label('Comentario')
                    ->limit(50),

                IconColumn::make('is_approved')
                    ->label('Aprobada')
                    ->boolean(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('reviewable_type')
                    ->options([
                        'company' => 'Empresa',
                        'product' => 'Producto',
                    ]),
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Estado de Aprobación'),
            ])
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
            'index' => Pages\ListReviews::route('/'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}