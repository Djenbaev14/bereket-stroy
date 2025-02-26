<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopBannerResource\Pages;
use App\Filament\Resources\TopBannerResource\RelationManagers;
use App\Models\Category;
use App\Models\TopBanner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopBannerResource extends Resource
{
    use Translatable;
    protected static ?string $model = TopBanner::class;
    protected static ?string $navigationGroup = 'Баннер';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        ->directory('top-banner') 
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
                    TextInput::make('header')
                        ->label('Текст заголовка')
                        ->placeholder('Текст заголовка')
                        ->required()
                        ->columnSpan(6),
                    TextInput::make('text')
                        ->label('Текстовый абзац')
                        ->placeholder('Текстовый абзац')
                        ->required()
                        ->columnSpan(6),
                ])->columns(12)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Ид'),
                ImageColumn::make('photo')->label('Фото'),
                TextColumn::make('header')->label('Текст заголовка'),
                TextColumn::make('text')->label('Текстовый абзац'),
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
        return 'Верхний баннер'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Верхний баннер'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Верхний баннер'; // Rus tilidagi ko'plik shakli
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTopBanners::route('/'),
            'create' => Pages\CreateTopBanner::route('/create'),
            'edit' => Pages\EditTopBanner::route('/{record}/edit'),
        ];
    }
}
