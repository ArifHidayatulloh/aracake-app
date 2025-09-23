@extends('layouts.guest', ['title' => 'Keranjang Belanja'])

@section('content')
    <div class="container px-6 py-4 mx-auto">
        <div class="flex items-center text-sm text-gray-600">
            <a href="/" class="hover:text-purple-600">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-purple-600">Keranjang Belanja</span>
        </div>
    </div>

    <section class="container px-6 py-8 mx-auto">
        <h1 class="mb-8 text-3xl font-bold text-gray-800">Keranjang Belanja</h1>

        {{-- Menggunakan form untuk mengirim data item terpilih --}}
        <form id="cart-form" action="{{ route('customer.order.create') }}" method="POST">
            @csrf
            <div class="flex flex-col gap-8 lg:flex-row">
                <div class="lg:w-2/3">
                    <div class="overflow-hidden bg-white shadow-md rounded-xl">
                        <div class="items-center hidden grid-cols-12 p-4 border-b border-gray-200 md:grid bg-gray-50">
                            {{-- Checkbox "Pilih Semua" --}}
                            <div class="col-span-1">
                                <input type="checkbox" id="select-all"
                                    class="text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            </div>
                            <div class="col-span-4 font-medium text-gray-600">Produk</div>
                            <div class="col-span-2 font-medium text-center text-gray-600">Harga</div>
                            <div class="col-span-3 font-medium text-center text-gray-600">Jumlah</div>
                            <div class="col-span-2 font-medium text-right text-gray-600">Subtotal</div>
                        </div>

                        <div class="divide-y divide-gray-200" id="cart-items">
                            @forelse ($cartItems as $item)
                                <div class="p-4 transition-all duration-300 cart-item" data-item-id="{{ $item->id }}">
                                    <div class="flex flex-col md:flex-row md:items-center">
                                        <div class="flex items-center mb-4 md:w-5/12 md:mb-0">
                                            {{-- Checkbox per item --}}
                                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                                class="mr-4 text-purple-600 border-gray-300 rounded item-checkbox focus:ring-purple-500">

                                            {{-- ======================================================= --}}
                                            {{-- PERBAIKAN: Input hidden yang salah sudah dihapus dari sini --}}
                                            {{-- ======================================================= --}}

                                            <button type="button"
                                                class="mr-4 text-gray-400 remove-item-btn hover:text-red-500"
                                                data-url="{{ route('cart.remove', $item->id) }}">
                                                <i class="far fa-trash-alt"></i>
                                            </button>

                                            @if ($item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                                    class="object-cover w-20 h-20 rounded-lg">
                                            @else
                                                <div
                                                    class="flex items-center justify-center w-20 h-20 text-gray-300 bg-gray-100 rounded-lg">
                                                    <i class="fas fa-image text-gray-400 text-3xl"></i>
                                                </div>
                                            @endif

                                            <div class="ml-4">
                                                <h3 class="font-medium text-gray-800">{{ $item->product->name }}</h3>
                                            </div>
                                        </div>
                                        <div class="mb-4 text-center md:w-2/12 md:mb-0">
                                            <span class="font-medium text-gray-800 item-price"
                                                data-price="{{ $item->product->price }}">
                                                {{ 'Rp ' . number_format($item->product->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="mb-4 md:w-3/12 md:mb-0">
                                            <div class="flex items-center justify-center">
                                                <button type="button"
                                                    class="flex items-center justify-center w-8 h-8 border border-gray-300 rounded-l-md hover:bg-gray-100"
                                                    onclick="decreaseQty(this)">
                                                    <i class="text-xs fas fa-minus"></i>
                                                </button>
                                                <input type="number" value="{{ $item->quantity }}" min="1"
                                                    class="w-12 h-8 text-center border-t border-b border-gray-300 quantity-input"
                                                    onchange="updateSubtotal(this)">
                                                <button type="button"
                                                    class="flex items-center justify-center w-8 h-8 border border-gray-300 rounded-r-md hover:bg-gray-100"
                                                    onclick="increaseQty(this)">
                                                    <i class="text-xs fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-right md:w-2/12">
                                            <span class="font-medium text-gray-800 item-subtotal">
                                                {{ 'Rp ' . number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center" id="empty-cart-message">
                                    <i class="mb-4 text-6xl text-gray-300 fas fa-shopping-cart"></i>
                                    <h3 class="mb-2 text-xl font-bold text-gray-800">Keranjang Kosong</h3>
                                    <p class="mb-4 text-gray-600">Belum ada produk di keranjang belanja Anda</p>
                                    <a href="{{ route('product') }}"
                                        class="px-6 py-2 text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                                        Mulai Belanja
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if (count($cartItems) > 0)
                    <div class="lg:w-1/3 order-summary">
                        <div class="sticky p-6 bg-white shadow-md rounded-xl top-4">
                            <h2 class="mb-6 text-xl font-bold text-gray-800">Ringkasan Belanja</h2>

                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium" id="subtotal">Rp 0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total Item</span>
                                    <span class="font-medium" id="total-items">0 item</span>
                                </div>
                                <div class="flex justify-between pt-4 border-t border-gray-200">
                                    <span class="font-bold text-gray-800">Total</span>
                                    <span class="text-xl font-bold text-purple-600" id="total">Rp 0</span>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit" id="checkout-btn"
                                    class="block w-full px-6 py-3 font-bold text-center text-white transition-all rounded-lg bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                    Pesan Sekarang
                                </button>
                            </div>

                            <div class="pt-6 mt-6 border-t border-gray-200">
                                <div class="text-sm text-gray-600">
                                    <p class="mb-2"><i class="mr-2 text-green-500 fas fa-shield-alt"></i>Pembayaran aman &
                                        terjamin</p>
                                    <p class="mb-2"><i class="mr-2 text-blue-500 fas fa-truck"></i>Pengiriman atau ambil
                                        di toko</p>
                                    <p><i class="mr-2 text-orange-500 fas fa-clock"></i>Minimal {{ $min_preparation_days }}
                                        hari persiapan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = '{{ csrf_token() }}';

            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            window.updateSubtotal = function(input) {
                const cartItem = input.closest('.cart-item');
                const itemId = cartItem.dataset.itemId;
                const price = parseFloat(cartItem.querySelector('.item-price').dataset.price);
                let quantity = parseInt(input.value);

                if (quantity < 1 || isNaN(quantity)) {
                    quantity = 1;
                    input.value = 1;
                    showAlert('Kuantitas tidak boleh kurang dari 1', 'error');
                }

                const subtotal = price * quantity;
                cartItem.querySelector('.item-subtotal').textContent = formatRupiah(subtotal);
                updateTotal();

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
                }).then(response => response.json()).then(data => {
                    if (!data.success) {
                        showAlert('Gagal memperbarui kuantitas', 'error');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan saat memperbarui item', 'error');
                });
            }

            window.increaseQty = function(button) {
                const input = button.previousElementSibling;
                input.value = parseInt(input.value) + 1;
                updateSubtotal(input);
            }

            window.decreaseQty = function(button) {
                const input = button.nextElementSibling;
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    updateSubtotal(input);
                }
            }

            function updateTotal() {
                let total = 0;
                let totalItems = 0;
                let itemsSelected = false;

                document.querySelectorAll('.cart-item').forEach(item => {
                    const checkbox = item.querySelector('.item-checkbox');
                    if (checkbox && checkbox.checked) {
                        itemsSelected = true;
                        const price = parseFloat(item.querySelector('.item-price').dataset.price);
                        const quantity = parseInt(item.querySelector('.quantity-input').value);
                        total += price * quantity;
                        totalItems += quantity;
                    }
                });

                const subtotalElement = document.getElementById('subtotal');
                const totalElement = document.getElementById('total');
                const totalItemsElement = document.getElementById('total-items');
                const checkoutBtn = document.getElementById('checkout-btn');

                if (subtotalElement) subtotalElement.textContent = formatRupiah(total);
                if (totalElement) totalElement.textContent = formatRupiah(total);
                if (totalItemsElement) totalItemsElement.textContent = `${totalItems} item`;

                if (checkoutBtn) {
                    checkoutBtn.disabled = !itemsSelected;
                }
            }

            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    updateTotal();
                    const allCheckboxes = document.querySelectorAll('.item-checkbox');
                    const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
                    const selectAllCheckbox = document.getElementById('select-all');
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = allCheckboxes.length > 0 && allCheckboxes
                            .length === checkedCheckboxes.length;
                    }
                });
            });

            document.getElementById('select-all')?.addEventListener('change', function() {
                document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateTotal();
            });

            document.getElementById('cart-form')?.addEventListener('submit', function(e) {
                const selectedItems = document.querySelectorAll('.item-checkbox:checked');
                if (selectedItems.length === 0) {
                    e.preventDefault();
                    showAlert('Pilih minimal satu produk untuk di-checkout.', 'error');
                }
            });

            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const removeUrl = this.dataset.url;
                    const cartItemElement = this.closest('.cart-item');

                    if (confirm('Anda yakin ingin menghapus item ini dari keranjang?')) {
                        fetch(removeUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    cartItemElement.style.transition =
                                        'opacity 0.5s, transform 0.5s';
                                    cartItemElement.style.opacity = '0';
                                    cartItemElement.style.transform = 'translateX(-20px)';

                                    setTimeout(() => {
                                        cartItemElement.remove();
                                        updateTotal();
                                        showAlert('Item berhasil dihapus', 'success');
                                        if (document.querySelectorAll('.cart-item')
                                            .length === 0) {
                                            location.reload();
                                        }
                                    }, 500);

                                } else {
                                    showAlert(data.message || 'Gagal menghapus item', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showAlert('Terjadi kesalahan saat menghapus item.', 'error');
                            });
                    }
                });
            });

            updateTotal();
        });

        function showAlert(message, type) {
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
    </script>
@endsection
