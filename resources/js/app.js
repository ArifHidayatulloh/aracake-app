import './bootstrap';

import EasyMDE from 'easymde';
import 'easymde/dist/easymde.min.css'; // Impor CSS EasyMDE

// Pastikan DOM sudah siap sebelum menginisialisasi EasyMDE
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi EasyMDE untuk setiap textarea dengan kelas 'easymde-editor'
    document.querySelectorAll('textarea.easymde-editor').forEach(textarea => {
        new EasyMDE({
            element: textarea,
            // Tambahkan opsi kustom di sini jika diperlukan
            // misal: status: false, // Menyembunyikan status bar
            // toolbar: ["bold", "italic", "heading", "|", "undo", "redo"]
        });
    });
});
