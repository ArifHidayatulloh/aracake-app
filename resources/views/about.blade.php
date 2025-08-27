@extends('layouts.guest', ['title' => 'Tentang Kami'])

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden min-h-[40vh] flex items-center gradient-bg">
        <div class="absolute inset-0 pattern-bg opacity-30"></div>

        <!-- Floating particles -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-pink-300/20 rounded-full animate-float"></div>
        <div class="absolute bottom-32 right-20 w-16 h-16 bg-purple-300/30 rounded-full animate-float"
            style="animation-delay: 2s;"></div>

        <div class="container mx-auto px-6 py-16 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Tentang Ara Cake</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">Cerita di balik setiap rasa lezat yang kami hadirkan untuk
                momen spesial Anda</p>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-12 md:mb-0 fade-in-section">
                    <div class="relative">
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-purple-400 to-pink-400 rounded-3xl opacity-20 animate-pulse">
                        </div>
                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Proses Pembuatan Kue" class="w-full rounded-2xl shadow-2xl relative">
                    </div>
                </div>
                <div class="md:w-1/2 md:pl-16 fade-in-section">
                    <div
                        class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full text-sm font-semibold mb-4">
                        📖 Cerita Kami
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Dari Dapur Kecil ke Toko Ternama</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Ara Cake dimulai pada tahun 2015 dari kecintaan terhadap dunia baking dan keinginan untuk berbagi
                        kebahagiaan melalui kue.
                        Awalnya hanya menerima pesanan dari teman dan keluarga, kini Ara Cake telah berkembang menjadi
                        destinasi utama bagi para pencinta kue dan makanan lezat.
                    </p>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Kami tidak hanya menyajikan kue, tetapi juga berbagai pilihan makanan lain seperti snack box, nasi
                        box, bolu, dan hidangan spesial lainnya.
                        Setiap hidangan dibuat dengan bahan-bahan pilihan dan resep yang telah teruji, menjadikan Ara Cake
                        pilihan tepat untuk setiap acara spesial Anda.
                    </p>
                    <div class="flex space-x-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">8+</div>
                            <div class="text-sm text-gray-500">Tahun Pengalaman</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">5000+</div>
                            <div class="text-sm text-gray-500">Pesanan Dipenuhi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">50+</div>
                            <div class="text-sm text-gray-500">Jenis Produk</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-gradient-to-br from-purple-50 via-white to-pink-50 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full pattern-bg opacity-10"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 fade-in-section">
                <div
                    class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full text-sm font-semibold mb-4">
                    💫 Nilai Kami
                </div>
                <h2
                    class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Yang Membuat Kami Berbeda
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Prinsip-prinsip yang kami pegang teguh dalam setiap
                    produk yang kami buat</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift fade-in-section">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-star text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-800">Kualitas Terbaik</h3>
                    <p class="text-gray-600">Kami hanya menggunakan bahan-bahan premium dan terbaik untuk memastikan cita
                        rasa yang konsisten dan memuaskan.</p>
                </div>

                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift fade-in-section">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-heart text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-800">Dibuat dengan Cinta</h3>
                    <p class="text-gray-600">Setiap produk kami dibuat dengan penuh dedikasi dan cinta, karena kami percaya
                        bahwa rasa terbaik berasal dari hati.</p>
                </div>

                <div
                    class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift fade-in-section">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-lightbulb text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-800">Inovasi Rasa</h3>
                    <p class="text-gray-600">Kami terus berinovasi menciptakan rasa-rasa baru yang unik, menggabungkan
                        tradisi dengan sentuhan modern.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 fade-in-section">
                <div
                    class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full text-sm font-semibold mb-4">
                    👨‍🍳 Tim Kami
                </div>
                <h2
                    class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Para Ahli di Balik Rasa
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Tim berpengalaman yang menjadikan Ara Cake sebagai
                    pilihan utama</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center fade-in-section">
                    <div
                        class="w-48 h-48 mx-auto bg-gradient-to-br from-purple-200 to-pink-200 rounded-full overflow-hidden mb-6 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1566554273541-37a9ca77b91f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Head Baker" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Ara Wijaya</h3>
                    <p class="text-purple-600 font-semibold mb-2">Founder & Head Baker</p>
                    <p class="text-gray-600 text-sm">Pendiri Ara Cake dengan passion di dunia baking selama lebih dari 10
                        tahun.</p>
                </div>

                <div class="text-center fade-in-section">
                    <div
                        class="w-48 h-48 mx-auto bg-gradient-to-br from-purple-200 to-pink-200 rounded-full overflow-hidden mb-6 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Pastry Chef" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Diana Putri</h3>
                    <p class="text-purple-600 font-semibold mb-2">Pastry Chef</p>
                    <p class="text-gray-600 text-sm">Ahli dalam membuat pastry dengan sentuhan kreatif dan inovatif.</p>
                </div>

                <div class="text-center fade-in-section">
                    <div
                        class="w-48 h-48 mx-auto bg-gradient-to-br from-purple-200 to-pink-200 rounded-full overflow-hidden mb-6 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b59b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Cake Designer" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Rina Santoso</h3>
                    <p class="text-purple-600 font-semibold mb-2">Cake Designer</p>
                    <p class="text-gray-600 text-sm">Spesialis dekorasi kue dengan kemampuan membuat karya seni yang
                        memukau.</p>
                </div>

                <div class="text-center fade-in-section">
                    <div
                        class="w-48 h-48 mx-auto bg-gradient-to-br from-purple-200 to-pink-200 rounded-full overflow-hidden mb-6 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Customer Service" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Sari Dewi</h3>
                    <p class="text-purple-600 font-semibold mb-2">Customer Service</p>
                    <p class="text-gray-600 text-sm">Selalu siap membantu Anda dengan senyuman dan solusi terbaik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 via-purple-700 to-pink-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-bg opacity-20"></div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="fade-in-section">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Tertarik dengan Produk Kami?</h2>
                <p class="text-xl mb-10 max-w-2xl mx-auto text-purple-100">Jelajahi berbagai pilihan kue dan makanan lezat
                    kami untuk acara spesial Anda</p>
                <a href="{{ route('product') }}"
                    class="inline-block px-8 py-4 bg-white text-purple-600 rounded-full font-bold text-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    Lihat Katalog Produk
                </a>
            </div>
        </div>
    </section>
@endsection
