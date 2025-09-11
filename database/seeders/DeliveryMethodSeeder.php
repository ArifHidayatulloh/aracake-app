<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('delivery_methods')->insert([
            [
                'method_name'  => 'Pickup di Toko',
                'description'  => 'Ambil langsung di toko tanpa biaya tambahan',
                'base_cost'    => 0.00,
                'cost_per_km'  => 0.00,
                'is_pickup'    => true,
                'is_active'    => true,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            
            [
                'method_name'  => 'Ojek Online (GoSend/GrabExpress)',
                'description'  => 'Pengiriman menggunakan layanan pihak ketiga seperti GoSend atau GrabExpress',
                'base_cost'    => 0.00, // Biaya tergantung platform
                'cost_per_km'  => 0.00,
                'is_pickup'    => false,
                'is_active'    => true,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
        ]);
    }
}
