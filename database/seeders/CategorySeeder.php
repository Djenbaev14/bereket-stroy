<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslatable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'uz' => 'Santexnika',
                    'qr' => 'Santexnika',
                    'ru' => 'Сантехника',
                    'en' => 'Plumbing',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Mebellar',
                    'qr' => 'Mebeller',
                    'ru' => 'мебель',
                    'en' => 'Furnitures',
                ],
            ],
            
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

    }
}
