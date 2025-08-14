@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Status Pesanan']]" />

        <x-header-page.header-page title="Manajemen Status Pesanan"
            description="Kelola berbagai status pesanan yang tersedia di toko Anda, termasuk penambahan, pengeditan, penghapusan, dan pengaturan status aktif/nonaktif status pesanan." />

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Status Pesanan</h3>
            {{-- <x-button.link-primary href="{{ route('admin.order-status.create') }}">
                <x-heroicon-o-plus class="w-5 h-5 mr-2" /> Tambah Status
                Pesanan
            </x-button.link-primary> --}}
        </div>

        {{-- Table order-status --}}
        @php
            $headers = ['Nama Status','Urutan','Deskripsi','Warna', 'Status', 'Aksi'];
        @endphp

        <x-table.table :headers="$headers" :pagination="$orderStatuses->links()">
            @forelse ($orderStatuses as $orderStatus)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $orderStatus->status_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $orderStatus->order }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $orderStatus->description }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                        <div class="status-color w-4 h-4 rounded-md"
                            style="background-color: {{ $orderStatus->status_color ?? '#FFFFFF' }};"
                            title="{{ $orderStatus->status_name }}"
                        ></div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if ($orderStatus->is_active)
                            <x-badge.badge-success>Aktif</x-badge.badge-success>
                        @else
                            <x-badge.badge-danger>Tidak Aktif</x-badge.badge-danger>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('admin.order-status.edit', $orderStatus->id) }}"
                            class="text-yellow-600 hover:text-yellow-900">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada
                        status pesanan ditemukan.</td>
                </tr>
            @endforelse
        </x-table.table>
    </div>
@endsection
