<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Perfume;
use Filament\Forms\Set;
use Filament\Forms\Get;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        // Left: Customer details (2 cols)
                        Forms\Components\Section::make('Customer Information')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('customer_name')
                                            ->required(),
                                        Forms\Components\TextInput::make('phone')
                                            ->tel()
                                            ->required(),
                                        Forms\Components\TextInput::make('whatsapp')
                                            ->label('WhatsApp Number')
                                            ->tel()
                                            ->required(),
                                        Forms\Components\TextInput::make('city')
                                            ->required(),
                                        Forms\Components\TextInput::make('area')
                                            ->required(),
                                    ]),
                                Forms\Components\Textarea::make('full_address')
                                    ->required()
                                    ->rows(3),
                                Forms\Components\Textarea::make('notes')
                                    ->label('Customer Order Notes')
                                    ->rows(2),
                            ])
                            ->columnSpan(2),

                        // Right: Order Status & Details (1 col)
                        Forms\Components\Section::make('Order Meta')
                            ->schema([
                                Forms\Components\TextInput::make('order_number')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->default(fn () => 'ORD-' . strtoupper(uniqid()))
                                    ->unique(ignoreRecord: true)
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'confirmed' => 'Confirmed',
                                        'delivered' => 'Delivered',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required()
                                    ->native(false),
                                Forms\Components\TextInput::make('total_price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0)
                                    ->required(),
                            ])
                            ->columnSpan(1),

                        // Full width: Order Items
                        Forms\Components\Section::make('Order Items')
                            ->schema([
                                Forms\Components\Repeater::make('items')
                                    ->relationship('items')
                                    ->schema([
                                        Forms\Components\Select::make('perfume_id')
                                            ->label('Select Perfume')
                                            ->options(Perfume::query()->pluck('name_en', 'id'))
                                            ->searchable()
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function ($state, Set $set) {
                                                if ($state) {
                                                    $perfume = Perfume::with('brand')->find($state);
                                                    if ($perfume) {
                                                        $set('perfume_name', $perfume->name_en);
                                                        $set('brand_name', $perfume->brand?->name ?? 'Unknown');
                                                        $set('size_ml', $perfume->size_ml);
                                                        $set('price', $perfume->price);
                                                    }
                                                }
                                            }),
                                        Forms\Components\TextInput::make('brand_name')
                                            ->label('Brand')
                                            ->readOnly()
                                            ->required(),
                                        Forms\Components\TextInput::make('perfume_name')
                                            ->label('Perfume')
                                            ->readOnly()
                                            ->required(),
                                        Forms\Components\TextInput::make('size_ml')
                                            ->label('Size (ml)')
                                            ->numeric()
                                            ->readOnly(),
                                        Forms\Components\TextInput::make('quantity')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live(debounce: 500)
                                            ->required(),
                                        Forms\Components\TextInput::make('price')
                                            ->numeric()
                                            ->live(debounce: 500)
                                            ->required(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(1)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $items = $get('items');
                                        $total = 0;
                                        if (is_array($items)) {
                                            foreach ($items as $item) {
                                                $price = floatval($item['price'] ?? 0);
                                                $qty = intval($item['quantity'] ?? 1);
                                                $total += $price * $qty;
                                            }
                                        }
                                        $set('total_price', $total);
                                    })
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
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
        return [];
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
