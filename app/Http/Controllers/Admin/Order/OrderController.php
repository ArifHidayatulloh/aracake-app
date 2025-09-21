<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\SystemLog;
use App\Models\OrderItem;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
{
    // 1. Mulai dengan query dasar TANPA sorting awal
    // Ganti baris ini:
    // $query = Order::with(['user', 'status'])->latest('order_date');
    // Menjadi:
    $query = Order::with(['user', 'status']);

    // Terapkan filter berdasarkan request input
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

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('order_date', [$request->input('start_date'), $request->input('end_date')]);
    }

    // 2. Hitung statistik SETELAH filter diterapkan
    $statsQuery = clone $query; // Duplikasi query agar tidak mengganggu paginasi

    $totalOrders = $statsQuery->count();
    
    $totalRevenue = (clone $statsQuery)->whereHas('status', function ($q) {
        $q->where('status_name', 'Selesai');
    })->sum('total_amount');
    
    $pendingOrders = (clone $statsQuery)->whereHas('status', function ($q) {
        $q->whereNotIn('status_name', ['Selesai', 'Dibatalkan', 'Gagal']);
    })->count();

    // 3. Terapkan pengurutan (sorting)
    $sortColumn = $request->get('sort', 'order_date'); // Default sort: tanggal pesanan
    $sortDirection = $request->get('direction', 'desc');

    $allowedSortColumns = ['no_transaction', 'order_date', 'total_amount', 'pickup_delivery_date'];
    if (in_array($sortColumn, $allowedSortColumns)) {
        $query->orderBy($sortColumn, $sortDirection);
    } else {
        // Fallback jika kolom sort tidak valid
        $query->orderBy('order_date', 'desc');
    }

    // 4. Ambil data dengan paginasi DAN hitung jumlah item per pesanan
    $orders = $query->withCount('items')->paginate(10)->withQueryString();

    // Ambil semua status untuk dropdown filter (tidak terpengaruh oleh filter lain)
    $orderStatus = OrderStatus::orderBy('order')->get();

    return view('admin.order.index', compact(
        'orders',
        'orderStatus',
        'totalOrders',
        'totalRevenue',
        'pendingOrders',
        'sortColumn',
        'sortDirection'
    ));
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

            // Set is_finish to true if the new status is 6 (Completed)
            if ($validatedData['order_status_id'] == 6) {
                $order->is_finish = true;
            } else {
                $order->is_finish = false;
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
    // Gunakan Carbon untuk manajemen tanggal yang lebih aman dan validasi
    try {
        $startDate = Carbon::parse($request->input('start_date', now()->subDays(29)))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date', now()))->endOfDay();
    } catch (\Exception $e) {
        // Fallback jika input tanggal tidak valid
        $startDate = now()->subDays(29)->startOfDay();
        $endDate = now()->endOfDay();
    }

    // --- QUERY OPTIMIZED UNTUK STATISTIK ---
    // Buat query dasar yang akan kita gunakan berulang kali
    $baseQuery = Order::whereBetween('order_date', [$startDate, $endDate]);

    // Kalkulasi statistik langsung di database, bukan di collection
    $totalOrders = (clone $baseQuery)->count();
    $totalRevenue = (clone $baseQuery)->where('is_finish', true)->sum('total_amount');
    $finishedOrdersCount = (clone $baseQuery)->where('is_finish', true)->count();
    $pendingOrdersCount = (clone $baseQuery)->where('is_finish', false)->where('is_cancelled', false)->count();
    $cancelledFailedOrders = (clone $baseQuery)->where('is_cancelled', true)->count();

    // --- [FITUR BARU] QUERY PRODUK TERLARIS ---
    $topSellingProducts = OrderItem::select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->whereBetween('orders.order_date', [$startDate, $endDate])
        ->where('orders.is_finish', true)
        ->groupBy('products.name')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();

    // --- QUERY UNTUK GRAFIK (OPTIMIZED) ---
    $revenueOverTime = (clone $baseQuery)->where('is_finish', true)
        ->select(
            DB::raw('DATE(order_date) as date'),
            DB::raw('SUM(total_amount) as total')
        )
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get()
        ->pluck('total', 'date');

    // Siapkan data chart dengan semua tanggal dalam rentang, isi dengan 0 jika tidak ada penjualan
    $chartData = [];
    $period = CarbonPeriod::create($startDate, $endDate);
    foreach ($period as $date) {
        $dateKey = $date->format('Y-m-d');
        $chartData[$dateKey] = $revenueOverTime->get($dateKey, 0);
    }
    
    // --- QUERY UNTUK TABEL DETAIL DENGAN PAGINASI ---
    $ordersForTable = (clone $baseQuery)->with('user', 'status')
                                        ->latest('order_date')
                                        ->paginate(15)
                                        ->withQueryString();

    return view('admin.order.report', [
        'orders' => $ordersForTable, // Menggunakan data yang sudah dipaginasi
        'totalOrders' => $totalOrders,
        'totalRevenue' => $totalRevenue,
        'finishedOrdersCount' => $finishedOrdersCount,
        'pendingOrdersCount' => $pendingOrdersCount,
        'cancelledFailedOrders' => $cancelledFailedOrders,
        'topSellingProducts' => $topSellingProducts,
        'chartData' => $chartData,
        'startDate' => $startDate->toDateString(),
        'endDate' => $endDate->toDateString(),
    ]);
}
}
