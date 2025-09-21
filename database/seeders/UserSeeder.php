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
        // 1. Membuat Admin Utama (data statis)
        User::factory()->create([
            'full_name' => 'Admin Toko',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Membuat 1 Customer dengan data statis (untuk mempermudah demo login)
        User::factory()->create([
            'full_name' => 'Arif Hidayatulloh',
            'username' => 'arif',
            'email' => 'hidayatulloharif590@gmail.com',
            'phone_number' => '089684914092',
            'role' => 'customer',
        ]);
        
        // 3. Membuat 4 Customer lainnya dengan data acak dari Factory
        // Factory akan otomatis menjalankan fungsi afterCreating untuk membuat Cart
        User::factory()->count(4)->create();
    }
}
