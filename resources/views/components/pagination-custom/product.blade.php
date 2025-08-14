@props([
    'paginator' => $paginator
])

@if ($paginator->lastPage() > 1)
    <div class="flex justify-center mt-12">
        <nav class="flex items-center space-x-2">
            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 border border-gray-300 rounded-md text-gray-400">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-500 hover:bg-purple-50">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Page Numbers --}}
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if ($i == $paginator->currentPage())
                    <span class="px-4 py-2 bg-purple-600 text-white rounded-md">{{ $i }}</span>
                @else
                    <a href="{{ $paginator->appends(request()->query())->url($i) }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-purple-50">{{ $i }}</a>
                @endif
            @endfor

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-500 hover:bg-purple-50">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="px-4 py-2 border border-gray-300 rounded-md text-gray-400">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </nav>
    </div>
@endif
