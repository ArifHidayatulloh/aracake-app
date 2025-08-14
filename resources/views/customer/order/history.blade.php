@extends('layouts.guest', ['title' => 'Riwayat Pesanan'])

@section('content')
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-500 text-white py-8">
        <div class="container mx-auto px-6">
            <h1 class="text-3xl font-bold mb-2">Riwayat Pesanan</h1>
            <p class="text-purple-100">Semua pesanan yang pernah Anda buat</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-6">
            <nav class="flex space-x-8">
                <a href="{{ route('customer.order.my-order') }}"
                    class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Pesanan Aktif
                </a>
                <a href="{{ route('customer.order.history') }}"
                    class="py-4 px-1 border-b-2 border-purple-500 font-medium text-sm text-purple-600">
                    Riwayat Pesanan
                </a>
            </nav>
        </div>
    </div>

    <!-- Content -->
    <section class="container mx-auto px-6 py-8">
        <!-- Filter & Search -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status-filter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Semua Status</option>
                        @foreach ($status as $stat)
                            <option value="{{ $stat->id }}">{{ $stat->status_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                    <select id="period-filter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Semua Waktu</option>
                        <option value="7">7 Hari Terakhir</option>
                        <option value="30">30 Hari Terakhir</option>
                        <option value="90">3 Bulan Terakhir</option>
                        <option value="365">1 Tahun Terakhir</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                    <select id="sort-filter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="highest">Harga Tertinggi</option>
                        <option value="lowest">Harga Terendah</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pesanan</label>
                    <div class="relative">
                        <input type="text" id="search-input" placeholder="No. pesanan atau produk..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6 pt-6 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-2xl font-bold text-purple-600">{{ $orders->count() }}</p>
                    <p class="text-sm text-gray-600">Total Pesanan</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $orders->where('is_finish', true)->count() }}</p>
                    <p class="text-sm text-gray-600">Berhasil</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $orders->where('is_cancelled', true)->count() }}</p>
                    <p class="text-sm text-gray-600">Dibatalkan</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-orange-600">
                        {{ $orders->filter(fn($order) => $order->order_status_id === \App\Models\OrderStatus::where('order', 8)->value('id'))->count() }}
                    </p>
                    <p class="text-sm text-gray-600">Gagal</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600">Rp
                        {{ number_format($orders->filter(fn($order) => $order->is_finish)->sum('total_amount'), 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-600">Total Pembelian</p>
                </div>
            </div>

        </div>

        <!-- Order History -->
        <div class="space-y-4" id="order-list">
            @forelse($orders as $order)
                <!-- Order Item -->
                <div
                    class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-{{ $order->is_finish ? 'green' : ($order->is_cancelled ? 'red' : 'gray') }}-500">
                    <div class="flex flex-col lg:flex-row justify-between items-start">
                        <div class="flex-1 mb-4 lg:mb-0">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-gray-800">Pesanan #{{ $order->invoice }}</h3>
                                <span
                                    class="bg-{{ $order->is_finish ? 'green' : ($order->is_cancelled ? 'red' : 'gray') }}-100 text-{{ $order->is_finish ? 'green' : ($order->is_cancelled ? 'red' : 'gray') }}-800 text-sm font-medium px-3 py-1 rounded-full mt-2 sm:mt-0">
                                    <i
                                        class="fas fa-{{ $order->is_finish ? 'check-circle' : ($order->is_cancelled ? 'times-circle' : 'hourglass-half') }} mr-1"></i>{{ $order->status->status_name }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-600">
                                <div>
                                    <p class="font-medium text-gray-800">Tanggal Pesan</p>
                                    <p>{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
                                </div>
                                @if ($order->is_finish)
                                    <div>
                                        <p class="font-medium text-gray-800">Tanggal Selesai</p>
                                        <p>{{ $order->updated_at->translatedFormat('d F Y, H:i') }}</p>
                                    </div>
                                @elseif($order->is_cancelled)
                                    <div>
                                        <p class="font-medium text-gray-800">Tanggal Batal</p>
                                        <p>{{ $order->updated_at->translatedFormat('d F Y, H:i') }}</p>
                                    </div>
                                @else
                                    <div>
                                        <p class="font-medium text-gray-800">Metode</p>
                                        <p>{{ $order->paymentMethod->method_name }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">Metode</p>
                                    <p>{{ $order->deliveryMethod->method_name }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Total</p>
                                    <p class="text-purple-600 font-bold text-lg">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $item->product->image_url }}"
                                                alt="{{ $item->product->product_name }}"
                                                class="w-10 h-10 object-cover rounded-lg">
                                            <div>
                                                <p class="font-medium text-gray-800 text-sm">
                                                    {{ $item->product->product_name }}</p>
                                                <p class="text-gray-600 text-xs">{{ $item->variant_name }}
                                                    x{{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 lg:ml-6">
                            <a href="{{ route('customer.order.detail', $order->no_transaction) }}"
                                class="bg-purple-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-purple-700 transition-all text-center text-sm">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm p-6 text-center text-gray-500">
                    <p>Tidak ada riwayat pesanan yang ditemukan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="mt-8">
                <x-pagination-custom.orders :orders="$orders" />
            </div>
        @endif

    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/order/historyOrder.js') }}"></script>
@endpush
