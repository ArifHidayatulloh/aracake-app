@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Kategori Produk']]" />
        <x-header-page.header-page title="Manajemen Kategori"
            description="Kelola berbagai kategori produk yang tersedia di toko Anda." />

        <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Daftar Kategori</h3>
                <x-button.link-primary href="{{ route('admin.category.create') }}">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
                </x-button.link-primary>
            </div>

            {{-- FILTER SECTION --}}
            <form action="{{ route('admin.category.index') }}" method="GET"
                class="flex flex-wrap items-center gap-4 pb-4 border-b">
                {{-- Search Input --}}
                <div class="flex-grow mt-2">
                    <label for="search" class="sr-only">Cari Kategori</label>
                    <x-form.input id="search" type="text" name="search" placeholder="Cari berdasarkan nama..."
                        value="{{ request('search') }}"
                        class="h-10 block w-full px-4 border rounded-md shadow-sm sm:text-sm border-purple-200 bg-white/50 focus:outline-none focus:ring-purple-500 focus:border-purple-500" />
                </div>

                {{-- Status Filter --}}
                <div>
                    <label for="is_active" class="sr-only">Status</label>
                    <select id="is_active" name="is_active"
                        class="h-10 block w-full px-4 border rounded-md shadow-sm sm:text-sm border-purple-200 bg-white/50 focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Semua Status</option>
                        <option value="1" @selected(request('is_active') == '1')>Aktif</option>
                        <option value="0" @selected(request('is_active') == '0')>Tidak Aktif</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center space-x-2">
                    <button type="submit"
                        class="h-10 inline-flex items-center justify-center px-4 text-xs font-semibold text-white uppercase transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                        Filter
                    </button>
                    @if (request('search') || request()->filled('is_active'))
                        <a href="{{ route('admin.category.index') }}"
                            class="h-10 inline-flex items-center justify-center px-4 text-xs font-semibold text-gray-700 uppercase transition duration-150 ease-in-out bg-gray-200 border border-transparent rounded-md hover:bg-gray-300">
                            Reset
                        </a>
                    @endif
                </div>
            </form>


            {{-- Table Kategori Produk --}}
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama
                                Kategori</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Jumlah Produk</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="flex items-center px-6 py-4 whitespace-nowrap">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                            class="w-10 h-10 mr-4 object-cover rounded">
                                    @else
                                        <div
                                            class="flex items-center justify-center w-10 h-10 mr-4 text-xs text-gray-500 bg-gray-200 rounded">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($category->description, 40) }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    <span
                                        class="font-bold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">{{ $category->products_count }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- NEW: Toggle Switch --}}
                                    <form action="{{ route('admin.category.toggleStatus', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="relative inline-flex items-center h-6 rounded-full w-11 {{ $category->is_active ? 'bg-purple-600' : 'bg-gray-200' }}">
                                            <span class="sr-only">Ubah Status</span>
                                            <span
                                                class="inline-block w-4 h-4 transform bg-white rounded-full transition {{ $category->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end space-x-4">
                                        <a href="{{ route('admin.category.edit', $category->slug) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        {{-- NEW: Delete Button with Confirmation --}}
                                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat diurungkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                    Tidak ada kategori produk ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $categories->links() }}</div>
        </div>
    </div>
@endsection
