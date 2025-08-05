<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orderStatus = OrderStatus::orderBy('id')->get();

        $query = Order::with('user', 'status');
        if ($request->filled('status')) {
            $query->where('order_status_id', $request->input('status'));
        }

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', $searchTerm)
                    ->orWhereHas('user', function ($q2) use ($searchTerm) {
                        $q2->where('name', 'like', $searchTerm);
                    });
            });
        }

        // Ambil data pesanan dengan pagination
        $orders = $query->latest()->paginate(10);

        return view('admin.order.index', compact('orders', 'orderStatus'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'status', 'deliveryMethod', 'address', 'items.product');

        $orderStatuses = OrderStatus::all();

        return view('admin.orders.show', compact('order', 'status'));
    }

    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'order_status_id' => 'required|exists:order_statuses,id',
            'cancellation_reason' => 'nullable|string|max:255',
        ]);

        $oldStatus = $order->orderStatus->name;
        $newStatus = OrderStatus::find($validatedData['order_status_id'])->name;

        DB::beginTransaction();
        try {
            // Update status pesanan
            $order->order_status_id = $validatedData['order_status_id'];
            // Update alasan pembatalan jika ada
            if ($request->filled('cancellation_reason')) {
                $order->cancellation_reason = $validatedData['cancellation_reason'];
            }

            $oldStatus = $order->status->name;
            $newStatus = OrderStatus::find($validatedData['order_status_id'])->name;

            // ---- LOG SYSTEM ---- //
            SystemLog::log(
                LogLevel::INFO->value,
                'ORDER_STATUS_UPDATED',
                'Status pesanan #' . $order->id . ' diubah dari "' . $oldStatus . '" menjadi "' . $newStatus . '" oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
                [
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'updated_by_user_id' => Auth::id(),
                    'request_data' => $validatedData,
                ]
            );
            // ---- END LOG SYSTEM ---- //

            // ---- ORDER LOG ---- //
            $order->logs()->create([
                'order_id' => $order->id,
                'timestamp' => now(),
                'actor_user_id' => Auth::id(),
                'event_type' => 'ORDER_STATUS_UPDATED',
                'old_value' => $oldStatus,
                'new_value' => $newStatus,
                'message' => 'Status pesanan diubah dari "' . $oldStatus . '" menjadi "' . $newStatus . '" oleh ' . (Auth::user()->name ?? 'Pengguna Tidak Dikenal') . '.',
            ]);
            // ---- END ORDER LOG ---- //

            $order->save();

            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status pesanan: ' . $e->getMessage());
        }
    }
}
