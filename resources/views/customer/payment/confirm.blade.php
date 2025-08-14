@extends('layouts.guest')

@section('content')
    <!-- Success Section -->
    <section class="container mx-auto px-6 py-16 text-center">
        <!-- Success Animation -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-32 h-32 bg-green-100 rounded-full mb-6">
                <i class="fas fa-check text-5xl text-green-500 animate-bounce"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Pembayaran Berhasil Diupload!</h1>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Terima kasih! Bukti pembayaran Anda telah berhasil diterima. Kami sedang memverifikasi pembayaran Anda dan akan segera mengonfirmasi pesanan.
            </p>
        </div>

        <!-- Order Status Card -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pesanan #ORD-2025-001</h2>
                        <p class="text-gray-600">Dipesan pada: {{ now()->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <span class="bg-orange-100 text-orange-800 text-sm font-medium px-4 py-2 rounded-full mt-4 md:mt-0">
                        <i class="fas fa-hourglass-half mr-2"></i>Menunggu Konfirmasi Pembayaran
                    </span>
                </div>

                <!-- Order Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600 mb-1">Nama Pemesan</p>
                        <p class="font-semibold text-gray-800">{{ session('order_data.nama', 'John Doe') }}</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600 mb-1">No. Telepon</p>
                        <p class="font-semibold text-gray-800">{{ session('order_data.phone', '+62 812 3456 7890') }}</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600 mb-1">Tanggal Ambil/Kirim</p>
                        <p class="font-semibold text-gray-800">{{ session('order_data.tanggal_ambil', '15 Agustus 2025') }}</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                        <p class="font-bold text-purple-600 text-lg">Rp 750.000</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4">Detail Pesanan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-medium text-gray-800">Chocolate Dream</span>
                                <p class="text-sm text-gray-600">Sedang (25cm) x1</p>
                            </div>
                            <span class="font-medium text-gray-800">Rp 250.000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-medium text-gray-800">Vanilla Paradise</span>
                                <p class="text-sm text-gray-600">Kecil (20cm) x1</p>
                            </div>
                            <span class="font-medium text-gray-800">Rp 200.000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-medium text-gray-800">Rainbow Cupcake</span>
                                <p class="text-sm text-gray-600">Set isi 6 x2</p>
                            </div>
                            <span class="font-medium text-gray-800">Rp 300.000</span>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="mb-8">
                    <h3 class="font-bold text-gray-800 mb-4">Status Pesanan</h3>
                    <div class="flex flex-col md:flex-row justify-between relative">
                        <!-- Step 1 - Completed -->
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full flex-shrink-0">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <div class="ml-4 md:ml-3 text-center md:text-left">
                                <p class="font-semibold text-green-600">Pesanan Dibuat</p>
                                <p class="text-sm text-gray-600">{{ now()->format('d M, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Connection Line -->
                        <div class="hidden md:flex flex-1 mx-4 items-center">
                            <div class="w-full h-0.5 bg-green-500"></div>
                        </div>

                        <!-- Step 2 - Current -->
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="flex items-center justify-center w-10 h-10 bg-orange-500 text-white rounded-full flex-shrink-0 animate-pulse">
                                <i class="fas fa-credit-card text-sm"></i>
                            </div>
                            <div class="ml-4 md:ml-3 text-center md:text-left">
                                <p class="font-semibold text-orange-600">Menunggu Konfirmasi</p>
                                <p class="text-sm text-gray-600">1-2 jam kerja</p>
                            </div>
                        </div>

                        <!-- Connection Line -->
                        <div class="hidden md:flex flex-1 mx-4 items-center">
                            <div class="w-full h-0.5 bg-gray-300"></div>
                        </div>

                        <!-- Step 3 - Pending -->
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-white rounded-full flex-shrink-0">
                                <i class="fas fa-cog text-sm"></i>
                            </div>
                            <div class="ml-4 md:ml-3 text-center md:text-left">
                                <p class="font-semibold text-gray-500">Sedang Diproses</p>
                                <p class="text-sm text-gray-600">2-3 hari kerja</p>
                            </div>
                        </div>

                        <!-- Connection Line -->
                        <div class="hidden md:flex flex-1 mx-4 items-center">
                            <div class="w-full h-0.5 bg-gray-300"></div>
                        </div>

                        <!-- Step 4 - Pending -->
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-white rounded-full flex-shrink-0">
                                <i class="fas fa-truck text-sm"></i>
                            </div>
                            <div class="ml-4 md:ml-3 text-center md:text-left">
                                <p class="font-semibold text-gray-500">Siap Diambil</p>
                                <p class="text-sm text-gray-600">Sesuai tanggal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- What's Next -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-info-circle text-blue-500 text-2xl mr-3"></i>
                        <h3 class="text-lg font-bold text-blue-800">Langkah Selanjutnya</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mr-2 mt-0.5"></i>
                            Tim kami akan memverifikasi pembayaran Anda dalam 1-2 jam kerja
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mr-2 mt-0.5"></i>
                            Anda akan menerima konfirmasi melalui WhatsApp/SMS
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mr-2 mt-0.5"></i>
                            Pesanan akan diproses setelah pembayaran dikonfirmasi
                        </li>
                    </ul>
                </div>

                <!-- Contact Information -->
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-headset text-purple-500 text-2xl mr-3"></i>
                        <h3 class="text-lg font-bold text-purple-800">Butuh Bantuan?</h3>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-purple-700">
                            <i class="fab fa-whatsapp text-green-500 mr-3"></i>
                            <div>
                                <p class="font-medium">WhatsApp</p>
                                <p>+62 812 3456 7890</p>
                            </div>
                        </div>
                        <div class="flex items-center text-purple-700">
                            <i class="fas fa-envelope text-blue-500 mr-3"></i>
                            <div>
                                <p class="font-medium">Email</p>
                                <p>info@tokokuemanis.com</p>
                            </div>
                        </div>
                        <div class="flex items-center text-purple-700">
                            <i class="fas fa-clock text-orange-500 mr-3"></i>
                            <div>
                                <p class="font-medium">Jam Operasional</p>
                                <p>Senin - Sabtu: 08:00 - 20:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-lg mx-auto">
                <a href="/"
                   class="flex-1 bg-gradient-to-r from-purple-600 to-pink-500 text-white py-3 px-6 rounded-lg font-bold hover:from-purple-700 hover:to-pink-600 transition-all text-center">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                </a>
                <a href=""
                   class="flex-1 border border-purple-600 text-purple-600 py-3 px-6 rounded-lg font-bold hover:bg-purple-50 transition-all text-center">
                    <i class="fas fa-search mr-2"></i>Lacak Pesanan
                </a>
            </div>

            <!-- Additional Information -->
            <div class="mt-12 p-6 bg-gray-50 rounded-xl">
                <h3 class="font-bold text-gray-800 mb-4 text-center">Informasi Penting</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                    <div class="text-center">
                        <i class="fas fa-shield-alt text-green-500 text-2xl mb-2"></i>
                        <p class="font-medium text-gray-800 mb-1">Pembayaran Aman</p>
                        <p>Data dan transaksi Anda dilindungi dengan sistem keamanan terbaik</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-award text-blue-500 text-2xl mb-2"></i>
                        <p class="font-medium text-gray-800 mb-1">Kualitas Terjamin</p>
                        <p>Semua kue dibuat fresh dengan bahan berkualitas premium</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-heart text-red-500 text-2xl mb-2"></i>
                        <p class="font-medium text-gray-800 mb-1">Dibuat dengan Cinta</p>
                        <p>Setiap kue dibuat dengan penuh perhatian dan cinta untuk kepuasan Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notification Modal (Optional) -->
    <div id="notification-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-8 max-w-md mx-4 text-center">
            <i class="fas fa-bell text-purple-500 text-4xl mb-4"></i>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Aktifkan Notifikasi</h3>
            <p class="text-gray-600 mb-6">Dapatkan update status pesanan langsung ke WhatsApp Anda</p>
            <div class="flex gap-3">
                <button onclick="closeModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50">
                    Nanti Saja
                </button>
                <button onclick="enableNotifications()" class="flex-1 bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700">
                    Aktifkan
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/payment/confirm.js') }}"></script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Add animation to cards */
        .bg-white {
            animation: fadeInUp 0.6s ease-out;
        }

        .bg-blue-50,
        .bg-purple-50 {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
@endsection
