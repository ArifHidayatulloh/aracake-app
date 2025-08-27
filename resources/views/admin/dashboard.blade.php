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
        <div class="bg-white rounded-lg shadow-sm p-6 border border-purple-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang di Dashboard Ara Cake! 👋</h2>
            <p class="text-gray-600">Pantau performa toko Anda dan kelola pesanan serta produk dengan mudah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white flex items-center justify-between transform hover:scale-105 transition-transform duration-200 ease-in-out">
                <div>
                    <p class="text-sm uppercase font-semibold text-purple-200">Total Pesanan</p>
                    <p class="text-4xl font-bold mt-1">{{ $totalOrderThisMonth }}</p>
                    <p class="text-sm text-purple-200 mt-1">
                        @if ($orderPercentageChange > 0)
                            <span class="text-green-300">+{{ number_format($orderPercentageChange, 1) }}%</span> dari bulan lalu
                        @else
                            <span class="text-red-300">{{ number_format($orderPercentageChange, 1) }}%</span> dari bulan lalu
                        @endif
                    </p>
                </div>
                <svg class="w-14 h-14 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                    </path>
                </svg>
            </div>

            <div
                class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white flex items-center justify-between transform hover:scale-105 transition-transform duration-200 ease-in-out">
                <div>
                    <p class="text-sm uppercase font-semibold text-indigo-200">Total Produk</p>
                    <p class="text-4xl font-bold mt-1">{{ $totalProduct }}</p>
                    <p class="text-sm text-indigo-200 mt-1">3 produk baru minggu ini</p>
                </div>
                <svg class="w-14 h-14 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>

            <div
                class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg shadow-lg p-6 text-white flex items-center justify-between transform hover:scale-105 transition-transform duration-200 ease-in-out">
                <div>
                    <p class="text-sm uppercase font-semibold text-teal-200">Total Penjualan</p>
                    <p class="text-4xl font-bold mt-1">Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</p>
                    <p class="text-sm text-teal-200 mt-1">Target bulanan tercapai!</p>
                </div>
                <svg class="w-14 h-14 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182L13.5 10.5m-11.25 4.5v7.5h15V12a2.25 2.25 0 0 0-2.25-2.25H15M12 6V4.5m-4.5 9V9M12 18h.008v.008H12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                    </path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-purple-100">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Pesanan Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No Transaksi
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Pesan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Ambil/Kirim
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($newOrder as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->no_transaction }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->user->full_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->order_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        style="background-color: {{ hexToRgba($order->status->status_color) }}; color: {{ $order->status->status_color }};"
                                        class="text-sm font-medium px-3 py-1 rounded-full mt-2 sm:mt-0">
                                        {{ $order->status->status_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->pickup_delivery_date->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.order.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 transition-colors">Lihat
                    Semua Pesanan &rarr;</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-purple-100">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik Penjualan Bulanan</h3>
            <div class="h-64">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('monthlySalesChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: @json($data),
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.2)',
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
                            grid: {
                                drawBorder: false,
                                color: 'rgba(200, 200, 200, 0.2)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
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

@section('scripts')


@endsection
