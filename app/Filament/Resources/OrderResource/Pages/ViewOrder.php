<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;
    protected function getHeaderActions(): array
    {
        return [
            // Agar tahrirlash yoki boshqa harakatlarni qo‘shmoqchi bo‘lsangiz
        ];
    }
    protected function getTable(): Table
    {
        return Table::make()
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID'),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->date(),

                TextColumn::make('status.name.uz')
                    ->label('Status')
                    ->color(fn ($record) => match ($record->status->name['en']) {
                        'new' => 'blue',
                        'completed' => 'green',
                        'cancelled' => 'red',
                        default => 'gray',
                    }),

                TextColumn::make('payment_method')
                    ->label('Payment Method'),

                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('usd'),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

}
