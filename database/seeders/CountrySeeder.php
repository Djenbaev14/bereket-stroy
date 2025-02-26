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
                    'en' => 'Germany',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Italiya',
                    'ru' => 'Италия',
                    'en' => 'Italy',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Shveysariya',
                    'ru' => 'Швейцария',
                    'en' => 'Switzerland',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Ispaniya',
                    'ru' => 'Испания',
                    'en' => 'Spain',
                ],
            ],
            [
                'name' => [
                    'uz' => 'AQSh',
                    'ru' => 'США',
                    'en' => 'USA',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Fransiya',
                    'ru' => 'Франция',
                    'en' => 'France',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Turkiya',
                    'ru' => 'Турция',
                    'en' => 'Turkey',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Xitoy',
                    'ru' => 'Китай',
                    'en' => 'China',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Polsha',
                    'ru' => 'Польша',
                    'en' => 'Poland',
                ],
            ],
            [
                'name' => [
                    'uz' => 'Buyuk Britaniya',
                    'ru' => 'Великобритания',
                    'en' => 'United Kingdom',
                ],
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
