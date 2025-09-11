<!-- Header -->
<header class="bg-white/90 backdrop-blur-sm border-b border-purple-100 shadow-sm flex-shrink-0">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Mobile Menu Button -->
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-purple-600 focus:outline-none">
            <!-- Bars Icon -->
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>
        </button>

        <div class="flex-1 max-w-md mx-4">
            <div class="relative">
                {{-- Dynamic greeting based on time --}}
                @php
                    $hour = now()->hour;
                    if ($hour < 12) {
                        $greeting = 'Pagi';
                    } elseif ($hour < 15) {
                        $greeting = 'Siang';
                    } elseif ($hour < 18) {
                        $greeting = 'Sore';
                    } else {
                        $greeting = 'Malam';
                    }
                @endphp

                <div class="text-lg font-medium text-purple-600">
                    Selamat {{ $greeting }}, {{ Auth::user()->full_name ?? 'Admin' }}!
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-4 relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none group">
                <div
                    class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white shadow-md">
                    {{ strtoupper(substr(Auth::user()->full_name ?? 'A', 0, 1)) }}
                </div>
                <span class="hidden md:inline text-gray-700 group-hover:text-purple-600 transition-colors">
                    {{ Auth::user()->full_name ?? 'Admin' }}
                </span>
                <!-- Chevron Down Icon -->
                <svg class="w-4 h-4 text-gray-500 group-hover:text-purple-600 transition-colors" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2  w-56 bg-white/95 backdrop-blur-sm rounded-lg shadow-xl z-10 border border-purple-100 overflow-hidden"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <div class="py-1">
                    <a href="{{ route('admin.profile') }}"
                        class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-colors flex items-center">
                        <!-- User Icon -->
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z">
                            </path>
                        </svg>
                        Profile
                    </a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-colors flex items-center">
                            <!-- Logout Icon -->
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15">
                                </path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
