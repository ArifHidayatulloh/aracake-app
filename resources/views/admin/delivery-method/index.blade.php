@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Metode Pengiriman', 'url' => route('admin.delivery-method.index')],
        ]" />

        <x-header-page.header-page title="Manajemen Metode Pengiriman"
            description="Kelola berbagai metode pengiriman yang tersedia di toko Anda, termasuk penambahan, pengeditan, penghapusan, dan pengaturan status aktif/nonaktif metode pengiriman." />

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Metode Pengiriman</h3>
            <x-button.link-primary href="{{ route('admin.delivery-method.create') }}">
                <x-heroicon-o-plus class="w-5 h-5 mr-2" /> Tambah Metode
                Pengiriman
            </x-button.link-primary>
        </div>

        {{-- Table delivery-method --}}
        @php
            $headers = ['Nama Metode', 'Deskripsi', 'Biaya Dasar', 'Biaya per KM', 'Tipe', 'Status', 'Aksi'];
        @endphp
        <x-table.table :headers="$headers" :pagination="$deliveryMethods->links()">
            @forelse ($deliveryMethods as $deliveryMethod)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $deliveryMethod->method_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $deliveryMethod->description }} </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $deliveryMethod->base_cost }} </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $deliveryMethod->cost_per_km }} </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($deliveryMethod->is_pickup)
                            <x-badge.badge-primary>Pickup</x-badge.badge-primary>
                        @else
                            <x-badge.badge-primary>Delivery</x-badge.badge-primary>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($deliveryMethod->is_active)
                            <x-badge.badge-success>Aktif</x-badge.badge-success>
                        @else
                            <x-badge.badge-danger>Tidak Aktif</x-badge.badge-danger>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('admin.delivery-method.edit', $deliveryMethod->id) }}"
                            class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada
                        metode pengiriman ditemukan.</td>
                </tr>
            @endforelse
        </x-table.table>
    </div>
@endsection
