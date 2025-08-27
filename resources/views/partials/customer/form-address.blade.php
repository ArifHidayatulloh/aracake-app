<!-- Modal Tambah Alamat -->
<div id="addressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Tambah Alamat Baru</h3>

            <form id="addressForm" method="POST" action="{{ route('store.address') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="address_line1" class="block text-sm font-medium text-gray-700">Alamat Jalan</label>
                        <input type="text" name="address_line1" id="address_line1" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div>
                        <label for="address_line2" class="block text-sm font-medium text-gray-700">Detail Alamat
                            (Opsional)</label>
                        <input type="text" name="address_line2" id="address_line2"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                            <input type="text" name="city" id="city" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>

                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <input type="text" name="province" id="province" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_default" id="is_default"
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                            value="{{ 'checked' ? 1 : 0 }}">
                        <label for="is_default" class="ml-2 block text-sm text-gray-700">
                            Jadikan alamat utama
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddressModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-purple-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Fungsi untuk modal alamat
    function openAddressModal() {
        document.getElementById('addressModal').classList.remove('hidden');
    }

    function closeAddressModal() {
        document.getElementById('addressModal').classList.add('hidden');
    }

    // Handle form submission dengan AJAX
    // Handle form submission dengan AJAX
    document.getElementById('addressForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true; // Nonaktifkan tombol

        const formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    // Re-enable the button if an error occurs
                    submitButton.disabled = false;
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Refresh halaman untuk menampilkan alamat baru
                    location.reload();
                } else {
                    alert('Gagal menyimpan alamat: ' + (data.message || 'Terjadi kesalahan'));
                    // Re-enable the button if the request was successful but the action failed
                    submitButton.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan alamat');
                // Re-enable the button on fetch error
                submitButton.disabled = false;
            });
    });
</script>

<style>
    /* Animasi untuk modal */
    .modal-enter {
        opacity: 0;
        transform: scale(0.95);
    }

    .modal-enter-active {
        opacity: 1;
        transform: scale(1);
        transition: opacity 200ms, transform 200ms;
    }

    .modal-exit {
        opacity: 1;
    }

    .modal-exit-active {
        opacity: 0;
        transform: scale(0.95);
        transition: opacity 200ms, transform 200ms;
    }
</style>
