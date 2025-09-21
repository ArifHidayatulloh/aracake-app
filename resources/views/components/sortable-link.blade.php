@props(['column', 'sortColumn', 'sortDirection'])

@php
    $newDirection = $sortColumn === $column && $sortDirection === 'asc' ? 'desc' : 'asc';
    $icon = '';
    if ($sortColumn === $column) {
        $icon = $sortDirection === 'asc' ? '▲' : '▼';
    }
    // Gabungkan parameter sorting baru dengan filter yang sudah ada
    // $queryString = http_build_query(array_merge(request()->query(), ['sort' => $column, 'direction' => $newDirection]));
    $queryString = http_build_query(array_merge(request()->except('page'), ['sort' => $column, 'direction' => $newDirection]));
@endphp

<a href="?{{ $queryString }}" class="flex items-center space-x-1">
    <span>{{ $slot }}</span>
    <span class="text-xs">{{ $icon }}</span>
</a>