<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesAndCustomerStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Sales Report statistikalari
            Stat::make('Общая торговля', number_format(Order::sum('total_amount')) . ' сум')
                ->description('Все время')
                ->color('success'),
            Stat::make('Сегодняшняя торговля', number_format(Order::whereDate('created_at', today())->sum('total_amount')) . ' сум')
                ->description('Только сегодня')
                ->color('primary'),
            Stat::make('Количество заказов', Order::count())
                ->description('Всего заказов')
                ->color('info'),

            // Mijozlar bo‘yicha statistikalar
            Stat::make('Всего клиентов', Customer::where('is_verified',1)->count())
                ->description('Клиенты в системе')
                ->color('success'),
            Stat::make('Новые клиенты', Customer::where('created_at', '>=', now()->subDays(30))->count())
                ->description('Последние 30 дней')
                ->color('primary'),
            Stat::make('Активные клиенты', Customer::has('orders', '>=', 1)->count())
                ->description('Те, кто сделал хотя бы 1 заказ')
                ->color('info'),
        ];
    }
}
