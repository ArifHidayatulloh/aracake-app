@extends('layouts.guest', ['title' => 'Keranjang Belanja'])

@section('content')
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="/" class="hover:text-purple-600">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-purple-600">Keranjang Belanja</span>
        </div>
    </div>

    <section class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Belanja</h1>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="hidden md:grid grid-cols-12 bg-gray-50 p-4 border-b border-gray-200">
                        <div class="col-span-5 font-medium text-gray-600">Produk</div>
                        <div class="col-span-2 font-medium text-gray-600 text-center">Harga</div>
                        <div class="col-span-3 font-medium text-gray-600 text-center">Jumlah</div>
                        <div class="col-span-2 font-medium text-gray-600 text-right">Subtotal</div>
                    </div>

                    <div class="divide-y divide-gray-200" id="cart-items">
                        @forelse ($cartItems as $item)
                            <div class="p-4 cart-item transition-all duration-300" data-item-id="{{ $item->id }}">
                                <div class="flex flex-col md:flex-row md:items-center">
                                    <div class="flex items-center md:w-5/12 mb-4 md:mb-0">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-500 mr-4 remove-item-btn">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                            class="w-20 h-20 object-cover rounded-lg">
                                        <div class="ml-4">
                                            <h3 class="font-medium text-gray-800">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-500">Ukuran: {{ $item->size }}</p>
                                        </div>
                                    </div>
                                    <div class="md:w-2/12 mb-4 md:mb-0 text-center">
                                        <span class="font-medium text-gray-800 item-price"
                                            data-price="{{ $item->product->price }}">
                                            {{ 'Rp ' . number_format($item->product->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="md:w-3/12 mb-4 md:mb-0">
                                        <div class="flex justify-center items-center">
                                            <button
                                                class="w-8 h-8 border border-gray-300 rounded-l-md flex items-center justify-center hover:bg-gray-100"
                                                onclick="decreaseQty(this)">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input type="number" value="{{ $item->quantity }}" min="1"
                                                class="w-12 h-8 border-t border-b border-gray-300 text-center quantity-input"
                                                onchange="updateSubtotal(this)">
                                            <button
                                                class="w-8 h-8 border border-gray-300 rounded-r-md flex items-center justify-center hover:bg-gray-100"
                                                onclick="increaseQty(this)">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="md:w-2/12 text-right">
                                        <span class="font-medium text-gray-800 item-subtotal">
                                            {{ 'Rp ' . number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center" id="empty-cart-message">
                                <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Keranjang Kosong</h3>
                                <p class="text-gray-600 mb-4">Belum ada produk di keranjang belanja Anda</p>
                                <a href="{{ route('product') }}"
                                    class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                                    Mulai Belanja
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if (count($cartItems) > 0)
                <div class="lg:w-1/3 order-summary">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Belanja</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium" id="subtotal">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Item</span>
                                <span class="font-medium" id="total-items">{{ $totalItems }} item</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4 flex justify-between">
                                <span class="font-bold text-gray-800">Total</span>
                                <span class="font-bold text-purple-600 text-xl" id="total">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('customer.order.create') }}"
                                class="w-full bg-gradient-to-r from-purple-600 to-pink-500 text-white py-3 px-6 rounded-lg font-bold hover:from-purple-700 hover:to-pink-600 transition-all text-center block">
                                Pesan Sekarang
                            </a>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="text-sm text-gray-600">
                                <p class="mb-2"><i class="fas fa-shield-alt text-green-500 mr-2"></i>Pembayaran aman &
                                    terjamin</p>
                                <p class="mb-2"><i class="fas fa-truck text-blue-500 mr-2"></i>Pengiriman atau ambil di
                                    toko</p>
                                <p><i class="fas fa-clock text-orange-500 mr-2"></i>Minimal {{ $min_preparation_days }}
                                    hari persiapan</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <script>
        // Token CSRF untuk keamanan, pastikan ada di setiap permintaan POST/PUT/DELETE
        const csrfToken = '{{ csrf_token() }}';

        function formatRupiah(number) {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function parseRupiah(rupiahString) {
            // Menghapus 'Rp ' dan semua titik, lalu mengubahnya ke integer
            return parseInt(rupiahString.replace(/[^\d]/g, ''));
        }

        function updateSubtotal(input) {
            const cartItem = input.closest('.cart-item');
            const itemId = cartItem.dataset.itemId;
            const price = parseFloat(cartItem.querySelector('.item-price').dataset.price);
            let quantity = parseInt(input.value);

            // Validasi kuantitas
            if (quantity < 1 || isNaN(quantity)) {
                quantity = 1;
                input.value = 1;
                showAlert('Kuantitas tidak boleh kurang dari 1', 'error');
            }

            const subtotal = price * quantity;
            cartItem.querySelector('.item-subtotal').textContent = formatRupiah(subtotal);
            updateTotal();

            // Kirim permintaan AJAX untuk memperbarui item ini saja
            fetch(`/cart/${itemId}/update-quantity`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Kuantitas item berhasil diperbarui', 'success');
                    } else {
                        showAlert('Gagal memperbarui kuantitas', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan saat memperbarui item', 'error');
                });
        }

        function increaseQty(button) {
            const input = button.previousElementSibling;
            input.value = parseInt(input.value) + 1;
            updateSubtotal(input);
        }
        function decreaseQty(button) {
            const input = button.nextElementSibling;
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateSubtotal(input);
            }
        }
        function updateTotal() {
            let total = 0;
            let totalItems = 0;

            document.querySelectorAll('.cart-item').forEach(item => {
                const price = parseFloat(item.querySelector('.item-price').dataset.price);
                const quantity = parseInt(item.querySelector('.quantity-input').value);
                total += price * quantity;
                totalItems += quantity;
            });

            const subtotalElement = document.getElementById('subtotal');
            const totalElement = document.getElementById('total');
            const totalItemsElement = document.getElementById('total-items');

            if (subtotalElement) subtotalElement.textContent = formatRupiah(total);
            if (totalElement) totalElement.textContent = formatRupiah(total);
            if (totalItemsElement) totalItemsElement.textContent = `${totalItems} item`;
        }

        function checkEmptyCart() {
            const cartItems = document.querySelectorAll('.cart-item');
            if (cartItems.length === 0) {
                const cartItemsContainer = document.getElementById('cart-items');
                if (cartItemsContainer) {
                    cartItemsContainer.innerHTML = `
                        <div class="p-8 text-center" id="empty-cart-message">
                            <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Keranjang Kosong</h3>
                            <p class="text-gray-600 mb-4">Belum ada produk di keranjang belanja Anda</p>
                            <a href="{{ route('product') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                                Mulai Belanja
                            </a>
                        </div>
                    `;
                }

                // Hide the cart actions and summary
                const orderSummary = document.querySelector('.order-summary');
                if (orderSummary) orderSummary.style.display = 'none';
            }
        }

        function showAlert(message, type) {
            // ... (Fungsi showAlert tidak berubah)
            const alert = document.createElement('div');
            alert.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            alert.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                ${message}
            `;
            document.body.appendChild(alert);

            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });

        // CSS Animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeOut {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(-20px); }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
