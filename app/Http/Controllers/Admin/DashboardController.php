<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // --- LOGIKA TANGGAL YANG LEBIH AMAN ---
        $now = Carbon::now();
        $previousMonthDate = $now->copy()->subMonthNoOverflow();

        // --- STATISTIK KARTU UTAMA (WIDGETS) ---

        // Total pesanan bulan ini
        $totalOrderThisMonth = Order::whereYear('order_date', $now->year)
            ->whereMonth('order_date', $now->month)
            ->count();
        
        // Total pesanan bulan lalu (untuk perbandingan)
        $totalOrderPreviousMonth = Order::whereYear('order_date', $previousMonthDate->year)
            ->whereMonth('order_date', $previousMonthDate->month)
            ->count();
        
        // Total pendapatan selesai bulan ini
        $totalRevenueThisMonth = Order::whereYear('order_date', $now->year)
            ->whereMonth('order_date', $now->month)
            ->where('is_finish', true)
            ->sum('total_amount');

        // Total semua pesanan
        $totalOrders = Order::count();

        // Total produk aktif
        $totalProduct = Product::where('is_active', true)->count();
        
        // [BARU] Pesanan yang perlu tindakan
        $actionableStatusIds = OrderStatus::whereIn('status_name', [
            'Menunggu Konfirmasi Pembayaran',
            'Pembayaran dikonfirmasi',
            'Pesanan Diproses'
        ])->pluck('id');
        $ordersNeedingAction = Order::whereIn('order_status_id', $actionableStatusIds)
            ->where('is_finish', false)
            ->where('is_cancelled', false)
            ->count();

        // Menghitung persentase perubahan pesanan
        $orderPercentageChange = 0;
        if ($totalOrderPreviousMonth > 0) {
            $orderPercentageChange = (($totalOrderThisMonth - $totalOrderPreviousMonth) / $totalOrderPreviousMonth) * 100;
        }

        // --- DATA UNTUK TABEL & DAFTAR ---

        // 5 pesanan terbaru yang butuh perhatian
        $newOrder = Order::with('user', 'status')
            ->where('is_finish', false)
            ->where('is_cancelled', false)
            ->latest('order_date')
            ->limit(5)
            ->get();

        // [BARU] 5 Produk Terlaris 30 hari terakhir
        $topSellingProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.is_finish', true) // Hanya dari pesanan yang selesai
            ->where('orders.order_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product:id,name') // Ambil hanya id dan nama produk
            ->limit(5)
            ->get();

        // --- DATA UNTUK GRAFIK PENJUALAN ---
        $monthlySalesData = Order::select(
            DB::raw('DATE_FORMAT(order_date, "%Y-%m") as month'),
            DB::raw('SUM(total_amount) as total_sales')
        )
            ->where('is_finish', true)
            ->where('order_date', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];
        $start = Carbon::now()->subMonths(6)->startOfMonth();

        for ($i = 0; $i <= 6; $i++) {
            $month = $start->format('Y-m');
            $labels[] = $start->format('M Y');
            $foundData = $monthlySalesData->firstWhere('month', $month);
            $data[] = $foundData ? $foundData->total_sales : 0;
            $start->addMonth();
        }

        // Mengirim semua data ke view
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalOrderThisMonth',
            'totalProduct',
            'totalRevenueThisMonth',
            'ordersNeedingAction',
            'newOrder',
            'topSellingProducts',
            'orderPercentageChange',
            'labels',
            'data'
        ));
    }

    public function profile()
    {
        return view('admin.profile.profile');
    }

     public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'username' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    public function accountDestroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        Auth::user()->delete();

        return redirect('/')->with('success', 'Akun berhasil dihapus');
    }
}
