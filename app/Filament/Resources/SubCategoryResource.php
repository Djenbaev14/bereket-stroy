<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubCategoryResource\Pages;
use App\Filament\Resources\SubCategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\SubCategory;
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

class SubCategoryResource extends Resource
{
    
    use Translatable;
    protected static ?string $model = SubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $navigationGroup = 'Продукты';
    protected static ?int $navigationSort = 3;


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
                        ->directory('sub_categories') 
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
                        ->searchable()
                        ->columnSpan(6),
                    Select::make('recommendedSubcategories')
                        ->label('Рекомендуемые субкатегории')
                        ->relationship('recommendedSubcategories', 'name->ru')
                        ->multiple()
                        ->preload()
                        ->options(function ($context) {
                            return Subcategory::where('id', '!=', $context->record->id ?? 0)
                                ->get()
                                ->mapWithKeys(function ($subcategory) {
                                    return [$subcategory->id => $subcategory->name];
                                });
                        })
                        ->columnSpan(6), // Avtomatik yuklash
                    TextInput::make('name')
                        ->label('Подкатегория')
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
                TextColumn::make('name')->label('Название')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Категория')->searchable()->sortable(),
                TextColumn::make('priority')->label('Приоритет')->sortable(),
                TextColumn::make('created_at')->sortable()
                ->label('Дата')
                ->formatStateUsing(function ($state) {
                    return \Carbon\Carbon::parse($state)->format('d/m/Y'); // Sana formatini o‘zgartirish
                })
            ])
            ->defaultSort('id', 'desc')
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
    public static function getNavigationLabel(): string
    {
        return 'Подкатегории'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Подкатегории'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Подкатегории'; // Rus tilidagi ko'plik shakli
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
            'index' => Pages\ListSubCategories::route('/'),
            'create' => Pages\CreateSubCategory::route('/create'),
            'edit' => Pages\EditSubCategory::route('/{record}/edit'),
        ];
    }
}
