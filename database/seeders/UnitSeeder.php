<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => [
                    'uz' => 'Dona',
                    'ru' => 'Штука',
                    'en' => 'Piece',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Metrlik',
                    'ru' => 'Метровый',
                    'en' => 'Meter',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kvadrat metr',
                    'ru' => 'Квадратный метр',
                    'en' => 'Square meter',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kub metr',
                    'ru' => 'Кубический метр',
                    'en' => 'Cubic meter',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Litr',
                    'ru' => 'Литр',
                    'en' => 'Liter',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Millimetr',
                    'ru' => 'Миллиметр',
                    'en' => 'Millimeter',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Santimetr',
                    'ru' => 'Сантиметр',
                    'en' => 'Centimeter',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kelvin',
                    'ru' => 'Кельвин',
                    'en' => 'Kelvin',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Bar',
                    'ru' => 'Бар',
                    'en' => 'Bar',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kg',
                    'ru' => 'Кг',
                    'en' => 'Kg',
                ],
            ],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
