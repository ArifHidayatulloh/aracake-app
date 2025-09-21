@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Manajemen Pesanan']]" />
        <x-header-page.header-page title="Manajemen Pesanan" description="Kelola dan lacak semua pesanan pelanggan Anda." />

        {{-- Statistik yang sekarang dinamis sesuai filter --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-white border rounded-lg shadow-sm border-purple-100">
                <p class="text-sm text-gray-500">Total Pesanan (Hasil Filter)</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-white border rounded-lg shadow-sm border-purple-100">
                <p class="text-sm text-gray-500">Pendapatan (Hasil Filter)</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-white border rounded-lg shadow-sm border-purple-100">
                <p class="text-sm text-gray-500">Pesanan Pending (Hasil Filter)</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($pendingOrders, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
            <div class="flex flex-col items-start justify-between mb-4 space-y-3 md:flex-row md:items-center md:space-y-0">
                <h3 class="text-xl font-bold text-gray-800">Daftar Pesanan</h3>
                <form action="{{ route('admin.order.index') }}" method="GET" class="flex flex-col items-center w-full md:w-auto md:flex-row md:space-x-2 space-y-2 md:space-y-0">
                    <input type="text" name="search" placeholder="Cari ID, Nama..." class="w-full px-4 py-2 border rounded-md shadow-sm sm:text-sm border-purple-200 bg-white/50 focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="{{ request('search') }}">
                    <select name="status" class="w-full px-4 py-2 border rounded-md shadow-sm sm:text-sm border-purple-200 bg-white/50 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Semua Status</option>
                        @foreach ($orderStatus as $stat)
                            <option value="{{ $stat->id }}" {{ request('status') == $stat->id ? 'selected' : '' }}>{{ $stat->status_name }}</option>
                        @endforeach
                    </select>
                    <div class="flex w-full space-x-2">
                        <input type="date" name="start_date" class="w-full px-4 py-2 border rounded-md shadow-sm sm:text-sm border-purple-200 bg-white/50 focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="{{ request('start_date') }}">
                        <input type="date" name="end_date" class="w-full px-4 py-2 border rounded-md shadow-sm sm:text-sm border-purple-200 bg-white/50 focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="{{ request('end_date') }}">
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-2 text-xs font-semibold text-white uppercase transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md md:w-auto hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">Filter</button>
                    @if (request()->hasAny(['search', 'status', 'start_date', 'end_date']))
                        <a href="{{ route('admin.order.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 text-xs font-semibold text-gray-700 uppercase transition duration-150 ease-in-out bg-gray-200 border border-transparent rounded-md md:w-auto hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Reset</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"><x-sortable-link column="no_transaction" :sortColumn="$sortColumn" :sortDirection="$sortDirection">No Transaksi</x-sortable-link></th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Pelanggan</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"><x-sortable-link column="order_date" :sortColumn="$sortColumn" :sortDirection="$sortDirection">Tgl Pesan</x-sortable-link></th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"><x-sortable-link column="total_amount" :sortColumn="$sortColumn" :sortDirection="$sortDirection">Total</x-sortable-link></th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jumlah Item</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    <a href="{{ route('admin.order.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">#{{ $order->no_transaction }}</a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $order->user->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $order->order_date->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">{{ $order->items_count }} item</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <span class="font-semibold" style="color: {{ $order->status->status_color }};">{{ $order->status->status_name }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="{{ route('admin.order.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">Tidak ada pesanan ditemukan.</td>
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