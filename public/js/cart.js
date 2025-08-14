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
    alert.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
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

document.addEventListener('DOMContentLoaded', function () {
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
