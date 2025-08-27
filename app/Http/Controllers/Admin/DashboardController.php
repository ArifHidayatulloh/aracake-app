<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // private function statusOrder(){
    //     $status = [
    //         ''
    //     ]
    // }
    public function dashboard()
    {
        // Mendapatkan bulan ini dan bulan sebelumnya
        $currentMonth = Carbon::now()->month;
        $previousMonth = Carbon::now()->subMonth()->month;
        $currentYear = Carbon::now()->year;

        // Mendapatkan statistik utama untuk widget
        $totalOrderThisMonth = Order::whereMonth('order_date', $currentMonth)
            ->whereYear('order_date', $currentYear)
            ->count();

        $totalOrderPreviousMonth = Order::whereMonth('order_date', $previousMonth)
            ->whereYear('order_date', $currentYear)
            ->count();

        $totalProduct = Product::where('is_active', true)->count();

        $totalRevenueThisMonth = Order::whereMonth('order_date', $currentMonth)
            ->whereYear('order_date', $currentYear)
            ->where('is_finish', true)
            ->sum('total_amount');

        // Menghitung persentase perubahan pesanan
        $orderPercentageChange = 0;
        if ($totalOrderPreviousMonth > 0) {
            $orderPercentageChange = (($totalOrderThisMonth - $totalOrderPreviousMonth) / $totalOrderPreviousMonth) * 100;
        }

        // Mendapatkan 5 pesanan terbaru yang belum selesai (pending)
        $newOrder = Order::with('user', 'status')
            ->where('is_finish', false)
            ->latest()
            ->limit(5)
            ->get();

        // Mendapatkan data untuk grafik penjualan bulanan
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

        return view('admin.dashboard', compact(
            'totalOrderThisMonth',
            'totalProduct',
            'totalRevenueThisMonth',
            'newOrder',
            'orderPercentageChange',
            'labels',
            'data'
        ));
    }
}
