@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Pengaturan Sistem', 'url' => route('admin.system-setting.index')],
        ]" />

        <x-header-page.header-page title="Pengaturan Sistem" description="Kelola pengaturan sistem toko Anda." />

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Pengaturan Sistem</h3>
            <x-button.link-primary href="{{ route('admin.system-setting.create') }}">
                <x-heroicon-o-plus class="w-5 h-5 mr-2" /> Tambah Pengaturan
            </x-button.link-primary>
        </div>

        {{-- Table system-setting --}}
        @php
            $headers = ['Nama Pengaturan', 'Nilai', 'Deskripsi', 'Status', 'Aksi'];
        @endphp

        <x-table.table :headers="$headers">
            @forelse ($systemSettings as $systemSetting)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm" title="{{ $systemSetting->setting_key }}">
                        {{ $systemSetting->setting_key }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm" title="{{ $systemSetting->setting_value }}">
                        {{ Str::limit($systemSetting->setting_value, 50, '...') }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm" title="{{ $systemSetting->description }}">
                        {{ Str::limit($systemSetting->description, 50, '...') ?? '' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if ($systemSetting->is_active)
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Tidak Aktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.system-setting.edit', $systemSetting->id) }}" class="text-yellow-600 hover:text-yellow-900">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada
                        pengaturan sistem ditemukan.</td>
                </tr>
            @endforelse
        </x-table.table>
    </div>
@endsection
