<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Настройки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('phone')
                    ->placeholder('998901234567')
                    ->label('Тел номер')
                    ->tel()
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(6),
                Forms\Components\TextInput::make('email')
                    ->placeholder('Емайл')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(6),
                Forms\Components\TextInput::make('instagram')
                    ->placeholder('Инстаграм')
                    ->label('Инстаграм')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(3),
                Forms\Components\TextInput::make('facebook')
                    ->placeholder('Фейсбук')
                    ->label('Фейсбук')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(3),
                Forms\Components\TextInput::make('telegram')
                    ->placeholder('Телеграм')
                    ->label('Телеграм')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(3),
                Forms\Components\TextInput::make('youtube')
                    ->placeholder('Ютуб')
                    ->label('Ютуб')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(3),
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instagram')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facebook')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telegram')
                    ->searchable(),
                Tables\Columns\TextColumn::make('youtube')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
    public static function getTableQuery()
    {
        return parent::getTableQuery()->limit(1);
    }
    public static function getNavigationUrl(): string
    {
        return static::getUrl('edit', ['record' => 1]); // 'id' 1 bilan tahrirlash sahifasiga yo'naltirish
    }
    public static function canCreate(): bool
    {
        return false; // Create tugmasini o'chiradi
    }
    public static function getNavigationLabel(): string
    {
        return 'Настройки'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Настройки'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Настройки'; // Rus tilidagi ko'plik shakli
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
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
