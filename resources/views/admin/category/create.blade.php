@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Kategori Produk', 'url' => route('admin.category.index')],
            ['label' => 'Tambah Kategori Produk'],
        ]" />

        <x-header-page.header-page title="Tambah Kategori Produk" description="Buat kategori produk baru di toko Anda." />

        <x-form.card>
            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-form.input typ="text" name="name" label="Nama Kategori" error="$errors->first('name')" required />

                <x-form.textarea name="description" label="Deskripsi Kategori" error="$errors->first('description')"
                    rows="4" />

                <x-form.toggle class="mb-5" name="is_active" label="Kategori Aktif" :checked="old('is_active', true)"
                    {{-- Defaultnya aktif saat tambah baru --}} error="$errors->first('is_active')" />

                <x-form.file class="mb-5" name="image" label="Gambar Kategori" error="$errors->first('image')" />

                <x-form.footer :cancel-url="route('admin.category.index')" submit-label="Simpan Kategori" {{-- Opsional: Jika Anda ingin ikon berbeda, contoh ikon 'save' --}}
                    {{-- submit-icon="M7 16V4h10v12c0 1.1-.9 2-2 2H9c-1.1 0-2-.9-2-2zM12 4.5l-4 4h8l-4-4z" --}} />
            </form>
        </x-form.card>
    </div>
@endsection
