// File upload handling
const fileInput = document.getElementById('payment_proof');
const fileDropZone = document.getElementById('file-drop-zone');
const filePlaceholder = document.getElementById('file-placeholder');
const filePreview = document.getElementById('file-preview');
const fileName = document.getElementById('file-name');

// Click to upload
fileDropZone.addEventListener('click', () => fileInput.click());

// File input change
fileInput.addEventListener('change', handleFileSelect);

// Drag and drop
fileDropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileDropZone.classList.add('border-purple-500');
});

fileDropZone.addEventListener('dragleave', () => {
    fileDropZone.classList.remove('border-purple-500');
});

fileDropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    fileDropZone.classList.remove('border-purple-500');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFileSelect();
    }
});

function handleFileSelect() {
    const file = fileInput.files[0];
    if (file) {
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File terlalu besar. Maksimal 5MB.');
            fileInput.value = '';
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.');
            fileInput.value = '';
            return;
        }

        fileName.textContent = file.name;
        filePlaceholder.classList.add('hidden');
        filePreview.classList.remove('hidden');
    }
}

function removeFile() {
    fileInput.value = '';
    filePlaceholder.classList.remove('hidden');
    filePreview.classList.add('hidden');
}

// Form submission
document.getElementById('payment-form').addEventListener('submit', function (e) {
    const submitBtn = document.getElementById('submit-btn');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

    // Simulate processing time
    setTimeout(() => {
        // This would normally be handled by the server
        // For demo purposes, we'll redirect to confirmation page
        window.location.href = '';
    }, 2000);
});

// Countdown timer
let timeLeft = 24 * 60 * 60; // 24 hours in seconds

function updateTimer() {
    const hours = Math.floor(timeLeft / 3600);
    const minutes = Math.floor((timeLeft % 3600) / 60);
    const seconds = timeLeft % 60;

    document.getElementById('countdown-timer').textContent =
        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    if (timeLeft > 0) {
        timeLeft--;
    } else {
        document.getElementById('countdown-timer').textContent = 'WAKTU HABIS';
        document.getElementById('countdown-timer').classList.add('text-red-600');
    }
}

// Update timer every second
setInterval(updateTimer, 1000);
updateTimer(); // Initial call
