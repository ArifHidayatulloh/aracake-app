 <!-- Enhanced Order Types Section -->
 <section class="py-20 bg-gradient-to-br from-white via-purple-50/50 to-pink-50/30 relative">
     <div class="container mx-auto px-6">
         <div class="text-center mb-16 fade-in-section">
             <div
                 class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full text-sm font-semibold mb-4">
                 📋 Pilihan Pesanan
             </div>
             <h2
                 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                 Pilihan Pesanan
             </h2>
             <p class="text-gray-600 max-w-2xl mx-auto text-lg">Berbagai opsi pesanan untuk kebutuhan dan acara spesial
                 Anda</p>
         </div>

         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
             <div
                 class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift hover-glow sparkle-effect fade-in-section">
                 <div
                     class="relative h-64 bg-gradient-to-br from-purple-100 via-purple-200 to-pink-200 rounded-t-3xl flex items-center justify-center overflow-hidden">
                     <div class="absolute inset-0 pattern-bg opacity-20"></div>
                     <i
                         class="fas fa-birthday-cake text-7xl text-purple-600 relative z-10 group-hover:scale-110 transition-transform duration-500"></i>
                     <div
                         class="absolute top-4 right-4 w-12 h-12 bg-white/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                         <i class="fas fa-bolt text-purple-600"></i>
                     </div>
                 </div>
                 <div class="p-8">
                     <h3 class="font-bold text-xl mb-4 text-gray-800">Pesan Langsung</h3>
                     <p class="text-gray-600 mb-6 leading-relaxed">Pilih dari koleksi kue kami yang sudah tersedia dan
                         siap untuk dipesan</p>
                     <div class="flex items-center justify-between">
                         <a href="{{ route('product') }}"
                             class="group px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                             <span class="flex items-center">
                                 Lihat Katalog
                                 <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                 </svg>
                             </span>
                         </a>
                         <div class="text-purple-600 font-semibold">✨ Instan</div>
                     </div>
                 </div>
             </div>

             <div
                 class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift hover-glow sparkle-effect fade-in-section">
                 <div
                     class="relative h-64 bg-gradient-to-br from-purple-100 via-purple-200 to-pink-200 rounded-t-3xl flex items-center justify-center overflow-hidden">
                     <div class="absolute inset-0 pattern-bg opacity-20"></div>
                     <i
                         class="fas fa-pencil-ruler text-7xl text-purple-600 relative z-10 group-hover:scale-110 transition-transform duration-500"></i>
                     <div
                         class="absolute top-4 right-4 w-12 h-12 bg-white/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                         <i class="fas fa-star text-purple-600"></i>
                     </div>
                     <div
                         class="absolute top-4 left-4 px-3 py-1 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-full">
                         POPULER
                     </div>
                 </div>
                 <div class="p-8">
                     <h3 class="font-bold text-xl mb-4 text-gray-800">Kue Custom</h3>
                     <p class="text-gray-600 mb-6 leading-relaxed">Desain kue khusus sesuai keinginan Anda dengan
                         berbagai pilihan rasa dan dekorasi</p>
                     <div class="flex items-center justify-between">
                        @php
                            $setting = App\Models\SystemSetting::where('is_active', true)->get()->keyBy('setting_key');
                        @endphp
                         <a href="https://api.whatsapp.com/send?phone={{ $setting['store_phone']->setting_value ?? '' }}"
                             class="group px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                             <span class="flex items-center">
                                 Buat Pesanan
                                 <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                 </svg>
                             </span>
                         </a>

                         <div class="text-purple-600 font-semibold">🎨 Kreatif</div>
                     </div>
                 </div>
             </div>
             <div
                 class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift hover-glow sparkle-effect fade-in-section">
                 <div
                     class="relative h-64 bg-gradient-to-br from-purple-100 via-purple-200 to-pink-200 rounded-t-3xl flex items-center justify-center overflow-hidden">
                     <div class="absolute inset-0 pattern-bg opacity-20"></div>
                     <i
                         class="fas fa-utensils text-7xl text-purple-600 relative z-10 group-hover:scale-110 transition-transform duration-500"></i>
                     <div
                         class="absolute top-4 right-4 w-12 h-12 bg-white/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                         <i class="fas fa-leaf text-purple-600"></i>
                     </div>
                 </div>
                 <div class="p-8">
                     <h3 class="font-bold text-xl mb-4 text-gray-800">Kue Tradisional</h3>
                     <p class="text-gray-600 mb-6 leading-relaxed">Kue-kue tradisional dengan cita rasa autentik dan
                         resep turun temurun</p>
                     <div class="flex items-center justify-between">
                         <a href="{{ route('product') }}"
                             class="group px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full font-medium hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                             <span class="flex items-center">
                                 Jelajahi
                                 <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                 </svg>
                             </span>
                         </a>
                         <div class="text-purple-600 font-semibold">🏛️ Autentik</div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
