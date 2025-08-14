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
@extends('layouts.guest', ['title' => 'Detail Pesanan'])

@section('content')
    <div class="bg-gray-50 py-4">
        <div class="container mx-auto px-6">
            <div class="flex items-center text-sm text-gray-600">
                <a href="/" class="hover:text-purple-600">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('customer.order.my-order') }}" class="hover:text-purple-600">Pesanan Saya</a>
                <span class="mx-2">/</span>
                <span class="text-purple-600">Detail Pesanan</span>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-sm border-b py-6">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan
                        #{{ $order->no_transaction ?? 'ORD-2025-001' }}</h1>
                    <p class="text-gray-600">Dipesan pada {{ $order->order_date->format('d M Y, H:i') }} WIB</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                    <span
                        style="background-color: {{ hexToRgba($order->status->status_color) }}; color: {{ $order->status->status_color }};"
                        class="text-sm font-medium px-3 py-1 rounded-full mt-2 sm:mt-0">
                        {{ $order->status->status_name }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <section class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">


                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Item Pesanan</h2>

                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <img src="{{ $item->product->image_url }}" alt="Chocolate Dream"
                                    class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p>x{{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">Rp
                                        {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Pembayaran</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-3">Metode Pembayaran</h3>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <span class="font-medium">{{ $order->paymentMethod->method_name }}</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $order->paymentMethod->account_number }}</p>
                                <p class="text-sm text-gray-600">{{ $order->paymentMethod->account_details }}</p>
                            </div>
                        </div>

                        @if ($order->status->order == '1')
                            {{-- Menunggu pembayaran --}}
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3">Status Pembayaran</h3>
                                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-clock text-red-500 mr-2"></i>
                                        <span class="font-medium text-red-800">Menunggu Pembayaran</span>
                                    </div>
                                    <p class="text-sm text-red-700">Silakan lakukan pembayaran sesuai instruksi di atas.</p>
                                </div>
                            </div>
                        @elseif($order->status->order == '2')
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3">Status Pembayaran</h3>
                                <div class="p-4 bg-orange-50 border border-orange-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-clock text-orange-500 mr-2"></i>
                                        <span class="font-medium text-orange-800">Sedang Diverifikasi</span>
                                    </div>
                                    <p class="text-sm text-orange-700">Bukti pembayaran telah diterima</p>
                                    <p class="text-sm text-orange-600">Upload:
                                        {{ $order->payment->payment_date->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @else
                            {{-- Sudah terbayar / status lain --}}
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-3">Status Pembayaran</h3>
                                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="font-medium text-green-800">Pembayaran Dikonfirmasi</span>
                                    </div>
                                    <p class="text-sm text-green-700">Pembayaran Anda telah berhasil diverifikasi.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Bukti Pembayaran</h3>
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            @if ($order->status->order == '1')
                                <a href="{{ route('customer.order.payment', $order->no_transaction) }}"
                                    class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg text-sm hover:bg-purple-700 transition-all text-center">
                                    <i class="fas fa-upload mr-2"></i>Unggah Bukti Pembayaran
                                </a>
                            @elseif($order->payment && $order->payment->proof_of_payment_url)
                                <i class="fas fa-file-image text-purple-500 text-2xl"></i>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">bukti_transfer_{{ $order->no_transaction }}.jpg
                                    </p>
                                    <p class="text-sm text-gray-600">Diupload
                                        {{ $order->payment->payment_date->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <button onclick="viewPaymentProof()"
                                    class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition-all">
                                    <i class="fas fa-eye mr-2"></i>Lihat
                                </button>
                            @else
                                <div class="w-full text-center text-gray-500 italic">
                                    Bukti pembayaran tidak tersedia.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Status Pesanan</h2>

                    <div class="relative">
                        <div class="absolute left-6 top-8 bottom-8 w-0.5 bg-gray-200"></div>

                        <div class="space-y-6">
                            @php
                                $allEvents = [
                                    'ORDER_CREATED' => 'Pesanan dibuat',
                                    'PAYMENT_PROOF_UPLOADED' => 'Pelanggan mengunggah bukti pembayaran',
                                    'PAYMENT_CONFIRMED' => 'Pembayaran dikonfirmasi',
                                    'ORDER_PROCESSED' => 'Pesanan sedang diproses',
                                    'DELIVERY_ASSIGNED' => 'Pesanan siap diambil/sedang dikirim',
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
                                        $hasTerminal = $event;
                                        break;
                                    }
                                }
                            @endphp

                            @foreach ($allEvents as $eventType => $eventAlias)
                                @php
                                    $isCompleted = in_array($eventType, $completedEvents);
                                    $log = $isCompleted ? $logs->firstWhere('event_type', $eventType) : null;

                                    // Jangan tampilkan terminal event sebagai pending kalau belum terjadi
                                    if (!$isCompleted && !$hasTerminal && in_array($eventType, $terminalEvents)) {
                                        continue;
                                    }
                                @endphp

                                @if ($isCompleted)
                                    <div class="flex items-start space-x-4">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-full flex-shrink-0 relative z-10
                        @if (in_array($eventType, $terminalEvents)) bg-red-500 text-white @else bg-green-500 text-white @endif">
                                            <i
                                                class="fas @if (in_array($eventType, $terminalEvents)) fa-times @else fa-check @endif"></i>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                                <div>
                                                    <h3 class="font-semibold text-gray-800">{{ $eventAlias }}</h3>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $log->message ?? 'Menunggu aksi...' }}</p>
                                                </div>
                                                <span class="text-sm text-gray-500 mt-1 sm:mt-0">
                                                    {{ $log->timestamp->format('d M Y, H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @if (in_array($eventType, $terminalEvents))
                                        @break
                                    @endif
                                @else
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

                    @if ($order->status->order == '5')
                        <form action="{{ route('customer.order.accepted', $order->no_transaction) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="mt-8 w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-purple-700 transition-all">
                                <i class="fas fa-check-circle mr-2"></i>Pesanan Diterima
                            </button>
                        </form>
                    @endif
                </div>


            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>

                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Informasi Pemesan</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-medium">{{ $order->user->full_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Telepon:</span>
                                <span class="font-medium">{{ $order->user->phone_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $order->user->email }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Pengiriman</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode:</span>
                                <span class="font-medium">{{ $order->deliveryMethod->method_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-medium">{{ $order->pickup_delivery_date->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm font-medium text-blue-800 mb-1">Alamat Toko:</p>
                            <p class="text-sm text-blue-700">{{ $systemSetting['store_address']->setting_value ?? '' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">Rp
                                {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Pengiriman:</span>
                            @if ($order->delivery_cost == 0)
                                <span class="font-medium text-green-600">Gratis</span>
                            @else
                                <span class="font-medium">Rp
                                    {{ number_format($order->delivery_cost, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="font-bold text-gray-800">Total:</span>
                            <span class="font-bold text-purple-600 text-xl">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Tindakan</h3>
                    <div class="space-y-3">
                        <a href="https://api.whatsapp.com/send?phone={{ $systemSetting['store_phone']->setting_value }}&text={{ urlencode('Halo, saya ingin bertanya tentang pesanan ' . $order->no_transaction) }}"
                            target="_blank"
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition-all text-center block">
                            <i class="fab fa-whatsapp mr-2"></i>Hubungi CS
                        </a>


                        @if ($order->status->order == '1')
                            <button onclick="showCancelModal()"
                                class="w-full border border-red-500 text-red-600 py-3 px-4 rounded-lg font-medium hover:bg-red-50 transition-all">
                                <i class="fas fa-times mr-2"></i>Batalkan Pesanan
                            </button>
                        @endif
                    </div>
                </div>

                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                    <h3 class="font-semibold text-purple-800 mb-3">Butuh Bantuan?</h3>
                    <div class="space-y-3 text-sm text-purple-700">
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-3"></i>
                            <div>
                                <p class="font-medium">Customer Service</p>
                                <p>{{ $systemSetting['store_phone']->setting_value }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <div>
                                <p class="font-medium">Email</p>
                                <p>{{ $systemSetting['store_email']->setting_value }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-3"></i>
                            <div>
                                <p class="font-medium">Jam Operasional</p>
                                <p>Senin - Sabtu: 08:00 - 20:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="cancel-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 max-w-md mx-4 w-full">
            <div class="flex items-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3"></i>
                <h3 class="text-xl font-bold text-gray-800">Batalkan Pesanan</h3>
            </div>

            <p class="text-gray-600 mb-4">Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat
                dibatalkan.</p>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Pembatalan</label>
                <select id="cancel-reason"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500"
                    name="cancellation_reason">
                    <option value="">Pilih alasan...</option>
                    <option value="Berubah pikiran">Berubah pikiran</option>
                    <option value="Salah pesan">Salah pesan</option>
                    <option value="Terlalu lama">Terlalu lama</option>
                    <option value="Menemukan yang lebih murah">Menemukan yang lebih murah</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button onclick="closeCancelModal()"
                    class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button onclick="confirmCancel()"
                    class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700">
                    Ya, Batalkan
                </button>
            </div>
        </div>
    </div>

    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 max-w-2xl mx-4 w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Bukti Pembayaran</h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="text-center">
                <img src="{{ Storage::url($order->payment->proof_of_payment_url) ?? '' }}" alt="Bukti Pembayaran"
                    class="max-w-full h-auto rounded-lg mx-auto">
                <p class="text-sm text-gray-600 mt-2">bukti transfer #{{ $order->no_transaction }}</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/order/detailOrder.js') }}"></script>
@endsection
