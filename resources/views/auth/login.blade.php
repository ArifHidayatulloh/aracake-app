@extends('layouts.auth', ['title' => 'Masuk'])

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left Side - Logo Section -->
                    <div
                        class="lg:w-1/2 bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 p-12 flex flex-col justify-center items-center relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div
                                class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-20 -translate-y-20">
                            </div>
                            <div
                                class="absolute bottom-0 right-0 w-32 h-32 bg-white rounded-full translate-x-16 translate-y-16">
                            </div>
                            <div class="absolute top-1/2 left-1/4 w-24 h-24 bg-white rounded-full opacity-50"></div>
                        </div>

                        <!-- Logo Content -->
                        <div class="relative z-10 text-center">
                            <!-- Main Logo -->
                            <div class="mb-8">
                                <div class="inline-flex p-6 bg-white/20 backdrop-blur-sm rounded-3xl shadow-lg">
                                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Brand Name -->
                            <h1 class="text-4xl font-bold text-white mb-4">Ara Cake</h1>
                            <p class="text-lg text-purple-100 mb-8 leading-relaxed">
                                Selamat datang kembali! Nikmati pengalaman berbelanja kue terbaik dengan berbagai pilihan
                                rasa yang menggugah selera.
                            </p>

                            <!-- Features -->
                            <div class="space-y-4">
                                <div class="flex items-center text-purple-100">
                                    <svg class="w-5 h-5 mr-3 text-purple-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Kue berkualitas premium</span>
                                </div>
                                <div class="flex items-center text-purple-100">
                                    <svg class="w-5 h-5 mr-3 text-purple-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Pengiriman cepat & aman</span>
                                </div>
                                <div class="flex items-center text-purple-100">
                                    <svg class="w-5 h-5 mr-3 text-purple-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Custom design sesuai keinginan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="lg:w-1/2 p-12 flex flex-col justify-center">
                        <div class="max-w-md mx-auto w-full">
                            <!-- Form Header -->
                            <div class="text-center mb-8">
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">Masuk ke Akun</h2>
                                <p class="text-gray-600">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}"
                                        class="font-semibold text-purple-600 hover:text-purple-500 transition-colors">
                                        Daftar di sini
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
                                                Email atau password yang Anda masukkan salah.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (session('error'))
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
                                                Email atau password yang Anda masukkan salah.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Login Form -->
                            <form class="space-y-6" action="{{ route('login-action') }}" method="POST">
                                @csrf

                                <!-- Email Field -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alamat Email
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                                </path>
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

                                <!-- Password Field -->
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input id="password" name="password" type="password"
                                            autocomplete="current-password" required
                                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                            placeholder="••••••••">
                                    </div>
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remember & Forgot Password -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input id="remember-me" name="remember" type="checkbox"
                                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded transition-colors">
                                        <label for="remember-me" class="ml-2 block text-sm text-gray-700 font-medium">
                                            Ingat saya
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div>
                                    <button type="submit"
                                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform transition-all duration-200 hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-purple-300 group-hover:text-purple-200 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                        </span>
                                        Masuk ke Akun
                                    </button>
                                </div>
                            </form>

                            {{-- <!-- Social Login (Optional) -->
                            <div class="mt-8">
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-4 bg-white text-gray-500 font-medium">Atau masuk dengan</span>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-2 gap-3">
                                    <button type="button"
                                        class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                                fill="#4285F4" />
                                            <path
                                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                                fill="#34A853" />
                                            <path
                                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                                fill="#FBBC05" />
                                            <path
                                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                                fill="#EA4335" />
                                        </svg>
                                        <span class="ml-2">Google</span>
                                    </button>

                                    <button type="button"
                                        class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
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
