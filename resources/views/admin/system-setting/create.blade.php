@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Pengaturan Sistem', 'url' => route('admin.system-setting.index')],
            ['label' => 'Tambah Pengaturan Sistem'],
        ]" />

        <x-header-page.header-page title="Tambah Pengaturan Sistem" description="Buat pengaturan sistem baru di toko Anda." />


        <x-form.card>
            <form action="{{ route('admin.system-setting.store') }}" method="POST">
                @csrf
                <x-form.input typ="text" name="setting_key" label="Nama Pengaturan" error="$errors->first('setting_name')"
                    required />

                <x-form.input typ="text" name="setting_value" label="Nilai Pengaturan"
                    error="$errors->first('setting_value')" required />

                <x-form.textarea name="description" label="Deskripsi Pengaturan" error="$errors->first('description')"
                    rows="4" />

                    <div id="setting_value_container"></div>

                {{-- Select option type --}}
                @php
                    $options = [
                        ['id' => 'string', 'name' => 'Teks (String)'],
                        ['id' => 'int', 'name' => 'Angka (Integer)'],
                        ['id' => 'decimal', 'name' => 'Desimal'],
                        ['id' => 'boolean', 'name' => 'Ya / Tidak (Boolean)'],
                        ['id' => 'json', 'name' => 'Data JSON'],
                    ];
                @endphp

                <x-form.select name="type" id="type_selector" label="Tipe Pengaturan" :options="$options"
    :selected="old('type', $systemSetting->type ?? null)" required />

                <x-form.toggle class="mb-5" name="is_active" label="Pengaturan Aktif" :checked="old('is_active', true)"
                    error="$errors->first('is_active')" />

                <x-form.footer :cancel-url="route('admin.system-setting.index')" submit-label="Simpan Pengaturan Sistem" />
            </form>
        </x-form.card>
    </div>
@endsection



