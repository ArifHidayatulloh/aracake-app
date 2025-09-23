@extends('layouts.guest', ['title' => 'Pesanan Saya'])

@section('content')
    <div class="py-8 text-white bg-gradient-to-r from-purple-600 to-pink-500">
        <div class="container px-6 mx-auto">
            <h1 class="mb-2 text-3xl font-bold">Pesanan Saya</h1>
            <p class="text-purple-100">Pantau status pesanan aktif Anda</p>
        </div>
    </div>

    <div class="border-b shadow-sm bg-white">
        <div class="container px-6 mx-auto">
            <nav class="flex space-x-8">
                <a href="{{ route('customer.order.my-order') }}"
                    class="px-1 py-4 text-sm font-medium text-purple-600 border-b-2 border-purple-500">Pesanan Aktif</a>
                <a href="{{ route('customer.order.history') }}"
                    class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300">Riwayat
                    Pesanan</a>
            </nav>
        </div>
    </div>

    <section class="container px-6 py-8 mx-auto">
        {{-- [PERBAIKAN] Form filter digabung jadi satu --}}
        <form action="{{ route('customer.order.my-order') }}" method="GET"
            class="flex flex-col items-start gap-4 mb-6 sm:flex-row sm:items-end">
            <div class="w-full sm:w-auto">
                <label for="search" class="text-sm font-medium text-gray-700">Cari Pesanan</label>
                <input type="text" placeholder="No. Transaksi / Nama Produk" name="search"
                    value="{{ request('search') }}"
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
            </div>
            <div class="w-full sm:w-auto">
                <label for="status" class="text-sm font-medium text-gray-700">Status</label>
                <select name="status"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $stat)
                        <option value="{{ $stat->id }}" @selected(request('status') == $stat->id)>{{ $stat->status_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white uppercase bg-purple-600 rounded-md hover:bg-purple-700">Filter</button>
                <a href="{{ route('customer.order.my-order') }}"
                    class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-md hover:bg-gray-300">Reset</a>
            </div>
        </form>

        <div class="space-y-6">
            @forelse ($orders as $order)
                @php
                    $statusColor = $order->status->status_color;
                @endphp
                <div class="p-6 bg-white border-l-4 rounded-xl shadow-md" style="border-left-color: {{ $statusColor }};">
                    {{-- Bagian Header Kartu --}}
                    <div class="flex flex-col items-start justify-between gap-2 mb-4 sm:flex-row sm:items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Pesanan #{{ $order->no_transaction }}</h3>
                            <p class="text-sm text-gray-500">Dipesan pada
                                {{ \Carbon\Carbon::parse($order->order_date)->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                        </div>
                        <span style="background-color: {{ hexToRgba($statusColor) }}; color: {{ $statusColor }};"
                            class="px-3 py-1 text-sm font-medium rounded-full">{{ $order->status->status_name }}</span>
                    </div>

                    {{-- [FITUR BARU] Progress Bar Status --}}
                    <div class="mb-6">
                        <div class="flex justify-between mb-1">
                            @foreach ($allActiveStatuses as $status)
                                <div class="text-xs text-center {{ $order->status->order >= $status->order ? 'font-bold text-purple-600' : 'text-gray-400' }}"
                                    style="width: {{ 100 / $allActiveStatuses->count() }}%">
                                    {{ $status->status_name }}
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-purple-600 h-2.5 rounded-full"
                                style="width: {{ (($order->status->order - 1) / ($allActiveStatuses->count() - 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Detail Produk --}}
                    <div class="p-4 mb-4 bg-gray-50 rounded-lg">
                        <div class="flex flex-wrap gap-4">
                            @foreach ($order->items as $item)
                                <div class="flex items-center space-x-3">
                                    @if ($item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                            class="object-cover w-12 h-12 rounded-lg">
                                    @else
                                        <div
                                            class="flex items-center justify-center w-12 h-12 text-gray-400 bg-gray-200 rounded-lg">
                                            <i class="text-2xl fas fa-box-open"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-600">x{{ $item->quantity }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t">
                        <div>
                            <span class="text-sm text-gray-600">Total Pembayaran</span>
                            <p class="text-xl font-bold text-purple-600">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('customer.order.detail', $order->no_transaction) }}"
                                class="flex-1 px-4 py-2 font-medium text-center text-white transition-all bg-purple-600 rounded-lg hover:bg-purple-700"><i
                                    class="mr-2 fas fa-eye"></i>Lihat Detail</a>
                            @if ($order->status->order == 1)
                                {{-- Menunggu Pembayaran --}}
                                <a href="{{ route('customer.order.payment', $order->no_transaction) }}"
                                    class="flex-1 px-4 py-2 font-medium text-center text-white transition-all bg-orange-500 rounded-lg hover:bg-orange-600"><i
                                        class="mr-2 fas fa-upload"></i>Lakukan Pembayaran</a>
                            @endif
                            <a href="https://api.whatsapp.com/send?phone={{ $systemSetting['store_phone'] }}&text={{ urlencode('Halo, saya ingin bertanya tentang pesanan ' . $order->no_transaction) }}"
                                target="_blank"
                                class="flex-1 px-4 py-2 font-medium text-center text-green-600 transition-all border border-green-500 rounded-lg hover:bg-green-50"><i
                                    class="mr-2 fab fa-whatsapp"></i>Hubungi CS</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center bg-white rounded-xl shadow-md">
                    <i class="mb-6 text-6xl text-gray-300 fas fa-shopping-bag"></i>
                    <h3 class="mb-3 text-xl font-bold text-gray-800">Tidak Ada Pesanan Ditemukan</h3>
                    <p class="mb-6 text-gray-600">Pesanan aktif yang cocok dengan filter Anda tidak ditemukan.</p>
                </div>
            @endforelse

            <div class="mt-8">{{ $orders->links() }}</div>
        </div>
    </section>
@endsection
