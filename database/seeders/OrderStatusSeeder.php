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
                    "ru"=>"новый"
                ],
            ],
            [
                
                "name"=>[
                    "en"=>"completed",
                    "uz"=>"tugallangan",
                    "ru"=>"завершено"
                ],
            ],
            [
                
                "name"=>[
                    "en"=>"cancelled",
                    "uz"=>"bekor qilingan",
                    "ru"=>"отменено"
                ],
            ]
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}
