 <!-- Enhanced CTA Section -->
 <section class="py-20 bg-gradient-to-r from-purple-600 via-purple-700 to-pink-600 text-white relative overflow-hidden">
     <div class="absolute inset-0 pattern-bg opacity-20"></div>
     <div
         class="absolute top-0 left-0 w-72 h-72 bg-gradient-to-br from-pink-400/30 to-transparent rounded-full blur-3xl animate-float">
     </div>
     <div class="absolute bottom-0 right-0 w-72 h-72 bg-gradient-to-tl from-purple-400/30 to-transparent rounded-full blur-3xl animate-float"
         style="animation-delay: 2s;"></div>

     <div class="container mx-auto px-6 text-center relative z-10">
         <div class="fade-in-section">
             <div
                 class="inline-block px-6 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-semibold mb-6">
                 🚀 Siap Memesan?
             </div>

             <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                 Siap Memesan Kue
                 <span class="bg-gradient-to-r from-yellow-200 to-pink-200 bg-clip-text text-transparent">
                     Sempurna
                 </span>
                 Anda?
             </h2>

             <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto text-purple-100 leading-relaxed">
                 Ciptakan momen manis dengan kue artisan kami untuk acara spesial Anda. Konsultasi gratis tersedia!
             </p>

             <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                 <a href="{{ route('product') }}"
                     class="group px-10 py-4 bg-white text-purple-600 rounded-full font-bold text-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover-glow">
                     <span class="flex items-center justify-center">
                         <i class="fas fa-shopping-cart mr-3"></i>
                         Pesan Sekarang
                         <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                         </svg>
                     </span>
                 </a>

                 @php
                     $setting = App\Models\SystemSetting::where('is_active', true)->get()->keyBy('setting_key');
                 @endphp
                 <a href="https://api.whatsapp.com/send?phone={{ $setting['store_phone']->setting_value ?? '' }}"
                     class="group px-10 py-4 border-2 border-white/30 backdrop-blur-sm text-white rounded-full font-bold text-lg hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                     <span class="flex items-center justify-center">
                         <i class="fas fa-phone mr-3"></i>
                         Hubungi Kami
                     </span>
                 </a>
             </div>

             <!-- Trust indicators -->
             <div class="flex flex-wrap justify-center items-center mt-12 space-x-8 text-purple-200">
                 <div class="flex items-center space-x-2">
                     <i class="fas fa-shield-alt text-green-300"></i>
                     <span>Kualitas Terjamin</span>
                 </div>
                 <div class="flex items-center space-x-2">
                     <i class="fas fa-truck text-blue-300"></i>
                     <span>Pengiriman Cepat</span>
                 </div>
                 <div class="flex items-center space-x-2">
                     <i class="fas fa-headset text-yellow-300"></i>
                     <span>Support 24/7</span>
                 </div>
             </div>
         </div>
     </div>
 </section>
