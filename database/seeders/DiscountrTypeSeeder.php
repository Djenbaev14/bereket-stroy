<?php

namespace Database\Seeders;

use App\Models\DiscountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountrTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discounts=[
            [
                'name' => [
                    'uz' => 'Foiz',
                    'ru' => 'Процент',
                    'en' => 'Percentage',
                ],
                'discount_type'=>'%'
            ],
            [
                'name' => [
                    'uz' => 'Fiksa',
                    'ru' => 'Фиксированная скидка',
                    'en' => 'Fixed',
                ],
                'discount_type'=>'UZS'
            ]
        ];
        
        foreach ($discounts as $discount) {
            DiscountType::create($discount);
        }
    }
}
