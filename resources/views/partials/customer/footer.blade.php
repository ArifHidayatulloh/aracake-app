@php
    $setting = App\Models\SystemSetting::where('is_active', true)->get()->keyBy('setting_key');
@endphp
<!-- Enhanced Footer -->
<footer class="bg-gray-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 to-pink-900/20"></div>

    <div class="container mx-auto px-6 pt-16 pb-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="fade-in-section">
                <div class="flex items-center mb-6">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold text-xl mr-3 shadow-lg">
                        AC
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 bg-clip-text text-transparent">
                        Ara Cake
                    </span>
                </div>
                <p class="text-gray-400 mb-6 leading-relaxed">
                    Toko kue premium dengan cita rasa tinggi dan bahan-bahan pilihan untuk momen spesial Anda.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ $setting['store_facebook']->setting_value ?? '#' }}"
                        class="w-10 h-10 bg-gray-800 hover:bg-purple-600 rounded-full flex items-center justify-center transition-colors duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ $setting['store_instagram']->setting_value ?? '#' }}"
                        class="w-10 h-10 bg-gray-800 hover:bg-pink-500 rounded-full flex items-center justify-center transition-colors duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ $setting['store_twitter']->setting_value ?? '#' }}"
                        class="w-10 h-10 bg-gray-800 hover:bg-blue-400 rounded-full flex items-center justify-center transition-colors duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="{{ $setting['store_youtube']->setting_value ?? '#' }}"
                        class="w-10 h-10 bg-gray-800 hover:bg-red-500 rounded-full flex items-center justify-center transition-colors duration-300">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div class="fade-in-section">
                <h3 class="text-xl font-bold mb-6 text-white">Tautan Cepat</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-gray-400 hover:text-purple-400 transition-colors duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-purple-500"></i>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product') }}"
                            class="text-gray-400 hover:text-purple-400 transition-colors duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-purple-500"></i>
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-400 hover:text-purple-400 transition-colors duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-purple-500"></i>
                            Tentang Kami
                        </a>
                    </li>                                       
                    <li>
                        <a href="#"
                            class="text-gray-400 hover:text-purple-400 transition-colors duration-300 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-purple-500"></i>
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            @php
                $categories = App\Models\ProductCategory::where('is_active',true)->get();
            @endphp

            <div class="fade-in-section">
                <h3 class="text-xl font-bold mb-6 text-white">Produk</h3>
                <ul class="space-y-3">
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('product', ['category' => $category->id]) }}"
                                class="text-gray-400 hover:text-purple-400 transition-colors duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-purple-500"></i>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach                    
                </ul>
            </div>

            <div class="fade-in-section">
                <h3 class="text-xl font-bold mb-6 text-white">Kontak Kami</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-purple-500 mt-1 mr-3"></i>
                        <span class="text-gray-400">{{ $setting['store_address']->setting_value ?? 'Alamat Toko' }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt text-purple-500 mr-3"></i>
                        <span class="text-gray-400">{{ $setting['store_phone']->setting_value ?? 'Nomor Telepon Toko' }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope text-purple-500 mr-3"></i>
                        <span class="text-gray-400">{{ $setting['store_email']->setting_value ?? 'Email Toko' }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-clock text-purple-500 mr-3"></i>
                        <span class="text-gray-400">Buka setiap hari 08:00 - 20:00 WIB</span>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center fade-in-section">
            <div class="text-gray-500 text-sm mb-4 md:mb-0">
                &copy; 2024 - {{ date('Y') }} Ara Cake. All rights reserved.
            </div>
            <div class="flex space-x-6">
                <a href="#" class="text-gray-500 hover:text-purple-400 transition-colors duration-300 text-sm">
                    Kebijakan Privasi
                </a>
                <a href="#" class="text-gray-500 hover:text-purple-400 transition-colors duration-300 text-sm">
                    Syarat & Ketentuan
                </a>
                <a href="#" class="text-gray-500 hover:text-purple-400 transition-colors duration-300 text-sm">
                    FAQ
                </a>
            </div>
        </div>
    </div>
</footer>
