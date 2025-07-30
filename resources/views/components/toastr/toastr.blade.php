@props([
    'type' => 'success', // success, error, warning, info
    'message' => '',
])

@php
    $colorMap = [
        'success' => 'green',
        'error' => 'red',
        'warning' => 'yellow',
        'info' => 'blue',
    ];
    $color = $colorMap[$type] ?? 'gray';
@endphp

<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 bg-{{ $color }}-500 text-white px-4 py-3 rounded shadow-lg z-50"
    role="alert"
>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            {{-- Icon bisa dibikin dinamis juga kalau mau --}}
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18.364 5.636l-1.414 1.414M6.343 17.657l-1.415 1.414M4 12h1.5m13 0H20M6.343 6.343l1.414 1.414M17.657 17.657l1.414 1.414M12 4v1.5m0 13V20" />
            </svg>
            <span>{{ $message }}</span>
        </div>
        <button @click="show = false" class="ml-4 text-white font-bold">&times;</button>
    </div>
</div>
