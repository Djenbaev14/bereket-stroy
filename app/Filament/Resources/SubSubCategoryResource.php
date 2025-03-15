<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubSubCategoryResource\Pages;
use App\Filament\Resources\SubSubCategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubSubCategoryResource extends Resource
{
    use Translatable;
    protected static ?string $model = SubSubCategory::class;
    
    protected static ?string $navigationGroup = 'Продукты';
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    FileUpload::make('photo')
                        ->image()
                        ->label('Фото')
                        ->disk('public') 
                        ->directory('sub_sub_categories') 
                        ->required()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->columnSpan(12),
                    Select::make('category_id')
                        ->label('Категории')
                        ->options(Category::all()->pluck('name', 'id'))
                        ->afterStateUpdated(fn (callable $set) => $set('sub_category_id', null)) // Kategoriya o‘zgarsa subkategoriya tozalanadi
                        ->reactive() // Kategoriya tanlanganda subcategory yangilansin
                        ->required()
                        ->searchable()
                        ->columnSpan(6),
                    Select::make('sub_category_id')
                            ->label('Подкатегории')
                            ->options(fn (callable $get) => 
                                SubCategory::where('category_id', $get('category_id'))->pluck('name', 'id') // Faqat tanlangan categoriyaga tegishlilari chiqadi
                            )
                            ->disabled(fn (callable $get) => empty($get('category_id'))) // Category tanlanmaguncha subcategory disable bo‘ladi
                            ->required()
                            ->columnSpan(6),
                    TextInput::make('name')
                        ->label('Под Подкатегория')
                        ->required()
                        ->columnSpan(6),
                    TextInput::make('priority')
                        ->type('number')
                        ->label('Приоритет')
                        ->columnSpan(6),
                ])->columns(12)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Ид'),
                TextColumn::make('name')->label('Название')->searchable(),
                TextColumn::make('category.name')->label('Категория')->searchable(),
                TextColumn::make('sub_category.name')->label('Подкатегория')->searchable(),
                TextColumn::make('priority')->label('Приоритет'),
                TextColumn::make('created_at')
                ->label('Дата')
                ->formatStateUsing(function ($state) {
                    return \Carbon\Carbon::parse($state)->format('d/m/Y'); // Sana formatini o‘zgartirish
                })
            ])
            ->defaultSort('id','desc')
            ->filters([
                //
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
    public static function getNavigationLabel(): string
    {
        return 'Под Подкатегории'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Под Подкатегории'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Под Подкатегории'; // Rus tilidagi ko'plik shakli
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubSubCategories::route('/'),
            'create' => Pages\CreateSubSubCategory::route('/create'),
            'edit' => Pages\EditSubSubCategory::route('/{record}/edit'),
        ];
    }
}
