<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerfumeResource\Pages;
use App\Models\Perfume;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PerfumeResource extends Resource
{
    protected static ?string $model = Perfume::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Perfume Details')
                    ->tabs([
                        // Tab 1: General Info
                        Forms\Components\Tabs\Tab::make('General Information')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('brand_id')
                                            ->relationship('brand', 'name_en')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Forms\Components\TextInput::make('name_en')
                                            ->label('Perfume Name (English)')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                            )
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('name_ar')
                                            ->label('Perfume Name (Arabic)')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),
                                    ]),
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\Select::make('gender')
                                            ->options([
                                                'male' => 'Male',
                                                'female' => 'Female',
                                                'unisex' => 'Unisex',
                                            ])
                                            ->required(),
                                        Forms\Components\Select::make('concentration')
                                            ->options([
                                                'EDC' => 'Eau de Cologne (EDC)',
                                                'EDT' => 'Eau de Toilette (EDT)',
                                                'EDP' => 'Eau de Parfum (EDP)',
                                                'Parfum' => 'Parfum',
                                                'Extrait' => 'Extrait de Parfum',
                                            ])
                                            ->required(),
                                        Forms\Components\TextInput::make('size_ml')
                                            ->label('Size (ml)')
                                            ->required()
                                            ->numeric()
                                            ->minValue(1),
                                        Forms\Components\Select::make('stock_status')
                                            ->options([
                                                'in_stock' => 'In Stock',
                                                'out_of_stock' => 'Out of Stock',
                                                'pre_order' => 'Pre Order',
                                            ])
                                            ->default('in_stock')
                                            ->required(),
                                    ]),
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\TextInput::make('price')
                                            ->required()
                                            ->numeric()
                                            ->prefix('$'),
                                        Forms\Components\TextInput::make('old_price')
                                            ->numeric()
                                            ->prefix('$'),
                                        Forms\Components\Toggle::make('pre_order')
                                            ->label('Allow Pre-Order')
                                            ->default(false),
                                        Forms\Components\TextInput::make('delivery_days')
                                            ->label('Delivery Days')
                                            ->required()
                                            ->numeric()
                                            ->default(3),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Active')
                                            ->default(true),
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('Featured Product')
                                            ->default(false),
                                    ]),
                            ]),

                        // Tab 2: Descriptions & Media
                        Forms\Components\Tabs\Tab::make('Descriptions & Media')
                            ->schema([
                                Forms\Components\Textarea::make('short_description_en')
                                    ->label('Short Description (English)')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('short_description_ar')
                                    ->label('Short Description (Arabic)')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('long_description_en')
                                    ->label('Long Description (English)')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('long_description_ar')
                                    ->label('Long Description (Arabic)')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('source_url')
                                    ->label('Source URL (e.g. Fragrantica link)')
                                    ->url()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\Section::make('Product Images')
                                    ->schema([
                                        Forms\Components\Repeater::make('images')
                                            ->relationship('images')
                                            ->schema([
                                                Forms\Components\FileUpload::make('image_path')
                                                    ->image()
                                                    ->directory('perfumes')
                                                    ->required(),
                                                Forms\Components\Toggle::make('is_primary')
                                                    ->label('Primary Image')
                                                    ->default(false),
                                                Forms\Components\TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->required(),
                                            ])
                                            ->columns(3)
                                            ->grid(2)
                                            ->defaultItems(1)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // Tab 3: Fragrantica Scent Profile
                        Forms\Components\Tabs\Tab::make('Fragrance Profile & Stats')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('perfumer')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('year_launched')
                                            ->numeric()
                                            ->minValue(1700)
                                            ->maxValue(date('Y') + 5),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Select::make('longevity')
                                            ->options([
                                                'very_weak' => 'Very Weak',
                                                'weak' => 'Weak',
                                                'moderate' => 'Moderate',
                                                'long_lasting' => 'Long Lasting',
                                                'eternal' => 'Eternal',
                                            ]),
                                        Forms\Components\Select::make('sillage')
                                            ->options([
                                                'intimate' => 'Intimate',
                                                'moderate' => 'Moderate',
                                                'strong' => 'Strong',
                                                'enormous' => 'Enormous',
                                            ]),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\CheckboxList::make('season')
                                            ->options([
                                                'spring' => 'Spring',
                                                'summer' => 'Summer',
                                                'autumn' => 'Autumn',
                                                'winter' => 'Winter',
                                            ])
                                            ->columns(2),
                                        Forms\Components\CheckboxList::make('occasion')
                                            ->options([
                                                'day' => 'Day',
                                                'night' => 'Night',
                                                'business' => 'Business',
                                                'casual' => 'Casual',
                                                'formal' => 'Formal',
                                            ])
                                            ->columns(2),
                                    ]),
                                Forms\Components\Section::make('Fragrance Notes')
                                    ->description('Configure the Top, Middle, and Base notes for this fragrance')
                                    ->schema([
                                        Forms\Components\Repeater::make('perfumeNotes')
                                            ->relationship('perfumeNotes')
                                            ->schema([
                                                Forms\Components\Select::make('note_id')
                                                    ->label('Note')
                                                    ->relationship('note', 'name_en')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                                Forms\Components\Select::make('type')
                                                    ->label('Pyramid Layer')
                                                    ->options([
                                                        'top' => 'Top Note (Head)',
                                                        'middle' => 'Middle Note (Heart)',
                                                        'base' => 'Base Note (Dry-down)',
                                                    ])
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->grid(2)
                                            ->columnSpanFull(),
                                    ]),
                                Forms\Components\Section::make('Main Accords')
                                    ->description('Configure the accords and their percentage intensity')
                                    ->schema([
                                        Forms\Components\Repeater::make('perfumeAccords')
                                            ->relationship('perfumeAccords')
                                            ->schema([
                                                Forms\Components\Select::make('accord_id')
                                                    ->label('Accord')
                                                    ->relationship('accord', 'name_en')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                                Forms\Components\TextInput::make('intensity')
                                                    ->label('Intensity %')
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->maxValue(100)
                                                    ->default(100)
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->grid(2)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images.image_path')
                    ->label('Thumbnail')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (EN)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('Name (AR)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name_en')
                    ->label('Brand')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                        'unisex' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('concentration')
                    ->sortable(),
                Tables\Columns\TextColumn::make('size_ml')
                    ->label('Size (ml)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Featured'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')
                    ->relationship('brand', 'name_en'),
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'unisex' => 'Unisex',
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
            'index' => Pages\ListPerfumes::route('/'),
            'create' => Pages\CreatePerfume::route('/create'),
            'edit' => Pages\EditPerfume::route('/{record}/edit'),
        ];
    }
}
