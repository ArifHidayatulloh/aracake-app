@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Status Pesanan']]" />

        <x-header-page.header-page title="Edit Status Pesanan" description="Ubah informasi status pesanan." />

        <x-form.card>
            <form action="{{ route('admin.order-status.update', $orderStatus->id) }}" method="POST">
                @csrf
                @method('PUT')
                <x-form.input typ="text" name="status_name" label="Nama Status" error="$errors->first('status_name')"
                    value="{{ $orderStatus->status_name }}" required />

                <x-form.input typ="text" name="order" label="Urutan" error="$errors->first('order')"
                    value="{{ $orderStatus->order }}" required readonly />

                <x-form.textarea name="description" label="Deskripsi Status" error="$errors->first('description')"
                    rows="4" value="{{ $orderStatus->description }}" />

                <x-form.input typ="text" name="status_color" label="Warna Status" error="$errors->first('status_color')"
                    value="{{ $orderStatus->status_color }}" required aria-placeholder="Gunakan warna hexadecimal" />

                <x-form.toggle class="mb-5" name="is_active" label="Status Aktif" :checked="old('is_active', $orderStatus->is_active)"
                    error="$errors->first('is_active')" />

                <x-form.footer :cancel-url="route('admin.order-status.index')" submit-label="Simpan Status Pesanan" />
            </form>
        </x-form.card>
    </div>
@endsection
