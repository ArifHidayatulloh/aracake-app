@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Laporan Pesanan']]" />

        <x-header-page.header-page title="Laporan Pesanan"
            description="Analisis kinerja penjualan Anda dalam rentang waktu tertentu." />

        {{-- Form Filter Tanggal --}}
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6">
            <form action="{{ route('admin.order.report') }}" method="GET"
                class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 items-end">
                <div class="w-full">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date"
                        class="mt-1 block w-full px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                        value="{{ $startDate }}">
                </div>
                <div class="w-full">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date"
                        class="mt-1 block w-full px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                        value="{{ $endDate }}">
                </div>
                <div class="flex space-x-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Tampilkan
                    </button>
                    <a href="{{ route('admin.order.report') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Statistik Laporan --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                <p class="text-sm text-gray-500">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                <p class="text-sm text-gray-500">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                <p class="text-sm text-gray-500">Pesanan Selesai</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($finishedOrders->count(), 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                <p class="text-sm text-gray-500">Pesanan Dibatalkan/Gagal</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($cancelledFailedOrders, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Grafik Penjualan (placeholder) --}}
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik Penjualan Bulanan</h3>
            <div class="h-64">
                {{-- Anda dapat menggunakan library seperti Chart.js di sini --}}
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Tabel Pesanan Detil --}}
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Daftar Pesanan (Detil)</h3>
                {{-- Tombol Export akan mengarah ke route yang berbeda untuk mengunduh laporan --}}
                {{-- <a href="#" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    Export CSV
                </a> --}}
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                Transaksi</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Pesan</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Ambil/Kirim</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        #{{ $order->no_transaction }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->user->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->order_date->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->pickup_delivery_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="font-semibold" style="color: {{ $order->status->status_color }};">
                                        {{ $order->status->status_name }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada data pesanan dalam rentang tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Script untuk Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var chartData = <?php echo json_encode($chartData); ?>;

            // Format label tanggal menjadi lebih pendek (contoh: 1 Jan)
            var formattedLabels = Object.keys(chartData).map(date => {
                var d = new Date(date);
                return d.getDate() + ' ' + d.toLocaleString('default', {
                    month: 'short'
                });
            });

            new Chart(ctx, {
                type: 'line', // atau 'line' jika lebih suka garis
                data: {
                    labels: formattedLabels,
                    datasets: [{
                        label: 'Pendapatan Harian',
                        data: Object.values(chartData),
                        backgroundColor: 'rgba(99, 102, 241, 0.5)',
                        borderColor: 'rgba(99, 102, 241, 1)',
                        borderWidth: 1,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Pendapatan (Rp)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
