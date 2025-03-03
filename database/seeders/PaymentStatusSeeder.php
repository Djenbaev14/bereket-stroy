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
        // ['pending', 'paid', 'failed']
        $payment_status=[
            [
                "name"=>[
                    "uz"=>"To'langan",
                    "ru"=>"Оплачено",
                    "en"=> "Paid"
                ]
            ],
            [
                "name"=>[
                    "en"=>"failed",
                    "uz"=>"To'lanmadi",
                    "ru"=>"Не оплачено"
                ]
            ],
        ];

        foreach ($payment_status as $value) {
            PaymentStatus::create($value);
        }
    }
}
