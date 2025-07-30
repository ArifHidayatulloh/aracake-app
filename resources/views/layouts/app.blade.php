<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ara Cake Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-purple-50 font-sans antialiased">
    <!-- This div controls the sidebarOpen state for the entire layout -->
    <div class="flex h-screen bg-gray-100" x-data="{ sidebarOpen: false }">
        {{-- Sidebar --}}
        @include('partials.admin.sidebar')

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-transition:opacity class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
            @click="sidebarOpen = false" x-cloak></div>

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Header --}}
            @include('partials.admin.header')


            <main class="flex-1 overflow-y-auto p-6">
                @if (session('success'))
                    <x-toastr.toastr type="success" :message="session('success')" />
                @endif

                @if ($errors->any())
                    <x-toastr.toastr type="error" :message="$errors->first()" />
                @endif

                @if (session('error'))
                    <x-toastr.toastr type="error" :message="session('error')" />
                @endif

                <!-- Main content area -->
                @yield('content')
            </main>

            <footer
                class="bg-white/80 backdrop-blur-sm border-t border-purple-100 py-3 px-6 text-sm text-purple-600/80">
                &copy; <span id="currentYear">{{ date('Y') }}</span> Ara Cake. All rights reserved.
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
    @stack('scripts')
</body>

</html>
