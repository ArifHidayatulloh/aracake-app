@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <x-breadcrumb.breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Metode Pengiriman', 'url' => route('admin.delivery-method.index')],
        ['label' => 'Tambah Metode Pengiriman'],
    ]" />

    <x-header-page.header-page title="Tambah Metode Pengiriman" description="Buat metode pengiriman baru di toko Anda." />

    <x-form.card>
        <form action="{{ route('admin.delivery-method.store') }}" method="POST">
            @csrf
            <x-form.input typ="text" name="method_name" label="Nama Metode" error="$errors->first('name')" required />

            <x-form.textarea name="description" label="Deskripsi Metode" error="$errors->first('description')"
                rows="4" />

            <x-form.input typ="number" name="base_cost" label="Biaya Dasar" error="$errors->first('base_cost')" required />

            <x-form.input typ="number" name="cost_per_km" label="Biaya per KM" error="$errors->first('cost_per_km')"
                required />

            <x-form.toggle class="mb-5" name="is_pickup" label="Metode Pengambilan" :checked="old('is_active', true)" error="$errors->first('is_pickup')" />

            <x-form.toggle class="mb-5" name="is_active" label="Metode Aktif" :checked="old('is_active', true)"
                error="$errors->first('is_active')" />

            <x-form.footer :cancel-url="route('admin.delivery-method.index')" submit-label="Simpan Metode Pengiriman" />
        </form>
    </x-form.card>
</div>
@endsection
