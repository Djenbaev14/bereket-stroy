<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
    // protected function getHeaderWidgets(): array
    // {
    //     return OrderResource::getWidgets();
    // }
    public function getTabs(): array
    {
        return [
            null => Tab::make('Все'),
            'Новый' => Tab::make()->query(fn ($query) => $query->where('order_status_id', '1')),
            'Ожидание оплаты' => Tab::make()->query(fn ($query) => $query->where('order_status_id', '2')),
            'Оплачено' => Tab::make()->query(fn ($query) => $query->where('order_status_id', '2')),
            'отменено' => Tab::make()->query(fn ($query) => $query->where('order_status_id', '3')),
        ];
    }
}
