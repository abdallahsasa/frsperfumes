<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                                    ->dehydrated(false)
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
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                            ])
                            ->columnSpan(1),

                        // Full width: Order Items
                        Forms\Components\Section::make('Order Items')
                            ->schema([
                                Forms\Components\Repeater::make('items')
                                    ->relationship('items')
                                    ->schema([
                                        Forms\Components\TextInput::make('brand_name')
                                            ->label('Brand')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('perfume_name')
                                            ->label('Perfume')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('size_ml')
                                            ->label('Size (ml)')
                                            ->numeric()
                                            ->disabled(),
                                        Forms\Components\TextInput::make('quantity')
                                            ->numeric()
                                            ->disabled(),
                                        Forms\Components\TextInput::make('price')
                                            ->numeric()
                                            ->prefix('$')
                                            ->disabled(),
                                    ])
                                    ->columns(5)
                                    ->addable(false)
                                    ->deletable(false)
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
