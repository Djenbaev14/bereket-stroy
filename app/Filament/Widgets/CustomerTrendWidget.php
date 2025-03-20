<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CustomerTrendWidget extends ChartWidget
{
    protected static ?string $heading = 'Рост клиентов';

    protected function getData(): array
    {
        $data = Trend::model(Customer::class)
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Новые клиенты (ежедневно)',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#FF6384',
                    'borderColor' => '#FF6384',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Grafik turi: chiziqli
    }

    protected static ?int $sort = 2; // SalesTrendWidget’dan keyin joylashishi uchun
}
