<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => ['en' => 'Red', 'ru' => 'Красный', 'uz' => 'Qizil',], 'hex' => '#FF0000'],
            ['name' => ['en' => 'Green', 'ru' => 'Зеленый', 'uz' => 'Yashil'], 'hex' => '#008000'],
            ['name' => ['en' => 'Blue', 'ru' => 'Синий', 'uz' => 'Ko‘k'], 'hex' => '#0000FF'],
            ['name' => ['en' => 'Yellow', 'ru' => 'Желтый', 'uz' => 'Sariq'], 'hex' => '#FFFF00'],
            ['name' => ['en' => 'Cyan', 'ru' => 'Голубой', 'uz' => 'Ko‘kimtir'], 'hex' => '#00FFFF'],
            ['name' => ['en' => 'Magenta', 'ru' => 'Пурпурный', 'uz' => 'Magenta'], 'hex' => '#FF00FF'],
            ['name' => ['en' => 'Black', 'ru' => 'Черный', 'uz' => 'Qora'], 'hex' => '#000000'],
            ['name' => ['en' => 'White', 'ru' => 'Белый', 'uz' => 'Oq'], 'hex' => '#FFFFFF'],
            ['name' => ['en' => 'Gray', 'ru' => 'Серый', 'uz' => 'Kulrang'], 'hex' => '#808080'],
            ['name' => ['en' => 'Orange', 'ru' => 'Оранжевый', 'uz' => 'To‘q sariq'], 'hex' => '#FFA500'],
            ['name' => ['en' => 'Purple', 'ru' => 'Фиолетовый', 'uz' => 'Binafsha'], 'hex' => '#800080'],
            ['name' => ['en' => 'Brown', 'ru' => 'Коричневый', 'uz' => 'Jigarrang'], 'hex' => '#A52A2A'],
            ['name' => ['en' => 'Pink', 'ru' => 'Розовый', 'uz' => 'Pushti'], 'hex' => '#FFC0CB'],
            ['name' => ['en' => 'Lime', 'ru' => 'Лаймовый', 'uz' => 'Lime'], 'hex' => '#00FF00'],
            ['name' => ['en' => 'Indigo', 'ru' => 'Индиго', 'uz' => 'Indigo'], 'hex' => '#4B0082'],
            ['name' => ['en' => 'Gold', 'ru' => 'Золотой', 'uz' => 'Oltin'], 'hex' => '#FFD700'],
            ['name' => ['en' => 'Silver', 'ru' => 'Серебряный', 'uz' => 'Kumush'], 'hex' => '#C0C0C0'],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate($color);
        }
    }
}
