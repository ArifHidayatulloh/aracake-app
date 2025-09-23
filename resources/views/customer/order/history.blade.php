@extends('layouts.guest', ['title' => 'Riwayat Pesanan'])

@section('content')
    <div class="py-8 text-white bg-gradient-to-r from-purple-600 to-pink-500">
        <div class="container px-6 mx-auto">
            <h1 class="mb-2 text-3xl font-bold">Riwayat Pesanan</h1>
            <p class="text-purple-100">Semua pesanan yang pernah Anda buat</p>
        </div>
    </div>

    <div class="border-b shadow-sm bg-white">
        <div class="container px-6 mx-auto">
            <nav class="flex space-x-8">
                <a href="{{ route('customer.order.my-order') }}" class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Pesanan Aktif</a>
                <a href="{{ route('customer.order.history') }}" class="px-1 py-4 text-sm font-medium text-purple-600 border-b-2 border-purple-500">Riwayat Pesanan</a>
            </nav>
        </div>
    </div>

    <section class="container px-6 py-8 mx-auto">
        <div class="p-6 mb-6 bg-white rounded-xl shadow-sm">
            <form action="{{ route('customer.order.history') }}" method="GET">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div>
                        <label for="search-input" class="block mb-2 text-sm font-medium text-gray-700">Cari</label>
                        <input type="text" id="search-input" name="search" placeholder="No. Pesanan / Produk" value="{{ request('search') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div>
                        <label for="status-filter" class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                        <select id="status-filter" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $stat)
                                <option value="{{ $stat->id }}" @selected(request('status') == $stat->id)>{{ $stat->status_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="period-filter" class="block mb-2 text-sm font-medium text-gray-700">Periode</label>
                        <select id="period-filter" name="period" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Semua Waktu</option>
                            <option value="30" @selected(request('period') == '30')>30 Hari Terakhir</option>
                            <option value="90" @selected(request('period') == '90')>3 Bulan Terakhir</option>
                            <option value="365" @selected(request('period') == '365')>1 Tahun Terakhir</option>
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="w-full px-4 py-2 font-semibold text-white uppercase bg-purple-600 rounded-md hover:bg-purple-700">Filter</button>
                        <a href="{{ route('customer.order.history') }}" class="w-full px-4 py-2 font-semibold text-center text-gray-700 uppercase bg-gray-200 rounded-md hover:bg-gray-300">Reset</a>
                    </div>
                </div>
            </form>
            
            <div class="grid grid-cols-1 gap-4 pt-6 mt-6 border-t border-gray-200 md:grid-cols-3">
                <div class="text-center"><p class="text-2xl font-bold text-purple-600">{{ number_format($totalOrders) }}</p><p class="text-sm text-gray-600">Total Pesanan</p></div>
                <div class="text-center"><p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalSpending) }}</p><p class="text-sm text-gray-600">Total Belanja</p></div>
                <div class="text-center"><p class="text-2xl font-bold text-red-600">{{ number_format($totalCancelled) }}</p><p class="text-sm text-gray-600">Pesanan Batal</p></div>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <div class="flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Pesanan #{{ $order->no_transaction }}</h3>
                            <p class="text-sm text-gray-500">Dipesan pada {{ $order->order_date->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                        </div>
                        <span class="text-sm font-medium px-3 py-1 rounded-full 
                            {{ $order->is_finish ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $order->status->status_name }}
                        </span>
                    </div>
                    <div class="py-4 my-4 border-t border-b">
                        @foreach ($order->items as $item)
                            <div class="flex items-center justify-between {{ !$loop->last ? 'mb-2' : '' }}">
                                <div class="flex items-center space-x-3">
                                    @if ($item->product && $item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="object-cover w-10 h-10 rounded-lg">                                
                                    @else
                                        <div class="flex items-center justify-center w-10 h-10 text-gray-400 bg-gray-200 rounded-lg">
                                            <i class="text-xl fas fa-box-open"></i>
                                        </div>                                        
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-600">x{{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700">Rp {{ number_format($item->subtotal) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <span class="text-sm text-gray-600">Total</span>
                            <p class="text-xl font-bold text-purple-600">Rp {{ number_format($order->total_amount) }}</p>
                        </div>
                        <div class="flex self-stretch gap-2 sm:self-center">
                            <a href="{{ route('customer.order.detail', $order->no_transaction) }}" class="flex-1 px-4 py-2 text-sm font-medium text-center text-purple-600 transition-all border border-purple-500 rounded-lg hover:bg-purple-50">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center bg-white rounded-xl shadow-sm">
                    <p class="text-gray-500">Tidak ada riwayat pesanan yang cocok dengan filter Anda.</p>
                </div>
            @endforelse
        </div>

        @if ($orders->hasPages())
            <div class="mt-8">{{ $orders->links() }}</div>
        @endif
    </section>
@endsection