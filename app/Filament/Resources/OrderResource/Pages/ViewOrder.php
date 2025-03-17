<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
            ->label('Export PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->action(fn ($record) => self::generatePdf($record)),
        ];
    }
    public static function generatePdf($record)
    {
        $pdf = Pdf::loadView('pdf.order', ['order' => $record])
        ->setPaper('A4')
        ->setOptions([
            'defaultFont' => 'DejaVu Sans', // UTF-8 uchun
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "order-{$record->id}.pdf"
        );
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
