<?php

namespace App\Filament\Resources\BotttomBannerResource\Pages;

use App\Filament\Resources\BotttomBannerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBotttomBanner extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = BotttomBannerResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
