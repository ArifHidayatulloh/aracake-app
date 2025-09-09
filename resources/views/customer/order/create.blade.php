@extends('layouts.guest', ['title' => 'Form Pemesanan'])

@section('content')
    <div class="container px-6 py-4 mx-auto">
        <div class="flex items-center text-sm text-gray-600">
            <a href="/" class="hover:text-purple-600">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('cart') }}" class="hover:text-purple-600">Keranjang</a>
            <span class="mx-2">/</span>
            <span class="text-purple-600">Form Pemesanan</span>
        </div>
    </div>

    <section class="container px-6 py-8 mx-auto">
        <h1 class="mb-8 text-3xl font-bold text-gray-800">Form Pemesanan</h1>

        <form action="{{ route('customer.order.store') }}" method="POST">
            @csrf
            @foreach ($cartItems as $item)
                <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
            @endforeach
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="p-6 mb-6 bg-white shadow-md rounded-xl">
                        <h2 class="mb-6 text-xl font-bold text-gray-800">Informasi Pelanggan</h2>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="nama" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap
                                    *</label>
                                <input type="text" name="nama" id="nama" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    value="{{ Auth::user()->full_name }}" disabled>
                            </div>
                            <div>
                                <label for="phone" class="block mb-1 text-sm font-medium text-gray-700">No. Telepon
                                    *</label>
                                <input type="tel" name="phone" id="phone" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    value="{{ Auth::user()->phone_number }}" disabled>
                            </div>
                            <div class="md:col-span-2">
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Alamat Pengiriman *</label>

                                @forelse ($userAddresses as $address)
                                    <div class="alamat-container">
                                        <label
                                            class="flex p-3 mb-2 border border-gray-200 rounded-lg cursor-pointer hover:border-purple-500">
                                            <input type="radio" name="pickup_delivery_address_id"
                                                value="{{ $address->id }}" required
                                                class="mt-1 text-purple-600 focus:ring-purple-500"
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
                                            <a href="#" data-address-id="{{ $address->id }}"
                                                class="ml-auto text-sm font-medium text-red-600 delete-address-btn hover:text-red-500">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </label>
                                    </div>
                                @empty
                                    <div class="mb-2 text-sm text-gray-500">Anda belum memiliki alamat</div>
                                @endforelse

                                <button type="button" onclick="openAddressModal()"
                                    class="mt-2 text-sm font-medium text-purple-600 hover:text-purple-500">
                                    + Tambah Alamat Baru
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="p-6 mb-6 bg-white shadow-md rounded-xl">
                        <h2 class="mb-6 text-xl font-bold text-gray-800">Detail Pesanan</h2>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="tanggal_ambil" class="block mb-1 text-sm font-medium text-gray-700">Tanggal
                                    Ambil/Kirim *</label>
                                <input type="date" name="pickup_delivery_date" id="tanggal_ambil" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    min="{{ now()->addDays($min_preparation_days)->format('Y-m-d') }}">
                                <p class="mt-1 text-xs text-gray-500">Minimal {{ $min_preparation_days }} hari dari
                                    sekarang</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block mb-3 text-sm font-medium text-gray-700">Metode Pengiriman *</label>
                                <div class="space-y-3">
                                    @foreach ($deliveryMethods as $delivery)
                                        <label
                                            class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-purple-500">
                                            <input type="radio" name="delivery_method_id" value="{{ $delivery->id }}"
                                                class="text-purple-600 focus:ring-purple-500"
                                                data-cost="{{ $delivery->base_cost }}"
                                                data-is_pickup="{{ $delivery->is_pickup ? '1' : '0' }}">
                                            <div class="ml-3">
                                                <span class="font-medium text-gray-800">{{ $delivery->method_name }}</span>
                                                <p class="text-sm text-gray-500">{{ $delivery->description }}</p>
                                                <p
                                                    class="text-sm {{ $delivery->is_pickup == true ? 'text-green-600' : 'text-purple-600' }} font-medium">

                                                    {{ $delivery->is_pickup == 1 ? 'Gratis' : 'Sesuai aplikasi (Ditanggung customer)' }}
                                                </p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label for="catatan" class="block mb-1 text-sm font-medium text-gray-700">Catatan
                                    Khusus</label>
                                <textarea name="notes" id="catatan" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                    placeholder="Tulisan di kue, permintaan khusus, dll."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-white shadow-md rounded-xl">
                        <h2 class="mb-6 text-xl font-bold text-gray-800">Metode Pembayaran</h2>
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
                    <div class="sticky p-6 bg-white shadow-md rounded-xl top-4">
                        <h2 class="mb-6 text-xl font-bold text-gray-800">Ringkasan Pesanan</h2>

                        <div class="mb-6 space-y-3">
                            @foreach ($cartItems as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <div>
                                        <span class="font-medium">{{ $item->product->name }}</span>
                                        <p class="text-xs text-gray-500">{{ $item->size }} x{{ $item->quantity }}</p>
                                    </div>
                                    <span class="font-medium">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4 space-y-3 border-t border-gray-200">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium" id="order-subtotal">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Biaya Pengiriman</span>
                                <span class="font-medium" id="delivery-cost">Gratis</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-gray-200">
                                <span class="font-bold text-gray-800">Total</span>
                                <span class="text-xl font-bold text-purple-600" id="order-total">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-8 space-y-3">

                            <button type="submit"
                                class="w-full px-6 py-3 font-bold text-white transition-all rounded-lg bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600">
                                Lanjut ke Pembayaran
                            </button>
                            <a href="{{ route('cart') }}"
                                class="block w-full px-6 py-3 font-medium text-center text-gray-700 transition-all border border-gray-300 rounded-lg hover:bg-gray-50">
                                ← Kembali ke Keranjang
                            </a>
                        </div>
                        <div class="pt-6 mt-6 border-t border-gray-200">
                            <div class="space-y-2 text-sm text-gray-600">
                                <p><i class="mr-2 text-green-500 fas fa-shield-alt"></i>Data aman & terlindungi</p>
                                <p><i class="mr-2 text-orange-500 fas fa-clock"></i>Proses 2-3 hari kerja</p>
                                <p><i class="mr-2 text-blue-500 fas fa-phone"></i>Customer service 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @include('partials.customer.form-address')
    </section>
    <script src="{{ asset('js/order/createOrder.js') }}"></script>
    <script>
        document.querySelectorAll('.delete-address-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                if (confirm('Apakah Anda yakin ingin menghapus alamat ini?')) {
                    const addressId = this.dataset.addressId;
                    const url = `/address/${addressId}`; // Pastikan URL sesuai dengan route Anda

                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                // Hapus elemen alamat dari DOM
                                this.closest('.alamat-container').remove();
                            } else {
                                alert('Gagal menghapus alamat: ' + (data.message ||
                                    'Terjadi kesalahan.'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menghapus alamat.');
                        });
                }
            });
        });
    </script>
@endsection
