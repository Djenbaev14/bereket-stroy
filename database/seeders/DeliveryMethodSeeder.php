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
                'type'=>'pickup',
                'name' => [
                    'uz'=>'Olib ketish',
                    'ru'=>'Самовывоз',
                    'en'=>'Take away',
                    'qr'=>'Alıp ketiw',
                ],
            ],
            [
                'type'=>'courier',
                'name' => [
                    'uz'=>'Yetkazib berish',
                    'ru'=>'Доставка',
                    'en'=> 'Delivery',
                    'qr'=>'Jetkerip beriw',
                ],
            ],
            
        ];
        
        foreach ($methods as $method) {
            DeliveryMethod::create($method);
        }
    }
}
