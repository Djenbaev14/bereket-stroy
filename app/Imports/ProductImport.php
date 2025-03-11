<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'price' => $row['price'] ,
            'category_id' => $row['cat_id'] ,
            'sub_category_id' => $row['subcat_id'] ,
            'sub_subcategory_id' => $row['subsubcat_id'] ?? null,
            'name' => [
                'uz' => $row['product_uz'] ?? '',
                'ru' => $row['product_ru'] ?? '',
                'en' => $row['product_en'] ?? '',
                'qr' => $row['product_qr'] ?? '',
            ],
            'description' => [
                'uz' => $row['desc_uz'] ?? '',
                'ru' => $row['desc_ru'] ?? '',
                'en' => $row['desc_en'] ?? '',
                'qr' => $row['desc_qr'] ?? '',
            ],
            'brand_id'=>$row['brand_id'],
            'country_id'=>$row['country_id'],
            'unit_id'=>$row['unit_id']
        ]);
    }
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['required', 'exists:sub_categories,id'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    

    public function map($row): array
    {
        return $row;
    }
}
