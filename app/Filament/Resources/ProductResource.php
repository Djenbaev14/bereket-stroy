<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Imports\ProductImporter;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\DiscountType;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Unit;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\Contracts\Editable;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Milon\Barcode\DNS1D;
use Thiktak\FilamentNestedBuilderForm\Forms\Components\NestedBuilder;
use Thiktak\FilamentNestedBuilderForm\Forms\Components\NestedSubBuilder;

class ProductResource extends Resource
{
    use Translatable;
    protected static ?string $model = Product::class;
    
    protected static ?string $navigationGroup = 'Продукты';
    protected static ?int $navigationSort = 1;


    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Название товара')
                        ->schema([
                            TextInput::make('name')
                            ->required()
                            ->label('Название'),
                            TextInput::make('slug')->required()->label('Название')->hidden(),
                            TinyEditor::make('description')
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsDirectory('uploads')
                                ->profile('default|simple|full|minimal|none|custom')
                                ->label('Описание')
                                ->columnSpan('full')
                        ]),
                    Wizard\Step::make('Общая настройка')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Select::make('category_id')
                                    ->label('Категории')
                                    ->options(Category::all()->pluck('name', 'id'))
                                    ->afterStateUpdated(fn (callable $set) => $set('sub_category_id', null)) // Kategoriya o‘zgarsa subkategoriya tozalanadi
                                    ->reactive() // Kategoriya tanlanganda subcategory yangilansin
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(1),
                                    Select::make('sub_category_id')
                                        ->label('Подкатегории')
                                        ->options(fn (callable $get) => 
                                            SubCategory::where('category_id', $get('category_id'))->pluck('name', 'id') // Faqat tanlangan categoriyaga tegishlilari chiqadi
                                        )
                                        ->afterStateUpdated(fn (callable $set) => $set('sub_sub_category_id', null)) // Subkategoriya o‘zgarsa sub-subkategoriya tozalanadi
                                        ->disabled(fn (callable $get) => empty($get('category_id'))) // Category tanlanmaguncha subcategory disable bo‘ladi
                                        ->required()
                                        ->reactive() // Kategoriya tanlanganda subcategory yangilansin
                                        ->columnSpan(1),
                                    Select::make('sub_sub_category_id')
                                        ->label('Под Подкатегории')
                                        ->options(fn (callable $get) => 
                                            SubSubCategory::where('sub_category_id', $get('sub_category_id'))->pluck('name', 'id') // Faqat tanlangan categoriyaga tegishlilari chiqadi
                                        )
                                        ->required(fn (callable $get) => SubSubCategory::where('sub_category_id', $get('sub_category_id'))->exists()) // Agar sub_sub_category mavjud bo‘lsa required bo‘ladi
                                        ->disabled(fn (callable $get) => empty($get('sub_category_id'))) // Category tanlanmaguncha subcategory disable bo‘ladi
                                        ->columnSpan(1),
                                    Select::make('brand_id')
                                        ->label('Бренд')
                                        ->options(Brand::all()->pluck('name', 'id'))
                                        ->required()
                                        ->searchable()
                                        ->columnSpan(1),
                                    Select::make('country_id')
                                        ->label('Страна')
                                        ->options(Country::all()->pluck('name', 'id'))
                                        ->required()
                                        ->searchable()
                                        ->columnSpan(1),
                                    Select::make('unit_id')
                                        ->label('Единица')
                                        ->options(Unit::all()->pluck('name', 'id'))
                                        ->required()
                                        ->searchable()
                                        ->columnSpan(1),
                                ])      
                        ]),
                    Wizard\Step::make('Цены и другие')
                        ->schema([
                            Grid::make(2)
                            ->schema([
                                TextInput::make('price')->required()->numeric()->label('Цена')->placeholder('Цена')->columnSpan(1),
                                TextInput::make('min_order_qty')->required()->numeric()->placeholder('Минимальное количество заказов')->label('Минимальное количество заказов')->columnSpan(1),
                            ])
                        ]),
                    Wizard\Step::make('Настройка переменной товара')
                    ->schema([
                        Grid::make(12)
                            ->schema([
                                FileUpload::make('photos')
                                ->image()
                                ->label('Фото')
                                ->disk('public') 
                                ->directory('products') 
                                ->required()
                                ->multiple()
                                ->imageEditor()
                                ->reorderable()
                                ->minFiles(1)
                                ->maxFiles(5)
                                ->maxSize(5 * 1024)
                                ->imageEditorAspectRatios([
                                    '16:9',
                                    '4:3',
                                    '1:1',
                                ])
                                ->columnSpan(12),
                                // Repeater::make('attributes')
                                // ->relationship('product_attribute')
                                // ->label('Атрибуты')
                                //     ->schema([
                                //         Select::make('attribute_id')
                                //         ->label('Атрибут')
                                //         ->options(fn () => Attribute::pluck('name', 'id'))
                                //         ->required()
                                //         ->searchable(),
         
                                //     Select::make('color_id')
                                //         ->label('Цвет')
                                //         ->options(fn () => Color::all()->mapWithKeys(fn ($color) => [
                                //                 $color->id => "<div style='display: flex; align-items: center;'>
                                //                     <div style='width: 15px; height: 15px; background: {$color->hex}; margin-right: 8px; border-radius: 3px;'></div>
                                //                     {$color->name}
                                //                 </div>",
                                //         ])->toArray()) // ✅ toArray() qo‘shildi
                                //         ->required()
                                //         ->searchable()
                                //         ->allowHtml(),
                                //     TextInput::make('value')
                                //             ->label('Ценить')
                                //             ->placeholder('Ценить')
                                //             ->required(),
                                //     TextInput::make('price')
                                //         ->label('Прайс')
                                //         ->placeholder('Прайс')
                                //         ->required()
                                //     ])
                                // ->columnSpan(6),
                                
                                // Repeater::make('color_images')
                                // ->relationship('product_color_photo')
                                // ->label('Цветовые изображения')
                                // ->schema([
                                //     Select::make('color_id')
                                //         ->label('Rang')
                                //         ->options(fn () => Color::all()->mapWithKeys(fn ($color) => [
                                //                 $color->id => "<div style='display: flex; align-items: center;'>
                                //                     <div style='width: 15px; height: 15px; background: {$color->hex}; margin-right: 8px; border-radius: 3px;'></div>
                                //                     {$color->name}
                                //                 </div>",
                                //         ])->toArray()) // ✅ toArray() qo‘shildi
                                //         ->required()
                                //         ->searchable()
                                //         ->allowHtml(),

                                //     JsonMediaGallery::make('photos')
                                //         ->label('Загрузить дополнительное изображение')
                                //         ->directory('product_color_photos')
                                //         ->reorderable()
                                //         ->preserveFilenames()
                                //         ->acceptedFileTypes(['png','jpg','svg','jpeg'])
                                //         ->maxSize(4 * 1024)
                                //         ->maxFiles(3)
                                //         ->minFiles(1)
                                //         ->replaceNameByTitle() // If you want to show title (alt customProperties) against file name
                                //         ->image() // only images by default , u need to choose one (images or document)
                                //         ->downloadable()
                                //         ->deletable()
                                //         ->columnSpan(6),
                                // ])
                                // ->columnSpan(6),
                        ])->columnSpanFull()
                    ]),
                    
                ])->columnSpan(2)
            ]);
    }
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {

    //     return $data;
    // }
    public static function afterCreate($record, array $data)
    {
    }
    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ImportAction::make()
            ->importer(ProductImporter::class)
        ])
            ->columns([
                ImageColumn::make('photos')->circular()->stacked(),
                TextColumn::make('name')->label('Название')->searchable(),
                TextColumn::make('category.name')->label('Название категория')->searchable(),
                TextColumn::make('sub_category.name')->label('Название подкатегория')->searchable(),
                TextColumn::make('price')->label('Цена')
                ->formatStateUsing(function ($state) {
                    return number_format($state, 0, '.', ' ') . " сум";  // Masalan, 1000.50 ni 1,000.50 formatida
                })->searchable(),
                TextColumn::make('discounted_price')
                ->label('Цена со скидкой')
                ->getStateUsing(function (Product $record) {
                    if ($record->activeDiscount->isNotEmpty()) {
                        $discount = $record->activeDiscount->first();
                        if ($discount->discount_type === 'UZS') {
                            return number_format($record->price - $discount->discount_amount, 0, ',', ' ') . ' сум';
                        } else {
                            return number_format(round((100 - $discount->discount_amount) * $record->price / 100), 0, ',', ' ').  ' сум';
                        }
                    }
                    return 'Озини нархида'; 
                }),
                ToggleColumn::make('is_active')->label('В продаже'),
            ])
            ->defaultSort('id','desc')
            ->filters([

                // **Brand bo‘yicha filter**
                SelectFilter::make('brand_id')
                    ->label('Бренд')
                    ->searchable()
                    ->options(fn () => Brand::all()->pluck('name', 'id')->map(fn ($name) => json_decode($name, true)[app()->getLocale()] ?? $name))
                    ->preload(),

                // **Category bo‘yicha filter**
                SelectFilter::make('category_id')
                    ->label('Категория')
                    ->searchable()
                    ->options(fn () => Category::all()->pluck('name', 'id')->map(fn ($name) => json_decode($name, true)[app()->getLocale()] ?? $name))
                    ->preload(),

            Filter::make('price_range')
                ->form([
                    TextInput::make('min')
                        ->numeric()
                        ->label('Минимальная цена')
                        ->placeholder('100000'),
                    TextInput::make('max')
                        ->numeric()
                        ->label('Максимальная цена')
                        ->placeholder('500000'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['min'] ?? null, fn ($q, $min) => $q->where('price', '>=', $min))
                        ->when($data['max'] ?? null, fn ($q, $max) => $q->where('price', '<=', $max));
                }),
                // **Subcategory bo‘yicha filter**
                SelectFilter::make('sub_category_id')
                ->label('Подкатегория')
                ->searchable()
                ->options(fn () => SubCategory::all()->pluck('name', 'id')->map(fn ($name) => json_decode($name, true)[app()->getLocale()] ?? $name))
                ->preload(),
                SelectFilter::make('is_active')
                    ->label('В продаже')
                    ->options([
                            '1' => 'Активный',  // true
                            '0' => 'Неактивный', // false
                    ])
                    ->preload(),
                    ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationLabel(): string
    {
        return 'Продукты'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Продукты'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Продукты'; // Rus tilidagi ko'plik shakli
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
