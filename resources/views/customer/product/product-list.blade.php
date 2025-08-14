@extends('layouts.guest', ['title' => 'Koleksi Kue Kami'])

@section('content')
    <!-- Product Header -->
    <header class="bg-gradient-to-r from-purple-50 to-pink-50 py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Koleksi Kue Kami</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan kue lezat untuk setiap momen spesial Anda</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12">
        <!-- Category Filter -->
        <div class="mb-12">
            <!-- Category Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mb-8">
                <a href="{{ route('product', array_merge(request()->query(), ['category' => ''])) }}"
                    class="px-6 py-2 rounded-full shadow-sm transition-all category-btn {{ !request('category') ? 'bg-purple-600 text-white' : 'bg-white hover:bg-purple-50' }}">
                    Semua
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('product', array_merge(request()->query(), ['category' => $category->id])) }}"
                        class="px-6 py-2 rounded-full shadow-sm transition-all category-btn {{ request('category') == $category->id ? 'bg-purple-600 text-white' : 'bg-white hover:bg-purple-50' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Search and Sort -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <!-- Search Form -->
                <form action="{{ route('product') }}" method="GET" class="relative w-full md:w-64">
                    <!-- Preserve other parameters -->
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kue..."
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <button type="submit" class="sr-only">Search</button>
                </form>

                <!-- Sort Form -->
                <div class="flex items-center space-x-2">
                    <form action="{{ route('product') }}" method="GET" id="sortForm">
                        <!-- Preserve other parameters -->
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <span class="text-gray-600">Urutkan Harga:</span>
                        <select name="sort" onchange="document.getElementById('sortForm').submit()"
                            class="border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Default</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Termurah</option>
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Termahal</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if (request('category') || request('search') || request('sort'))
                <div class="mb-6 flex flex-wrap gap-2 items-center">
                    <span class="text-sm text-gray-600">Filter aktif:</span>

                    @if (request('category'))
                        @php
                            $selectedCategory = $categories->find(request('category'));
                        @endphp
                        @if ($selectedCategory)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800">
                                {{ $selectedCategory->name }}
                                <a href="{{ route('product', array_merge(request()->query(), ['category' => ''])) }}"
                                    class="ml-1 text-purple-600 hover:text-purple-800">
                                    <i class="fas fa-times text-xs"></i>
                                </a>
                            </span>
                        @endif
                    @endif

                    @if (request('search'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                            "{{ request('search') }}"
                            <a href="{{ route('product', array_merge(request()->query(), ['search' => ''])) }}"
                                class="ml-1 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times text-xs"></i>
                            </a>
                        </span>
                    @endif

                    @if (request('sort'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                            {{ request('sort') == 'asc' ? 'Termurah' : 'Termahal' }}
                            <a href="{{ route('product', array_merge(request()->query(), ['sort' => ''])) }}"
                                class="ml-1 text-green-600 hover:text-green-800">
                                <i class="fas fa-times text-xs"></i>
                            </a>
                        </span>
                    @endif

                    <a href="{{ route('product') }}"
                        class="text-sm text-red-600 hover:text-red-800 underline">
                        Hapus semua filter
                    </a>
                </div>
            @endif

            <!-- Products Count -->
            <div class="mb-6">
                <p class="text-gray-600">
                    Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk
                    @if (request('search'))
                        untuk pencarian "<strong>{{ request('search') }}</strong>"
                    @endif
                </p>
            </div>

            <!-- Product Grid -->
            @if ($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($products as $product)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden product-card transition-all duration-300 hover:shadow-xl hover:-translate-y-1 animate-fade-in">
                            <div class="relative">
                                <img src="{{ $product->image_url ?? 'https://placehold.co/300' }}" alt="{{ $product->name }}"
                                    class="w-full h-64 object-cover">

                                <!-- Product Badges -->
                                @if ($product->is_preorder_only == true)
                                    <div
                                        class="absolute top-3 left-3 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        PREORDER
                                    </div>
                                @elseif ($product->is_recommended == true)
                                    <div
                                        class="absolute top-3 left-3 bg-pink-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        BEST
                                    </div>
                                @endif
                            </div>

                            <div class="p-5">
                                <!-- Product Title -->
                                <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 min-h-[3.5rem]">
                                    {{ $product->name }}
                                </h3>

                                <!-- Order Count -->
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-shopping-bag text-gray-400 text-xs mr-1"></i>
                                    <span class="text-gray-500 text-sm">({{ $product->orderItems->count() }}
                                        pesanan)</span>
                                </div>

                                <!-- Description -->
                                @php
                                    $limitedDescription = Str::limit($product->description, 80, '...');
                                    $markdownDescription = Str::markdown($limitedDescription);
                                @endphp
                                <div class="text-gray-600 mb-4 text-sm line-clamp-3 min-h-[4rem]">
                                    {!! $markdownDescription !!}
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <span class="text-2xl font-bold text-purple-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <!-- Detail Button -->
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium flex items-center justify-center text-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Detail
                                    </a>
                                    @if (Auth::check())
                                        <!-- Add to Cart Button -->
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="flex-1 bg-purple-600 text-white px-4 py-2.5 rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium flex items-center justify-center">
                                                <i class="fas fa-shopping-cart mr-2"></i>
                                                Keranjang
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="flex-1 bg-purple-600 text-white px-4 py-2.5 rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium flex items-center justify-center">
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            Keranjang
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Products Found -->
                <div class="text-center py-16">
                    <div class="mb-4">
                        <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500 mb-6">
                        @if (request('search'))
                            Coba gunakan kata kunci pencarian yang berbeda
                        @else
                            Belum ada produk yang tersedia untuk kategori ini
                        @endif
                    </p>
                    <a href="{{ route('product') }}"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Lihat Semua Produk
                    </a>
                </div>
            @endif

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="mt-12">
                    <x-pagination-custom.product :paginator="$products" />
                </div>
            @endif
        </div>
    </main>

    <!-- Additional CSS for line-clamp -->
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
