@extends('layouts.guest', ['title' => 'Form Pemesanan'])

@section('content')
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="/" class="hover:text-purple-600">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('cart') }}" class="hover:text-purple-600">Keranjang</a>
            <span class="mx-2">/</span>
            <span class="text-purple-600">Form Pemesanan</span>
        </div>
    </div>

    <section class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Form Pemesanan</h1>

        <form action="{{ route('customer.order.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Pelanggan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap
                                    *</label>
                                <input type="text" name="nama" id="nama" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    value="{{ Auth::user()->full_name }}" disabled>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon
                                    *</label>
                                <input type="tel" name="phone" id="phone" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    value="{{ Auth::user()->phone_number }}" disabled>
                            </div>
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman *</label>

                                @forelse ($userAddresses as $address)
                                    <label
                                        class="flex items-start p-3 border border-gray-200 rounded-lg mb-2 cursor-pointer hover:border-purple-500">
                                        <input type="radio" name="pickup_delivery_address_id" value="{{ $address->id }}"
                                            required class="mt-1 text-purple-600 focus:ring-purple-500"
                                            {{ $address->is_default ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <span class="block font-medium text-gray-800">
                                                {{ $address->address_line1 }}
                                                @if ($address->address_line2)
                                                    , {{ $address->address_line2 }}
                                                @endif
                                            </span>
                                            <span class="block text-sm text-gray-500">
                                                {{ $address->city }}, {{ $address->province }} -
                                                {{ $address->postal_code }}
                                            </span>
                                            @if ($address->is_default)
                                                <span
                                                    class="inline-block mt-1 px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                                    Alamat Utama
                                                </span>
                                            @endif
                                        </div>
                                    </label>
                                @empty
                                    <div class="text-sm text-gray-500 mb-2">Anda belum memiliki alamat</div>
                                @endforelse

                                <button type="button" onclick="openAddressModal()"
                                    class="mt-2 text-sm font-medium text-purple-600 hover:text-purple-500">
                                    + Tambah Alamat Baru
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Detail Pesanan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="tanggal_ambil" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                    Ambil/Kirim *</label>
                                <input type="date" name="pickup_delivery_date" id="tanggal_ambil" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    min="{{ now()->addDays($min_preparation_days)->format('Y-m-d') }}">
                                <p class="text-xs text-gray-500 mt-1">Minimal {{ $min_preparation_days }} hari dari
                                    sekarang</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pengiriman *</label>
                                <div class="space-y-3">
                                    @foreach ($deliveryMethods as $delivery)
                                        <label
                                            class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-purple-500">
                                            <input type="radio" name="delivery_method_id" value="{{ $delivery->id }}"
                                                class="text-purple-600 focus:ring-purple-500"
                                                data-cost="{{ $delivery->base_cost }}">
                                            <div class="ml-3">
                                                <span class="font-medium text-gray-800">{{ $delivery->method_name }}</span>
                                                <p class="text-sm text-gray-500">{{ $delivery->description }}</p>
                                                <p
                                                    class="text-sm {{ $delivery->base_cost == 0 ? 'text-green-600' : 'text-purple-600' }} font-medium">
                                                    Rp
                                                    {{ $delivery->base_cost == 0 ? 'Gratis' : number_format($delivery->base_cost, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                                    Khusus</label>
                                <textarea name="notes" id="catatan" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    placeholder="Tulisan di kue, permintaan khusus, dll."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Metode Pembayaran</h2>
                        <div class="space-y-3">
                            @foreach ($paymentMethods as $payment)
                                <label
                                    class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-purple-500">
                                    <input type="radio" name="payment_method_id" value="{{ $payment->id }}"
                                        class="text-purple-600 focus:ring-purple-500">
                                    <div class="ml-3">
                                        <span class="font-medium text-gray-800">{{ $payment->method_name }}</span>
                                        <p class="text-sm text-gray-500">{{ $payment->account_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $payment->account_details }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1" id="order-summary" data-subtotal="{{ $subtotal }}">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>

                        <div class="space-y-3 mb-6">
                            @foreach ($cartItems as $item)
                                <div class="flex justify-between items-center text-sm">
                                    <div>
                                        <span class="font-medium">{{ $item->product->name }}</span>
                                        <p class="text-gray-500 text-xs">{{ $item->size }} x{{ $item->quantity }}</p>
                                    </div>
                                    <span class="font-medium">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium" id="order-subtotal">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Biaya Pengiriman</span>
                                <span class="font-medium" id="delivery-cost">Gratis</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between">
                                <span class="font-bold text-gray-800">Total</span>
                                <span class="font-bold text-purple-600 text-xl" id="order-total">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-8 space-y-3">

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-purple-600 to-pink-500 text-white py-3 px-6 rounded-lg font-bold hover:from-purple-700 hover:to-pink-600 transition-all">
                                Lanjut ke Pembayaran
                            </button>
                            <a href="{{ route('cart') }}"
                                class="w-full border border-gray-300 text-gray-700 py-3 px-6 rounded-lg font-medium hover:bg-gray-50 transition-all text-center block">
                                ← Kembali ke Keranjang
                            </a>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="text-sm text-gray-600 space-y-2">
                                <p><i class="fas fa-shield-alt text-green-500 mr-2"></i>Data aman & terlindungi</p>
                                <p><i class="fas fa-clock text-orange-500 mr-2"></i>Proses 2-3 hari kerja</p>
                                <p><i class="fas fa-phone text-blue-500 mr-2"></i>Customer service 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @include('partials.customer.form-address')
    </section>
    <script src="{{ asset('js/order/createOrder.js') }}"></script>
@endsection
