@extends('layouts.app')

@section('content')
    <x-breadcrumb.breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Metode Pengiriman', 'url' => route('admin.delivery-method.index')],
        ['label' => 'Edit Metode Pengiriman'],
    ]" />

    <x-header-page.header-page title="Edit Metode Pengiriman" description="Ubah informasi metode pengiriman." />

    <x-form.card>
        <form action="{{ route('admin.delivery-method.update', $deliveryMethod->id) }}" method="POST">
            @csrf
            @method('PUT')
            <x-form.input typ="text" name="method_name" label="Nama Metode" error="$errors->first('name')"
                value="{{ old('name', $deliveryMethod->method_name) }}" required />

            <x-form.textarea name="description" label="Deskripsi Metode" error="$errors->first('description')"
                rows="4" value="{{ old('description', $deliveryMethod->description) }}" />

            <x-form.input typ="number" name="base_cost" label="Biaya Dasar" error="$errors->first('base_cost')"
                value="{{ old('base_cost', $deliveryMethod->base_cost) }}" required />

            <x-form.input typ="number" name="cost_per_km" label="Biaya per KM" error="$errors->first('cost_per_km')"
                value="{{ old('cost_per_km', $deliveryMethod->cost_per_km) }}" required />

            <x-form.toggle class="mb-5" name="is_pickup" label="Metode Pengambilan" :checked="old('is_active', $deliveryMethod->is_pickup)"
                error="$errors->first('is_pickup')" />

            <x-form.toggle class="mb-5" name="is_active" label="Metode Aktif" :checked="old('is_active', $deliveryMethod->is_active)"
                error="$errors->first('is_active')" />

            <x-form.footer :cancel-url="route('admin.delivery-method.index')" submit-label="Simpan Metode Pengiriman" />
        </form>
    </x-form.card>
@endsection
