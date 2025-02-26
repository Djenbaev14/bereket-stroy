<?php

namespace App\Filament\Resources\BotttomBannerResource\Pages;

use App\Filament\Resources\BotttomBannerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBotttomBanner extends EditRecord
{
    
    use EditRecord\Concerns\Translatable;
    protected static string $resource = BotttomBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
