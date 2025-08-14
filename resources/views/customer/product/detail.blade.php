@extends('layouts.guest',['title' => $product->name])

@section('content')
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-purple-600">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('product') }}" class="hover:text-purple-600">Produk</a>
            <span class="mx-2">/</span>
            @if ($product->category)
                <a href="{{ route('product', ['category' => $product->category->slug]) }}"
                    class="hover:text-purple-600">{{ $product->category->name }}</a>
                <span class="mx-2">/</span>
            @endif
            <span class="text-purple-600">{{ $product->name }}</span>
        </div>
    </div>

    <section class="container mx-auto px-6 py-12" x-data="productDetail()">
        <div class="flex flex-col lg:flex-row gap-12">
            <div class="lg:w-1/2">
                <div class="bg-white rounded-xl shadow-md p-4 mb-4">
                    <img :src="mainImage" :alt="product.name" class="w-full h-96 object-contain rounded-lg">
                </div>

                @if ($product->images && $product->images->count() > 0)
                    <div class="grid grid-cols-4 gap-3">

                        @foreach ($product->images as $index => $image)
                            <button @click="changeMainImage('{{ $image->image_url  }}')"
                                :class="{
                                    'ring-2 ring-purple-500': mainImage.includes(
                                        '{{ $image->image_url }}')
                                }"
                                class="bg-white rounded-lg p-1 border border-gray-200 transition-all hover:border-purple-300">
                                <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $product->name }}"
                                    class="w-full h-20 object-cover rounded-md">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="lg:w-1/2">
                <div class="bg-white rounded-xl shadow-md p-8">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-2 mb-3">
                                @if ($product->is_recommended)
                                    <span
                                        class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">RECOMMENDED</span>
                                @endif
                                @if ($product->is_preorder_only)
                                    <span
                                        class="bg-orange-100 text-orange-800 text-xs font-semibold px-2.5 py-0.5 rounded">PREORDER
                                        ONLY</span>
                                @endif
                            </div>

                            <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $product->name }}</h1>

                            <div class="flex items-center mb-4 text-sm text-gray-500">
                                <div class="flex items-center mr-4">
                                    <i class="fas fa-shopping-bag mr-1"></i>
                                    <span>{{ $product->orderItems_count ?? 0 }} pesanan</span>
                                </div>
                                <span class="mx-2 text-gray-300">|</span>
                                <span
                                    class="font-medium {{ $product->is_available ? 'text-green-600' : 'text-orange-600' }}">
                                    <i class="fas {{ $product->is_available ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                                    {{ $product->is_available ? 'Tersedia' : 'Preorder Only' }}
                                </span>
                                @if ($product->preparation_time_days && $product->preparation_time_days > 0)
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span>
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $product->preparation_time_days }} hari persiapan
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <span class="text-3xl font-bold text-purple-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-col sm:flex-row gap-3 items-end">
                            <div>
                                <label for="quantity-selector"
                                    class="block text-sm font-medium text-gray-700 mb-2">Jumlah:</label>
                                <div class="flex items-center">
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" @click="decrementQuantity()"
                                            class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors rounded-l-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                            :disabled="quantity <= 1">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" id="quantity-selector" x-model.number="quantity"
                                            @input="updateQuantity()" min="1" max="99"
                                            class="w-16 text-center border-x border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent py-2">
                                        <button type="button" @click="incrementQuantity()"
                                            class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors rounded-r-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                            :disabled="quantity >= 99">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="ml-4 text-sm text-gray-600">
                                        <span class="font-medium">Total: </span>
                                        <span class="text-purple-600 font-bold"
                                            x-text="'Rp ' + (product.price * quantity).toLocaleString('id-ID')"></span>
                                    </div>
                                </div>
                            </div>
                                <div>
                                    @if (Auth::check())
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                            x-ref="addToCartForm">
                                            @csrf
                                            <input type="hidden" name="quantity" :value="quantity">

                                            <button type="submit"
                                                class="bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg font-medium transition-colors flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed h-[42px]"
                                                :disabled="!product.is_available && !product.is_preorder_only">
                                                <i class="fas fa-shopping-cart mr-2"></i>
                                                Tambah ke Keranjang
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg font-medium transition-colors flex items-center justify-center">
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            Tambah ke Keranjang
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-share-alt mr-2"></i>
                            <span class="mr-4">Bagikan:</span>
                            <div class="flex space-x-2">
                                <button type="button" @click="shareToFacebook()"
                                    class="text-gray-500 hover:text-blue-500 p-2 rounded-full hover:bg-blue-50 transition-colors">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button type="button" @click="shareToTwitter()"
                                    class="text-gray-500 hover:text-blue-400 p-2 rounded-full hover:bg-blue-50 transition-colors">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button type="button" @click="shareToWhatsApp()"
                                    class="text-gray-500 hover:text-green-500 p-2 rounded-full hover:bg-green-50 transition-colors">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                                <button type="button" @click="shareToCopyLink()"
                                    class="text-gray-500 hover:text-gray-900 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'description'"
                            :class="activeTab === 'description' ? 'border-purple-500 text-purple-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors">
                            Deskripsi Produk
                        </button>
                    </nav>
                </div>
                <div class="p-8">
                    <div class="prose max-w-none text-gray-600">
                        {!! Str::markdown($product->description) !!}
                    </div>
                    @if ($product->category)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Kategori:</span>
                                <a href="{{ route('product', ['category' => $product->category->slug]) }}"
                                    class="text-purple-600 hover:text-purple-800">{{ $product->category->name }}</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="relative">
                                <a href="{{ route('product.detail', $relatedProduct->slug) }}">
                                    <img src="{{ $relatedProduct->image_url ? $relatedProduct->image_url : 'https://placehold.co/400x300?text=No+Image' }}"
                                        alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                                </a>

                                @if ($relatedProduct->is_recommended)
                                    <span
                                        class="absolute top-3 left-3 bg-purple-500 text-white text-xs font-bold px-2 py-0.5 rounded">RECOMMENDED</span>
                                @elseif($relatedProduct->is_featured)
                                    <span
                                        class="absolute top-3 left-3 bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">FEATURED</span>
                                @elseif($relatedProduct->is_preorder_only)
                                    <span
                                        class="absolute top-3 left-3 bg-orange-500 text-white text-xs font-bold px-2 py-0.5 rounded">PREORDER</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <a href="{{ route('product.detail', $relatedProduct->slug) }}"
                                    class="font-bold text-gray-800 hover:text-purple-600 transition-colors block mb-2">
                                    {{ $relatedProduct->name }}
                                </a>
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-shopping-bag text-gray-400 text-xs mr-1"></i>
                                    <span class="text-gray-500 text-xs">{{ $relatedProduct->orderItems_count ?? 0 }}
                                        pesanan</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-purple-600 font-bold">
                                        Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}
                                    </span>
                                    <a href="{{ route('product.detail', $relatedProduct->slug) }}"
                                        class="bg-purple-600 hover:bg-purple-700 text-white py-1 px-3 rounded text-xs transition-colors">
                                        <i class="fas fa-eye mr-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <script>
        function productDetail() {
            return {
                // Variabel-variabel inisial
                product: @json($product),
                mainImage: '{{ $product->image_url ?? 'https://placehold.co/400x300?text=No+Image' }}',
                quantity: 1,
                activeTab: 'description',

                // Fungsi untuk mengganti gambar utama
                changeMainImage(imageUrl) {
                    this.mainImage = imageUrl;
                },

                // Fungsi untuk menambah jumlah
                incrementQuantity() {
                    if (this.quantity < 99) {
                        this.quantity++;
                    }
                },

                // Fungsi untuk mengurangi jumlah
                decrementQuantity() {
                    if (this.quantity > 1) {
                        this.quantity--;
                    }
                },

                // Fungsi untuk memperbarui jumlah dari input
                updateQuantity() {
                    if (this.quantity < 1) {
                        this.quantity = 1;
                    } else if (this.quantity > 99) {
                        this.quantity = 99;
                    }
                },

                // Fungsi untuk share
                shareToFacebook() {
                    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href),
                        '_blank');
                },
                shareToTwitter() {
                    const text = encodeURIComponent('Cek produk keren ini: ' + this.product.name);
                    window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) +
                        '&text=' + text, '_blank');
                },
                shareToWhatsApp() {
                    const text = encodeURIComponent('Lihat produk ini: ' + this.product.name + ' - ' + window.location
                        .href);
                    window.open('https://wa.me/?text=' + text, '_blank');
                },
                shareToCopyLink() {
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('Link produk telah disalin ke clipboard!');
                    });
                }
            }
        }
    </script>
@endsection
