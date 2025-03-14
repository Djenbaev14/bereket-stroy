<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountType;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
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
                    TextInput::make('name')->label('Название')->unique()->required()->columnSpan(12),
                    Select::make('discount_type_id')
                        ->label('Тип скидки')
                        ->options(DiscountType::pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->columnSpan(6), // Tanlangan qiymatga qarab boshqa inputlarni o'zgartirish uchun

                    TextInput::make('discount_amount')
                        ->label(fn ($get) =>DiscountType::find($get('discount_type_id'))?->name)
                        ->placeholder(fn ($get) =>DiscountType::find($get('discount_type_id'))?->name)
                        ->suffix(fn ($get) =>DiscountType::find($get('discount_type_id'))?->discount_type)
                        ->numeric()
                        ->reactive()
                        ->rules([
                            fn ($get) => \Illuminate\Validation\Rule::when(
                                DiscountType::find($get('name'))?->discount_type === 'Процент',
                                ['max:100'] // Foiz chegirma 100% dan oshmasligi kerak
                            ),
                            fn ($get) => \Illuminate\Validation\Rule::when(
                                DiscountType::find($get('name'))?->discount_type === 'Фиксированная скидка',
                                ['lte:' . $get('price')] // Fiks chegirma mahsulot narxidan katta bo‘lmasligi kerak
                            ),
                        ])
                        ->disabled(fn ($get) => !$get('discount_type_id'))
                        ->columnSpan(6), // Chegirma turi tanlanmaguncha yashirin bo'ladi
                        
                        Select::make('products')
                        ->relationship('products', 'name') // O‘zbek tilida chiqarish
                        ->multiple()
                        ->label('Продукты')
                        ->options(Product::whereDoesntHave('activeDiscount')->pluck('name', 'id')->map(fn ($name) => json_decode($name, true)[app()->getLocale()] ?? $name))
                        // ->options(fn () => Product::all()->pluck('name', 'id')->map(fn ($name) => json_decode($name, true)[app()->getLocale()] ?? $name))
                        ->columnSpan(6)
                        ->preload(),
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
                // Select::make('products')
                //     ->label('Продукты')
                //     // ->relationship('products', 'name->ru') // O‘zbek tilida chiqarish
                //     ->options(Product::whereDoesntHave('activeDiscount')->pluck('name', 'id'))
                //     ->multiple() // Bir nechta mahsulot tanlash uchun
                //     ->preload(),
                TextColumn::make('formatted_discount')
                    ->label('Сумма скидки')
                    ->state(fn ($record) => "{$record->discount_amount} " . ($record->discount_type->discount_type)),
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
