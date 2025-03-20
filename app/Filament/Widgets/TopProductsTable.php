<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopProductsTable extends BaseWidget
{
    protected static ?string $heading = 'Eng Ko‘p Sotilgan Mahsulotlar';
    protected static ?int $sort = 4; // Tartibda to‘rtinchi bo‘lishi uchun
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {return $table
        ->query(
            Product::query()
                ->select('products.*',
                DB::raw('SUM(order_items.quantity) as total_sold'), 
                        DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'))
                ->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id', 'products.name', 'products.price') 
                ->orderByRaw('SUM(order_items.quantity) DESC')
                ->limit(5) // Top 5 mahsulot
        )
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Mahsulot Nomi')
                ->searchable(),
            Tables\Columns\TextColumn::make('price')
                ->label('Narxi')
                ->money('UZS', true), // UZS formatida
            Tables\Columns\TextColumn::make('total_sold')
                ->label('Sotilgan Miqdor'),
                // ->getStateUsing(fn ($record) => $record->orderItems()->sum('quantity')),
            Tables\Columns\TextColumn::make('total_revenue')
                ->label('Umumiy Daromad')
                // ->getStateUsing(fn ($record) => $record->orderItems()->sum(DB::raw('quantity * price')))
                ->money('UZS', true),
        ]);
    }
}
