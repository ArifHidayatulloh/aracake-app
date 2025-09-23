/**
 * Menampilkan modal konfirmasi pembatalan pesanan.
 */
function showCancelModal() {
    const modal = document.getElementById('cancel-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

/**
 * Menutup modal konfirmasi pembatalan pesanan.
 */
function closeCancelModal() {
    const modal = document.getElementById('cancel-modal');
    const reasonSelect = document.getElementById('cancel-reason');
    if (modal) {
        modal.classList.add('hidden');
    }
    if (reasonSelect) {
        reasonSelect.value = ''; // Reset pilihan alasan
    }
}

/**
 * Mengirim request untuk membatalkan pesanan setelah konfirmasi.
 * @param {Event} event - Event dari tombol yang diklik.
 */
function confirmCancel(event) {
    const reason = document.getElementById('cancel-reason').value;
    if (!reason) {
        alert('Mohon pilih alasan pembatalan.');
        return;
    }

    // [PERBAIKAN] Ambil URL dari data-attribute pada tombol utama
    const mainCancelButton = document.getElementById('cancel-order-button');
    const url = mainCancelButton.getAttribute('data-url');

    // Tombol "Ya, Batalkan" yang ada di dalam modal
    const confirmBtn = event.target;
    confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Membatalkan...';
    confirmBtn.disabled = true;

    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // [PERBAIKAN] Teruskan elemen tombol ke fungsi success
            showCancelSuccess(confirmBtn);
        } else {
            alert(data.message || 'Gagal membatalkan pesanan. Silakan coba lagi.');
            confirmBtn.innerHTML = 'Ya, Batalkan';
            confirmBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
        confirmBtn.innerHTML = 'Ya, Batalkan';
        confirmBtn.disabled = false;
    });
}

/**
 * Menampilkan notifikasi sukses dan me-reload halaman.
 * @param {HTMLElement} button - Tombol yang statusnya akan diubah.
 */
function showCancelSuccess(button) {
    button.innerHTML = '<i class="fas fa-check mr-2"></i>Berhasil Dibatalkan';

    setTimeout(() => {
        closeCancelModal();

        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fas fa-check mr-2"></i>Pesanan berhasil dibatalkan';
        document.body.appendChild(notification);

        // Hapus notifikasi dan reload halaman setelah beberapa detik
        setTimeout(() => {
            notification.remove();
            window.location.reload(); // Reload halaman untuk melihat status terbaru
        }, 3000);
    }, 2000);
}

/**
 * Menampilkan modal bukti pembayaran.
 */
function viewPaymentProof() {
    const modal = document.getElementById('payment-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

/**
 * Menutup modal bukti pembayaran.
 */
function closePaymentModal() {
    const modal = document.getElementById('payment-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

/**
 * Menutup modal jika pengguna mengklik di luar area konten modal.
 */
window.onclick = function (event) {
    if (event.target.id === 'cancel-modal') {
        closeCancelModal();
    }
    if (event.target.id === 'payment-modal') {
        closePaymentModal();
    }
    // [PERBAIKAN] Logika untuk 'complete-modal' dihapus karena tidak ada di HTML
}

/**
 * (Opsional) Fungsi untuk download invoice jika digunakan.
 * @param {Event} event
 */
function downloadInvoice(event) {
    const button = event.target;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengunduh...';
    button.disabled = true;

    // Simulasi proses download
    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-download mr-2"></i>Download Invoice';
        button.disabled = false;

        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fas fa-check mr-2"></i>Invoice berhasil diunduh!';
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }, 2000);
}