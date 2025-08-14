<!-- Enhanced Hero Section -->
<section class="relative overflow-hidden min-h-screen flex items-center gradient-bg">
    <div class="absolute inset-0 pattern-bg opacity-30"></div>

    <!-- Floating particles -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-pink-300/20 rounded-full animate-float"></div>
    <div class="absolute bottom-32 right-20 w-16 h-16 bg-purple-300/30 rounded-full animate-float"
        style="animation-delay: 2s;"></div>
    <div class="absolute top-1/2 left-20 w-12 h-12 bg-yellow-300/25 rounded-full animate-float"
        style="animation-delay: 4s;"></div>

    <div class="container mx-auto px-6 py-24 flex flex-col md:flex-row items-center relative z-10">
        <div class="md:w-1/2 z-20 fade-in-section">
            <div
                class="inline-flex items-center glass-effect rounded-full px-6 py-2 mb-6 text-white text-sm font-medium">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                Artisan Bakery Premium
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold leading-tight mb-6">
                <span
                    class="bg-gradient-to-r from-yellow-200 via-pink-200 to-purple-200 bg-clip-text text-transparent block">
                    Momen Manis
                </span>
                <span class="text-white block mt-2">
                    Dimulai dengan
                    <span class="bg-gradient-to-r from-pink-300 to-purple-300 bg-clip-text text-transparent">
                        Ara Cake
                    </span>
                </span>
            </h1>

            <p class="text-xl text-white/90 mb-8 max-w-lg leading-relaxed">
                Temukan kue dan pastry artisan yang dibuat dengan cinta dan bahan-bahan premium untuk acara spesial
                Anda. Setiap gigitan adalah kebahagiaan.
            </p>

            <div class="flex space-x-8 mb-8">
                <div class="text-center glass-effect rounded-xl px-4 py-3">
                    <div class="text-2xl font-bold text-white">500+</div>
                    <div class="text-sm text-white/70">Pelanggan Bahagia</div>
                </div>
                <div class="text-center glass-effect rounded-xl px-4 py-3">
                    <div class="text-2xl font-bold text-white">50+</div>
                    <div class="text-sm text-white/70">Varian Rasa</div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <button
                    class="group px-[5rem] py-4 bg-white text-purple-600 rounded-full font-semibold hover-glow transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <a href="{{ route('product') }}">
                        <span class="flex items-center justify-center">
                            Jelajahi Produk
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </a>
                </button>
            </div>
        </div>

        <div class="md:w-1/2 mt-12 md:mt-0 relative fade-in-section">
            <div class="relative">
                <div
                    class="absolute -inset-4 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full opacity-20 animate-pulse">
                </div>
                <div class="relative overflow-hidden rounded-3xl sparkle-effect">
                    <img src="https://images.unsplash.com/photo-1559620192-032c4bc4674e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                        alt="Kue Lezat"
                        class="w-full max-w-lg mx-auto transform transition-all duration-500 hover:scale-105 shadow-2xl">
                </div>
            </div>
        </div>
    </div>
</section>
