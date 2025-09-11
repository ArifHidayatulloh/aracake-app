<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
