<?php

namespace App\Filament\Resources\AttributeResource\Pages;

use App\Filament\Resources\AttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttributes extends ListRecords
{
    
    use ListRecords\Concerns\Translatable;
    protected static string $resource = AttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
