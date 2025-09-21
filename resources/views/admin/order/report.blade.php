@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Laporan Pesanan']]" />
        <x-header-page.header-page title="Laporan Pesanan" description="Analisis kinerja penjualan Anda dalam rentang waktu tertentu." />

        {{-- Form Filter Tanggal --}}
        <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
            <form action="{{ route('admin.order.report') }}" method="GET" class="flex flex-col items-end space-y-2 md:flex-row md:space-y-0 md:space-x-2">
                <div class="w-full">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="block w-full px-4 py-2 mt-1 border rounded-md shadow-sm sm:text-sm border-purple-200 focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="{{ $startDate }}">
                </div>
                <div class="w-full">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="block w-full px-4 py-2 mt-1 border rounded-md shadow-sm sm:text-sm border-purple-200 focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="{{ $endDate }}">
                </div>
                <div class="flex pt-5 space-x-2">
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white uppercase transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Tampilkan</button>
                    {{-- [FITUR BARU] Tombol Export (Arahkan ke route export yang akan dibuat) --}}
                    {{-- <a href="{{ route('admin.order.report.export', request()->query()) }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-700">Export</a> --}}
                </div>
            </form>
        </div>

        {{-- Statistik Laporan --}}
        <div class="p-4 bg-white border rounded-lg shadow-sm border-purple-100"><p class="text-sm text-gray-500">Total Pendapatan</p><p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p></div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div class="p-4 bg-white border rounded-lg shadow-sm border-purple-100"><p class="text-sm text-gray-500">Total Pesanan</p><p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders, 0, ',', '.') }}</p></div>
            <div class="p-4 bg-white border rounded-lg shadow-sm border-purple-100"><p class="text-sm text-gray-500">Pesanan Selesai</p><p class="text-2xl font-bold text-gray-900">{{ number_format($finishedOrdersCount, 0, ',', '.') }}</p></div>
            <div class="p-4 bg-white border rounded-lg shadow-sm border-purple-100"><p class="text-sm text-gray-500">Pesanan Pending</p><p class="text-2xl font-bold text-gray-900">{{ number_format($pendingOrdersCount, 0, ',', '.') }}</p></div>
            <div class="p-4 bg-white border rounded-lg shadow-sm border-purple-100"><p class="text-sm text-gray-500">Dibatalkan/Gagal</p><p class="text-2xl font-bold text-gray-900">{{ number_format($cancelledFailedOrders, 0, ',', '.') }}</p></div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Grafik Penjualan --}}
            <div class="p-6 bg-white border rounded-lg shadow-sm lg:col-span-2 border-purple-100">
                <h3 class="mb-4 text-xl font-bold text-gray-800">Grafik Pendapatan Harian</h3>
                <div class="h-80"><canvas id="revenueChart"></canvas></div>
            </div>

            {{-- [FITUR BARU] Daftar Produk Terlaris --}}
            <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
                <h3 class="mb-4 text-xl font-bold text-gray-800">Produk Terlaris</h3>
                <ul class="space-y-4">
                    @forelse($topSellingProducts as $product)
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-gray-700 truncate">{{ $product->name }}</span>
                            <span class="font-bold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">{{ $product->total_sold }} terjual</span>
                        </li>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada produk yang terjual.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Tabel Pesanan Detil --}}
        <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
            <h3 class="mb-4 text-xl font-bold text-gray-800">Daftar Rincian Pesanan</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">No Transaksi</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Pelanggan</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tanggal Pesan</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Total</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap"><a href="{{ route('admin.order.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">#{{ $order->no_transaction }}</a></td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $order->user->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $order->order_date->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap"><span class="font-semibold" style="color: {{ $order->status->status_color }};">{{ $order->status->status_name }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">Tidak ada data pesanan dalam rentang tanggal ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- [FITUR BARU] Link Paginasi --}}
            <div class="mt-4">{{ $orders->links() }}</div>
        </div>
    </div>

    {{-- Script untuk Chart.js (tetap sama) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var chartData = @json($chartData);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(chartData).map(date => new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })),
                    datasets: [{
                        label: 'Pendapatan Harian',
                        data: Object.values(chartData),
                        backgroundColor: 'rgba(139, 92, 246, 0.5)',
                        borderColor: 'rgba(139, 92, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true }, x: { grid: { display: false } } },
                    plugins: { tooltip: { callbacks: { label: context => 'Rp ' + context.raw.toLocaleString('id-ID') } } }
                }
            });
        });
    </script>
@endsection