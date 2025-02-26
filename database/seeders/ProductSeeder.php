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
                'name' => [
                    'uz' => 'Vannalar',
                    'ru' => 'Ванны',
                    'en' => 'Bathtubs',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Dush kabinalar',
                    'ru' => 'Душевые кабины',
                    'en' => 'Shower Cabins',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Suv quvurlari',
                    'ru' => 'Водопроводные трубы',
                    'en' => 'Water Pipes',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Suv quvurlari',
                    'ru' => 'Водопроводные трубы',
                    'en' => 'Water Pipes',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Suv quvurlari',
                    'ru' => 'Водопроводные трубы',
                    'en' => 'Water Pipes',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Suv quvurlari',
                    'ru' => 'Водопроводные трубы',
                    'en' => 'Water Pipes',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Suv quvurlari',
                    'ru' => 'Водопроводные трубы',
                    'en' => 'Water Pipes',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kranchalar va Armaturlar',
                    'ru' => 'Краны и арматура',
                    'en' => 'Faucets and Fittings',
                ],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
