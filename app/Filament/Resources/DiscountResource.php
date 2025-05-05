<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\DiscountType;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class DiscountResource extends Resource
{
    use Translatable;
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationGroup = 'Продукты';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    FileUpload::make('photo')
                        ->label('Фото')
                        ->image()
                        ->disk('public') 
                        ->directory('discounts')
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                    ])->columnSpan(12),
                    TextInput::make('name')->label('Название')->placeholder('Название')->unique()->required()->columnSpan(12),
                    TextInput::make('text')->label('Текст')->placeholder('Текст')->columnSpan(12),
                        Repeater::make('Продукты')
                            ->label('Продукты')
                            ->relationship('discountProducts')// Relationshipni bog‘lash
                            ->schema([
                                Select::make('product_id')
                                    // ->relationship('product', 'name') // O‘zbek tilida chiqarish
                                    ->label('Название')
                                    ->options(
                                        Product::whereDoesntHave('activeDiscount')
                                            ->get()
                                            ->pluck('name', 'id') // Pluck ichida id va name ni to‘g‘ri tartibda yozish kerak
                                            // ->map(fn ($name) => json_decode($name, true)[app()->getLocale()] ?? $name)
                                    )
                                    ->getOptionLabelFromRecordUsing(fn ($record) => json_decode($record->name, true)[app()->getLocale()] ?? $record->name)
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->searchable()
                                    ->reactive() // Tanlanganida qiymatni olish uchun
                                    ->afterStateUpdated(fn (Get $get, callable $set) => 
                                        $set('price',Product::find($get('product_id'))?->price ?? null)
                                    )
                                    ->columnSpan(6),
                                TextInput::make('price')
                                    ->placeholder('Цена')
                                    ->label('Цена')
                                    // ->readOnly()
                                    ->columnSpan(3),
                                TextInput::make('discounted_price')
                                    ->placeholder('Цена со скидкой')
                                    ->label('Цена со скидкой')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(3),
                            ])
                        ->columns(12)
                        ->columnSpan(12),
                        DateTimePicker::make('deadline')->minDate(now())->required()->columnSpan(6),


                ])->columns(12)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo'),
                TextColumn::make('name')->label('Название')->searchable(),
                TextColumn::make('deadline')
                    ->label('Скидка заканчивается')
                    ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d-m-Y H:i:s') : 'Noma’lum')
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
    // public static function canCreate(): bool
    // {
    //     // Bazadagi eng oxirgi discountni tekshiramiz
    //     $latestDiscount = Discount::latest('id')->first();

    //     // Agar deadline mavjud bo‘lsa va muddati o‘tmagan bo‘lsa, create tugma chiqmasin
    //     if ($latestDiscount && $latestDiscount->deadline > now()) {
    //         return false;
    //     }

    //     return true;
    // }
    public static function getNavigationLabel(): string
    {
        return 'Скидки'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Скидки'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Скидки'; // Rus tilidagi ko'plik shakli
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
