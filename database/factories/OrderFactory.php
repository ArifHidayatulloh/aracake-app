<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $customer = User::where('role', 'customer')->inRandomOrder()->first();
        $deliveryMethod = \App\Models\DeliveryMethod::inRandomOrder()->first();
        $paymentMethod = \App\Models\PaymentMethod::inRandomOrder()->first();
        $orderDate = $this->faker->dateTimeBetween('-3 months', 'now');
        
        return [
            'no_transaction' => 'ARA-' . Str::upper(Str::random(3)) . '-' . $orderDate->format('YmdHis'),
            'user_id' => $customer->id,
            'order_status_id' => OrderStatus::where('order', 1)->first()->id, 
            'delivery_method_id' => $deliveryMethod->id,
            'pickup_delivery_address_id' => $customer->addresses()->inRandomOrder()->first()->id ?? null,
            'payment_method_id' => $paymentMethod->id,
            'order_date' => $orderDate,
            'pickup_delivery_date' => (clone $orderDate)->modify('+' . rand(3, 10) . ' days'),
            'total_amount' => 0, 'delivery_cost' => 0, 'notes' => $this->faker->optional(0.3)->sentence,
            'is_cancelled' => false, 'cancellation_reason' => null, 'is_finish' => false,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {
            $allStatuses = OrderStatus::orderBy('order')->get()->keyBy('order');
            $finalStatus = $allStatuses->random();
            
            $subtotal = 0;
            $products = Product::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($products as $product) {
                $quantity = rand(1, 2);
                $itemSubtotal = $product->price * $quantity;
                OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'quantity' => $quantity, 'unit_price' => $product->price, 'subtotal' => $itemSubtotal]);
                $subtotal += $itemSubtotal;
            }
            $order->total_amount = $subtotal + $order->delivery_cost;
            $order->save();

            $currentTime = Carbon::parse($order->order_date);

            foreach ($allStatuses as $level => $status) {
                if ($level > $finalStatus->order) break;
                
                $currentTime->addHours(rand(1, 48));
                
                $previousStatus = $allStatuses->get($level - 1);

                switch ($level) {
                    case 1:
                        OrderLog::create(['order_id' => $order->id, 'actor_user_id' => $order->user_id, 'event_type' => 'ORDER_CREATED', 'message' => 'Pesanan dibuat oleh pelanggan.', 'timestamp' => $order->order_date, 'new_value' => $status->status_name]);
                        break;
                    case 2:
                        Payment::create(['order_id' => $order->id, 'payment_method_id' => $order->payment_method_id, 'payment_date' => $currentTime, 'proof_of_payment_url' => '', 'is_confirmed' => false]);
                        OrderLog::create(['order_id' => $order->id, 'actor_user_id' => $order->user_id, 'event_type' => 'PAYMENT_PROOF_UPLOADED', 'message' => 'Bukti pembayaran diunggah.', 'timestamp' => $currentTime, 'old_value' => $previousStatus?->status_name, 'new_value' => $status->status_name]);
                        break;
                    case 3:
                        $order->payment()->update(['is_confirmed' => true, 'confirmed_by_user_id' => User::where('role', 'admin')->first()->id, 'confirmed_at' => $currentTime]);
                        OrderLog::create(['order_id' => $order->id, 'actor_user_id' => User::where('role', 'admin')->first()->id, 'event_type' => 'PAYMENT_CONFIRMED', 'message' => 'Pembayaran dikonfirmasi admin.', 'timestamp' => $currentTime, 'old_value' => $previousStatus?->status_name, 'new_value' => $status->status_name]);
                        break;
                    case 4:
                        OrderLog::create(['order_id' => $order->id, 'actor_user_id' => User::where('role', 'admin')->first()->id, 'event_type' => 'ORDER_PROCESSED', 'message' => 'Pesanan mulai diproses.', 'timestamp' => $currentTime, 'old_value' => $previousStatus?->status_name, 'new_value' => $status->status_name]);
                        break;
                    case 5:
                         OrderLog::create(['order_id' => $order->id, 'actor_user_id' => User::where('role', 'admin')->first()->id, 'event_type' => 'DELIVERY_ASSIGNED', 'message' => 'Pesanan siap untuk diambil/dikirim.', 'timestamp' => $currentTime, 'old_value' => $previousStatus?->status_name, 'new_value' => $status->status_name]);
                        break;
                    case 6: // Selesai
                        // [PERBAIKAN KUNCI] Hanya buat log 'Selesai' jika status akhirnya BUKAN 'Dibatalkan' atau 'Gagal'
                        if (!in_array($finalStatus->status_name, ['Dibatalkan', 'Gagal'])) {
                             OrderLog::create(['order_id' => $order->id, 'actor_user_id' => User::where('role', 'admin')->first()->id, 'event_type' => 'ORDER_COMPLETED', 'message' => 'Pesanan selesai.', 'timestamp' => $currentTime, 'old_value' => $previousStatus?->status_name, 'new_value' => $status->status_name]);
                        }
                        break;
                }
            }

            if ($finalStatus->status_name === 'Selesai') {
                $order->is_finish = true;
                $order->is_cancelled = false;
            } elseif (in_array($finalStatus->status_name, ['Dibatalkan', 'Gagal'])) {
                $order->is_finish = false;
                $order->is_cancelled = true;
                $order->cancellation_reason = 'Dibatalkan/Gagal oleh sistem seeder.';
                
                $lastValidStatusKey = collect([1,2,3,4,5])->filter(fn($val) => $val < $finalStatus->order)->last();
                $lastValidStatus = $allStatuses->get($lastValidStatusKey);

                OrderLog::create(['order_id' => $order->id, 'actor_user_id' => User::where('role', 'admin')->first()->id, 'event_type' => 'ORDER_CANCELLED', 'message' => 'Pesanan dibatalkan.', 'timestamp' => $currentTime->addHours(1), 'old_value' => $lastValidStatus?->status_name, 'new_value' => $finalStatus->status_name]);
            }
            
            $order->order_status_id = $finalStatus->id;
            $order->save();
        });
    }
}