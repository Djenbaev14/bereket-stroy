<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Branch;
use App\Models\Day;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Traineratwot\FilamentOpenStreetMap\Forms\Components\MapInput;

class BranchResource extends Resource
{
    
    use Translatable;
    protected static ?string $model = Branch::class;
    
    protected static ?string $navigationGroup = 'Настройки';

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('branch_name')
                    ->label('Название филиала')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(4),
                Forms\Components\TextInput::make('street')
                    ->label('Название улицы')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(4),
            
                Forms\Components\TimePicker::make('start_date')
                    ->label('Время начала')
                    ->seconds(false) // Sekundlarni o‘chirib qo‘yish
                    ->required()
                    ->columnSpan(2),

                Forms\Components\TimePicker::make('end_date')
                    ->label('Время окончания')
                    ->seconds(false)
                    ->required()
                    ->columnSpan(2),
                Forms\Components\CheckboxList::make('days')
                    ->label('Рабочие дни')
                    ->relationship('days',"name") // Uz tilida chiqarish
                    ->options(function () {
                        return Day::all()->pluck('name', 'id'); // JSON dan 'uz' tilini olish
                    })
                    ->columnSpan(4),

                MapInput::make('point_array')
                    ->label('Локация')
                    ->saveAsArray() // Important for Array type
                    ->placeholder('Choose your location')
                    ->coordinates(59.6022910410232, 42.47038509576842) // start coordinates
                    ->rows(10)
                    ->columnSpan(8), // height of map

            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Ид')->sortable(),
                TextColumn::make('branch_name')->label('Название филиала')->searchable()->sortable(),
                TextColumn::make('street')->label('Название улицы')->searchable()->sortable()
            ])
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
