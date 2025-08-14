@extends('layouts.auth',['title' => 'Daftar'])

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left Side - Logo Section -->
                    <div class="lg:w-2/5 bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 p-12 flex flex-col justify-center items-center relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-20 -translate-y-20"></div>
                            <div class="absolute bottom-0 right-0 w-32 h-32 bg-white rounded-full translate-x-16 translate-y-16"></div>
                            <div class="absolute top-1/3 left-1/4 w-24 h-24 bg-white rounded-full opacity-50"></div>
                            <div class="absolute bottom-1/3 left-1/2 w-16 h-16 bg-white rounded-full opacity-30"></div>
                        </div>

                        <!-- Logo Content -->
                        <div class="relative z-10 text-center">
                            <!-- Main Logo -->
                            <div class="mb-8">
                                <div class="inline-flex p-6 bg-white/20 backdrop-blur-sm rounded-3xl shadow-lg">
                                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Brand Name -->
                            <h1 class="text-4xl font-bold text-white mb-4">Ara Cake</h1>
                            <p class="text-lg text-purple-100 mb-8 leading-relaxed">
                                Bergabunglah dengan komunitas pencinta kue terbaik! Dapatkan akses ke berbagai koleksi kue premium dan penawaran eksklusif.
                            </p>

                            <!-- Benefits -->
                            <div class="space-y-4">
                                <div class="flex items-center text-purple-100">
                                    <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span>Akun gratis selamanya</span>
                                </div>
                                <div class="flex items-center text-purple-100">
                                    <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span>Diskon khusus member</span>
                                </div>
                                <div class="flex items-center text-purple-100">
                                    <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span>Notifikasi produk terbaru</span>
                                </div>
                                <div class="flex items-center text-purple-100">
                                    <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span>Priority customer service</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Register Form -->
                    <div class="lg:w-3/5 p-12 flex flex-col justify-center">
                        <div class="max-w-2xl mx-auto w-full">
                            <!-- Form Header -->
                            <div class="text-center mb-8">
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
                                <p class="text-gray-600">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}" class="font-semibold text-purple-600 hover:text-purple-500 transition-colors">
                                        Masuk di sini
                                    </a>
                                </p>
                            </div>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700 font-medium">
                                                Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.

                                                <ul class="list-disc list-inside mt-2">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Register Form -->
                            <form class="space-y-6" action="{{ route('register-process') }}" method="POST">
                                @csrf

                                <!-- Personal Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Full Name -->
                                    <div>
                                        <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nama Lengkap *
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <input id="full_name" name="full_name" type="text" autocomplete="name" required
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="Nama lengkap" value="{{ old('full_name') }}">
                                        </div>
                                        @error('full_name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Username -->
                                    <div>
                                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Username
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                            </div>
                                            <input id="username" name="username" type="text" autocomplete="username"
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="username (opsional)" value="{{ old('username') }}">
                                        </div>
                                        @error('username')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Alamat Email *
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                                </svg>
                                            </div>
                                            <input id="email" name="email" type="email" autocomplete="email" required
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="email@contoh.com" value="{{ old('email') }}">
                                        </div>
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone Number -->
                                    <div>
                                        <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nomor Telepon
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                            </div>
                                            <input id="phone_number" name="phone_number" type="number" autocomplete="tel"
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="081234567890 (opsional)" value="{{ old('phone_number') }}">
                                        </div>
                                        @error('phone_number')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password Section -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Password *
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </div>
                                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="••••••••">
                                        </div>
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Konfirmasi Password *
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox" required
                                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded transition-colors">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="text-gray-700">
                                            Saya menyetujui
                                            <a href="#" class="font-semibold text-purple-600 hover:text-purple-500 underline transition-colors">
                                                Syarat & Ketentuan
                                            </a>
                                            dan
                                            <a href="#" class="font-semibold text-purple-600 hover:text-purple-500 underline transition-colors">
                                                Kebijakan Privasi
                                            </a>
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div>
                                    <button type="submit"
                                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform transition-all duration-200 hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-purple-300 group-hover:text-purple-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                            </svg>
                                        </span>
                                        Buat Akun Sekarang
                                    </button>
                                </div>
                            </form>

                            {{-- <!-- Alternative Registration -->
                            <div class="mt-8">
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-4 bg-white text-gray-500 font-medium">Atau daftar dengan</span>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-2 gap-3">
                                    <button type="button"
                                        class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                        </svg>
                                        <span class="ml-2">Google</span>
                                    </button>

                                    <button type="button"
                                        class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                        </svg>
                                        <span class="ml-2">Twitter</span>
                                    </button>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
