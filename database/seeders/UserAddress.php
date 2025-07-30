<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress as ModelsUserAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserAddress extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create('id_ID'); // Atau locale yang Anda gunakan

        // Batasi jumlah user untuk menghindari seeding terlalu banyak data
        // Jika UserSeeder Anda membuat 10.000 user, ini akan membuat 10.000 alamat
        // pertimbangkan User::take(100)->get() jika ingin membatasi
        User::all()->each(function ($user) use ($faker) {
            ModelsUserAddress::create([
                'user_id' => $user->id,
                'address_line1' => $faker->streetAddress,
                'address_line2' => $faker->buildingNumber, // <--- Ganti di sini
                // Alternatif lain jika Anda ingin sesuatu yang lebih umum:
                // 'address_line_2' => $faker->optional()->word, // Bisa null atau satu kata
                // 'address_line_2' => $faker->optional()->sentence(2, true), // Bisa null atau kalimat pendek
                'city' => $faker->city,
                'province' => $faker->state,
                'postal_code' => $faker->postcode,
                'is_default' => true,
            ]);
        });
    }
}
