<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $products = [
            [
                "category_id"=>1,
                "sub_category_id"=>1,
                "sub_sub_category_id"=>1,
                "brand_id"=>4,
                "country_id"=>1,
                'name' => [
                    'uz' => 'Vannalar',
                    'ru' => 'Ванны',
                    'en' => 'Bathtubs',
                ],
                'description' => [
                    'uz' => 'Vannalar',
                    'ru' => 'Ванны',
                    'en' => 'Bathtubs',
                ],
                'unit_id'=>1,
                'price'=>150000
            ],
            [
                "category_id"=>1,
                "sub_category_id"=>2,
                "brand_id"=>1,
                "country_id"=>2,
                'name' => [
                    'uz' => 'Dush kabinalar',
                    'ru' => 'Душевые кабины',
                    'en' => 'Shower Cabins',
                ],
                'description' => [
                    'uz' => 'Dush kabinalar',
                    'ru' => 'Душевые кабины',
                    'en' => 'Shower Cabins',
                ],
                'unit_id'=>1,
                'price'=>800000
            ],
            [
                "category_id"=>1,
                "sub_category_id"=>3,
                "sub_sub_category_id"=>3,
                "brand_id"=>3,
                "country_id"=>1,
                'name' => [
                    'uz' => 'Suv quvurlari',
                    'ru' => 'Водопроводные трубы',
                    'en' => 'Water Pipes',
                ],
                'description' => [
                    'uz' => 'Suv quvurlari',
                    'ru' => 'Водопроводные трубы',
                    'en' => 'Water Pipes',
                ],
                'unit_id'=>1,
                'price'=>990000
            ],
            [
                "category_id"=>1,
                "sub_category_id"=>3,
                "sub_sub_category_id"=>3,
                "brand_id"=>1,
                "country_id"=>2,
                'name' => [
                    'uz' => 'Kranchalar va Armaturlar',
                    'ru' => 'Краны и арматура',
                    'en' => 'Faucets and Fittings',
                ],
                'name' => [
                    'uz' => 'Kranchalar va Armaturlar',
                    'ru' => 'Краны и арматура',
                    'en' => 'Faucets and Fittings',
                ],
                'unit_id'=>1,
                'price'=>100000
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
