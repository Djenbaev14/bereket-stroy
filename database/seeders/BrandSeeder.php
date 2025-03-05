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
                    'qr' => 'Grohe',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Hansgrohe',
                    'ru' => 'Hansgrohe',
                    'en' => 'Hansgrohe',
                    'qr' => 'Grohe',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Roca',
                    'ru' => 'Roca',
                    'en' => 'Roca',
                    'qr' => 'Roca',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Geberit',
                    'ru' => 'Geberit',
                    'en' => 'Geberit',
                    'qr' => 'Geberit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Vitra',
                    'ru' => 'Vitra',
                    'en' => 'Vitra',
                    'qr' => 'Vitra',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Ideal Standard',
                    'ru' => 'Ideal Standard',
                    'en' => 'Ideal Standard',
                    'qr' => 'Ideal Standard',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Cersanit',
                    'ru' => 'Cersanit',
                    'en' => 'Cersanit',
                    'qr' => 'Cersanit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kohler',
                    'ru' => 'Kohler',
                    'en' => 'Kohler',
                    'qr' => 'Kohler',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Duravit',
                    'ru' => 'Duravit',
                    'en' => 'Duravit',
                    'qr' => 'Duravit',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Laufen',
                    'ru' => 'Laufen',
                    'en' => 'Laufen',
                    'qr' => 'Laufen',
                ],
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
