<?php

namespace Database\Seeders;

use App\Models\SubSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subsubcategories = [
            [
                'sub_category_id' => 1, // Vannalar
                'category_id' => 1, // Vannalar
                'name' => [
                    'uz' => 'Akril vannalar',
                    'en' => 'Acrylic Bathtubs',
                    'ru' => 'Акриловые ванны',
                    'qr'=>'Akril vannalar',
                ],
            ],
            [
                'sub_category_id' => 1,
                'category_id' => 1,
                'name' => [
                    'uz' => 'Chugun vannalar',
                    'en' => 'Cast Iron Bathtubs',
                    'ru' => 'Чугунные ванны',
                    'qr' => 'Chugun vannalar',
                ],
            ],
            [
                'sub_category_id' => 3, // Oshxona mebellari
                'category_id' => 1, // Oshxona mebellari
                'name' => [
                    'uz' => 'Modulli oshxona mebellari',
                    'en' => 'Modular Kitchen Furniture',
                    'ru' => 'Модульная кухонная мебель',
                    'qr' => 'Modulli oshxona mebellari',
                ],
            ],
            [
                'sub_category_id' => 5,
                'category_id' => 2,
                'name' => [
                    'uz' => 'Tayyor oshxona mebellari',
                    'en' => 'Ready-made Kitchen Furniture',
                    'ru' => 'Готовая кухонная мебель',
                    'qr' => 'Tayyor oshxona mebellari',
                ],
            ],
        ];

        foreach ($subsubcategories as $subsubcategory) {
            SubSubCategory::create($subsubcategory);
        }
    }
}
