@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Pengaturan Sistem', 'url' => route('admin.system-setting.index')],
            ['label' => 'Edit Pengaturan Sistem'],
        ]" />

        <x-header-page.header-page title="Edit Pengaturan Sistem" description="Ubah informasi pengaturan sistem." />

        <x-form.card>
            <form action="{{ route('admin.system-setting.update', $systemSetting->id) }}" method="POST">
                @csrf
                @method('PUT')

                <x-form.input typ="text" name="setting_key" label="Nama Pengaturan" error="$errors->first('setting_key')"
                    value="{{ $systemSetting->setting_key }}" required readonly  class="!bg-gray-100"/>

                <x-form.input typ="text" name="setting_value" label="Nilai Pengaturan"
                    error="$errors->first('setting_value')" value="{{ $systemSetting->setting_value }}" required />

                <x-form.textarea name="description" label="Deskripsi Pengaturan" error="$errors->first('description')"
                    rows="4" value="{{ $systemSetting->description }}" readonly class="!bg-gray-100"/>

                <input name="type" value="{{ $systemSetting->type }}" readonly class="!bg-gray-100" hidden/>
                <x-form.toggle class="mb-5" name="is_active" label="Pengaturan Aktif" :checked="old('is_active', $systemSetting->is_active)"
                    error="$errors->first('is_active')" />

                <x-form.footer :cancel-url="route('admin.system-setting.index')" submit-label="Simpan Pengaturan Sistem" />
            </form>
        </x-form.card>
    </div>
@endsection
