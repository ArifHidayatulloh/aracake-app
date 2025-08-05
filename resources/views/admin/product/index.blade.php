@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Produk', 'url' => route('admin.product.index')],
        ]" />

        <x-header-page.header-page title="Manajemen Produk" description="Kelola produk di toko Anda." />

        <div class="flex justify-between items-center mb-6"> {{-- Tambah margin-bottom --}}
            <h3 class="text-2xl font-bold text-gray-800">Daftar Produk</h3> {{-- Ubah judul sedikit --}}
            <x-button.link-primary href="{{ route('admin.product.create') }}">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Produk
            </x-button.link-primary>
        </div>

        {{-- FILTER & SEARCH SECTION --}}
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-700 mb-4">Filter Produk</h4>
            <form action="{{ route('admin.product.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 items-end">
                    {{-- Kategori Filter --}}
                    <x-form.select2 name="category" label="Kategori" :options="$categories
                        ->map(fn($cat) => ['id' => $cat->id, 'name' => $cat->name])
                        ->prepend(['id' => '', 'name' => 'Semua Kategori'])" id="category" :selected="request('category')"
                        {{-- Menggunakan request('category') untuk nilai terpilih --}} placeholder="Pilih Kategori" {{-- Pastikan ini ada! --}} />

                    {{-- Status Filter --}}
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                        <select name="is_active" id="is_active"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    {{-- Rekomendasi Filter --}}
                    <div>
                        <label for="is_recommended"
                            class="block text-sm font-medium text-gray-700 mb-1">Rekomendasi:</label>
                        <select name="is_recommended" id="is_recommended"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            <option value="">Semua Rekomendasi</option>
                            <option value="1" {{ request('is_recommended') == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ request('is_recommended') == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    {{-- Preorder Filter --}}
                    <div>
                        <label for="is_preorder" class="block text-sm font-medium text-gray-700 mb-1">Preorder:</label>
                        <select name="is_preorder" id="is_preorder"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            <option value="">Semua Preorder</option>
                            <option value="1" {{ request('is_preorder') == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ request('is_preorder') == '0' ? 'selected' : '' }}>Tidak</option>
                            </option>
                        </select>
                    </div>

                    {{-- Preorder Hanya Filter --}}
                    <div>
                        <label for="is_preorder_only" class="block text-sm font-medium text-gray-700 mb-1">Hanya
                            Preorder:</label>
                        <select name="is_preorder_only" id="is_preorder_only"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            <option value="">Semua</option>
                            <option value="1" {{ request('is_preorder_only') == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ request('is_preorder_only') == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    {{-- Tersedia Filter --}}
                    <div>
                        <label for="is_available" class="block text-sm font-medium text-gray-700 mb-1">Tersedia:</label>
                        <select name="is_available" id="is_available"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            <option value="">Semua</option>
                            <option value="1" {{ request('is_available') == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ request('is_available') == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    {{-- Search Input --}}
                    <div class="md:col-span-2 lg:col-span-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Produk:</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Cari berdasarkan nama..."
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="col-span-full xl:col-span-1 flex justify-end xl:justify-start items-center pt-4 md:pt-0 gap-1">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('admin.product.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"> Reset</a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table product --}}
        @php
            $headers = [
                'Gambar',
                'Nama',
                'Kategori',
                'Harga',
                'Tersedia',
                'Preorder', // Kolom ini seharusnya untuk is_preorder_only jika memang itu yang dimaksud
                'Rekomendasi',
                'Fitur',
                'Status',
                'Aksi',
            ];
        @endphp

        <x-table.table :headers="$headers" :pagination="$products->links()">
            @forelse ($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-16 h-16 object-cover rounded">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $product->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $product->category->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if ($product->is_available)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ya</span>
                        @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak</span>
                        @endif
                    </td>
                    {{-- Kolom Preorder (is_preorder_only) --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if ($product->is_preorder_only)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Ya</span>
                        @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak</span>
                        @endif
                    </td>
                    {{-- Hapus duplikasi kolom 'Preorder Hanya' --}}
                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $product->is_preorder_only ? 'Ya' : 'Tidak' }}
                    </td> --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if ($product->is_recommended)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Ya</span>
                        @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if ($product->is_featured)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Ya</span>
                        @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if ($product->is_active)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                        @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak
                                Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.product.show', $product->slug) }}"
                            class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Detail
                        </a>
                        <a href="{{ route('admin.product.edit', $product->slug) }}"
                            class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Edit
                        </a>
                        {{-- Form untuk Delete --}}
                        <form action="" method="POST" class="inline-block"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada
                        produk ditemukan.</td>
                </tr>
            @endforelse
        </x-table.table>
    </div>
@endsection
