<?php

namespace Database\Seeders;

use App\Models\DeliveryMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => [
                    'uz'=>'Olib ketish',
                    'ru'=>'Еда на вынос',
                    'en'=>'Take away',
                ],
            ],
            [
                'name' => [
                    'uz'=>'Yetkazib berish',
                    'ru'=>'Доставка',
                    'en'=> 'Delivery',
                ],
            ],
            
        ];
        
        foreach ($methods as $method) {
            DeliveryMethod::create($method);
        }
    }
}
