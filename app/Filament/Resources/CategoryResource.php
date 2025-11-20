<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers\SubcategoriesRelationManager;
use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Mansoor\UnsplashPicker\Actions\UnsplashPickerAction;

class CategoryResource extends Resource
{
    use Translatable;
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Продукты';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    TextInput::make('name')
                        ->label('Название Категория')
                        ->placeholder('Название Категория')
                        ->required(),
                    TextInput::make('priority')
                        ->type('number')
                        ->label('Приоритет')
                        ->placeholder('Приоритет')
                        ->columnSpan(1),
                    FileUpload::make('photo')
                        ->image()
                        // ->imageResizeMode(400)
                        ->label('Фото')
                        ->disk('public')
                        ->directory('categories') 
                        ->hintAction(
                    UnsplashPickerAction::make()
                                ->label('Выбрать из Unsplash')
                                ->small()
                                ->thumbnail()
                                ->perPage(20)
                                ->defaultSearch(fn (Get $get) => $get('name'))
                                ->after(function ($state, callable $set) {
                                    dd($state); // Kelayotgan ma'lumotni tekshirish
                                })
                        )->columnSpan(1),
                    // FileUpload::make('photo')
                    //     ->image()
                    //     ->label('Фото')
                    //     ->disk('public') 
                    //     ->directory('categories') 
                    //     ->required()
                    //     ->imageEditor()
                    //     ->imageEditorAspectRatios([
                    //         '16:9',
                    //         '4:3',
                    //         '1:1',
                    //     ])
                    //     ->columnSpan(1),
                    FileUpload::make('icon')
                        ->image()
                        ->label('Icon')
                        ->disk('public') 
                        ->directory('icon_categories') 
                        ->required()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->columnSpan(1),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Ид'),
                ImageColumn::make('photo')
                    ->label('Фото')
                    ->square(),
                TextColumn::make('name')->label('Название')->searchable()->sortable(),
                TextColumn::make('sub_category_count')->counts('sub_category')->label('Под категории')
                ->badge()
                ->color('primary')->sortable(),
                TextColumn::make('products_count')->counts('products')->label('Продукты')->badge()->color('success')->sortable(),
                TextColumn::make('created_at')
                ->label('Дата')
                ->sortable()
                ->formatStateUsing(function ($state) {
                    return \Carbon\Carbon::parse($state)->format('d/m/Y'); // Sana formatini o‘zgartirish
                })
            ])
            ->defaultPaginationPageOption(50)
            ->defaultSort('id','desc')
            ->filters([
                //
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
    public static function getNavigationLabel(): string
    {
        return 'Категории'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Категории'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Категории'; // Rus tilidagi ko'plik shakli
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
