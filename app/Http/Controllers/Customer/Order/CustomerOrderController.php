<?php

namespace App\Http\Controllers\Customer\Order;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\OrderStatus;
use App\Models\Payment;
use Illuminate\Support\Str;
use App\Models\PaymentMethod;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function create()
    {
        $cartItems = Auth::user()->cart->items()->with('product')->get();
        $deliveryMethods = DeliveryMethod::where('is_active', true)->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $userAddresses = Auth::user()->addresses;

        $min_preparation_days = (int) SystemSetting::where('setting_key', 'min_preparation_days')->value('setting_value');

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        return view('customer.order.create', [
            'cartItems' => $cartItems,
            'deliveryMethods' => $deliveryMethods,
            'paymentMethods' => $paymentMethods,
            'userAddresses' => $userAddresses,
            'subtotal' => $subtotal,
            'min_preparation_days' => $min_preparation_days
        ]);
    }

    // ... (lanjutan dari kode sebelumnya)

    public function store(Request $request)
    {
        $min_preparation_days = (int) SystemSetting::where('setting_key', 'min_preparation_days')->value('setting_value');
        $validatedData = $request->validate([
            'pickup_delivery_address_id' => 'required|exists:user_addresses,id',
            'pickup_delivery_date' => 'required|date|after_or_equal:' . now()->addDays($min_preparation_days)->format('Y-m-d'), // Tambahkan validasi tanggal minimum
            'delivery_method_id' => 'required|exists:delivery_methods,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string|max:1000',
        ], [
            'pickup_delivery_date.after_or_equal' => 'Tanggal pengiriman/pengambilan harus setelah ' . now()->addDays($min_preparation_days)->format('Y-m-d'),
            'notes.max' => 'Catatan tidak boleh lebih dari 1000 karakter',
        ]);

        $user = Auth::user();
        // Gunakan relasi dengan benar untuk mendapatkan item keranjang
        $cartItems = $user->cart->items()->with('product')->get();
        $deliveryMethod = DeliveryMethod::find($validatedData['delivery_method_id']);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong, tidak dapat membuat pesanan.');
        }

        // Hitung subtotal dari item keranjang yang diambil dari database
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $deliveryCost = $deliveryMethod->base_cost;
        $totalAmount = $subtotal + $deliveryCost;

        // Ambil status "Pending" secara dinamis, asumsi kolom 'name' ada di tabel order_statuses
        $status = OrderStatus::where('order', '1')->first();
        // Jika tidak ada, fallback ke ID 1 atau lemparkan exception
        if (!$status) {
            throw new \Exception('Order status "Pending" not found.');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'no_transaction' => 'ARA-' . Str::upper(Str::random(3)) . '-' . now()->format('Ymd'),
                'order_status_id' => $status->id,
                'delivery_method_id' => $validatedData['delivery_method_id'],
                'pickup_delivery_address_id' => $validatedData['pickup_delivery_address_id'],
                'payment_method_id' => $validatedData['payment_method_id'],
                'pickup_delivery_date' => $validatedData['pickup_delivery_date'],
                'total_amount' => $totalAmount,
                'delivery_cost' => $deliveryCost,
                'notes' => $validatedData['notes'],
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price, // Ambil harga dari produk, bukan dari item keranjang
                    'subtotal' => $item->product->price * $item->quantity,
                ]);
            }

            // Hapus item keranjang setelah pesanan dibuat
            $user->cart->items()->delete();
            DB::commit();

            // Tambahkan log untuk pesanan yang berhasil dibuat
            // Asumsi OrderLog::log adalah method statis
            OrderLog::log([
                'order_id' => $order->id,
                'actor_user_id' => Auth::id(),
                'event_type' => 'ORDER_CREATED',
                'message' => 'Pesanan baru dibuat oleh ' . Auth::user()->full_name . '.',
                'old_value' => null,
                'new_value' => null,
            ]);

            return redirect()->route('customer.order.payment', ['order' => $order->no_transaction])->with('success', 'Pesanan Anda berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart')->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi. ' . $e->getMessage());
        }
    }

    public function payment(Order $order)
    {
        $systemSetting = SystemSetting::where('is_active', true)->get()->keyBy('setting_key');
        $order->load(['user', 'status', 'deliveryMethod', 'address', 'items.product', 'paymentMethod']);
        return view('customer.payment.payment', compact('order', 'systemSetting'));
    }

    public function cancel(Request $request, Order $order)
    {
        $order->update([
            'order_status_id' => OrderStatus::where('order', '7')->first()->id,
            'is_cancelled' => true,
            'cancellation_reason' => request('cancellation_reason')
        ]);

        $order->logs()->create([
            'actor_user_id' => Auth::id(),
            'order_id' => $order->id,
            'event_type' => 'ORDER_CANCELLED',
            'message' => 'Pesanan telah dibatalkan oleh ' . Auth::user()->full_name . '. Alasan: ' . $request->input('cancellation_reason'),
            'timestamp' => now(),
        ]);

        return redirect()->route('customer.order.detail', ['order' => $order->no_transaction]);
    }
    public function uploadPaymentProof(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $path = $file->store('payment_proof', 'public');
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method_id' => $order->payment_method_id,
                'payment_date' => now(),
                'proof_of_payment_url' => $path,
            ]);

            $order->update([
                'order_status_id' => OrderStatus::where('order', '2')->first()->id
            ]);

            OrderLog::log([
                'order_id' => $order->id,
                'actor_user_id' => Auth::id(),
                'event_type' => 'PAYMENT_PROOF_UPLOADED',
                'message' => 'Pelanggan mengunggah bukti pembayaran.',
            ]);

            DB::commit();
            // Redirect yang sudah pasti benar
            return redirect()->route('customer.order.detail', ['order' => $order->no_transaction])
                ->with('success', 'Bukti pembayaran berhasil diunggah. Kami akan segera memverifikasinya.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah bukti pembayaran. Silakan coba lagi. ' . $e->getMessage());
        }
    }

    public function accepted(Order $order)
    {
        $order->update([
            'order_status_id' => OrderStatus::where('order', '6')->first()->id,
            'is_finish' => true,
        ]);

        $order->logs()->create([
            'order_id' => $order->id,
            'timestamp' => now(),
            'actor_user_id' => Auth::id(),
            'event_type' => 'ORDER_COMPLETED',
            'message' => 'Pesanan telah diterima.',
        ]);
        return redirect()->route('customer.order.detail', ['order' => $order->no_transaction]);
    }

    public function myOrder()
    {
        $status = OrderStatus::where('order', '!=', '5')->where('order', '!=', '6')->where('order', '!=', '7')->orderBy('order', 'asc')->get();
        $orders = Auth::user()->orders()->where('is_cancelled', '!=', true)->where('is_finish', '!=', true)->with(['status', 'paymentMethod', 'deliveryMethod', 'address', 'items.product'])->paginate(10)->withQueryString();
        return view('customer.order.my-order', compact('orders', 'status'));
    }

    public function history()
    {
        // Ambil ID status untuk pesanan selesai, dibatalkan, dan gagal
        $completedId = OrderStatus::where('order', 6)->value('id'); // ORDER_COMPLETED
        $cancelledId = OrderStatus::where('order', 7)->value('id'); // ORDER_CANCELLED
        $failedId = OrderStatus::where('order', 8)->value('id');    // ORDER_FAILED

        // Ambil pesanan user dengan status tersebut
        $orders = Auth::user()->orders()
            ->whereIn('order_status_id', [$completedId, $cancelledId, $failedId])
            ->with(['status', 'paymentMethod', 'deliveryMethod', 'address', 'items.product'])
            ->latest()
            ->paginate(10);

        // Ambil status (jika dibutuhkan untuk filter UI)
        $status = OrderStatus::whereIn('order', [6, 7, 8])
            ->orderBy('order', 'asc')
            ->get();

        return view('customer.order.history', compact('orders', 'status'));
    }


    public function detail(Order $order)
    {
        $systemSetting = SystemSetting::where('is_active', true)->get()->keyBy('setting_key');
        $order->load(['user', 'status', 'deliveryMethod', 'address', 'items.product', 'paymentMethod', 'logs']);
        return view('customer.order.detail', compact('order', 'systemSetting'));
    }
}
