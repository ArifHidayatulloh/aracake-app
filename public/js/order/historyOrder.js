let currentRating = 0;
let currentOrderId = '';

// Filter functionality
function applyFilters() {
    const statusFilter = document.getElementById('status-filter').value;
    const periodFilter = document.getElementById('period-filter').value;
    const sortFilter = document.getElementById('sort-filter').value;
    const searchTerm = document.getElementById('search-input').value.toLowerCase();

    const orders = Array.from(document.querySelectorAll('#order-list > div'));
    let visibleOrders = orders.filter(order => {
        // Status filter
        if (statusFilter && !order.dataset.status.includes(statusFilter)) {
            return false;
        }

        // Period filter
        if (periodFilter) {
            const orderDate = new Date(order.dataset.date);
            const cutoffDate = new Date();
            cutoffDate.setDate(cutoffDate.getDate() - parseInt(periodFilter));
            if (orderDate < cutoffDate) {
                return false;
            }
        }

        // Search filter
        if (searchTerm && !order.textContent.toLowerCase().includes(searchTerm)) {
            return false;
        }

        return true;
    });

    // Sort orders
    if (sortFilter === 'newest') {
        visibleOrders.sort((a, b) => new Date(b.dataset.date) - new Date(a.dataset.date));
    } else if (sortFilter === 'oldest') {
        visibleOrders.sort((a, b) => new Date(a.dataset.date) - new Date(b.dataset.date));
    } else if (sortFilter === 'highest') {
        visibleOrders.sort((a, b) => parseInt(b.dataset.total) - parseInt(a.dataset.total));
    } else if (sortFilter === 'lowest') {
        visibleOrders.sort((a, b) => parseInt(a.dataset.total) - parseInt(b.dataset.total));
    }

    // Hide all orders
    orders.forEach(order => order.style.display = 'none');

    // Show filtered and sorted orders
    const container = document.getElementById('order-list');
    visibleOrders.forEach(order => {
        order.style.display = 'block';
        container.appendChild(order);
    });

    // Update results count
    document.getElementById('results-count').textContent = `Menampilkan ${visibleOrders.length} pesanan`;
}

// Event listeners for filters
document.getElementById('status-filter').addEventListener('change', applyFilters);
document.getElementById('period-filter').addEventListener('change', applyFilters);
document.getElementById('sort-filter').addEventListener('change', applyFilters);
document.getElementById('search-input').addEventListener('input', applyFilters);

function reorder(orderId) {
    if (confirm('Apakah Anda ingin memesan ulang pesanan ini?')) {
        // Simulate adding items to cart
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fas fa-check mr-2"></i>Item berhasil ditambahkan ke keranjang!';
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

function showReviewModal(orderId) {
    currentOrderId = orderId;
    document.getElementById('review-modal').classList.remove('hidden');
}

function closeReviewModal() {
    document.getElementById('review-modal').classList.add('hidden');
    currentRating = 0;
    document.getElementById('review-comment').value = '';
    updateStarDisplay();
}

function updateStarDisplay() {
    const stars = document.querySelectorAll('#star-rating i');
    stars.forEach((star, index) => {
        if (index < currentRating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

// Star rating functionality
document.querySelectorAll('#star-rating i').forEach(star => {
    star.addEventListener('click', function () {
        currentRating = parseInt(this.dataset.rating);
        updateStarDisplay();
    });

    star.addEventListener('mouseenter', function () {
        const hoverRating = parseInt(this.dataset.rating);
        document.querySelectorAll('#star-rating i').forEach((s, index) => {
            if (index < hoverRating) {
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-300');
            }
        });
    });

    star.addEventListener('mouseleave', function () {
        updateStarDisplay();
    });
});

function submitReview() {
    if (currentRating === 0) {
        alert('Mohon berikan rating terlebih dahulu');
        return;
    }

    const comment = document.getElementById('review-comment').value.trim();
    if (!comment) {
        alert('Mohon berikan komentar');
        return;
    }

    // Simulate API call
    const submitBtn = event.target;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
    submitBtn.disabled = true;

    setTimeout(() => {
        closeReviewModal();

        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fas fa-check mr-2"></i>Review berhasil dikirim! Terima kasih atas feedback Anda.';
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 4000);
    }, 1500);
}

function exportToExcel() {
    // Simulate export functionality
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.innerHTML = '<i class="fas fa-download mr-2"></i>Mengunduh riwayat pesanan...';
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.innerHTML = '<i class="fas fa-check mr-2"></i>File berhasil diunduh!';
        notification.classList.remove('bg-blue-500');
        notification.classList.add('bg-green-500');

        setTimeout(() => {
            notification.remove();
        }, 2000);
    }, 2000);
}

// Initialize filters on page load
document.addEventListener('DOMContentLoaded', function () {
    applyFilters();
});
