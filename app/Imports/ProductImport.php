<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\SubCategory;
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
        
        $categoryName = mb_convert_encoding($row['cat'], 'UTF-8', 'auto');

        $category = Category::whereJsonContains('name->ru', $categoryName)->first();
        if (!$category) {
            $category = Category::create([
                'name' => [
                    'ru'=> $row['cat'] ?? '',
                ],
                // 'photo'=>$row['cat_photo']??null
            ]);
        }
        
        $subcategoryName = mb_convert_encoding($row['subcat'], 'UTF-8', 'auto');

        $subcategory = SubCategory::whereJsonContains('name->ru', $subcategoryName)->first();
        if (!$subcategory) {
            $subcategory = SubCategory::create([
                'category_id'=>$category->id,
                'name' => [
                    'ru'=> $row['subcat'] ?? '',
                ],
                // 'photo'=>$row['sub_cat_photo']??null
            ]);
        }
        
        $brandName = mb_convert_encoding($row['brand'], 'UTF-8', 'auto');

        $brand = Brand::whereJsonContains('name->ru', $brandName)->first();
        if (!$brand) {
            $brand = Brand::create([
                'name' => [
                    'ru'=> $row['brand'] ?? '',
                    'qr'=> $row['brand'] ?? '',
                    'uz'=> $row['brand'] ?? '',
                    'en'=> $row['brand'] ?? '',
                ],
                'icon'=>$row['brand_photo']??null
            ]);
        }
        
        $countryName = mb_convert_encoding($row['country'], 'UTF-8', 'auto');
        $country = Country::whereJsonContains('name->ru', $countryName)->first();
        if (!$country) {
            $country = Country::create([
                'name' => [
                    'ru'=> $row['country'] ?? '',
                ]
            ]);
        }

        return new Product([
            'category_id'=>$category->id,
            'sub_category_id'=>$subcategory->id,
            'price' => $row['price'] ,
            // 'sub_subcategory_id' => $row['subsubcat_id'] ?? null,
            'name' => [
                'uz' =>mb_convert_encoding($row['product_uz'] ?? '', 'UTF-8', 'auto'),
                'ru' => mb_convert_encoding($row['product_ru'] ?? '', 'UTF-8', 'auto'),
                'en' => mb_convert_encoding($row['product_en'] ?? '', 'UTF-8', 'auto'),
                'qr' => mb_convert_encoding($row['product_qr'] ?? '', 'UTF-8', 'auto'),
            ],
            'description' => [
                // 'uz' => mb_convert_encoding($row['desc_uz'] ?? '', 'UTF-8', 'auto'),
                // 'ru' => mb_convert_encoding($row['desc_ru'] ?? '', 'UTF-8', 'auto'),
                // 'en' => mb_convert_encoding($row['desc_en'] ?? '', 'UTF-8', 'auto'),
                // 'qr' => mb_convert_encoding($row['desc_qr'] ?? '', 'UTF-8', 'auto'),
                'uz' => htmlspecialchars_decode($row['desc_uz'] ?? '', ENT_QUOTES),
                'ru' => htmlspecialchars_decode($row['desc_ru'] ?? '', ENT_QUOTES),
                'en' => htmlspecialchars_decode($row['desc_en'] ?? '', ENT_QUOTES),
                'qr' => htmlspecialchars_decode($row['desc_qr'] ?? '', ENT_QUOTES),
            ],
            'brand_id'=>$brand->id,
            'country_id'=>$country->id,
            'unit_id'=>1,
            // 'photos'=>[$row['photo']]
            // 'photos'=>["products/01JP2KDVFTV0Y4GGJZ6KEHSPJ3.jpg"]
        ]);
    }
    public function rules(): array
    {
        return [
            // 'category_id' => ['required', 'exists:categories,id'],
            // 'sub_category_id' => ['required', 'exists:sub_categories,id'],
            // 'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    

    public function map($row): array
    {
        return $row;
    }
}
