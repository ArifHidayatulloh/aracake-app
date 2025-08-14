@extends('layouts.app')

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
                    <p class="text-4xl font-bold mt-1">1,234</p>
                    <p class="text-sm text-purple-200 mt-1">+12% dari bulan lalu</p>
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
                    <p class="text-4xl font-bold mt-1">87</p>
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
                    <p class="text-4xl font-bold mt-1">Rp 125.000.000</p>
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
                                ID Pesanan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
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
                                Tanggal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#AC001</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Budi Santoso</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Red Velvet Cake</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 250.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Selesai
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-07-20</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#AC002</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Siti Aminah</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Chocolate Fudge</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 180.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-07-21</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#AC003</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Joko Susilo</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Vanilla Bean Cake</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 200.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Selesai
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-07-22</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#AC004</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Dewi Lestari</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Strawberry Shortcake</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 220.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Dibatalkan
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-07-22</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-700 transition-colors">Lihat
                    Semua Pesanan &rarr;</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-purple-100">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik Penjualan Bulanan</h3>
            <div
                class="h-64 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 border border-dashed border-gray-200">
                <p>Area ini bisa menampilkan grafik penjualan Anda (misalnya, menggunakan Chart.js atau library lainnya).
                </p>
            </div>
        </div>
    </div>
@endsection
