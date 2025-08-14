<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data id terkait untuk foreign key
        $userIds = DB::table('users')->pluck('id')->toArray();
        $orderStatusIds = DB::table('order_statuses')->pluck('id')->toArray();
        $deliveryMethodIds = DB::table('delivery_methods')->pluck('id')->toArray();
        $addressIds = DB::table('user_addresses')->pluck('id')->toArray();
        $paymentMethodIds = DB::table('payment_methods')->pluck('id')->toArray();

        // Fungsi buat no transaksi unik
        function generateNoTransaction() {
            return 'TRX-' . strtoupper(Str::random(10));
        }

        // Buat 5 data bulan ini
        for ($i = 0; $i < 5; $i++) {
            DB::table('orders')->insert([
                'no_transaction' => generateNoTransaction(),
                'user_id' => $userIds[array_rand($userIds)],
                'order_status_id' => $orderStatusIds[array_rand($orderStatusIds)],
                'delivery_method_id' => $deliveryMethodIds[array_rand($deliveryMethodIds)],
                'pickup_delivery_address_id' => count($addressIds) > 0 ? $addressIds[array_rand($addressIds)] : null,
                'payment_method_id' => $paymentMethodIds[array_rand($paymentMethodIds)],
                'order_date' => Carbon::now()->subDays(rand(0, 10))->toDateTimeString(),
                'pickup_delivery_date' => Carbon::now()->addDays(rand(1, 10))->toDateString(),
                'total_amount' => rand(100000, 1000000) / 100,
                'delivery_cost' => rand(10000, 50000) / 100,
                'notes' => 'Order bulan ini',
                'is_cancelled' => false,
                'cancellation_reason' => null,
                'is_finish' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Buat 5 data bulan lalu
        for ($i = 0; $i < 5; $i++) {
            DB::table('orders')->insert([
                'no_transaction' => generateNoTransaction(),
                'user_id' => $userIds[array_rand($userIds)],
                'order_status_id' => $orderStatusIds[array_rand($orderStatusIds)],
                'delivery_method_id' => $deliveryMethodIds[array_rand($deliveryMethodIds)],
                'pickup_delivery_address_id' => count($addressIds) > 0 ? $addressIds[array_rand($addressIds)] : null,
                'payment_method_id' => $paymentMethodIds[array_rand($paymentMethodIds)],
                'order_date' => Carbon::now()->subMonth()->subDays(rand(0, 10))->toDateTimeString(),
                'pickup_delivery_date' => Carbon::now()->subMonth()->addDays(rand(1, 10))->toDateString(),
                'total_amount' => rand(100000, 1000000) / 100,
                'delivery_cost' => rand(10000, 50000) / 100,
                'notes' => 'Order bulan lalu',
                'is_cancelled' => false,
                'cancellation_reason' => null,
                'is_finish' => false,
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now()->subMonth(),
            ]);
        }
    }
}
