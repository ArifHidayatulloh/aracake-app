<aside
    class="
        fixed inset-y-0 left-0 z-40 w-64
        bg-gradient-to-b from-purple-800 to-purple-900 text-white
        flex-shrink-0 flex flex-col
        transform transition-transform ease-in-out duration-300
        md:relative md:translate-x-0 rounded-tr-2xl rounded-br-2xl
    "
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" x-cloak>
    <div class="p-5 flex-shrink-0">
        <h1 class="text-2xl font-bold flex items-center space-x-3">
            <div class="p-2 bg-white/10 rounded-lg backdrop-blur-sm">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <span class="bg-gradient-to-r from-purple-200 to-white bg-clip-text text-transparent">Ara Cake</span>
        </h1>
    </div>

    <nav
        class="mt-2 px-2 flex-grow overflow-y-auto
                scrollbar scrollbar-thumb-purple-500 scrollbar-track-purple-950 scrollbar-w-2 scrollbar-thumb-rounded-full
                hover:scrollbar-thumb-purple-400">
        <div class="px-4 py-2 text-xs font-semibold text-purple-300 uppercase tracking-wider">
            Main Menu
        </div>
        <ul class="space-y-1">
            <li>
                <a href="/"
                    class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-white/5 text-purple-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/5' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
                        </path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="" {{-- Asumsi route untuk daftar pesanan --}}
                    class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-white/5 text-purple-200 {{ request()->routeIs('admin.orders.*') ? 'bg-white/5' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
                        </path>
                    </svg>
                    Pesanan
                    <span class="ml-auto px-2 py-0.5 bg-purple-600/30 text-xs rounded-full">15</span>
                </a>
            </li>

        </ul>

        {{-- PRODUCT & CATEGORY --}}
        <div class="px-4 py-2 text-xs font-semibold text-purple-300 uppercase tracking-wider">
            PRODUK
        </div>
        <ul class="space-y-1">
            <li>
                <a href="/"
                    class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-white/5 text-purple-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/5' : '' }}">
                    <x-heroicon-o-cube class="w-5 h-5 mr-3" />
                    Produk
                </a>
            </li>
            <li>
                <a href="{{ route('admin.category.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-white/5 text-purple-200 {{ request()->routeIs('admin.category.*') ? 'bg-white/5' : '' }}">
                    <x-heroicon-o-tag class="w-5 h-5 mr-3" />
                    Kategori
                </a>
            </li>

        </ul>


        <div class="px-4 py-2 mt-8 text-xs font-semibold text-purple-300 uppercase tracking-wider">
            Lainnya
        </div>
        <ul class="space-y-1">
            <li>
                <a href="{{ route('admin.order-status.index') }}" {{-- Asumsi route untuk pengaturan sistem --}}
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-white/5 text-purple-200 transition-colors {{ request()->routeIs('admin.order-status.*') ? 'bg-white/5' : '' }}">
                    <x-heroicon-o-clipboard-document-check class="w-5 h-5 mr-3" />
                    Status Order
                </a>
            </li>
            <li>
                <a href="{{ route('admin.delivery-method.index') }}" {{-- Asumsi route untuk pengaturan sistem --}}
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-white/5 text-purple-200 transition-colors {{ request()->routeIs('admin.delivery-method.*') ? 'bg-white/5' : '' }}">
                    <x-heroicon-o-truck class="w-5 h-5 mr-3" />
                    Metode Pengiriman
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payment-method.index') }}" {{-- Asumsi route untuk pengaturan sistem --}}
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-white/5 text-purple-200 transition-colors {{ request()->routeIs('admin.payment-method.*') ? 'bg-white/5' : '' }}">
                    <x-heroicon-o-credit-card class="w-5 h-5 mr-3" />
                    Metode Pembayaran
                </a>
            </li>
            <li>
                <a href="{{ route('working-hour.index') }}" {{-- Asumsi route untuk pengaturan sistem --}}
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-white/5 text-purple-200 transition-colors {{ request()->routeIs('admin.working-hour.*') ? 'bg-white/5' : '' }}">
                    <x-heroicon-o-clock class="w-5 h-5 mr-3" />
                    Pengaturan Jam Kerja
                </a>
            </li>
            <li>
                <a href="{{ route('admin.system-setting.index') }}" {{-- Asumsi route untuk pengaturan sistem --}}
                    class="flex items-center px-4 py-3 rounded-lg hover:bg-white/5 text-purple-200 transition-colors {{ request()->routeIs('admin.system-setting.*') ? 'bg-white/5' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a6.932 6.932 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.240.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                    </svg>
                    Pengaturan Sistem
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-4 bg-white/5 backdrop-blur-sm border-t border-purple-700/30 flex-shrink-0 rounded-br-2xl">
        <div class="flex items-center space-x-3">
            <div
                class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white shadow-md">
                A
            </div>
            <div>
                <p class="text-sm font-medium text-white">
                    Administrator
                </p>
                <p class="text-xs text-purple-300">Admin</p>
            </div>
        </div>
    </div>
</aside>
