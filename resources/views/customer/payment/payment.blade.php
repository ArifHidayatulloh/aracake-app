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

    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
@endphp
@extends('layouts.guest', ['title' => "Pembayaran $order->no_transaction"])

@section('content')
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="/" class="hover:text-purple-600">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('cart') }}" class="hover:text-purple-600">Keranjang</a>
            <span class="mx-2">/</span>
            <a href="" class="hover:text-purple-600">Pesanan</a>
            <span class="mx-2">/</span>
            <span class="text-purple-600">Pembayaran</span>
        </div>
    </div>

    <section class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Pembayaran</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                @if ($order->status->order == '1')
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Pesanan
                                #{{ $order->no_transaction }}</h2>
                            <span
                                style="background-color: {{ hexToRgba($order->status->status_color) }}; color: {{ $order->status->status_color }};"
                                class="text-sm font-medium px-3 py-1 rounded-full">
                                {{ $order->status->status_name }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Nama Pemesan</p>
                                <p class="font-medium">{{ $order->user->full_name }}
                                    ({{ $order->user->username }})</p>
                            </div>
                            <div>
                                <p class="text-gray-600">No. Telepon</p>
                                <p class="font-medium">{{ $order->user->phone_number }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tanggal Ambil/Kirim</p>
                                <p class="font-medium">

                                    {{ \Carbon\Carbon::parse($order->pickup_delivery_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Metode Pengiriman</p>
                                <p class="font-medium">
                                    {{ $order->deliveryMethod->method_name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 mb-6" id="payment-method-card">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Metode Pembayaran Dipilih</h2>

                        <div class="payment-method active" id="transfer-method">
                            <div class="border border-purple-500 rounded-lg p-4 bg-purple-50">
                                <h3 class="font-bold text-gray-800 mb-4">Transfer Bank</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white p-4 rounded-lg border">
                                        <div class="flex items-center mb-2">
                                            <span class="font-medium">{{ $order->paymentMethod->method_name }}</span>
                                        </div>
                                        @if ($order->paymentMethod->account_number != null)
                                            <p class="text-sm text-gray-600">No. Rekening</p>
                                            <p class="font-mono text-lg font-bold text-purple-600">

                                                {{ $order->paymentMethod->account_number }}</p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $order->paymentMethod->account_details }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm text-blue-800">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Transfer sesuai dengan total yang tertera. Setelah
                                        transfer, upload bukti pembayaran di
                                        bawah.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Upload Bukti Pembayaran</h2>

                        <form action="{{ route('customer.payment.upload', $order->no_transaction) }}" method="POST"
                            enctype="multipart/form-data" id="payment-form">
                            @csrf
                            <div class="mb-6">
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bukti Transfer/Pembayaran *
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-500 transition-colors"
                                    id="file-drop-zone">
                                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*,.pdf"
                                        required class="hidden">
                                    <div id="file-placeholder">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-gray-600 mb-2">Klik untuk upload atau
                                            drag & drop</p>
                                        <p class="text-sm text-gray-500">Format: JPG, PNG,
                                            PDF (Maks. 5MB)</p>
                                    </div>
                                    <div id="file-preview" class="hidden">
                                        <i class="fas fa-file-image text-4xl text-green-500 mb-2"></i>
                                        <p id="file-name" class="font-medium text-gray-800">
                                        </p>
                                        <button type="button" onclick="removeFile()"
                                            class="text-red-500 text-sm mt-2 hover:underline">
                                            Hapus file
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href=""
                                    class="flex-1 border border-gray-300 text-gray-700 py-3 px-6 rounded-lg font-medium hover:bg-gray-50 transition-all text-center">
                                    ← Kembali
                                </a>
                                <button type="submit" id="submit-btn"
                                    class="flex-1 bg-gradient-to-r from-purple-600 to-pink-500 text-white py-3 px-6 rounded-lg font-bold hover:from-purple-700 hover:to-pink-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                    Konfirmasi Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif ($order->status->order == '2')
                    <div class="bg-white rounded-xl shadow-md p-6 text-center">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-6xl text-green-500"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Bukti Pembayaran Terunggah</h2>
                        <p class="text-gray-600 mb-4">
                            Bukti pembayaran Anda telah kami terima dan sedang dalam proses verifikasi.
                        </p>
                        <p class="text-gray-600">
                            Kami akan segera memperbarui status pesanan Anda. Silakan cek detail pesanan Anda secara
                            berkala.
                        </p>
                        <a href="{{ route('customer.order.detail', $order->no_transaction) }}"
                            class="mt-4 inline-block text-purple-600 hover:underline font-medium">
                            Lihat Detail Pesanan
                        </a>
                    </div>
                @else
                    {{-- Kondisi lain, misalnya sudah diproses --}}
                    <div class="bg-white rounded-xl shadow-md p-6 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pesanan Anda Sedang Diproses</h2>
                        <p class="text-gray-600 mb-4">
                            Pesanan Anda telah dibayar dan sedang kami siapkan.
                        </p>
                        <a href="{{ route('customer.order.detail', $order->no_transaction) }}"
                            class="mt-4 inline-block text-purple-600 hover:underline font-medium">
                            Lihat Detail Pesanan
                        </a>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Total Pembayaran</h2>

                    <div class="space-y-3 mb-6">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between items-center text-sm">
                                <div>
                                    <span class="font-medium">{{ $item->product->name }}</span>
                                    <p class="text-gray-500 text-xs">
                                        x{{ $item->quantity }}</p>
                                </div>
                                <span class="font-medium">{{ formatRupiah($item->unit_price * $item->quantity) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span
                                class="font-medium">{{ formatRupiah($order->total_amount - $order->delivery_cost) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Pengiriman</span>
                            <span class="font-medium">

                                {{ $order->delivery_cost > 0 ? formatRupiah($order->delivery_cost) : 'Gratis' }}
                            </span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-bold text-purple-600 text-2xl">
                                {{ formatRupiah($order->total_amount) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-3">Butuh Bantuan?</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><i class="fas fa-phone text-green-500 mr-2"></i>WhatsApp:
                                {{ $systemSetting['store_phone']->setting_value ?? '' }}</p>
                            <p><i class="fas fa-envelope text-blue-500 mr-2"></i>Email:
                                {{ $systemSetting['store_email']->setting_value ?? '' }}</p>
                            <p class="text-xs text-gray-500 mt-3">Customer service siap
                                membantu 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/payment/payment.js') }}"></script>
@endsection
