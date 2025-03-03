<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Cheesegrits\FilamentPhoneNumbers\Forms\Components\PhoneNumber;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    Select::make('is_legal')
                    ->label('Тип клиента')
                    ->options([
                        0 => 'Физические лица',
                        1 => 'Юридические Лиц',
                    ])
                    ->columnSpan(6)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set) => $set('company_name', $state == 1 ? '' : null))
                    ->afterStateUpdated(fn ($state, $set) => $set('inn', $state == 1 ? '' : null)),
                TextInput::make('company_name')
                    ->label('Компания')
                    ->placeholder('Компания')
                    ->required()
                    ->hidden(fn ($get) => $get('is_legal') != 1)
                    ->columnSpan(6),
                TextInput::make('inn')
                    ->label('ИНН')
                    ->placeholder('ИНН')
                    ->required()
                    ->hidden(fn ($get) => $get('is_legal') != 1)
                    ->columnSpan(6),
                    TextInput::make('last_name')->required()->label('Фамилия')->placeholder('Фамилия')->columnSpan(6),
                    TextInput::make('first_name')->required()->label('Имя')->placeholder('Имя')->columnSpan(6),
                    PhoneInput::make('phone')->countryStatePath('phone_country')->required()->columnSpan(6),
                    DatePicker::make('birthday')->label('День рождения')->columnSpan(6)
                    
                ])->columns(12)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Ид'),
                TextColumn::make('is_legal')
                    ->label('Тип клиента')
                    // ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d-m-Y H:i:s') : 'Noma’lum')
                    ->formatStateUsing(fn ($state) => $state == 1 ? 'Юридические Лиц' : 'Физические лица'),
                TextColumn::make('last_name')->sortable()->searchable()->label('Фамилия'),
                TextColumn::make('first_name')->sortable()->searchable()->label('Имя'),
                TextColumn::make('phone')->sortable()->searchable()->label('Тел номер'),
                Tables\Columns\TextColumn::make('is_verified')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state == 1?'Проверено':'Не подтверждено')
                    
    ->color(fn (string $state): string => match ($state) {
        '1' => 'success',
        '0' => 'danger',
    }),
                TextColumn::make('created_at')->dateTime()
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
    public static function getNavigationLabel(): string
    {
        return 'Клиенты'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Клиенты'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Клиенты'; // Rus tilidagi ko'plik shakli
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
