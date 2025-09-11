<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'setting_key' => 'min_preparation_days',
                'setting_value' => '2',
                'description' => 'Minimal hari persiapan untuk setiap pesanan (tidak termasuk hari libur).',
                'type' => 'int',
            ],
            [
                'setting_key' => 'store_address',
                'setting_value' => 'Jl. Bunga Melati No. 12, Kel. Harapan, Kec. Jaya, Kota Jakarta Timur, Kode Pos 13120',
                'description' => 'Alamat fisik toko Ara Cake.',
                'type' => 'string',
            ],
            [
                'setting_key' => 'store_phone',
                'setting_value' => '021-7890123',
                'description' => 'Nomor telepon kontak toko.',
                'type' => 'string',
            ],
            [
                'setting_key' => 'store_email',
                'setting_value' => 'info@aracake.com',
                'description' => 'Alamat email kontak toko.',
                'type' => 'string',
            ],
            [
                'setting_key' => 'delivery_radius_km',
                'setting_value' => '15.5',
                'description' => 'Radius maksimum pengiriman lokal dalam kilometer.',
                'type' => 'decimal',
            ],
            // [
            //     'setting_key' => 'working_hours',
            //     'setting_value' => json_encode([
            //         'Monday' => '09:00-17:00',
            //         'Tuesday' => '09:00-17:00',
            //         'Wednesday' => '09:00-17:00',
            //         'Thursday' => '09:00-17:00',
            //         'Friday' => '09:00-17:00',
            //         'Saturday' => '10:00-15:00',
            //         'Sunday' => 'Closed',
            //     ]),
            //     'description' => 'Jam operasional toko.',
            //     'type' => 'json',
            // ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::firstOrCreate(
                ['setting_key' => $setting['setting_key']],
                $setting
            );
        }
        $this->command->info('System settings seeded!');
    }
}
