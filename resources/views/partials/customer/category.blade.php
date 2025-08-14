<!-- Enhanced Categories Section -->
<section class="py-20 bg-gradient-to-br from-purple-50 via-white to-pink-50 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full pattern-bg opacity-10"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16 fade-in-section">
            <div
                class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full text-sm font-semibold mb-4">
                ✨ Kategori Premium
            </div>
            <h2
                class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent pb-2">
                Kategori Kami
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">Jelajahi pilihan lezat kategori kue untuk setiap acara
                spesial Anda</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($categories as $category)
                <div class="group relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:scale-105 hover-lift sparkle-effect fade-in-section">
                    <div class="h-72 overflow-hidden relative">
                        <img src="{{ $category->image ? Storage::url($category->image) : 'https://placehold.co/300' }}"
                            alt="{{ $category->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-purple-900/80 via-purple-600/40 to-transparent">
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ $category->name }}</h3>
                                <p class="text-purple-200">{{ $category->products->count() }} produk</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
