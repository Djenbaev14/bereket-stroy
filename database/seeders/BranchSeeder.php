<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches=[
            [
                'branch_name' => [
                    'uz' => 'Nokis filiali',
                    'ru' => 'Филиал Нокис',
                    'en' => 'Nokis Branch',
                    'qr' => 'Nokis filiali',
                ],
                'street' => [
                    'uz'=>'Nokis Allayar Dosnazar koshesi 1-uy',
                    'ru'=>'Улица Аллайара Досназара 1-дом',
                    'en'=>'Allayar Dosnazar street 1-house',
                    'qr'=>'Allayar Dosnazar kochasi 1-uy',
                ],
                'start_date' => '08:00',
                'end_date' => '18:00',
                'days' => [1,2,3,4,5],
                'point_array'=>[59.62167452933488, 42.45712039038748]
            ],

            [
                'branch_name' => [
                    'uz' => 'Mega Nukus filiali',
                    'ru' => 'Филиал Мега Нукус',
                    'en' => 'Mega Nukus Branch',
                    'qr' => 'Mega Nukus filiali',
                ],
                'street' => [
                    'uz'=>'Nokis Allayar Dosnazar koshesi 2-uy',
                    'ru'=>'Улица Аллайара Досназара 2-дом',
                    'en'=>'Allayar Dosnazar street 2-house',
                    'qr'=>'Allayar Dosnazar kochasi 2-uy',
                ],
                'start_date' => '08:00',
                'end_date' => '18:00',
                'days' => [1,2,3,4,5,6],
                'point_array'=>[59.62167452933488, 42.45712039038748]
            ],

        ];
        foreach ($branches as $branch) {
            $b=Branch::create([
                'branch_name' => $branch['branch_name'],
                'street' => $branch['street'],
                'start_date' => $branch['start_date'],
                'end_date' => $branch['end_date'],
                'point_array' => $branch['point_array'],
            ]);
            $b->days()->attach($branch['days']);
        }
    }
}
