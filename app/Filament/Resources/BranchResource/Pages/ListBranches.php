<?php

namespace App\Filament\Resources\BranchResource\Pages;

use App\Filament\Resources\BranchResource;
use App\Imports\BranchImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBranches extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // \EightyNine\ExcelImport\ExcelImportAction::make()
            //     ->slideOver()
            //     ->color("primary")
            //     ->use(BranchImport::class),
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
