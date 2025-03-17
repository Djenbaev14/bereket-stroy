<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;
    protected function getHeaderActions(): array
    {
        return [
        ];
    }


    // protected function getFormSchema(): array
    // {
    //     return [
    //         Section::make('Информация о клиенте')
    //             ->columns(2)
    //             ->schema([
    //                 TextColumn::make('customer.first_name')->label('Имя клиента'),
    //                 TextColumn::make('customer.phone')->label('Телефон'),
    //             ]),

    //         Section::make('Информация о продаже')
    //             ->columns(2)
    //             ->schema([
    //                 TextColumn::make('id')->label('ID'),
    //                 TextColumn::make('created_at')->label('Дата')->dateTime(),
    //                 // TextColumn::make('status')->label('Статус')
    //                 //     ->color(fn ($record) => $record->status == 'Принят' ? 'success' : 'warning'),
    //             ]),

    //         Section::make('Список товаров')
    //             ->columns(1)
    //             ->schema([
    //                 Grid::make(5)
    //                     ->schema([
    //                         TextColumn::make('OrderItems.product.name')->label('Название'),
    //                         TextColumn::make('OrderItems.quantity')->label('Количество'),
    //                         TextColumn::make('OrderItems.product.unit.name')->label('Кол-во б. ед.'),
    //                         TextColumn::make('OrderItems.price')->label('Цена'),
    //                         // TextColumn::make('products.pivot.total')->label('Сумма'),
    //                     ]),
    //                 TextColumn::make('total_amount')->label('Итого:')->weight('bold'),
    //             ]),
    //     ];
    // }

}
