// Show notification modal after 3 seconds
setTimeout(() => {
    document.getElementById('notification-modal').classList.remove('hidden');
}, 3000);

function closeModal() {
    document.getElementById('notification-modal').classList.add('hidden');
}

function enableNotifications() {
    // Simulate enabling notifications
    const modal = document.getElementById('notification-modal');
    modal.innerHTML = `
                <div class="bg-white rounded-xl p-8 max-w-md mx-4 text-center">
                    <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Notifikasi Aktif!</h3>
                    <p class="text-gray-600 mb-6">Anda akan menerima update status pesanan via WhatsApp</p>
                    <button onclick="closeModal()" class="bg-green-500 text-white py-2 px-6 rounded-lg hover:bg-green-600">
                        Tutup
                    </button>
                </div>
            `;

    setTimeout(() => {
        closeModal();
    }, 2000);
}

// Auto-refresh page status (simulate real-time updates)
let refreshCount = 0;
const maxRefresh = 3;

function simulateStatusUpdate() {
    refreshCount++;

    if (refreshCount <= maxRefresh) {
        // Show a subtle notification that we're checking for updates
        const statusNotif = document.createElement('div');
        statusNotif.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        statusNotif.innerHTML = '<i class="fas fa-sync fa-spin mr-2"></i>Mengecek status pembayaran...';
        document.body.appendChild(statusNotif);

        setTimeout(() => {
            statusNotif.remove();
        }, 2000);
    }
}

// Check for updates every 30 seconds (in real app, this would be WebSocket or Server-Sent Events)
setInterval(simulateStatusUpdate, 30000);

// Add some interactive animations
document.querySelectorAll('.animate-bounce').forEach(el => {
    setInterval(() => {
        el.classList.remove('animate-bounce');
        setTimeout(() => {
            el.classList.add('animate-bounce');
        }, 100);
    }, 3000);
});
