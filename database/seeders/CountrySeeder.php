<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => [
                    'uz' => 'Germaniya',
                    'ru' => 'Германия',
                    'qr' => 'Germaniya',
                    'en' => 'Germany',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Italiya',
                    'qr' => 'Italiya',
                    'ru' => 'Италия',
                    'en' => 'Italy',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Shveysariya',
                    'qr' => 'Shveysariya',
                    'ru' => 'Швейцария',
                    'en' => 'Switzerland',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Ispaniya',
                    'ru' => 'Испания',
                    'qr' => 'Ispaniya',
                    'en' => 'Spain',
                ],
            ],
            [
                'name' => [
                    'uz' => 'AQSh',
                    'ru' => 'США',
                    'qr' => 'AQSh',
                    'en' => 'USA',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Fransiya',
                    'ru' => 'Франция',
                    'qr' => 'Fransiya',
                    'en' => 'France',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Turkiya',
                    'ru' => 'Турция',
                    'qr' => 'Turkiya',
                    'en' => 'Turkey',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Xitoy',
                    'ru' => 'Китай',
                    'qr' => 'Xitoy',
                    'en' => 'China',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Polsha',
                    'ru' => 'Польша',
                    'qr' => 'Polsha',
                    'en' => 'Poland',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Buyuk Britaniya',
                    'ru' => 'Великобритания',
                    'qr' => 'Ullı Britaniya',
                    'en' => 'United Kingdom',
                ],
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
