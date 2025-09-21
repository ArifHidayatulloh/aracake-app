@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Produk']]" />
        <x-header-page.header-page title="Manajemen Produk" description="Kelola semua produk yang tersedia di toko Anda." />

        <div class="p-6 bg-white border rounded-lg shadow-sm border-purple-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Daftar Produk</h3>
                <x-button.link-primary href="{{ route('admin.product.create') }}">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Produk
                </x-button.link-primary>
            </div>

            {{-- FILTER & SEARCH SECTION --}}
            <form action="{{ route('admin.product.index') }}" method="GET" class="pb-4 mb-4 border-b">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <x-form.input name="search" placeholder="Cari Nama/SKU..." value="{{ request('search') }}" />
                    <x-form.select2 name="category" label='' :options="$categories
                        ->map(fn($cat) => ['id' => $cat->id, 'name' => $cat->name])
                        ->prepend(['id' => '', 'name' => 'Semua Kategori'])" id="category" :selected="request('category')"
                        {{-- Menggunakan request('category') untuk nilai terpilih --}} placeholder="Pilih Kategori" {{-- Pastikan ini ada! --}} />
                    <x-form.select name="is_active" :options="[['id' => '1', 'name' => 'Aktif'], ['id' => '0', 'name' => 'Tidak Aktif']]" placeholder="Semua Status"
                        selected="{{ request('is_active') }}" />
                    <x-form.select name="is_available" :options="[['id' => '1', 'name' => 'Tersedia'], ['id' => '0', 'name' => 'Tidak Tersedia']]" placeholder="Ketersediaan"
                        selected="{{ request('is_available') }}" />
                </div>
                <div class="flex items-center justify-end mt-4 space-x-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white uppercase bg-purple-600 rounded-md hover:bg-purple-700">Filter</button>
                    <a href="{{ route('admin.product.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-md hover:bg-gray-300">Reset</a>
                </div>
            </form>

            {{-- TABLE PRODUCT --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Produk</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Kategori</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Harga
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Atribut</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr>
                                <td class="flex items-center px-6 py-4 whitespace-nowrap">
                                    @if (!$product->image_url)
                                        <div class="w-12 h-12 mr-4 bg-gray-100 rounded flex items-center justify-center">
                                            <i class="fa-solid fa-image text-gray-300"></i>
                                        </div>
                                    @else
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                            class="w-12 h-12 mr-4 object-cover rounded">
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $product->category->name }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800 whitespace-nowrap">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.product.toggleStatus', $product->slug) }}"
                                        method="POST">
                                        @csrf @method('PATCH') <input type="hidden" name="field" value="is_active">
                                        <button type="submit"
                                            class="text-xs font-semibold rounded-full px-2 py-1 {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <x-badge.badge-info :is-active="$product->is_available">Tersedia</x-badge.badge-info>
                                        <x-badge.badge-info :is-active="$product->is_recommended">Rekomendasi</x-badge.badge-info>
                                        <x-badge.badge-info :is-active="$product->is_featured">Unggulan</x-badge.badge-info>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end space-x-4">
                                        <a href="{{ route('admin.product.edit', $product->slug) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('admin.product.destroy', $product->slug) }}" method="POST"
                                            onsubmit="return confirm('Anda yakin ingin menghapus produk ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                    Tidak ada produk ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $products->links() }}</div>
        </div>
    </div>
@endsection
