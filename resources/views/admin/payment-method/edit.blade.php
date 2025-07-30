@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-breadcrumb.breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Metode Pembayaran']]" />

        <x-header-page.header-page title="Edit Metode Pembayaran" description="Ubah informasi metode pembayaran." />

        <x-form.card>
            <form action="{{ route('admin.payment-method.update', $paymentMethod->id) }}" method="POST">
                @csrf
                @method('PUT')
                <x-form.input typ="text" name="method_name" label="Nama Metode" error="$errors->first('method_name')"
                    value="{{ $paymentMethod->method_name }}" required />

                <x-form.textarea name="account_details" label="Detail Akun" error="$errors->first('account_details')"
                    rows="4" value="{{ $paymentMethod->account_details }}" />

                <x-form.toggle class="mb-5" name="is_active" label="Metode Aktif" :checked="old('is_active', $paymentMethod->is_active)"
                    error="$errors->first('is_active')" />

                <x-form.footer :cancel-url="route('admin.payment-method.index')" submit-label="Simpan Metode Pembayaran" />
            </form>
        </x-form.card>
    </div>
@endsection
