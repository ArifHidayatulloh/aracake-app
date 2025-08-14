function confirmPickup(orderId) {
    if (confirm('Apakah Anda yakin pesanan ini sudah diambil?')) {
        // Simulate API call
        const button = event.target;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        button.disabled = true;

        setTimeout(() => {
            // Remove the order card with animation
            const orderCard = button.closest('.bg-white');
            orderCard.style.animation = 'fadeOut 0.5s ease-out';

            setTimeout(() => {
                orderCard.remove();

                // Show success notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                notification.innerHTML = '<i class="fas fa-check mr-2"></i>Pesanan berhasil dikonfirmasi diambil!';
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);

                // Update order count
                const orderCount = document.getElementById('order-count');
                const currentCount = parseInt(orderCount.textContent.match(/\d+/)[0]);
                orderCount.textContent = `Menampilkan ${currentCount - 1} pesanan`;

                // Show empty state if no orders left
                if (currentCount - 1 === 0) {
                    document.getElementById('empty-state').classList.remove('hidden');
                }
            }, 500);
        }, 1000);
    }
}

// Auto-refresh functionality (simulate real-time updates)
setInterval(() => {
    // In real app, this would check for status updates via API
    const statusElements = document.querySelectorAll('.fa-spin');
    statusElements.forEach(el => {
        // Add subtle animation to show it's checking
        el.style.opacity = '0.5';
        setTimeout(() => {
            el.style.opacity = '1';
        }, 200);
    });
}, 30000); // Check every 30 seconds

// Search functionality
const searchInput = document.querySelector('input[placeholder="Cari pesanan..."]');
searchInput.addEventListener('input', function () {
    const query = this.value.toLowerCase();
    const orders = document.querySelectorAll('.bg-white.rounded-xl.shadow-md');

    orders.forEach(order => {
        const orderText = order.textContent.toLowerCase();
        if (orderText.includes(query)) {
            order.style.display = 'block';
        } else {
            order.style.display = 'none';
        }
    });
});

// Filter functionality
const filterSelect = document.querySelector('select');
filterSelect.addEventListener('change', function () {
    const filter = this.value;
    const orders = document.querySelectorAll('.bg-white.rounded-xl.shadow-md');

    orders.forEach(order => {
        if (filter === '') {
            order.style.display = 'block';
        } else {
            const statusElement = order.querySelector('.bg-orange-100, .bg-blue-100, .bg-green-100');
            const statusText = statusElement ? statusElement.textContent.toLowerCase() : '';

            let show = false;
            switch (filter) {
                case 'pending_confirmation':
                    show = statusText.includes('menunggu konfirmasi');
                    break;
                case 'processing':
                    show = statusText.includes('sedang diproses');
                    break;
                case 'ready':
                    show = statusText.includes('siap diambil');
                    break;
            }

            order.style.display = show ? 'block' : 'none';
        }
    });
});
