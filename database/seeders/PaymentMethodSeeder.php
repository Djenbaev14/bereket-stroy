<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses= [
            [
                "name"=>'cash'
            ],
            [
                "name"=>'payment'
            ],
            [
               "name"=>'installment'
            ],
        ];
        
        foreach ($statuses as $payment_method) {
            PaymentMethod::create($payment_method);
        }
    }
}
