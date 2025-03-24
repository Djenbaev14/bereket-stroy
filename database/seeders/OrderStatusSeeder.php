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
        $statuses= [
            [
                'status'=>'pending',
                "name"=>[
                    "uz"=>"buyurtma qabul qilindi",
                    "en"=>"order received",
                    "ru"=>"заказ принят",
                    "qr"=>"buyırtpa qabıl etildi",
                ],
            ],
            [
                'status'=>'confirmed',
                "name"=>[
                    "uz"=>"buyurtma tasdiqlandi",
                    "en"=>"order approved",
                    "ru"=>"заказ одобрен",
                    "qr"=>"buyırtpa tastıyıqlandı",
                ],
            ],
            // [
            //     'status'=>'processing',
            //     "name"=>[
            //         'en'=>"preparing order",
            //         'uz'=>"buyurtma tayyorlanmoqda",
            //         'ru'=>"подготовка заказа",
            //         'qr'=>"buyırtpa tayarlanıp",
            //    ] 
            // ],
            [
                'status'=>'delivered',
                "name"=>[
                    "en"=>"order delivered to customer",
                    "uz"=>"buyurtma mijozga yetkazildi",
                    "ru"=>"заказ доставлен клиенту",
                    "qr"=>"buyırtpa klientke jetkerildi",
                ],
            ],
            // [
            //     'status'=>'picked_up',
            //     "name"=>[
            //         "en"=>"customer picked up the order",
            //         "uz"=>"mijoz buyurtmani olib ketdi",
            //         "ru"=>"клиент забрал заказ",
            //         "qr"=>"klient buyırtpanı alıp ketti",
            //     ],
            // ],
            [
                'status'=>'cancelled',
                "name"=>[
                    "en"=>"order canceled",
                    "uz"=>"buyurtma bekor qilindi",
                    "ru"=>"заказ отменён",
                    "qr"=>"buyırtpa biykarlandı",
                ],
            ]
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}
