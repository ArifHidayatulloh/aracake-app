@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Kategori Produk']]" />

        <x-header-page.header-page title="Manajemen Kategori"
            description="Kelola berbagai kategori produk yang tersedia di toko Anda, termasuk penambahan, pengeditan, penghapusan, dan pengaturan status aktif/nonaktif kategori." />


        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Kategori Produk</h3>
            <x-button.link-primary href="{{ route('admin.category.create') }}">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
                Produk
            </x-button.link-primary>
        </div>

        {{-- FILTER SECTION --}}
        <div class="bg-white border-b shadow-sm p-4 border border-gray-100 mb-6">
            <form action="{{ route('admin.category.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                {{-- Search Input --}}
                <div class="flex-grow">
                    <label for="search" value="Cari Kategori" class="sr-only" >Cari Kategori</label>
                    <x-form.input
                        id="search"
                        type="text"
                        name="search"
                        placeholder="Cari berdasarkan nama..."
                        value="{{ request('search') }}"
                        class="w-full mb-0"
                    />
                </div>

                {{-- Status Filter (Aktif/Tidak Aktif) --}}
                <div class="mb-4">
                    <label for="is_active" value="Status" class="sr-only">Status</label>
                    <select id="is_active" name="is_active"
                        class=" block w-full px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm bg-white/50">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                {{-- Submit Button --}}
                <div class="mb-4">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Filter
                    </button>
                </div>

                {{-- Clear Filter Button (Optional but Recommended) --}}
                @if (request('search') || !is_null(request('is_active')))
                    <div class="mb-4">
                        <a href="{{ route('admin.category.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Bersihkan
                        </a>
                    </div>
                @endif
            </form>
        </div>
        {{-- END FILTER SECTION --}}

        {{-- Table Kategori Produk --}}
        @php
            $headers = ['Nama', 'Deskripsi', 'Gambar', 'Status', 'Aksi'];
        @endphp

        <x-table.table :headers="$headers" :pagination="$categories->links()">
            @forelse ($categories as $category)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $category->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ Str::limit($category->description, 50, '...') }} {{-- Limit description for table --}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                class="w-16 h-16 object-cover rounded">
                        @else
                            <div
                                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                N/A</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($category->is_active)
                            <x-badge.badge-success>Aktif</x-badge.badge-success>
                        @else
                            <x-badge.badge-danger>Tidak Aktif</x-badge.badge-danger>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('admin.category.edit', $category->slug) }}"
                            class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        {{-- Tambahkan tombol delete jika diperlukan, menggunakan form atau Alpine.js modal --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada
                        kategori produk ditemukan.</td>
                </tr>
            @endforelse
        </x-table.table>
    </div>
@endsection
