@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Profile Admin</h1>
                <p class="text-gray-600">Kelola informasi profil akun Anda</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">
                    {{ Auth::user()->role  }}
                </span>
            </div>
        </div>
    </div>

    <!-- Content -->
    <section class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Profil</h2>
                    
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="full_name" id="full_name" required
                                    value="{{ old('full_name', Auth::user()->full_name) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                    Username
                                </label>
                                <input type="text" name="username" id="username"
                                    value="{{ old('username', Auth::user()->username) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                                    placeholder="opsional">
                                @error('username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-600">*</span>
                                </label>
                                <input type="email" name="email" id="email" required
                                    value="{{ old('email', Auth::user()->email) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="md:col-span-2">
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <input type="tel" name="phone_number" id="phone_number"
                                    value="{{ old('phone_number', Auth::user()->phone_number) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                                    placeholder="+62 812 3456 7890">
                                @error('phone_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="bg-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Ubah Password</h2>
                    
                    <form action="{{ route('admin.change-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Saat Ini <span class="text-red-600">*</span>
                                </label>
                                <input type="password" name="current_password" id="current_password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Baru <span class="text-red-600">*</span>
                                </label>
                                <input type="password" name="new_password" id="new_password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                                @error('new_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password Baru <span class="text-red-600">*</span>
                                </label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="bg-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6 ">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center">
                            <span class="text-3xl font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->full_name, 0, 1)) }}
                            </span>
                        </div>

                        <!-- User Info -->
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ Auth::user()->full_name }}</h3>
                        <p class="text-gray-600 mb-1">{{ Auth::user()->email }}</p>
                        @if(Auth::user()->phone_number)
                            <p class="text-gray-600 mb-4">{{ Auth::user()->phone_number }}</p>
                        @endif

                    </div>
                </div>

                <!-- Account Status -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Status Akun</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                Aktif
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Terdaftar</span>
                            <span class="text-sm text-gray-800">{{ Auth::user()->created_at->format('d M Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Terakhir Login</span>
                            <span class="text-sm text-gray-800">{{ now()->format('d M Y H:i') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Email Terverifikasi</span>
                            <span class="text-sm {{ Auth::user()->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                                {{ Auth::user()->email_verified_at ? '✓' : '✗' }}
                            </span>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-red-800 mb-4">Zona Berbahaya</h3>
                        
                        <form action="{{ route('admin.profile.delete') }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-100 text-red-700 px-4 py-2 rounded-lg font-medium hover:bg-red-200 transition-colors text-center">
                                Hapus Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Form validation and feedback
    document.addEventListener('DOMContentLoaded', function() {
        // Add real-time validation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                        
                        field.addEventListener('input', function() {
                            this.classList.remove('border-red-500');
                        });
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi (*)');
                }
            });
        });

        // Phone number formatting
        const phoneInput = document.getElementById('phone_number');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    value = '+62' + value.substring(1);
                }
                e.target.value = value;
            });
        }
    });
</script>
@endsection