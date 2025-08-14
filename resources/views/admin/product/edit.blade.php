@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Produk', 'url' => route('admin.product.index')],
            ['label' => 'Edit Produk'],
        ]" />

        <x-header-page.header-page title="Edit Produk" description="Ubah informasi produk di toko Anda." />

        <x-form.card>
            <form action="{{ route('admin.product.update', $product->slug) }}" method="POST" enctype="multipart/form-data"
                x-data="{
                    images: @js(old('images', $product->images->toArray())),
                    thumbnailIndex: null,

                    // Preview image
                    previewImage(event, index) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                // Ensure a valid object exists at this index
                                if (!this.images[index]) {
                                    this.images[index] = {};
                                }

                                this.images[index].file = file;
                                this.images[index].preview = e.target.result;
                                this.images[index].is_new = true; // Mark as new file
                                this.images[index].id = null;     // Clear old ID for new file
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    // Add new image field
                    addImageField() {
                        this.images.push({
                            file: null,
                            alt_text: '',
                            is_thumbnail: false,
                            preview: null,
                            is_new: true,
                            id: null,
                        });
                        // If this is the first image, set it as thumbnail
                        if (this.images.length === 1) {
                            this.setAsThumbnail(0);
                        }
                    },

                    // Remove image field
                    removeImageField(index) {
                        this.images.splice(index, 1);
                        // If the removed image was the thumbnail, set the first one as thumbnail
                        if (this.thumbnailIndex === index) {
                            this.setAsThumbnail(0);
                        } else if (this.thumbnailIndex > index) {
                            // If thumbnail was after the removed image, decrement its index
                            this.thumbnailIndex--;
                        }
                        this.updateThumbnailFlags();
                    },

                    // Set thumbnail
                    setAsThumbnail(indexToSet) {
                        this.thumbnailIndex = indexToSet;
                        this.updateThumbnailFlags();
                    },

                    // Update thumbnail flags
                    updateThumbnailFlags() {
                        this.images.forEach((image, index) => {
                            image.is_thumbnail = (index === this.thumbnailIndex);
                        });
                    },

                    // Initialize
                    init() {
                        // Find the existing thumbnail index
                        const existingThumbnailIndex = this.images.findIndex(image => image.is_thumbnail);
                        this.thumbnailIndex = existingThumbnailIndex !== -1 ? existingThumbnailIndex : 0;

                        // If no images exist, add one and set it as thumbnail
                        if (this.images.length === 0) {
                            this.addImageField();
                        } else {
                            // Ensure thumbnail is set correctly on init
                            this.updateThumbnailFlags();
                        }
                    }
                }" x-init="init()">
                @csrf
                @method('PUT')

                {{-- Product Information --}}
                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Informasi Produk</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form.input name="name" label="Nama Produk" :value="old('name', $product->name)" :required="true"
                            :error="$errors->first('name')" />

                        <x-form.select2 label="Kategori" name="category_id" id="category_id" :options="$categories"
                            :selected="old('category_id', $product->category_id)" placeholder="Pilih Kategori Produk"
                            :error="$errors->first('category_id')" :required="true" />
                    </div>

                    <x-form.input name="sku" label="SKU" :value="old('sku', $product->sku)" :required="true"
                        :error="$errors->first('sku')" />

                    <div class="mt-5">
                        <x-form.markdown-editor name="description" label="Deskripsi" :error="$errors->first('description')"
                            rows="8" :value="old('description', $product->description)" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <x-form.input name="price" label="Harga" type="number" :value="old('price', $product->price)"
                            :required="true" :error="$errors->first('price')" />
                        <x-form.input name="preparation_time_days" label="Waktu Pengerjaan (hari)" type="number"
                            :value="old('preparation_time_days', $product->preparation_time_days)" :required="true"
                            :error="$errors->first('preparation_time_days')" />
                    </div>

                    {{-- Product Options --}}
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" name="is_available" id="is_available" value="1"
                                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                            <label for="is_available" class="ml-2 block text-sm text-gray-900">Produk Tersedia</label>
                        </div>
                        <div class="flex items-center">
                            <input type="hidden" name="is_recommended" value="0">
                            <input type="checkbox" name="is_recommended" id="is_recommended" value="1"
                                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                {{ old('is_recommended', $product->is_recommended) ? 'checked' : '' }}>
                            <label for="is_recommended" class="ml-2 block text-sm text-gray-900">Produk Rekomendasi</label>
                        </div>
                        <div class="flex items-center">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">Produk Unggulan</label>
                        </div>
                    </div>
                </div>

                {{-- Product Images --}}
                <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Gambar Produk</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Unggah setidaknya satu gambar. Tandai salah satu sebagai gambar thumbnail utama.
                    </p>

                    <template x-for="(image, index) in images" :key="image.id || 'new_' + index">
                        <div class="relative mb-6 p-4 border border-gray-200 rounded-lg bg-white shadow-sm">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-medium text-gray-800">Gambar #<span x-text="index + 1"></span></h4>
                                <button type="button" x-show="images.length > 1" @click="removeImageField(index)"
                                    class="p-2 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label :for="'images[' + index + '][file]'"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        File Gambar <span x-show="image.is_new" class="text-red-500">*</span>
                                    </label>
                                    <input type="file" :name="'images[' + index + '][file]'" :id="'images[' + index + '][file]'"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100"
                                        @change="previewImage($event, index)" accept="image/*"
                                        x-bind:required="!image.id">

                                    <div x-show="image.preview || image.image_url" class="mt-4">
                                        <span class="block text-sm font-medium text-gray-700 mb-2">Preview:</span>
                                        <img :src="image.preview || image.image_url" :alt="image.alt_text"
                                            class="w-32 h-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                                    </div>

                                    <input type="hidden" :name="'images[' + index + '][id]'" x-model="image.id">
                                </div>

                                <div>
                                    <label :for="'images[' + index + '][alt_text]'"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Teks Alternatif (Alt Text)
                                    </label>
                                    <input type="text" :name="'images[' + index + '][alt_text]'"
                                        :id="'images[' + index + '][alt_text]'"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                        placeholder="Contoh: Kue Red Velvet dengan topping cream cheese"
                                        x-model="image.alt_text">

                                    <div class="mt-4 flex items-center">
                                        <input type="radio" name="thumbnail_selection" :id="'is_thumbnail_' + index"
                                            :value="index" x-model="thumbnailIndex" @change="setAsThumbnail(index)"
                                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                                        <label :for="'is_thumbnail_' + index"
                                            class="ml-2 block text-sm text-gray-900">
                                            Set sebagai Thumbnail Utama
                                        </label>
                                        <input type="hidden" :name="'images[' + index + '][is_thumbnail]'"
                                            :value="image.is_thumbnail ? 1 : 0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Error Messages --}}
                    @error('images')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('images.*.file')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('images.*.alt_text')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-6 flex justify-center">
                        <button type="button" @click="addImageField()"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.5v15m7.5-7.5h-15"></path>
                            </svg>
                            Tambah Gambar Lain
                        </button>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end mt-8 gap-4">
                    <a href="{{ route('admin.product.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 13.5h6m-3-3v6m-9-9v10.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v3">
                            </path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </x-form.card>
    </div>
@endsection
