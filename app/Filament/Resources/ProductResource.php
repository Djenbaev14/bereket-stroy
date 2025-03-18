<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\ProductResource\Pages;
use App\Imports\ProductImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Unit;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

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
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('photos')->circular()->stacked(),
                TextColumn::make('name')->label('Название')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Название категория')->searchable()->sortable(),
                TextColumn::make('sub_category.name')->label('Название подкатегория')->searchable()->sortable(),
                TextColumn::make('price')->label('Цена')
                ->formatStateUsing(function ($state) {
                    return number_format($state, 0, '.', ' ') . " сум";  // Masalan, 1000.50 ni 1,000.50 formatida
                })->searchable()->sortable(),
                TextColumn::make('discounted_price')
                ->label('Цена со скидкой')
                ->getStateUsing(function (Product $record) {
                    if ($record->activeDiscount) {
                        return number_format($record->activeDiscount->discounted_price, 0, ',', ' ') . ' сум';
                    }
                    return 'Озини нархида'; 
                }),
                ToggleColumn::make('is_active')
                ->label('В продаже')
                ->afterStateUpdated(function ($record, $state) {
                    if ($state) {
                        Notification::make()
                            ->title('Mahsulot yoqildi')
                            ->success()
                            ->body($record->name . ' savdoga qo\'yildi.')
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Mahsulot o‘chirildi')
                            ->danger()
                            ->body($record->name . ' savdodan o‘chirildi.')
                            ->send();
                    }
                }),
            ])
            ->defaultPaginationPageOption(50)
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
                    
                SelectFilter::make('sub_category_id')
                    ->label('Подкатегория')
                    ->searchable()
                    ->options(fn ($get) => 
                        $get('category_id')
                            ? SubCategory::where('category_id', $get('category_id'))
                                ->pluck('name', 'id')
                                ->map(fn ($name) => json_decode($name, true)[app()->getLocale()] ?? $name)
                            : []
                    )
                    ->hidden(fn ($get) => !$get('category_id'))
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
                Filter::make('discounted')
                    ->label('Только товары со скидкой')
                    ->columnSpan('full')
                    ->query(fn ($query) => $query->whereHas('activeDiscount'))
                    ], layout: FiltersLayout::AboveContent)
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
