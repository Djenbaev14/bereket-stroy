<?php

namespace App\Filament\Widgets;

use App\Models\PaymentType;
use Filament\Widgets\Widget;
use Filament\Notifications\Notification;

class PaymentMethodsWidget extends Widget
{
    protected static string $view = 'filament.widgets.payment-methods-widget';
    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'paymentMethods' => PaymentType::all(),
        ];
    }
    public static function canView(): bool
    {
        return request()->routeIs('filament.admin.resources.payment-types.index');
    }
    public function toggleStatus($id)
    {
        $payment = PaymentType::find($id);
        if ($payment) {
            $payment->update(['is_active' => !$payment->is_active]);
        }
        
        Notification::make()
            ->title('Статус изменен')
            ->success()
            ->body('Успешно изменен тип оплаты!')
            ->send();
    }
}
