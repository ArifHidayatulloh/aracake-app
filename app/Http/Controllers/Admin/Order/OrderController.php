<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\SystemLog;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all order statuses for the dropdown filter
        $orderStatus = OrderStatus::orderBy('order')->get();

        // Fetch data for the dashboard widgets
        $totalRevenue = Order::whereHas('status', function ($q) {
            $q->where('order', '6');
        })->sum('total_amount');
        $pendingOrders = Order::whereHas('status', function ($q) {
            $q->whereNotIn('order', ['6', '7', '8']);
        })->count();


        // Start with the base query for the orders table
        $query = Order::with('user', 'status');
        // Apply filters based on request input
        if ($request->filled('status')) {
            $query->where('order_status_id', $request->input('status'));
        }

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_transaction', 'like', $searchTerm)
                    ->orWhereHas('user', function ($q2) use ($searchTerm) {
                        $q2->where('full_name', 'like', $searchTerm);
                    });
            });
        }

        // New: Apply date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('pickup_delivery_date', [$request->input('start_date'), $request->input('end_date')]);
        }

        // New: Handle sorting based on request input
        $sortColumn = $request->get('sort', 'created_at'); // Default sort column
        $sortDirection = $request->get('direction', 'desc'); // Default sort direction

        // Validate sort column to prevent SQL injection
        $allowedSortColumns = ['no_transaction', 'created_at', 'total_amount', 'pickup_delivery_date'];
        if (in_array($sortColumn, $allowedSortColumns)) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Get the paginated orders
        $orders = $query->paginate(10);
        $totalOrders = $query->count();

        // Pass all data to the view
        return view('admin.order.index', compact('orders', 'orderStatus', 'totalOrders', 'totalRevenue', 'pendingOrders', 'sortColumn', 'sortDirection'));
    }

    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'order_status_id' => 'required|exists:order_statuses,id',
            'message' => 'nullable|string|max:255',
        ]);

        $oldStatus = $order->status->status_name;

        DB::beginTransaction();
        try {
            // Update status pesanan
            $order->order_status_id = $validatedData['order_status_id'];

            // Set is_cancelled to true if the new status is 7 (Cancelled) or 8 (Failed)
            if (in_array($validatedData['order_status_id'], [7, 8])) {
                $order->is_cancelled = true;
            } else {
                $order->is_cancelled = false;
            }

            // Update alasan pembatalan jika ada
            if ($request->filled('message')) {
                $order->cancellation_reason = $validatedData['message'];
            }

            $order->save(); // Simpan perubahan sebelum membuat log

            // Ambil status baru
            $newStatusModel = OrderStatus::find($validatedData['order_status_id']);
            $newStatus = $newStatusModel->status_name;

            // Mapping order ke event
            $eventType = [
                1 => 'ORDER_CREATED',
                2 => 'PAYMENT_PROOF_UPLOADED',
                3 => 'PAYMENT_CONFIRMED',
                4 => 'ORDER_PROCESSED',
                5 => 'DELIVERY_ASSIGNED',
                6 => 'ORDER_COMPLETED',
                7 => 'ORDER_CANCELLED',
                8 => 'ORDER_FAILED',
            ];

            $event = $eventType[$newStatusModel->order] ?? 'UNKNOWN_EVENT';

            if ($event == 'ORDER_FAILED') {
                $message = $validatedData['message'] ?? 'Pesanan gagal tanpa keterangan.';
            } else {
                $message = 'Status pesanan diubah dari "' . $oldStatus . '" menjadi "' . $newStatus . '" oleh ' . (Auth::user()->full_name ?? 'Pengguna Tidak Dikenal') . '.';
            }

            // Buat log perubahan
            $order->logs()->create([
                'order_id' => $order->id,
                'timestamp' => now(),
                'actor_user_id' => Auth::id(),
                'event_type' => $event,
                'old_value' => $oldStatus,
                'new_value' => $newStatus,
                'message' => $message
            ]);

            DB::commit();

            return redirect()->route('admin.order.show', $order->id)
                ->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui status pesanan: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load('user', 'status', 'deliveryMethod', 'address', 'items.product', 'logs', 'payment');

        // Ambil semua status pesanan untuk dropdown "Ubah Status"
        $orderStatus = OrderStatus::where('order', '>=', $order->status->order)
            ->whereNotIn('order', [7])
            ->orderBy('order', 'asc')
            ->get();


        // Kirim objek $order dan $orderStatus ke view
        return view('admin.order.show', compact('order', 'orderStatus'));
    }
    // public function update(Request $request, Order $order)
    // {
    //     $validatedData = $request->validate([
    //         'order_status_id' => 'required|exists:order_statuses,id',
    //         'message' => 'nullable|string|max:255',
    //     ]);

    //     $oldStatus = $order->status->status_name;

    //     DB::beginTransaction();
    //     try {
    //         // Update status pesanan
    //         $order->order_status_id = $validatedData['order_status_id'];

    //         // Update alasan pembatalan jika ada
    //         if ($request->filled('message')) {
    //             $order->cancellation_reason = $validatedData['message'];
    //         }

    //         $order->save(); // Simpan perubahan sebelum membuat log

    //         // Ambil status baru
    //         $newStatusModel = OrderStatus::find($validatedData['order_status_id']);
    //         $newStatus = $newStatusModel->status_name;

    //         // Mapping order ke event
    //         $eventType = [
    //             1 => 'ORDER_CREATED',
    //             2 => 'PAYMENT_PROOF_UPLOADED',
    //             3 => 'PAYMENT_CONFIRMED',
    //             4 => 'ORDER_PROCESSED',
    //             5 => 'DELIVERY_ASSIGNED',
    //             6 => 'ORDER_COMPLETED',
    //             7 => 'ORDER_CANCELLED',
    //             8 => 'ORDER_FAILED',
    //         ];


    //         $event = $eventType[$newStatusModel->order] ?? 'UNKNOWN_EVENT';

    //         if ($event == 'ORDER_FAILED') {
    //             $message = $validatedData['message'] ?? 'Pesanan gagal tanpa keterangan.';
    //         } else {
    //             $message = 'Status pesanan diubah dari "' . $oldStatus . '" menjadi "' . $newStatus . '" oleh ' . (Auth::user()->full_name ?? 'Pengguna Tidak Dikenal') . '.';
    //         }

    //         // Buat log perubahan
    //         $order->logs()->create([
    //             'order_id' => $order->id,
    //             'timestamp' => now(),
    //             'actor_user_id' => Auth::id(),
    //             'event_type' => $event,
    //             'old_value' => $oldStatus,
    //             'new_value' => $newStatus,
    //             'message' => $message
    //         ]);

    //         DB::commit();

    //         return redirect()->route('admin.order.show', $order->id)
    //             ->with('success', 'Status pesanan berhasil diperbarui.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()
    //             ->with('error', 'Terjadi kesalahan saat memperbarui status pesanan: ' . $e->getMessage());
    //     }
    // }

    public function report(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $query = Order::whereBetween('order_date', [$startDate, $endDate . ' 23:59:59'])
            ->with('user', 'status');

        $orders = $query->get();

        // Hitung metrik
        $totalOrders = $orders->count();
        $finishedOrders = $orders->where('is_finish', true);
        $totalRevenue = $finishedOrders->sum('total_amount');
        $averageOrderValue = $finishedOrders->count() > 0 ? $totalRevenue / $finishedOrders->count() : 0;
        $cancelledFailedOrders = $orders->where('is_cancelled', true)->count();

        // Data untuk grafik per tanggal
        $chartData = [];
        $dateRange = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($endDate . ' 23:59:59')
        );

        foreach ($dateRange as $date) {
            $dateKey = $date->format('Y-m-d');
            $chartData[$dateKey] = $finishedOrders->filter(function ($order) use ($dateKey) {
                return $order->order_date->format('Y-m-d') === $dateKey;
            })->sum('total_amount');
        }

        return view('admin.order.report', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'averageOrderValue',
            'finishedOrders',
            'cancelledFailedOrders',
            'chartData',
            'startDate',
            'endDate'
        ));
    }
}
