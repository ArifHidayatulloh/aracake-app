document.addEventListener('DOMContentLoaded', function () {
    // Helper function untuk format angka ke Rupiah
    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    // Ambil subtotal dari data attribute
    const orderSummary = document.getElementById('order-summary');
    const subtotal = parseInt(orderSummary.dataset.subtotal) || 0;
    let deliveryCost = 0;

    // Update biaya pengiriman berdasarkan pilihan metode pengiriman
    document.querySelectorAll('input[name="delivery_method_id"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const deliveryCostEl = document.getElementById('delivery-cost');
            const orderTotalEl = document.getElementById('order-total');

            // Ambil biaya pengiriman dari data atribut
            const cost = parseInt(this.dataset.cost) || 0;
            deliveryCost = cost;

            // Update tampilan biaya pengiriman dan total
            deliveryCostEl.textContent = cost === 0 ? 'Gratis' : formatRupiah(cost);
            const total = subtotal + deliveryCost;
            orderTotalEl.textContent = formatRupiah(total);
        });
    });

    // Inisialisasi nilai awal
    const initialDeliveryMethod = document.querySelector('input[name="delivery_method_id"]:checked');
    if (initialDeliveryMethod) {
        // Picu event 'change' untuk menghitung total awal
        initialDeliveryMethod.dispatchEvent(new Event('change'));
    } else {
        // Jika tidak ada metode pengiriman yang dipilih, hitung total hanya dari subtotal
        document.getElementById('order-total').textContent = formatRupiah(subtotal);
    }
});