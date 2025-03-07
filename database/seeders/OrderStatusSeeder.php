<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // statuses 3 languages (en, ru, uz)
        // ['pending', 'processing', 'shipped', 'completed', 'cancelled']
        $statuses= [
            [
                
                "name"=>[
                    "uz"=>"yangi",
                    "en"=>"new",
                    "ru"=>"новый",
                    "qr"=>"jańa",
                ],
            ],
            [
                
                "name"=>[
                    "uz"=>"tolov kutilmoqda",
                    "en"=>"payment pending",
                    "ru"=>"ожидание оплаты",
                    "qr"=>"to'lem kutilip atir",
                ],
            ],
            [
               "name"=>[
                'en'=>"paid",
                'uz'=>"to'landi",
                'ru'=>"оплачено",
                'qr'=>"to'lendi",
               ] 
            ],
            [
                
                "name"=>[
                    "en"=>"cancelled",
                    "uz"=>"bekor qilingan",
                    "ru"=>"отменено",
                    "qr"=>"biykar etilgen",
                ],
            ]
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}
