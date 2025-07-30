@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Kategori Produk', 'url' => route('admin.category.index')],
            ['label' => 'Edit Kategori Produk'],
        ]" />

        <x-header-page.header-page title="Edit Kategori Produk" description="Ubah informasi kategori produk." />

        <x-form.card>
            <form action="{{ route('admin.category.update', $category->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-form.input typ="text" name="name" label="Nama Kategori" error="$errors->first('name')"
                    value="{{ old('name', $category->name) }}" required />

                <x-form.textarea name="description" label="Deskripsi Kategori" error="$errors->first('description')"
                    rows="4" value="{{ old('description', $category->description) }}" />

                <x-form.toggle class="mb-5" name="is_active" label="Kategori Aktif" :checked="old('is_active', $category->is_active)"
                    error="$errors->first('is_active')" />

                <x-form.file class="mb-5" name="image" label="Gambar Kategori" error="$errors->first('image')" />

                <x-form.footer :cancel-url="route('admin.category.index')" submit-label="Simpan Kategori"
                    submit-icon="M7 16V4h10v12c0 1.1-.9 2-2 2H9c-1.1 0-2-.9-2-2zM12 4.5l-4 4h8l-4-4z" />
            </form>
        </x-form.card>
    </div>
@endsection
