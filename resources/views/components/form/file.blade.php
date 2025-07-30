@props([
    'name',
    'label',
    'error' => null,
    'currentImage' => null, // Untuk menampilkan gambar yang sudah ada
    'required' => false,
    'class' => '',
])

<div class="{{ $class }}" x-data="{
    imageUrl: '{{ $currentImage }}', // Inisialisasi dengan gambar yang sudah ada

    // Fungsi untuk menampilkan preview gambar
    previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imageUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            this.imageUrl = null; // Hapus preview jika tidak ada file
        }
    }
}">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <input type="file" name="{{ $name }}" id="{{ $name }}"
        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100"
        accept="image/*"
        @change="previewImage($event)">

    {{-- @if ($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @enderror --}}

    {{-- Area untuk menampilkan preview gambar --}}
    <div x-show="imageUrl" class="mt-3">
        <span class="block text-sm font-medium text-gray-700 mb-1">Preview Gambar:</span>
        <img :src="imageUrl" alt="Preview Gambar"
            class="mt-1 w-32 h-32 object-cover rounded-lg border border-gray-200 shadow-sm">
    </div>
</div>
