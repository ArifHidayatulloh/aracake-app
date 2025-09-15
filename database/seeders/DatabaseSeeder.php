<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserAddress::class,
            OrderStatusSeeder::class,
            CategorySeeder::class,
            PaymentMethodSeeder::class,
            DeliveryMethodSeeder::class,
            SystemSettingSeeder::class,
            WorkingHourSeeder::class
        ]);


    }
}
