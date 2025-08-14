@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- Breadcrumb dan Header Halaman --}}
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Manajemen Pesanan', 'url' => route('admin.order.index')],
            ['label' => 'Detail Pesanan'],
        ]" />

        <x-header-page.header-page title="Detail Pesanan #{{ $order->no_transaction }}"
            description="Informasi lengkap dan riwayat pesanan." />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Bagian Kiri: Informasi Pesanan dan Produk --}}
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6 space-y-6">
                    {{-- Informasi Pelanggan dan Pengiriman --}}
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Pelanggan & Pengiriman</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Nama Pelanggan:</p>
                                <p class="font-semibold text-gray-900">{{ $order->user->full_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Email:</p>
                                <p class="font-semibold text-gray-900">{{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Alamat Pengiriman:</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $order->address->address_line1 }}, {{ $order->address->address_line2 }}
                                    <br>
                                    {{ $order->address->city }},{{ $order->address->province }} -
                                    {{ $order->address->postal_code }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-500">Tanggal Ambil/Kirim:</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $order->pickup_delivery_date->format('d M Y') }}</p>
                            </div>

                            {{-- Bagian Baru untuk Notes Order --}}
                            @if ($order->notes)
                                <div class="sm:col-span-2">
                                    <p class="text-gray-500">Catatan Pesanan:</p>
                                    <p class="font-semibold text-gray-900">{{ $order->notes }}</p>
                                </div>
                            @endif

                            {{-- Tambahan: Bukti Pembayaran --}}
                            <div class="sm:col-span-2">
                                <p class="text-gray-500">Bukti Pembayaran:</p>
                                @if ($order->payment)
                                    <button id="open-payment-modal" type="button"
                                        class="font-semibold text-purple-600 hover:text-purple-800 underline focus:outline-none">
                                        Lihat Bukti Pembayaran
                                    </button>
                                @else
                                    <p class="font-semibold text-gray-400">Belum ada bukti pembayaran</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-200">

                    {{-- Detail Produk --}}
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Produk Pesanan</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Produk</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga Satuan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->product->name }} ({{ $item->product->sku }})</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                                {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                                {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        {{-- Biaya Tambahan --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Biaya Delivery</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                            {{ number_format($order->delivery_cost, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-900">Total</td>
                                        <td class="px-6 py-4 font-bold text-gray-900">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Status Pesanan (Timeline) --}}
                <div class="mt-6 bg-white rounded-lg shadow-sm border border-purple-100 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Riwayat Pesanan</h3>
                    <div class="space-y-6">
                        @php
                            $allEvents = [
                                'ORDER_CREATED' => 'Pesanan dibuat',
                                'PAYMENT_PROOF_UPLOADED' => 'Pelanggan mengunggah bukti pembayaran',
                                'PAYMENT_CONFIRMED' => 'Pembayaran dikonfirmasi',
                                'ORDER_PROCESSED' => 'Pesanan sedang diproses',
                                'DELIVERY_ASSIGNED' => 'Pesanan siap diambil',
                                'ORDER_COMPLETED' => 'Pesanan selesai',
                                'ORDER_CANCELLED' => 'Pesanan dibatalkan',
                                'ORDER_FAILED' => 'Pesanan gagal',
                            ];

                            $terminalEvents = ['ORDER_CANCELLED', 'ORDER_FAILED'];
                            $logs = $order->logs;
                            $completedEvents = $logs->pluck('event_type')->all();

                            $hasTerminal = false;
                            foreach ($terminalEvents as $event) {
                                if (in_array($event, $completedEvents)) {
                                    $hasTerminal = $event; // simpan terminal event yg terjadi
                                    break;
                                }
                            }
                        @endphp

                        @foreach ($allEvents as $eventType => $eventAlias)
                            @php
                                $isCompleted = in_array($eventType, $completedEvents);
                                $log = $isCompleted ? $logs->firstWhere('event_type', $eventType) : null;

                                // Jika event terminal BELUM terjadi, sembunyikan event terminal dari pending state
                                if (!$isCompleted && !$hasTerminal && in_array($eventType, $terminalEvents)) {
                                    continue;
                                }
                            @endphp

                            @if ($isCompleted)
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 rounded-full flex-shrink-0 relative z-10
                @if (in_array($eventType, $terminalEvents)) bg-red-500 text-white @else bg-green-500 text-white @endif">
                                        <i class="fas @if (in_array($eventType, $terminalEvents)) fa-times @else fa-check @endif"></i>
                                    </div>
                                    <div class="flex-1 pt-2">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                            <div>
                                                <h3 class="font-semibold text-gray-800">{{ $eventAlias }}</h3>
                                                <p class="text-sm text-gray-600">{{ $log->message ?? 'Menunggu aksi...' }}
                                                </p>
                                            </div>
                                            <span class="text-sm text-gray-500 mt-1 sm:mt-0">
                                                {{ $log->timestamp->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Hentikan loop jika event terminal sudah ditemukan --}}
                                @if (in_array($eventType, $terminalEvents))
                                    @break
                                @endif
                            @else
                                {{-- Hanya tampilkan step pending jika tidak melewati terminal --}}
                                @if (!$hasTerminal)
                                    <div class="flex items-start space-x-4">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-full flex-shrink-0 relative z-10 bg-gray-200 text-gray-500">
                                            <i class="fas fa-circle"></i>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                                <div>
                                                    <h3 class="font-semibold text-gray-400">{{ $eventAlias }}</h3>
                                                    <p class="text-sm text-gray-400">Menunggu aksi...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Status Pesanan & Aksi --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-6 space-y-6 sticky top-6">
                    {{-- Informasi Status Saat Ini --}}
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Status Pesanan Saat Ini</h3>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full text-white"
                                style="background-color: {{ $order->status->status_color }}">
                                {{ $order->status->status_name }}
                            </span>
                        </div>
                    </div>

                    <hr class="border-gray-200">

                    {{-- Form Perubahan Status --}}
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Ubah Status</h3>
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                                role="alert">
                                <strong class="font-bold">Sukses!</strong>
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                                role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="status_id" class="block text-sm font-medium text-gray-700">Status Baru</label>
                                <select name="order_status_id" id="status_id" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <option value="" disabled>Pilih Status Baru</option>
                                    @foreach ($orderStatus as $status)
                                        <option value="{{ $status->id }}"
                                            @if ($order->status->id == $status->id) disabled @endif>
                                            {{ $status->status_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_status_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700">Pesan Log
                                    (Opsional)</label>
                                <textarea name="message" id="message" rows="3"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                    placeholder="Tambahkan catatan untuk riwayat pesanan..."></textarea>
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Perbarui Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Bukti Pembayaran --}}
    <div id="payment-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-semibold text-gray-900">Bukti Pembayaran</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="mt-2">
                @if ($order->payment)
                    <img src="{{ Storage::url($order->payment->proof_of_payment_url) ?? '' }}" alt="Bukti Pembayaran"
                        class="w-full h-auto rounded-md shadow-sm">
                @else
                    <p class="text-gray-500 text-center">Tidak ada bukti pembayaran yang diunggah.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('payment-modal');
            const openModalBtn = document.getElementById('open-payment-modal');
            const closeModalBtn = document.getElementById('close-modal');

            if (openModalBtn) {
                openModalBtn.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                });
            }

            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Tutup modal jika mengklik di luar konten modal
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
