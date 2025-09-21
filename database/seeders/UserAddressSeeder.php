<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserAddress;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // 1. Ambil SEMUA user yang rolenya 'customer'
        $customers = User::where('role', 'customer')->get();

        // 2. Loop setiap customer dan buatkan satu alamat default
        foreach ($customers as $customer) {
            UserAddress::factory()->create([
                'user_id' => $customer->id,
                'is_default' => true,
            ]);
        }

        // 3. (OPSIONAL TAPI SANGAT DISARANKAN UNTUK DEMO)
        // Kita buat alamat yang statis/pasti untuk customer demo kita ('arif')
        // agar datanya mudah diprediksi saat demo.

        $demoCustomer = User::where('username', 'arif')->first();
        if ($demoCustomer) {
            // Update alamat yang tadi sudah dibuat oleh factory
            // agar datanya tidak acak
            $demoCustomer->addresses()->first()->update([
                'address_line1' => 'Jl. Demo Aplikasi No. 123',
                'address_line2' => 'Blok A4, Kav. 10',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'postal_code' => '12190',
            ]);
        }
    }
}
