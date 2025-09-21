@extends('layouts.app')
@php
    function hexToRgba($hex, $alpha = 0.15)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return "rgba($r, $g, $b, $alpha)";
    }
@endphp

@section('content')
    <div class="space-y-6">
        <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
            <h2 class="mb-2 text-2xl font-bold text-gray-800">Selamat Datang di Dashboard Ara Cake! 👋</h2>
            <p class="text-gray-600">Pantau performa toko Anda dan kelola pesanan serta produk dengan mudah.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-5">
            {{-- Kartu Total Pesanan Keseluruhan --}}
            <div
                class="flex items-center justify-between p-6 text-white transition-transform duration-200 ease-in-out transform bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg hover:scale-105">
                <div>
                    <p class="text-sm font-semibold uppercase text-blue-200">Total Pesanan Keseluruhan</p>
                    <p class="mt-1 text-4xl font-bold">{{ $totalOrders }}</p>
                    <p class="mt-1 text-sm text-blue-200">Semua pesanan sejak awal</p>
                </div>
                <i class="text-5xl opacity-50 fa-solid fa-boxes-packing"></i>
            </div>

            {{-- Kartu Total Pesanan --}}
            <div
                class="flex items-center justify-between p-6 text-white transition-transform duration-200 ease-in-out transform bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg hover:scale-105">
                <div>
                    <p class="text-sm font-semibold uppercase text-purple-200">Total Pesanan (Bulan Ini)</p>
                    <p class="mt-1 text-4xl font-bold">{{ $totalOrderThisMonth }}</p>
                    <p class="mt-1 text-sm text-purple-200">
                        @if ($orderPercentageChange >= 0)
                            <span class="text-green-300">+{{ number_format($orderPercentageChange, 1) }}%</span> dari bulan lalu
                        @else
                            <span class="text-red-300">{{ number_format($orderPercentageChange, 1) }}%</span> dari bulan lalu
                        @endif
                    </p>
                </div>
                <i class="text-5xl opacity-50 fa-solid fa-cart-shopping"></i>
            </div>

            {{-- [BARU] Kartu Perlu Diproses --}}
            <div
                class="flex items-center justify-between p-6 text-white transition-transform duration-200 ease-in-out transform bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg shadow-lg hover:scale-105">
                <div>
                    <p class="text-sm font-semibold uppercase text-yellow-200">Perlu Diproses</p>
                    <p class="mt-1 text-4xl font-bold">{{ $ordersNeedingAction }}</p>
                    <p class="mt-1 text-sm text-yellow-200">Pesanan menunggu tindakan</p>
                </div>
                <i class="text-5xl opacity-50 fa-solid fa-hourglass-half"></i>
            </div>

            {{-- Kartu Total Penjualan --}}
            <div
                class="flex items-center justify-between p-6 text-white transition-transform duration-200 ease-in-out transform bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg shadow-lg hover:scale-105">
                <div>
                    <p class="text-sm font-semibold uppercase text-teal-200">Total Penjualan</p>
                    <p class="mt-1 text-4xl font-bold">Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</p>
                    <p class="mt-1 text-sm text-teal-200">Pendapatan bulan ini</p>
                </div>
                <i class="text-5xl opacity-50 fa-solid fa-sack-dollar"></i>
            </div>

            {{-- Kartu Total Produk --}}
            <div
                class="flex items-center justify-between p-6 text-white transition-transform duration-200 ease-in-out transform bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg hover:scale-105">
                <div>
                    <p class="text-sm font-semibold uppercase text-indigo-200">Total Produk</p>
                    <p class="mt-1 text-4xl font-bold">{{ $totalProduct }}</p>
                    <p class="mt-1 text-sm text-indigo-200">Produk aktif</p>
                </div>
                <i class="text-5xl opacity-50 fa-solid fa-cake-candles"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Tabel Pesanan Terbaru --}}
            <div class="p-6 bg-white border rounded-lg shadow-sm lg:col-span-2 border-purple-100">
                <h3 class="mb-4 text-xl font-bold text-gray-800">Pesanan Terbaru Menunggu Tindakan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">No Transaksi</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Pelanggan</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Total</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($newOrder as $order)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('admin.order.show', $order->id ) }}">
                                            #{{ $order->no_transaction }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $order->user->full_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span style="background-color: {{ hexToRgba($order->status->status_color) }}; color: {{ $order->status->status_color }};" class="px-3 py-1 text-sm font-medium rounded-full">
                                            {{ $order->status->status_name }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-sm text-center text-gray-500">Tidak ada pesanan baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('admin.order.index') }}" class="text-sm font-medium text-purple-600 transition-colors hover:text-purple-700">Lihat Semua Pesanan &rarr;</a>
                </div>
            </div>

            {{-- [BARU] Daftar Produk Terlaris --}}
            <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
                <h3 class="mb-4 text-xl font-bold text-gray-800">Produk Terlaris (30 Hari)</h3>
                <ul class="space-y-4">
                    @forelse($topSellingProducts as $item)
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-gray-700 truncate">{{ $item->product->name }}</span>
                            <span class="font-bold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">
                                {{ $item->total_quantity }}
                            </span>
                        </li>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada data penjualan.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
            <h3 class="mb-4 text-xl font-bold text-gray-800">Grafik Penjualan 6 Bulan Terakhir</h3>
            <div class="h-64">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('monthlySalesChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: @json($data),
                        borderColor: 'rgb(139, 92, 246)',
                        backgroundColor: 'rgba(139, 92, 246, 0.2)',
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
                            grid: { drawBorder: false, color: 'rgba(200, 200, 200, 0.2)' },
                            ticks: { callback: value => 'Rp ' + value.toLocaleString('id-ID') }
                        },
                        x: { grid: { display: false } }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: context => 'Rp ' + context.raw.toLocaleString('id-ID') } }
                    }
                }
            });
        });
    </script>
@endsection