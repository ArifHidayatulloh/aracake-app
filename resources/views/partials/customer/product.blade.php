 <!-- Enhanced Featured Products -->
 <section class="py-20 bg-gradient-to-b from-white via-purple-50/30 to-white relative">
     <div class="container mx-auto px-6">
         <div class="text-center mb-16 fade-in-section">
             <div
                 class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full text-sm font-semibold mb-4">
                 🏆 Produk Terbaik
             </div>
             <h2
                 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent pb-2">
                 Produk Unggulan
             </h2>
             <p class="text-gray-600 max-w-2xl mx-auto text-lg">Kreasi kami yang paling populer dan lezat, dibuat dengan
                 resep rahasia keluarga</p>
         </div>

         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
             @foreach ($featuredProducts as $product)
                 <div
                     class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift hover-glow sparkle-effect fade-in-section">
                     <div class="relative overflow-hidden rounded-t-3xl">
                         <img src="{{ $product->image_url ? $product->image_url : 'https://placehold.co/400'  }}" alt="Chocolate Cake"
                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">

                         @if ($product->is_recommended == true)
                             <div
                                 class="absolute top-4 right-4 px-3 py-1 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-full">
                                 BEST
                             </div>
                         @endif

                         <div
                             class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                         </div>
                     </div>
                     <div class="p-6">
                         <div class="">
                             <h3 class="font-bold text-lg text-gray-800">{{ $product->name }}</h3>
                             <span class="text-purple-600 font-bold text-lg">Rp
                                 {{ number_format($product->price) }}</span>
                         </div>
                         <p class="text-gray-500 text-sm mb-4">{{ $product->category->name }}</p>
                         <div class="flex items-center justify-between">
                             <div class="flex space-x-2">
                                 <a href="{{ route('product.detail', $product->slug) }}"
                                     class="p-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-600 rounded-full hover:from-purple-200 hover:to-pink-200 transition-all duration-300 transform hover:scale-110 px-5">
                                     <i class="fas fa-eye text-sm"></i> Lihat
                                 </a>
                                 @if (Auth::check())
                                     <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                         @csrf
                                         <button
                                             class="p-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full hover:from-purple-700 hover:to-pink-600 transition-all duration-300 transform hover:scale-110 shadow-lg px-5">
                                             <i class="fas fa-shopping-cart text-sm"></i> Tambah
                                         </button>
                                     </form>
                                 @else
                                     <a href="{{ route('login') }}"
                                         class="p-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full hover:from-purple-700 hover:to-pink-600 transition-all duration-300 transform hover:scale-110 shadow-lg px-5">
                                         <i class="fas fa-shopping-cart text-sm"></i> Tambah
                                     </a>
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>
             @endforeach
         </div>

         <div class="text-center mt-16 fade-in-section">
             <button
                 class="group px-10 py-4 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full font-semibold text-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover-glow">
                 <a href="{{ route('product') }}">
                     <span class="flex items-center justify-center">
                         Lihat Semua Produk
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
 </section>
