<?php

namespace App\Filament\Resources\BotttomBannerResource\Pages;

use App\Filament\Resources\BotttomBannerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBotttomBanners extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = BotttomBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
