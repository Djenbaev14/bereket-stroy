<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => [
                    'uz' => 'Grohe',
                    'ru' => 'Grohe',
                    'en' => 'Grohe',
                    'kr' => 'Grohe',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Hansgrohe',
                    'ru' => 'Hansgrohe',
                    'en' => 'Hansgrohe',
                    'kr' => 'Grohe',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Roca',
                    'ru' => 'Roca',
                    'en' => 'Roca',
                    'kr' => 'Roca',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Geberit',
                    'ru' => 'Geberit',
                    'en' => 'Geberit',
                    'kr' => 'Geberit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Vitra',
                    'ru' => 'Vitra',
                    'en' => 'Vitra',
                    'kr' => 'Vitra',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Ideal Standard',
                    'ru' => 'Ideal Standard',
                    'en' => 'Ideal Standard',
                    'kr' => 'Ideal Standard',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Cersanit',
                    'ru' => 'Cersanit',
                    'en' => 'Cersanit',
                    'kr' => 'Cersanit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kohler',
                    'ru' => 'Kohler',
                    'en' => 'Kohler',
                    'kr' => 'Kohler',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Duravit',
                    'ru' => 'Duravit',
                    'en' => 'Duravit',
                    'kr' => 'Duravit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Laufen',
                    'ru' => 'Laufen',
                    'en' => 'Laufen',
                    'kr' => 'Laufen',
                ],
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
