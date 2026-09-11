<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use App\Models\TenantUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Ventas';

    protected static ?string $navigationLabel = 'Pedidos';

    protected static ?string $modelLabel = 'pedido';

    protected static ?string $pluralModelLabel = 'pedidos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información del Pedido y Cliente')
                            ->description('Detalles del comprador, entrega y método de cobro')
                            ->schema([
                                Forms\Components\TextInput::make('folio')
                                    ->label('Folio del Pedido')
                                    ->placeholder('Se asigna automáticamente al guardar')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->maxLength(60),

                                Forms\Components\Select::make('user_id')
                                    ->label('Cuenta Registrada (Opcional)')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?int $state) {
                                        if ($state) {
                                            $u = TenantUser::find($state);
                                            if ($u) {
                                                $set('customer_name', $u->name);
                                                $set('customer_email', $u->email);
                                            }
                                        }
                                    }),

                                Forms\Components\TextInput::make('customer_name')
                                    ->label('Nombre del Cliente')
                                    ->required()
                                    ->placeholder('Nombre completo del comprador')
                                    ->maxLength(150),

                                Forms\Components\TextInput::make('customer_phone')
                                    ->label('Teléfono / WhatsApp')
                                    ->tel()
                                    ->placeholder('Ej. 492 123 4567')
                                    ->maxLength(50),

                                Forms\Components\TextInput::make('customer_email')
                                    ->label('Correo Electrónico')
                                    ->email()
                                    ->placeholder('cliente@ejemplo.com')
                                    ->maxLength(150),

                                Forms\Components\Select::make('status')
                                    ->label('Estado del Pedido')
                                    ->options([
                                        'pending' => '⏳ Pendiente',
                                        'processing' => '📦 En Preparación',
                                        'completed' => '✅ Completado / Entregado',
                                        'cancelled' => '❌ Cancelado',
                                    ])
                                    ->default('pending')
                                    ->required(),

                                Forms\Components\Select::make('payment_method')
                                    ->label('Método de Pago')
                                    ->options([
                                        'efectivo' => '💵 Efectivo en Tienda / Entrega',
                                        'tarjeta' => '💳 Tarjeta Débito / Crédito',
                                        'spei' => '🏦 Transferencia SPEI',
                                        'whatsapp' => '💬 Coordinado por WhatsApp',
                                        'oxxo' => '🏪 OXXO / Depósito en Efectivo',
                                    ])
                                    ->default('efectivo')
                                    ->required(),

                                Forms\Components\Select::make('payment_status')
                                    ->label('Estado del Pago')
                                    ->options([
                                        'pending' => '⏳ Pendiente de Pago',
                                        'paid' => '✅ Pagado',
                                        'refunded' => '↩️ Reembolsado',
                                    ])
                                    ->default('pending')
                                    ->required(),

                                Forms\Components\TextInput::make('shipping_address')
                                    ->label('Dirección o Modalidad de Entrega')
                                    ->default('Recogida en Sucursal Zacatecas Centro')
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('order_notes')
                                    ->label('Notas / Instrucciones del Pedido')
                                    ->rows(2)
                                    ->placeholder('Instrucciones de empaque, regalos, horario de entrega, etc.')
                                    ->columnSpanFull(),
                            ])->columns(['default' => 1, 'md' => 3]),

                        Forms\Components\Section::make('Artículos del Pedido (Catálogo de la Tienda)')
                            ->description('Agrega los artículos que el cliente desea comprar directamente desde el catálogo')
                            ->schema([
                                Forms\Components\Repeater::make('items')
                                    ->relationship('items')
                                    ->label('Artículos Agregados')
                                    ->addActionLabel('＋ Agregar artículo de la tienda')
                                    ->reorderable(false)
                                    ->defaultItems(1)
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->label('Artículo de la Tienda')
                                            ->relationship('product', 'name')
                                            ->getOptionLabelFromRecordUsing(function (Product $record) {
                                                $stockLabel = $record->stock > 0 ? "Stock: {$record->stock}" : "Agotado";
                                                $catName = $record->category ? " [{$record->category->name}]" : "";
                                                return "{$record->name}{$catName} — $" . number_format((float)$record->price, 2) . " ({$stockLabel})";
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (Set $set, Get $get, ?int $state) {
                                                if ($state) {
                                                    $product = Product::find($state);
                                                    if ($product) {
                                                        $set('price', (float)$product->price);
                                                        $set('product_name', $product->name);
                                                    }
                                                }
                                                static::recalculateTotal($get, $set);
                                            })
                                            ->columnSpan(['default' => 12, 'md' => 5]),

                                        Forms\Components\Hidden::make('product_name')
                                            ->dehydrated(true),

                                        Forms\Components\TextInput::make('quantity')
                                            ->label('Cantidad')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->required()
                                            ->live(debounce: 250)
                                            ->afterStateUpdated(function (Set $set, Get $get) {
                                                static::recalculateTotal($get, $set);
                                            })
                                            ->columnSpan(['default' => 6, 'md' => 2]),

                                        Forms\Components\TextInput::make('price')
                                            ->label('Precio Unit.')
                                            ->numeric()
                                            ->prefix('$')
                                            ->required()
                                            ->live(debounce: 250)
                                            ->afterStateUpdated(function (Set $set, Get $get) {
                                                static::recalculateTotal($get, $set);
                                            })
                                            ->columnSpan(['default' => 6, 'md' => 2]),

                                        Forms\Components\Placeholder::make('line_total')
                                            ->label('Subtotal')
                                            ->content(function (Get $get) {
                                                $qty = (int) ($get('quantity') ?: 1);
                                                $price = (float) ($get('price') ?: 0);
                                                return '$' . number_format($qty * $price, 2);
                                            })
                                            ->columnSpan(['default' => 12, 'md' => 3]),
                                    ])
                                    ->columns(12)
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        static::recalculateTotal($get, $set);
                                    })
                                    ->columnSpanFull(),

                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Placeholder::make('spacer')
                                            ->hiddenLabel()
                                            ->content('')
                                            ->columnSpan(['default' => 0, 'md' => 2]),
                                        Forms\Components\TextInput::make('total_amount')
                                            ->label('Monto Total a Pagar')
                                            ->numeric()
                                            ->prefix('$')
                                            ->required()
                                            ->default(0.00)
                                            ->helperText('Se calcula automáticamente de los artículos agregados.')
                                            ->columnSpan(['default' => 12, 'md' => 1]),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function recalculateTotal(Get $get, Set $set): void
    {
        $items = $get('items') ?? $get('../../items') ?? [];
        $total = 0;
        if (is_array($items)) {
            foreach ($items as $item) {
                $qty = (int) ($item['quantity'] ?? 1);
                $price = (float) ($item['price'] ?? 0);
                $total += $qty * $price;
            }
        }

        $formatted = number_format($total, 2, '.', '');
        $set('total_amount', $formatted);
        $set('../../total_amount', $formatted);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->label('# Folio')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Folio copiado')
                    ->default(fn (Order $record) => '#' . $record->id),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->description(fn (Order $record) => $record->customer_phone ?: ($record->customer_email ?: $record->user?->email))
                    ->default(fn (Order $record) => $record->user?->name ?? 'Cliente Mostrador'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => '⏳ Pendiente',
                        'processing' => '📦 En Preparación',
                        'completed' => '✅ Completado',
                        'cancelled' => '❌ Cancelado',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pago')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'gray' => 'refunded',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'paid' => 'Pagado',
                        'refunded' => 'Reembolsado',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Método')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'efectivo', 'cash' => '💵 Efectivo',
                        'tarjeta', 'card' => '💳 Tarjeta',
                        'spei' => '🏦 SPEI',
                        'whatsapp' => '💬 WhatsApp',
                        'oxxo' => '🏪 OXXO',
                        default => $state ?? 'Efectivo',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('USD')
                    ->weight('bold')
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Artículos')
                    ->counts('items')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filtrar por Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'processing' => 'En Preparación',
                        'completed' => 'Completado',
                        'cancelled' => 'Cancelado',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Filtrar por Pago')
                    ->options([
                        'pending' => 'Pendiente',
                        'paid' => 'Pagado',
                        'refunded' => 'Reembolsado',
                    ]),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
