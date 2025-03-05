<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BotttomBannerResource\Pages;
use App\Filament\Resources\BotttomBannerResource\RelationManagers;
use App\Models\BottomBanner;
use App\Models\BotttomBanner;
use App\Models\Product;
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

class BotttomBannerResource extends Resource
{
    use Translatable;
    protected static ?string $model = BottomBanner::class;
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?int $navigationSort = 2;

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
                        ->directory('bottom-banner') 
                        ->required()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->columnSpan(12),
                    TextInput::make('url')
                        ->label('Ссылка')
                        ->placeholder('Ссылка')
                        ->required()
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
                TextColumn::make('url')->label('Ссылка'),
                TextColumn::make('header')->label('Текст заголовка'),
                TextColumn::make('text')->label('Текстовый абзац'),
                TextColumn::make('created_at')
                ->label('Дата')
                ->formatStateUsing(function ($state) {
                    return \Carbon\Carbon::parse($state)->format('d/m/Y'); // Sana formatini o‘zgartirish
                })
            ])
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
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'publish'
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Нижний баннер'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Нижний баннер'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Нижний баннер'; // Rus tilidagi ko'plik shakli
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
            'index' => Pages\ListBotttomBanners::route('/'),
            'create' => Pages\CreateBotttomBanner::route('/create'),
            'edit' => Pages\EditBotttomBanner::route('/{record}/edit'),
        ];
    }
}
