<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_statuses')->insert([
            [
                'status_name'    => 'Menunggu Pembayaran',
                'order'          => 1,
                'description'    => 'Pesanan telah dibuat, menunggu pembayaran dari pelanggan.',
                'status_color'   => '#FFA500',
                'is_active'      => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'status_name'    => 'Menunggu Konfirmasi Pembayaran',
                'order'          => 2,
                'description'    => 'Menunggu aksi dari admin.',
                'status_color'   => '#FFC107',
                'is_active'      => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'status_name'    => 'Pembayaran dikonfirmasi',
                'order'          => 3,
                'description'    => 'Pembayaran dikonfirmasi oleh admin.',
                'status_color'   => '#4CAF50',
                'is_active'      => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'status_name'    => 'Pesanan Diproses',
                'order'          => 4,
                'description'    => 'Pesanan sedang diproses.',
                'status_color'   => '#2196F3',
                'is_active'      => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'status_name'    => 'Siap Diambil/Dikirim',
                'order'          => 5,
                'description'    => 'Barang siap untuk diambil/dikirim.',
                'status_color'   => '#03A9F4',
                'is_active'      => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'status_name'    => 'Selesai',
                'order'          => 6,
                'description'    => 'Pesanan telah diambil/diterima.',
                'status_color'   => '#2E7D32',
                'is_active'      => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'status_name'    => 'Dibatalkan',
                'order'          => 7,
                'description'    => 'Pesanan dibatalkan.',
                'status_color'   => '#9E9E9E',
                'is_active'      => 0,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'status_name'    => 'Gagal',
                'order'          => 8,
                'description'    => 'Masalah dalam pesanan.',
                'status_color'   => '#F44336',
                'is_active'      => 0,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            
        ]);
    }
}
