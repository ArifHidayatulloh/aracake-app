@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <x-breadcrumb.breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Metode Pembayaran', 'url' => route('admin.payment-method.index')],
    ]" />

    <x-header-page.header-page title="Manajemen Metode Pembayaran"
        description="Kelola berbagai metode pembayaran yang tersedia di toko Anda, termasuk penambahan, pengeditan, penghapusan, dan pengaturan status aktif/nonaktif metode pembayaran." />

    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-800">Metode Pembayaran</h3>
        <x-button.link-primary href="{{ route('admin.payment-method.create') }}">
            <x-heroicon-o-plus class="w-5 h-5 mr-2" /> Tambah Metode
            Pembayaran
        </x-button.link-primary>
    </div>

    {{-- Table payment-method --}}
    @php
        $headers = ['Nama Metode','Nomor Akun', 'Detail Akun', 'Status', 'Aksi'];
    @endphp

    <x-table.table :headers="$headers" :pagination="$paymentMethods->links()">
        @forelse ($paymentMethods as $paymentMethod)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $paymentMethod->method_name }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $paymentMethod->account_number }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $paymentMethod->account_details }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    @if ($paymentMethod->is_active)
                        <x-badge.badge-success>Aktif</x-badge.badge-success>
                    @else
                        <x-badge.badge-danger>Tidak Aktif</x-badge.badge-danger>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('admin.payment-method.edit', $paymentMethod->id) }}"
                            class="text-yellow-600 hover:text-yellow-900">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada
                    metode pembayaran ditemukan.</td>
            </tr>
        @endforelse
    </x-table.table>
</div>
@endsection
