<?php

namespace App\Filament\Resources\PaymentTypeResource\Pages;

use App\Filament\Resources\PaymentTypeResource;
use App\Filament\Widgets\PaymentMethodsWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentTypes extends ListRecords
{
    protected static string $resource = PaymentTypeResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            PaymentMethodsWidget::class,
        ];
    }
}
