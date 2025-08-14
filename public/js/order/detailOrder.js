function downloadInvoice() {
    const button = event.target;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengunduh...';
    button.disabled = true;

    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-download mr-2"></i>Download Invoice';
        button.disabled = false;

        const notification = document.createElement('div');
        notification.className =
            'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fas fa-check mr-2"></i>Invoice berhasil diunduh!';
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }, 2000);
}

function showCancelModal() {
    document.getElementById('cancel-modal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancel-modal').classList.add('hidden');
    document.getElementById('cancel-reason').value = '';
}

function confirmCancel() {
    const reason = document.getElementById('cancel-reason').value;
    if (!reason) {
        alert('Mohon pilih alasan pembatalan');
        return;
    }

    const button = event.target;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Membatalkan...';
    button.disabled = true;

    setTimeout(() => {
        closeCancelModal();

        const notification = document.createElement('div');
        notification.className =
            'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<i class="fas fa-check mr-2"></i>Pesanan berhasil dibatalkan';
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
            window.location.href = '';
        }, 3000);
    }, 2000);
}

function viewPaymentProof() {
    document.getElementById('payment-modal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('payment-modal').classList.add('hidden');
}
// Function to show the complete order modal
function showCompleteModal() {
    document.getElementById('complete-modal').classList.remove('hidden');
}

// Function to close the complete order modal
function closeCompleteModal() {
    document.getElementById('complete-modal').classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function (event) {
    if (event.target.id === 'cancel-modal') {
        closeCancelModal();
    }
    if (event.target.id === 'payment-modal') {
        closePaymentModal();
    }
    if (event.target.id == 'complete-modal') {
        closeCompleteModal();
    }
}
