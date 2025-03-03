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
        return [
            null => Tab::make('All'),
            'new' => Tab::make()->query(fn ($query) => $query->where('order_status_id', '1')),
            'completed' => Tab::make()->query(fn ($query) => $query->where('order_status_id', '2')),
            'cancelled' => Tab::make()->query(fn ($query) => $query->where('order_status_id', '3')),
        ];
    }
}
