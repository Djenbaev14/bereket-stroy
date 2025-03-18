<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Goodoneuz\PayUz\Database\Seeds\PayUzSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // ColorSeeder::class,
            // CategorySeeder::class,
            // SubCategorySeeder::class,
            // SubSubCategorySeeder::class,
            // CountrySeeder::class,
            // BrandSeeder::class,
            // DiscountrTypeSeeder::class,
            PaymentStatusSeeder::class,
            PaymentMethodSeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
            PaymentTypeSeeder::class,
            DeliveryMethodSeeder::class,
            DaySeeder::class,
            OrderStatusSeeder::class,
            // BranchSeeder::class,
        ]);
    }
}
