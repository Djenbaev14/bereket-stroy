<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentProductResource\Pages;
use App\Filament\Resources\CommentProductResource\RelationManagers;
use App\Models\CommentProduct;
use App\Models\Customer;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class CommentProductResource extends Resource
{
    protected static ?string $model = CommentProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Продукты';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('customer_id')
                ->label('Клиенты')
                ->options(Customer::all()->pluck('first_name', 'id'))
                ->required()
                ->searchable()
                ->columnSpan(1),
                Select::make('product_id')
                ->label('Продукты')
                ->options(Product::all()->pluck('name', 'id'))
                ->required()
                ->searchable()
                ->columnSpan(1),
                Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
                    Select::make('rating')
                    ->label('Рейтин')
                    ->options([
                        '1'=>'1',
                        '2'=>'2',
                        '3'=>'3',
                        '4'=>'4',
                        '5'=>'5',
                    ])
                    ->required()
                    ->searchable()
                    ->columnSpan(1),
            ]);
    }
    public static function canCreate(): bool
    {
        return false; // Create tugmasini o'chiradi
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Фото')
                    ->square(),
                Tables\Columns\TextColumn::make('customer.first_name')
                    ->label('Клиент')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Продукти')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationLabel(): string
    {
        return 'Комментарии'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Комментарии'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Комментарии'; // Rus tilidagi ko'plik shakli
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommentProducts::route('/'),
            'create' => Pages\CreateCommentProduct::route('/create'),
            'edit' => Pages\EditCommentProduct::route('/{record}/edit'),
        ];
    }
}
