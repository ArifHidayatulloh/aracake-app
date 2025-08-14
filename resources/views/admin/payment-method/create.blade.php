@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <x-breadcrumb.breadcrumb
        :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Metode Pembayaran', 'url' => route('admin.payment-method.index')],
            ['label' => 'Tambah Metode Pembayaran'],
        ]"
    />

    <x-header-page.header-page title="Tambah Metode Pembayaran" description="Buat metode pembayaran baru di toko Anda." />

    <x-form.card>
        <form action="{{ route('admin.payment-method.store') }}" method="POST">
            @csrf
            <x-form.input typ="text" name="method_name" label="Nama Metode" error="$errors->first('method_name')" required />

            <x-form.input typ="text" name="account_number" label="Nomor Akun" error="$errors->first('account_number')" />

            <x-form.textarea name="account_details" label="Detail Akun" error="$errors->first('account_details')"
                rows="4" />

            <x-form.toggle class="mb-5" name="is_active" label="Metode Aktif" :checked="old('is_active', true)"
                error="$errors->first('is_active')" />

            <x-form.footer :cancel-url="route('admin.payment-method.index')" submit-label="Simpan Metode Pembayaran" />
        </form>
    </x-form.card>
@endsection
