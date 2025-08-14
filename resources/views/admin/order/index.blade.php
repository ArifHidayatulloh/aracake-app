@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Manajemen Pesanan']]" />

        <x-header-page.header-page title="Manajemen Pesanan" description="Kelola dan lacak semua pesanan pelanggan Anda." />

        {{-- New: Order Statistics Widgets --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                <p class="text-sm text-gray-500">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                <p class="text-sm text-gray-500">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                <p class="text-sm text-gray-500">Pesanan Pending</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($pendingOrders, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 space-y-3 md:space-y-0">
                <h3 class="text-xl font-bold text-gray-800">Daftar Pesanan</h3>
                <form action="{{ route('admin.order.index') }}" method="GET"
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 items-center">

                    {{-- Hidden inputs to maintain sorting state --}}
                    <input type="hidden" name="sort" value="{{ $sortColumn }}">
                    <input type="hidden" name="direction" value="{{ $sortDirection }}">

                    <input type="text" name="search" placeholder="Cari ID Pesanan, Nama Pelanggan..."
                        class="px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm bg-white/50 w-full"
                        value="{{ request('search') }}">
                    <select name="status"
                        class="px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm bg-white/50 w-full">
                        <option value="">Semua Status</option>
                        @foreach ($orderStatus as $stat)
                            <option value="{{ $stat->id }}" {{ request('status') == $stat->id ? 'selected' : '' }}>
                                {{ $stat->status_name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- New: Date Range Filter Inputs --}}
                    <div class="flex space-x-2 w-full">
                        <input type="date" name="start_date"
                            class="px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm bg-white/50 w-full"
                            value="{{ request('start_date') }}">
                        <input type="date" name="end_date"
                            class="px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm bg-white/50 w-full"
                            value="{{ request('end_date') }}">
                    </div>

                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full md:w-auto">
                        Filter
                    </button>
                    @if (request('search') || request('status') || request('start_date') || request('end_date'))
                        <a href="{{ route('admin.order.index') }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full md:w-auto">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- Helper function for creating sort links --}}
                            @php
                                function sortLink($column, $sortColumn, $sortDirection) {
                                    $newDirection = $sortColumn === $column && $sortDirection === 'asc' ? 'desc' : 'asc';
                                    $icon = '';
                                    if ($sortColumn === $column) {
                                        $icon = $sortDirection === 'asc' ? '▲' : '▼';
                                    }
                                    $queryString = http_build_query(array_merge(request()->except(['page', 'sort', 'direction']), ['sort' => $column, 'direction' => $newDirection]));
                                    return "<a href='?". $queryString . "' class='flex items-center'>".
                                        "<span>" . str_replace('_', ' ', ucwords($column)) . "</span>" .
                                        "<span class='ml-1 text-xs'>{$icon}</span>" .
                                        "</a>";
                                }
                            @endphp

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                {!! sortLink('no_transaction', $sortColumn, $sortDirection) !!}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                {!! sortLink('created_at', $sortColumn, $sortDirection) !!}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                {!! sortLink('pickup_delivery_date', $sortColumn, $sortDirection) !!}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                {!! sortLink('total_amount', $sortColumn, $sortDirection) !!}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('admin.order.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        #{{ $order->no_transaction }}</td>
                                    </a>
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
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada pesanan ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
