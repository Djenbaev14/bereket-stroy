<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $payment_types = [
            [
                'name' => [
                    "uz" => "Naqd pul",
                    "ru" => "Наличные",
                    "en" => "Cash"
                ],
            ],
            [
                'name' => [
                    "uz" => "Payme",
                    "ru" => "Payme",
                    "en" => "Payme"
                ],
            ],
            [
                'name' => [
                    "uz" => "Click",
                    "ru" => "Click",
                    "en" => "Click"
                ],
            ],
            [
                'name' => [
                    "uz" => "Muddatli to'lov",
                    "ru"=>"Отсроченный платеж",
                    "en"=>"Deferred payment"
                ],
            ],
            
        ];
        
        foreach ($payment_types as $payment_type) {
            PaymentType::create($payment_type);
        }
    }
}
