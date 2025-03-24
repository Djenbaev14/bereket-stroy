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
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return OrderResource::getWidgets();
    }
    public function getTabs(): array
    {
        $query = $this->getTableQuery();
        $allCount = $query->count();
        $acceptedCount = $query->clone()->where('order_status_id', 1)->count();
        $approvedCount = $query->clone()->where('order_status_id', 2)->count();
        $deliveredCount = $query->clone()->where('order_status_id', 3)->count();
        $canceledCount = $query->clone()->where('order_status_id', 4)->count();
        return [
            null => Tab::make('Все')->badge($allCount),
            'Заказ принят' => Tab::make()
                ->label('Заказ принят')
                ->badge($acceptedCount)
                ->query(fn ($query) => $query->where('order_status_id', 1)),
            'Заказ одобрен' => Tab::make()
                ->label('Заказ одобрен')
                ->badge($approvedCount)
                ->query(fn ($query) => $query->where('order_status_id', 2)),
            'Заказ доставлен клиенту' => Tab::make()
                ->label('Заказ доставлен клиенту')
                ->badge($deliveredCount)
                ->query(fn ($query) => $query->where('order_status_id', 3)),
            'Заказ отменён' => Tab::make()
                ->label('Заказ отменён')
                ->badge($canceledCount)
                ->query(fn ($query) => $query->where('order_status_id', 4)),
        ];
    }
}
