<?php

namespace Database\Seeders;

use Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            ['name' => ['ru' => 'Размер', 'uz' => 'O‘lcham', 'en' => 'Size']],
            ['name' => ['ru' => 'Тип', 'uz' => 'Turi', 'en' => 'Type']],
        ];

        foreach ($attributes as $attribute) {
            \App\Models\Attribute::create($attribute);
        }
    }
}
