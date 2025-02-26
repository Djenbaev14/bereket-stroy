<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            [
                'category_id'=>1,
                'name' => [
                    'uz' => 'Vannalar',
                    'ru' => 'Ванны',
                    'en' => 'Bathtubs',
                ],
            ],
            [
                'category_id'=>1,
                'name' => [
                    'uz' => 'Dush kabinalar',
                    'ru' => 'Душевые кабины',
                    'en' => 'Shower Cabins',
                ],
            ],
            [
                'category_id'=>1,
                'name' => [
                    'uz' => 'Suv quvurlari',
                    'ru' => 'Водопроводные трубы',
                    'en' => 'Water Pipes',
                ],
            ],
            [
                'category_id'=>1,
                'name' => [
                    'uz' => 'Kranchalar va Armaturlar',
                    'ru' => 'Краны и арматура',
                    'en' => 'Faucets and Fittings',
                ],
            ],

            [
                'category_id' => 2, // Mebellar
                'name' => [
                    'uz' => 'Oshxona mebellari',
                    'en' => 'Kitchen Furniture',
                    'ru' => 'Кухонная мебель'
                ],
            ],
            [
                'category_id' => 2,
                'name' => [
                    'uz' => 'Yotoqxona mebellari',
                    'en' => 'Bedroom Furniture',
                    'ru' => 'Спальная мебель'
                ],
            ],
            
        ];

        foreach ($subCategories as $subCategory) {
            SubCategory::create($subCategory);
        }
    }
}
