<?php

namespace App\Filament\Imports;

use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Database\Eloquent\Model;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('category_id')
                ->requiredMapping()
                ->rules(['required', 'exists:categories,id']),

            ImportColumn::make('subcategory_id')
                ->rules(['nullable', 'exists:subcategories,id']),

            ImportColumn::make('subsubcategory_id')
                ->rules(['nullable', 'exists:subsubcategories,id']),

            ImportColumn::make('price')
                ->rules(['nullable', 'numeric']),

            ImportColumn::make('name_uz')
                ->label('Name (Uzbek)')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

                ImportColumn::make('name_ru')
                ->label('Name (Russian)')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('name_en')
                ->label('Name (English)')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('name_qr')
                ->label('Name (QR)')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
                
            ImportColumn::make('description_uz')
                ->label('description (Uzbek)')
                ->requiredMapping()
                ->rules(['required', 'max:255']),


                ImportColumn::make('description_ru')
                ->label('description (Russian)')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('description_en')
                ->label('description (English)')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('description_qr')
                ->label('description (QR)')
                ->requiredMapping()
                ->rules(['required']),

        ];
    }

    public function resolveRecord(): ?Product
    {

        return Product::create([
            'category_id' => $this->data['category_id'],
            'subcategory_id' => $this->data['subcategory_id'] ?? null,
            'subsubcategory_id' => $this->data['subsubcategory_id'] ?? null,
            'price' => $this->data['price'] ?? null,
            'name' => json_encode([
                'uz' => $this->data['name_uz'],
                'ru' => $this->data['name_ru'],
                'en' => $this->data['name_en'],
                'qr' => $this->data['name_qr'],
            ]),
            'description' => json_encode([
                'uz' => $this->data['description_uz'],
                'ru' => $this->data['description_ru'],
                'en' => $this->data['description_en'],
                'qr' => $this->data['description_qr'],
            ]),
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
