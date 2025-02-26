<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("locales")->insert([
            'code'=>'uz',
            'name'=>"O‘zbek",
            'is_default'=>true,
            'is_active'=>true,
        ]);
        
        DB::table("locales")->insert([
            'code'=>'ru',
            'name'=>"Русский",
            'is_default'=>false,
            'is_active'=>true,
        ]);
        
        DB::table("locales")->insert([
            'code'=>'qr',
            'name'=>"Qaraqalpaq",
            'is_default'=>false,
            'is_active'=>true,
        ]);
        DB::table("locales")->insert([
            'code'=>'en',
            'name'=>"English",
            'is_default'=>false,
            'is_active'=>true,
        ]);
        
    }
}
