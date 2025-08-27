@extends('layouts.guest', ['title' => 'Hubungi Kami'])

@section('content')
     <!-- Contact Info Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 fade-in-section">
                <div class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full text-sm font-semibold mb-4">
                    📞 Hubungi Kami
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent py-3">
                    Mari Terhubung
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Jangan ragu untuk menghubungi kami melalui berbagai cara di bawah ini</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift fade-in-section">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-800">Lokasi</h3>
                    <p class="text-gray-600 mb-4">{{ $setting['store_address']->setting_value }}</p>
                    <a href="#" class="text-purple-600 font-semibold hover:underline">Lihat di Peta</a>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift fade-in-section">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-phone text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-800">Telepon</h3>
                    <p class="text-gray-600 mb-4">{{ $setting['store_phone']->setting_value }}</p>
                    <a href="https://api.whatsapp.com/send?phone={{ $setting['store_phone']->setting_value ?? '' }}" class="text-purple-600 font-semibold hover:underline">Hubungi Sekarang</a>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-500 transform hover-lift fade-in-section">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-800">Email</h3>
                    <p class="text-gray-600 mb-4">{{ $setting['store_email']->setting_value }}</p>
                    <a href="mailto:{{ $setting['store_email']->setting_value }}" class="text-purple-600 font-semibold hover:underline">Kirim Email</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in-section">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Jam Operasional</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">Senin - Jumat</span>
                            <span class="font-semibold text-gray-800">08:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">Sabtu</span>
                            <span class="font-semibold text-gray-800">08:00 - 22:00</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">Minggu</span>
                            <span class="font-semibold text-gray-800">09:00 - 18:00</span>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mt-10 mb-6">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="{{ $setting['store_facebook']->setting_value ?? '#' }}" class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ $setting['store_instagram']->setting_value ?? '#' }}" class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?phone={{ $setting['store_phone']->setting_value ?? '' }}" class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="{{ $setting['store_youtube']->setting_value ?? '#' }}" class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-8 shadow-lg fade-in-section">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h3>
                    <form action="#" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
                            </div>
                            <div>
                                <label for="email" class="block text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="subject" class="block text-gray-700 mb-2">Subjek</label>
                            <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-500 text-white py-4 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-20 bg-gradient-to-br from-purple-50 to-pink-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 fade-in-section">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Kunjungi Toko Kami</h2>
                <p class="text-gray-600 mt-2">Datang langsung ke toko kami untuk pengalaman berbelanja yang lebih personal</p>
            </div>

            <div class="rounded-3xl overflow-hidden shadow-2xl fade-in-section">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613502864!3d-6.194741395493371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6e452c5d5b4c5c4e!2sJakarta%2C%20Indonesia!5e0!3m2!1sen!2sus!4v1633033220019!5m2!1sen!2sus"
                        width="100%"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        class="rounded-3xl">
                </iframe>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 fade-in-section">
                <div class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full text-sm font-semibold mb-4">
                    ❓ Pertanyaan Umum
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent py-2">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Temukan jawaban atas pertanyaan umum seputar produk dan layanan kami</p>
            </div>

            <div class="max-w-3xl mx-auto space-y-6 fade-in-section">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Berapa lama waktu yang dibutuhkan untuk pesanan kue custom?</h3>
                    <p class="text-gray-600">Pesanan kue custom biasanya membutuhkan waktu 2-3 hari tergantung kompleksitas desain. Untuk pesanan mendesak, silakan hubungi kami langsung untuk konsultasi.</p>
                </div>

                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Apakah menyediakan layanan pengiriman?</h3>
                    <p class="text-gray-600">Ya, kami menyediakan layanan pengiriman dalam area Jakarta dan sekitarnya. Biaya pengiriman bervariasi tergantung jarak dan ukuran pesanan.</p>
                </div>

                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Bagaimana cara memesan snack box untuk acara perusahaan?</h3>
                    <p class="text-gray-600">Anda dapat menghubungi kami melalui WhatsApp atau email minimal 3 hari sebelum acara. Kami akan mengirimkan katalog dan quotation untuk Anda.</p>
                </div>

                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Apakah menerima pesanan dalam jumlah besar?</h3>
                    <p class="text-gray-600">Tentu, kami menerima pesanan dalam jumlah besar untuk acara pernikahan, seminar, atau acara perusahaan. Diskon khusus tersedia untuk pesanan besar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 via-purple-700 to-pink-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 pattern-bg opacity-20"></div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="fade-in-section">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Butuh Bantuan Cepat?</h2>
                <p class="text-xl mb-10 max-w-2xl mx-auto text-purple-100">Hubungi kami melalui WhatsApp untuk respon yang lebih cepat</p>
                <a href="https://wa.me/6281234567890" class="inline-block px-8 py-4 bg-white text-purple-600 rounded-full font-bold text-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <i class="fab fa-whatsapp mr-2"></i> Chat via WhatsApp
                </a>
            </div>
        </div>
    </section>
@endsection
