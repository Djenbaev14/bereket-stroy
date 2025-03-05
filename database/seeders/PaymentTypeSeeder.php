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
                    "uz" => "Muddatli to'lov",
                    "ru"=>"Отсроченный платеж",
                    "en"=>"Deferred payment",
                    "qr"=>"Múddetli tólem"
                ],
                'text'=>[
                    'uz'=>"Buyurtmani 3 oydan 24 oy muddatgacha bo‘lib to‘lashingiz mumkin.",
                    'ru'=>"Вы можете оплатить заказ в рассрочку от 3 до 24 месяцев.",
                    'en'=>"You can pay for the order in installments from 3 to 24 months.",
                    'qr'=>"Buyırtpanı 3 aydan 24 ayǵa shekemgi múddetke bólip tólew múmkin.",
                ],
                'photo'=>'images/payments/muddatli.png',
            ],
            [
                'name' => [
                    "uz" => "Naqd pul",
                    "ru" => "Наличные",
                    "en" => "Cash",
                    "qr" => "naq pul",
                ],
                'photo'=>'images/payments/naqd.png',
                'text'=>[
                    'uz'=>'Buyurtmani qo‘lingizga olganingizda naqt ko‘rinishida to‘lashingiz mumkin.',
                    'ru'=>'Вы можете оплатить заказ наличными при получении.',
                    'en'=>'You can pay for the order in cash when you receive it.',
                    'qr'=>'Buyırtpanı qolıńızǵa alǵanda naq kóriniste tólewińiz múmkin.',
                ]
            ],
            [
                'name' => [
                    "uz" => "Uzum bank",
                    "ru" => "Uzum bank",
                    "en" => "Uzum bank",
                    "qr" => "Uzum bank",
                ],
                'photo'=>'images/payments/uzum.png',
                'text'=>[
                    'uz'=>'Sizni Uzum bank ilovasiga yo‘naltiramiz, u yerda buyurtma uchun to‘lovni amalga oshirishingiz mumkin.',
                    'ru'=>'Мы перенаправим вас в приложение Uzum bank, где вы сможете оплатить заказ.',
                    'en'=>'We will redirect you to the Uzum bank, where you can pay for the order.',
                    'qr'=>'Sizdi Uzum bank qosımshasına jiberemiz, ol jerde buyırtpa ushın tólemdi ámelge asırıwıńız múmkin.',
                ]
            ],
            [
                'name' => [
                    "uz" => "Payme",
                    "ru" => "Payme",
                    "en" => "Payme"
                ],
                'photo'=>'images/payments/payme.png',
                'text'=>[
                    'uz'=>'Sizni Payme ilovasiga yo‘naltiramiz, u yerda buyurtma uchun to‘lovni amalga oshirishingiz mumkin.',
                    'ru'=>'Мы перенаправим вас в приложение Payme, где вы сможете оплатить заказ.',
                    'en'=>'We will redirect you to the Payme, where you can pay for the order.',
                    'qr'=>'Sizdi Payme qosımshasına jiberemiz, ol jerde buyırtpa ushın tólemdi ámelge asırıwıńız múmkin.',
                ]
            ],
            [
                'name' => [
                    "uz" => "Click",
                    "ru" => "Click",
                    "en" => "Click"
                ],
                'photo'=>'images/payments/click.png',
                'text'=>[
                    'uz'=>'Sizni click-up ilovasiga yo‘naltiramiz, u yerda buyurtma uchun to‘lovni amalga oshirishingiz mumkin.',
                    'ru'=>'Мы перенаправим вас в приложение Click, где вы сможете оплатить заказ.',
                    'en'=>'We will redirect you to the Click, where you can pay for the order.',
                    'qr'=>'Sizdi click-up qosımshasına jiberemiz, ol jerde buyırtpa ushın tólemdi ámelge asırıwıńız múmkin.',
                ]
            ],
            
        ];
        
        foreach ($payment_types as $payment_type) {
            PaymentType::create($payment_type);
        }
    }
}
