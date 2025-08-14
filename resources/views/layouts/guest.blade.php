<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ara Cake - {{ $title }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-gray-50">
    @include('partials.customer.nav')

    @if (session('success'))
        <x-toastr.toastr type="success" :message="session('success')" />
    @endif

    @if ($errors->any())
        <x-toastr.toastr type="error" :message="$errors->first()" />
    @endif

    @if (session('error'))
        <x-toastr.toastr type="error" :message="session('error')" />
    @endif
    @yield('content')

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-500 text-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 hidden z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    @include('partials.customer.footer')

    <script src="{{ asset('js/scrollToTop.js') }}"></script>
</body>

</html>
