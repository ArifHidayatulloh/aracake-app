<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ara Cake - {{$title}}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="antialiased">
    <!-- Elemen dekoratif mengambang -->
    <div class="fixed -z-10 w-full h-full overflow-hidden">
        <div
            class="absolute top-20 left-10 w-64 h-64 rounded-full bg-purple-100 opacity-20 blur-3xl animate-float delay-100">
        </div>
        <div
            class="absolute bottom-20 right-10 w-64 h-64 rounded-full bg-pink-100 opacity-20 blur-3xl animate-float delay-300">
        </div>
    </div>

    <div class="content">
        @include('partials.customer.nav')

        @yield('content')

        @include('partials.customer.footer')

        <!-- Tombol kembali ke atas -->
        <a href="#"
            class="fixed bottom-8 right-8 bg-purple-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-purple-700 transition-colors z-40">
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>

    <!-- Tombol kembali ke atas -->
    <a href="#"
        class="fixed bottom-8 right-8 bg-purple-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-purple-700 transition-colors z-40">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Animasi saat elemen muncul di layar
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate-fade-in');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(el => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(el);
            });
        });
    </script>
</body>

</html>
