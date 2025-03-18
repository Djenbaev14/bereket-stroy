<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses= [
            [
                'type'=>'unpaid',
                "name"=>[
                    "uz"=>"to'lanmagan",
                    "en"=>"unpaid",
                    "ru"=>"неоплаченный",
                    "qr"=>"tólenbegen",
                ],
            ],
            [
                'type'=>'processing',
                "name"=>[
                    "uz"=>"to‘lov jarayonida",
                    "en"=>"process",
                    "ru"=>"в процессе оплаты",
                    "qr"=>"tólem procesinde",
                ],
            ],
            [
                'type'=>'paid',
                "name"=>[
                    "uz"=>"to‘landi",
                    "en"=>"paid",
                    "ru"=>"оплаченный",
                    "qr"=>"tólendi",
                ],
            ],
            [
                'type'=>'failed',
                "name"=>[
                    "en"=>"payment failed",
                    "uz"=>"to'lov muvaffaqiyatsiz tugadi",
                    "ru"=>"оплата не удалась",
                    "qr"=>"tólem orınlanbadı",
                ],
            ],
            [
                'type'=>'refunded',
                "name"=>[
                    "en"=>"payment refunded",
                    "uz"=>"to'lov qaytarildi",
                    "ru"=>"оплата возвращена",
                    "qr"=>"tólem qaytarıldı",
                ],
            ]
        ];
        foreach ($statuses as $status) {
            PaymentStatus::create($status);
        }
    }
}
