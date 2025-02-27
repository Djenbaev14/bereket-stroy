<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Branch;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Traineratwot\FilamentOpenStreetMap\Forms\Components\MapInput;

class BranchResource extends Resource
{
    
    use Translatable;
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MapInput::make('point_array')
                    ->label('Локация')
                    ->saveAsArray() // Important for Array type
                    ->placeholder('Choose your location')
                    ->coordinates(59.6022910410232, 42.47038509576842) // start coordinates
                    ->rows(10), // height of map

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            
                Forms\Components\CheckboxList::make('days')
                    ->label('Ish kunlari')
                    ->relationship('days','key') // Uz tilida chiqarish
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    
    public static function getNavigationLabel(): string
    {
        return 'Филиалы'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Филиалы'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Филиалы'; // Rus tilidagi ko'plik shakli
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
