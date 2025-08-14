@extends('layouts.guest',['title' => 'Beranda'])

@section('content')
    @include('partials.customer.hero')
    @include('partials.customer.category')
    @include('partials.customer.product')
    @include('partials.customer.process')
    @include('partials.customer.order-type')
    @include('partials.customer.cta')
@endsection
