  <!-- Enhanced Navigation -->
  <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg shadow-lg border-b border-purple-100/20">
      <div class="container mx-auto px-6 py-4">
          <div class="flex justify-between items-center">
              <a href="#" class="flex items-center space-x-3 group">
                  <div class="relative">
                      <div
                          class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                          <span class="relative z-10">AC</span>
                          <div
                              class="absolute inset-0 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 opacity-0 group-hover:opacity-30 blur-md transition-all duration-300">
                          </div>
                      </div>
                      <div
                          class="absolute -top-1 -right-1 w-3 h-3 bg-pink-400 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 animate-pulse">
                      </div>
                  </div>
                  <div class="flex flex-col">
                      <span
                          class="text-2xl font-bold bg-gradient-to-r from-purple-600 via-purple-700 to-pink-600 bg-clip-text text-transparent">
                          Ara Cake
                      </span>
                      <span
                          class="text-xs text-gray-500 -mt-1 opacity-0 group-hover:opacity-100 transition-all duration-300">
                          Premium Cakes
                      </span>
                  </div>
              </a>

              <div class="hidden md:flex items-center space-x-1">
                  <a href="{{ route('home') }}"
                      class="relative px-4 py-2 font-medium text-gray-700 hover:text-purple-600 transition-all duration-300 rounded-lg group">
                      <span class="relative z-10">Beranda</span>
                      <div
                          class="absolute inset-0 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                      </div>
                  </a>
                  <a href="{{ route('product') }}"
                      class="relative px-4 py-2 font-medium text-gray-700 hover:text-purple-600 transition-all duration-300 rounded-lg group">
                      <span class="relative z-10">Produk</span>
                      <div
                          class="absolute inset-0 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                      </div>
                  </a>
                  <a href="#"
                      class="relative px-4 py-2 font-medium text-gray-700 hover:text-purple-600 transition-all duration-300 rounded-lg group">
                      <span class="relative z-10">Tentang</span>
                      <div
                          class="absolute inset-0 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                      </div>
                  </a>
                  <a href="#"
                      class="relative px-4 py-2 font-medium text-gray-700 hover:text-purple-600 transition-all duration-300 rounded-lg group">
                      <span class="relative z-10">Kontak</span>
                      <div
                          class="absolute inset-0 bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                      </div>
                  </a>
              </div>

              <div class="flex items-center space-x-3" x-data="{ open: false }">
                  @if (Auth::check())
                      <a href="{{ route('cart') }}"
                          class="relative p-2 text-gray-700 hover:text-purple-600 transition-all duration-300 rounded-lg hover:bg-purple-50 group">
                          <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none"
                              stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5M7 13l-1.1 5m0 0h11.4M6 18a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4z">
                              </path>
                          </svg>
                          <span
                              class="absolute -top-2 -right-2 w-5 h-5 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ Auth::user()->cart?->items->count() ?? 0 }}
                          </span>
                      </a>
                  @endif

                  @if (Auth::check())
                      <!-- User Button with Dropdown -->
                      <div class="relative">
                          <button @click="open = !open"
                              class="p-2 text-gray-700 hover:text-purple-600 transition-all duration-300 rounded-lg hover:bg-purple-50 focus:outline-none flex gap-1">
                              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                              </svg>
                              {{ Str::limit(Auth::user()->username, 10, '...') }}
                              <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"></path>
                              </svg>
                            </button>

                          <!-- Dropdown Menu -->
                          <div x-show="open" @click.away="open = false"
                              x-transition:enter="transition ease-out duration-100"
                              x-transition:enter-start="transform opacity-0 scale-95"
                              x-transition:enter-end="transform opacity-100 scale-100"
                              x-transition:leave="transition ease-in duration-75"
                              x-transition:leave-start="transform opacity-100 scale-100"
                              x-transition:leave-end="transform opacity-0 scale-95"
                              class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                              {{-- <a href="#"
                                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600">Profil
                                  Saya</a> --}}
                              <a href="{{ route('customer.order.my-order') }}"
                                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600">Pesanan
                                  Saya</a>
                              <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                  <button type="submit"
                                      class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                      Keluar
                                  </button>
                              </form>
                          @else
                              <a href="{{ route('login') }}"
                                  class="relative px-4 py-2 font-medium font-bold bg-gradient-to-r from-purple-600 via-purple-700 to-pink-600 bg-clip-text text-transparent">
                                  Masuk
                                  <span class="float-right ml-1"><i class="fa-solid fa-right-to-bracket"></i> </span>
                              </a>
                  @endif
              </div>
          </div>
      </div>
  </nav>
