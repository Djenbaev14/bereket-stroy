<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            ['key' => 'monday', 'name' => ['uz' => 'Dushanba', 'en' => 'Monday', 'ru' => 'Понедельник']],
            ['key' => 'tuesday', 'name' => ['uz' => 'Seshanba', 'en' => 'Tuesday', 'ru' => 'Вторник']],
            ['key' => 'wednesday', 'name' => ['uz' => 'Chorshanba', 'en' => 'Wednesday', 'ru' => 'Среда']],
            ['key' => 'thursday', 'name' => ['uz' => 'Payshanba', 'en' => 'Thursday', 'ru' => 'Четверг']],
            ['key' => 'friday', 'name' => ['uz' => 'Juma', 'en' => 'Friday', 'ru' => 'Пятница']],
            ['key' => 'saturday', 'name' => ['uz' => 'Shanba', 'en' => 'Saturday', 'ru' => 'Суббота']],
            ['key' => 'sunday', 'name' => ['uz' => 'Yakshanba', 'en' => 'Sunday', 'ru' => 'Воскресенье']],
        ];

        foreach ($days as $day) {
            DB::table('days')->insert([
                'key' => $day['key'],
                'name' => json_encode($day['name'], JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
