@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- Breadcrumb --}}
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Produk', 'url' => route('admin.product.index')],
            ['label' => $product->name],
        ]" />

        {{-- Header Page --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.product.edit', $product->slug) }}"
                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.862 4.477z" />
                </svg>
                Edit Produk
            </a>
        </div>

        {{-- Product Detail Content --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 lg:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12" x-data="{
                mainImage: '{{ $product->thumbnail_image_url ? $product->thumbnail_image_url : '' }}',
                images: @js($product->images->map(fn($image) => ['url' => $image->image_url, 'alt' => $image->alt_text, 'is_thumbnail' => $image->is_thumbnail])),

                init() {
                    // Set the main image based on the thumbnail on page load, if one exists.
                    const thumbnail = this.images.find(img => img.is_thumbnail);
                    if (thumbnail) {
                        this.mainImage = thumbnail.url;
                    } else if (this.images.length > 0) {
                        this.mainImage = this.images[0].url;
                    }
                },

                // Function to change the main image
                changeMainImage(imageUrl) {
                    this.mainImage = imageUrl;
                }
            }">

                {{-- Product Images Section --}}
                <div class="flex flex-col">
                    {{-- Main Image --}}
                    <div class="mb-4 rounded-lg overflow-hidden border border-gray-200 shadow-md">
                        <template x-if="mainImage">
                            <img :src="mainImage" alt="Gambar utama produk" class="w-full h-full object-cover aspect-square">
                        </template>
                        <template x-if="!mainImage">
                            <div class="bg-gray-100 flex items-center justify-center text-gray-400 aspect-square p-6">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </template>
                    </div>

                    {{-- Image Gallery --}}
                    @if ($product->images->count() > 0)
                        <div class="grid grid-cols-4 gap-4 mt-4">
                            @foreach ($product->images as $index => $image)
                                <div class="relative cursor-pointer rounded-lg overflow-hidden border-2 transition-colors duration-200"
                                    :class="mainImage === '{{$image->image_url }}' ? 'border-purple-600 ring-4 ring-purple-200' : 'border-gray-200'"
                                    @click="changeMainImage('{{ $image->image_url }}')">
                                    <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}"
                                        class="w-full h-full object-cover aspect-square">
                                    @if ($image->is_thumbnail)
                                        <div class="absolute top-1 right-1 bg-purple-600 text-white text-xs px-2 py-1 rounded-full">
                                            Thumbnail
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Product Information Section --}}
                <div class="flex flex-col">
                    {{-- Product Header & Status --}}
                    <h1 class="text-3xl font-extrabold text-gray-900">{{ $product->name }}</h1>
                    <div class="mt-2 text-xl text-gray-500">
                        Kategori:
                        <a href="{{ route('admin.product.index', ['category' => $product->category->slug]) }}"
                           class="text-purple-600 hover:text-purple-800 font-semibold">{{ $product->category->name }}</a>
                    </div>

                    <div class="mt-4">
                         <span class="text-4xl font-bold text-gray-900">
                            {{ 'Rp' . number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Product Badges and Details --}}
                    <div class="mt-6 text-sm text-gray-600 space-y-4">
                        <div class="flex items-center space-x-3 flex-wrap">
                            <span class="font-semibold px-3 py-1 text-xs rounded-full border {{ $product->is_available ? 'text-green-800 bg-green-100 border-green-200' : 'text-red-800 bg-red-100 border-red-200' }}">
                                Status: {{ $product->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-3 flex-wrap">
                            @if ($product->is_recommended)
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800">
                                    Rekomendasi
                                </span>
                            @endif
                            @if ($product->is_featured)
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">
                                    Unggulan
                                </span>
                            @endif
                        </div>
                        <div class="space-y-2 mt-4 pt-4 border-t border-gray-200">
                            <p><strong>SKU:</strong> <span class="text-gray-900">{{ $product->sku }}</span></p>
                            <p><strong>Waktu Pengerjaan:</strong> <span class="text-gray-900">{{ $product->preparation_time_days }} hari</span></p>
                        </div>
                    </div>

                    {{-- Product Description --}}
                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Produk</h2>
                        <div class="prose max-w-none text-gray-600 leading-relaxed">
                            {!! Str::markdown($product->description) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
