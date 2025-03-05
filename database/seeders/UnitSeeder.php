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
                    'qr' => 'Dona',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Metrlik',
                    'ru' => 'Метровый',
                    'en' => 'Meter',
                    'qr' => 'Metrlik',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kvadrat metr',
                    'ru' => 'Квадратный метр',
                    'en' => 'Square meter',
                    'qr' => 'Kvadrat metr',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kub metr',
                    'ru' => 'Кубический метр',
                    'en' => 'Cubic meter',
                    'qr' => 'Kub metr',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Litr',
                    'ru' => 'Литр',
                    'en' => 'Liter',
                    'qr' => 'Litr',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Millimetr',
                    'ru' => 'Миллиметр',
                    'en' => 'Millimeter',
                    'qr' => 'Millimetr',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Santimetr',
                    'ru' => 'Сантиметр',
                    'en' => 'Centimeter',
                    'qr' => 'Santimetr',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kelvin',
                    'ru' => 'Кельвин',
                    'en' => 'Kelvin',
                    'qr' => 'Kelvin',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Bar',
                    'ru' => 'Бар',
                    'en' => 'Bar',
                    'qr' => 'Bar',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Kg',
                    'ru' => 'Кг',
                    'en' => 'Kg',
                    'qr' => 'Kg',
                ],
            ],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
