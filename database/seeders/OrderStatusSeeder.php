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
                    "uz"=>"qabul qilingan",
                    "ru"=>"принят",
                    "qr"=>"qabıl etilgen",
                    'en'=>'accepted'
                ],
            ],
            [
                "name"=>[
                    "en"=>"completed",
                    "uz"=>"tugallangan",
                    "ru"=>"завершено",
                    "qr"=>"tamamlanǵan",
                ],
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
