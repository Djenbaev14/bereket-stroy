<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Imports\ProductImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    
    use ListRecords\Concerns\Translatable;
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->slideOver()
                ->color("primary")
                ->use(ProductImport::class),
            Action::make('download-template')
            ->label('Скачать шаблон')
            ->color('primary')
            ->action(fn () => response()->download(storage_path('app/templates/product_template.csv'))),
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
