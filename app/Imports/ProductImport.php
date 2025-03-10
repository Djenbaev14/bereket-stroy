<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'category_id' => $row['category_id'],
            'subcategory_id' => $row['subcategory_id'],
            'subsubcategory_id' => $row['subsubcategory_id'],
            'name' => json_encode([
                'uz' => $row['name_uz'],
                'ru' => $row['name_ru'],
                'en' => $row['name_en'],
                'qr' => $row['name_qr'],
            ]),
            'description' => $row['description'],
        ]);
    }
}
