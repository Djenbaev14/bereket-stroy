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
                ],
            ],
            [
                'name' => [
                    'uz' => 'Hansgrohe',
                    'ru' => 'Hansgrohe',
                    'en' => 'Hansgrohe',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Roca',
                    'ru' => 'Roca',
                    'en' => 'Roca',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Geberit',
                    'ru' => 'Geberit',
                    'en' => 'Geberit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Vitra',
                    'ru' => 'Vitra',
                    'en' => 'Vitra',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Ideal Standard',
                    'ru' => 'Ideal Standard',
                    'en' => 'Ideal Standard',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Cersanit',
                    'ru' => 'Cersanit',
                    'en' => 'Cersanit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kohler',
                    'ru' => 'Kohler',
                    'en' => 'Kohler',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Duravit',
                    'ru' => 'Duravit',
                    'en' => 'Duravit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Laufen',
                    'ru' => 'Laufen',
                    'en' => 'Laufen',
                ],
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
