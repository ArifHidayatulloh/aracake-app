<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'method_name'     => 'Transfer Bank BCA',
                'account_number'  => '1234567890',
                'account_details' => 'A/N Toko Kue Ara',
                'description'     => 'Pembayaran melalui transfer ke rekening BCA',
                'is_active'       => true,
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],
            [
                'method_name'     => 'Transfer Bank BRI',
                'account_number'  => '0987654321',
                'account_details' => 'A/N Toko Kue Ara',
                'description'     => 'Pembayaran melalui transfer ke rekening BRI',
                'is_active'       => true,
                'created_at'      => Carbon::now(),
                'updated_at'      => Carbon::now(),
            ],
        ]);
    }
}
