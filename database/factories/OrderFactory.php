<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Order::class;

    public function definition(): array
    {
        // Ambil customer, metode pengiriman, dan pembayaran secara acak
        $customer = User::where('role', 'customer')->inRandomOrder()->first();
        $deliveryMethod = \App\Models\DeliveryMethod::inRandomOrder()->first();
        $paymentMethod = \App\Models\PaymentMethod::inRandomOrder()->first();

        // Tentukan tanggal pesanan secara acak dari 3 bulan lalu sampai hari ini
        $orderDate = $this->faker->dateTimeBetween('-3 months', 'now');
        $pickupDate = (clone $orderDate)->modify('+' . rand(3, 10) . ' days');

        return [
            'no_transaction' => 'ARA-' . Str::upper(Str::random(3)) . '-' . $orderDate->format('YmdHis'),
            'user_id' => $customer->id,
            'order_status_id' => OrderStatus::inRandomOrder()->first()->id, // Status awal acak
            'delivery_method_id' => $deliveryMethod->id,
            'pickup_delivery_address_id' => $customer->addresses()->inRandomOrder()->first()->id ?? null,
            'payment_method_id' => $paymentMethod->id,
            'order_date' => $orderDate,
            'pickup_delivery_date' => $pickupDate,
            'total_amount' => 0, // Akan dihitung ulang nanti
            'delivery_cost' => $deliveryMethod->is_pickup ? 0 : 0, // Di seeder ini kita anggap gratis dulu
            'notes' => $this->faker->optional(0.3)->sentence, // 30% pesanan punya catatan
            'is_cancelled' => false,
            'cancellation_reason' => null,
            'is_finish' => false,
        ];
    }

     /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {
            // == LOGIKA CERDAS DIMULAI DI SINI ==

            $subtotal = 0;
            // 1. Buat 1 sampai 3 item pesanan (OrderItems) untuk setiap pesanan
            $products = Product::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($products as $product) {
                $quantity = rand(1, 2);
                $itemSubtotal = $product->price * $quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ]);
                $subtotal += $itemSubtotal;
            }

            // 2. Update total_amount di pesanan utama berdasarkan subtotal item
            $order->total_amount = $subtotal + $order->delivery_cost;
            $order->save();

            // 3. Buat Log pertama: "ORDER_CREATED"
            OrderLog::create([
                'order_id' => $order->id,
                'actor_user_id' => $order->user_id,
                'event_type' => 'ORDER_CREATED',
                'message' => 'Pesanan dibuat oleh pelanggan.',
                'timestamp' => $order->order_date,
            ]);

            // 4. Logika berdasarkan Status Pesanan
            $status = $order->status; // Mengambil relasi status

            // Jika status BUKAN "Menunggu Pembayaran", maka buat data pembayaran (Payment)
            if ($status->order > 1) { 
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method_id' => $order->payment_method_id,
                    'payment_date' => (clone $order->order_date)->modify('+' . rand(0, 24) . ' hours'),
                    'proof_of_payment_url' => null,
                    'is_confirmed' => ($status->order > 2), // Terkonfirmasi jika statusnya sudah lewat "Menunggu Konfirmasi"
                    'confirmed_by_user_id' => ($status->order > 2) ? User::where('role', 'admin')->first()->id : null,
                    'confirmed_at' => ($status->order > 2) ? (clone $order->order_date)->modify('+2 days') : null,
                ]);

                // Buat Log: "PAYMENT_PROOF_UPLOADED"
                 OrderLog::create([
                    'order_id' => $order->id,
                    'actor_user_id' => $order->user_id,
                    'event_type' => 'PAYMENT_PROOF_UPLOADED',
                    'message' => 'Bukti pembayaran diunggah.',
                    'timestamp' => (clone $order->order_date)->modify('+1 hours'),
                ]);
            }

            // Jika status "Selesai", "Dibatalkan", atau "Gagal"
            if (in_array($status->status_name, ['Selesai', 'Dibatalkan', 'Gagal'])) {
                if ($status->status_name === 'Selesai') {
                    $order->is_finish = true;
                }
                if (in_array($status->status_name, ['Dibatalkan', 'Gagal'])) {
                    $order->is_cancelled = true;
                    $order->cancellation_reason = 'Dibatalkan otomatis oleh sistem seeder.';
                }
                $order->save();

                // Buat Log terakhir
                OrderLog::create([
                    'order_id' => $order->id,
                    'actor_user_id' => User::where('role', 'admin')->first()->id,
                    'event_type' => $status->status_name === 'Selesai' ? 'ORDER_COMPLETED' : 'ORDER_CANCELLED',
                    'message' => 'Pesanan ditandai sebagai ' . strtolower($status->status_name) . ' oleh admin.',
                    'timestamp' => (clone $order->pickup_delivery_date)->modify('+1 days'),
                ]);
            }
        });
    }
}
