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
@extends('layouts.guest', ['title' => 'Pesanan Saya'])

@section('content')
    <div class="bg-gradient-to-r from-purple-600 to-pink-500 text-white py-8">
        <div class="container mx-auto px-6">
            <h1 class="text-3xl font-bold mb-2">Pesanan Saya</h1>
            <p class="text-purple-100">Pantau status pesanan aktif Anda</p>
        </div>
    </div>

    <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-6">
            <nav class="flex space-x-8">
                <a href="{{ route('customer.order.my-order') }}"
                    class="py-4 px-1 border-b-2 border-purple-500 font-medium text-sm text-purple-600">
                    Pesanan Aktif
                </a>
                <a href="{{ route('customer.order.history') }}"
                    class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Riwayat Pesanan
                </a>
            </nav>
        </div>
    </div>

    <section class="container mx-auto px-6 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                <select class="px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                    name="status">
                    <option value="">Semua Status</option>
                    @foreach ($status as $stat)
                        <option value="{{ $stat->id }}" @if (request('status') == $stat->id) selected @endif>
                            {{ $stat->status_name }}</option>
                    @endforeach
                </select>
                <span class="text-sm text-gray-600" id="order-count">Menampilkan {{ $orders->count() }} pesanan</span>
            </div>
            <div class="relative">
                <form action="{{ route('customer.order.my-order') }}" method="GET" class="flex items-center">
                    <input type="text" placeholder="Cari pesanan..." name="search" value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            @forelse ($orders as $order)
                @php
                    $statusColor = $order->status->status_color;
                    $currentStep = $order->status->order;
                    $totalSteps = \App\Models\OrderStatus::whereNotIn('order', ['7', '8'])->max('order');
                    $percentage = ($currentStep / $totalSteps) * 100;

                    $systemSetting = \App\Models\SystemSetting::where('is_active', true)->get()->keyBy('setting_key');
                @endphp

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4" style="border-left-color: {{ $statusColor }};">
                    <div class="flex flex-col lg:flex-row justify-between items-start mb-4">
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3">
                                <h3 class="text-xl font-bold text-gray-800">Pesanan #{{ $order->no_transaction }}</h3>
                                <span style="background-color: {{ hexToRgba($statusColor) }}; color: {{ $statusColor }};"
                                    class="text-sm font-medium px-3 py-1 rounded-full mt-2 sm:mt-0">
                                    {{ $order->status->status_name }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600 mb-4">
                                <div>
                                    <p class="font-medium text-gray-800">Tanggal Pesan</p>
                                    <p>{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y, H:i') }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Tanggal Antar/Ambil</p>
                                    <p>{{ \Carbon\Carbon::parse($order->pickup_delivery_date)->format('d F Y') }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Total</p>
                                    <p class="text-purple-600 font-bold text-lg">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex flex-wrap gap-4">
                            @foreach ($order->items->take(3) as $item)
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                        class="w-12 h-12 object-cover rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">{{ $item->product->name }}</p>
                                        <p class="text-gray-600 text-xs">x{{ $item->quantity }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @if ($order->items->count() > 3)
                                <div class="flex items-center text-gray-500">
                                    <span class="text-sm">+{{ $order->items->count() - 3 }} item lainnya</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('customer.order.detail', $order->no_transaction) }}"
                            class="flex-1 bg-purple-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-purple-700 transition-all text-center">
                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                        </a>

                        {{-- Tampilkan tombol Unggah Bukti Pembayaran jika statusnya 'Menunggu Pembayaran' --}}
                        @if ($order->status->status_key == 'WAITING_PAYMENT')
                            <a href="#"
                                class="flex-1 bg-orange-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-orange-600 transition-all text-center">
                                <i class="fas fa-upload mr-2"></i>Unggah Bukti Pembayaran
                            </a>
                        @endif

                        {{-- Tampilkan tombol Konfirmasi Diambil jika statusnya 'Siap Diambil' --}}
                        @if ($order->status->status_key == 'DELIVERY_ASSIGNED')
                            <a href="#"
                                class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-700 transition-all text-center"
                                onclick="confirmPickup('{{ $order->no_transaction }}')">
                                <i class="fas fa-hand-holding mr-2"></i>Konfirmasi Diambil
                            </a>
                        @endif

                        <a href="https://api.whatsapp.com/send?phone={{ $systemSetting['store_phone']->setting_value }}&text={{ urlencode('Halo, saya ingin bertanya tentang pesanan ' . $order->no_transaction) }}"
                            target="_blank"
                            class="flex-1 border border-green-500 text-green-600 py-2 px-4 rounded-lg font-medium hover:bg-green-50 transition-all text-center">
                            <i class="fab fa-whatsapp mr-2"></i>Hubungi CS
                        </a>
                    </div>
                </div>
            @empty
                <div id="empty-state" class="bg-white rounded-xl shadow-md p-12 text-center">
                    <i class="fas fa-shopping-bag text-gray-300 text-6xl mb-6"></i>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Belum Ada Pesanan Aktif</h3>
                    <p class="text-gray-600 mb-6">Anda belum memiliki pesanan yang sedang diproses.</p>
                    <a href="{{ route('customer.order.history') }}"
                        class="inline-block bg-purple-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-purple-700 transition-all">
                        <i class="fas fa-history mr-2"></i>Lihat Riwayat Pesanan
                    </a>
                </div>
            @endforelse

            {{-- Tambahkan pagination link jika ada --}}
            <div class="mt-8">
                <x-pagination-custom.orders :orders="$orders" />
            </div>
        </div>


    </section>

    <script>
        // ... (kode javascript tidak perlu diubah, tetap sama)
        function confirmPickup(orderId) {
            if (confirm('Apakah Anda yakin pesanan ini sudah diambil?')) {
                // Simulate API call
                const button = event.target;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                button.disabled = true;

                setTimeout(() => {
                    // Remove the order card with animation
                    const orderCard = button.closest('.bg-white');
                    orderCard.style.animation = 'fadeOut 0.5s ease-out';

                    setTimeout(() => {
                        orderCard.remove();

                        // Show success notification
                        const notification = document.createElement('div');
                        notification.className =
                            'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                        notification.innerHTML =
                            '<i class="fas fa-check mr-2"></i>Pesanan berhasil dikonfirmasi diambil!';
                        document.body.appendChild(notification);

                        setTimeout(() => {
                            notification.remove();
                        }, 3000);

                        // Update order count
                        const orderCount = document.getElementById('order-count');
                        const currentCount = parseInt(orderCount.textContent.match(/\d+/)[0]);
                        orderCount.textContent = `Menampilkan ${currentCount - 1} pesanan`;

                        // Show empty state if no orders left
                        if (currentCount - 1 === 0) {
                            document.getElementById('empty-state').classList.remove('hidden');
                        }
                    }, 500);
                }, 1000);
            }
        }

        // Search functionality
        const searchInput = document.querySelector('input[placeholder="Cari pesanan..."]');
        searchInput.addEventListener('input', function() {
            // Ini akan memicu form submit untuk pencarian
            // Anda bisa menggunakan AJAX di sini jika ingin real-time tanpa refresh
            // Tapi untuk saat ini, kita bisa submit form saja
            const form = this.closest('form');
            form.submit();
        });

        // Filter functionality
        const filterSelect = document.querySelector('select[name="status"]');
        filterSelect.addEventListener('change', function() {
            // Ini juga akan memicu form submit
            const form = this.closest('form');
            form.submit();
        });
    </script>
@endsection
