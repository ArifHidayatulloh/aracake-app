<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Admin
         */
        User::create([
            'full_name' => 'Admin Toko',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'phone_number' => '081234567890',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        /**
         * Customer
         */

        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 20; $i++) {
            User::create([
                'full_name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->email,
                'phone_number' => $faker->phoneNumber,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);
        }
    }
}
