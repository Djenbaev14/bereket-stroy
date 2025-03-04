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
            ['key' => 'monday', 'name' => ['uz' => 'Dushanba', 'en' => 'Monday', 'ru' => 'Понедельник','kr'=>'Dúyshembi']],
            ['key' => 'tuesday', 'name' => ['uz' => 'Seshanba', 'en' => 'Tuesday', 'ru' => 'Вторник','kr'=>'Shiyshembi']],
            ['key' => 'wednesday', 'name' => ['uz' => 'Chorshanba', 'en' => 'Wednesday', 'ru' => 'Среда','kr'=>'Sárshembi']],
            ['key' => 'thursday', 'name' => ['uz' => 'Payshanba', 'en' => 'Thursday', 'ru' => 'Четверг','kr'=>'Piyshembi']],
            ['key' => 'friday', 'name' => ['uz' => 'Juma', 'en' => 'Friday', 'ru' => 'Пятница','kr'=>'Juma']],
            ['key' => 'saturday', 'name' => ['uz' => 'Shanba', 'en' => 'Saturday', 'ru' => 'Суббота','kr'=>'Shembi']],
            ['key' => 'sunday', 'name' => ['uz' => 'Yakshanba', 'en' => 'Sunday', 'ru' => 'Воскресенье','kr'=>'Ekshembi']],
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
