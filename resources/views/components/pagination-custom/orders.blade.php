@props(['orders'])

@if ($orders->hasPages())
    <div class="flex flex-col sm:flex-row justify-between items-center mt-8">
        <p class="text-sm text-gray-700 mb-4 sm:mb-0">
            Menampilkan <span class="font-medium">{{ $orders->firstItem() }}</span> sampai <span class="font-medium">{{ $orders->lastItem() }}</span> dari <span class="font-medium">{{ $orders->total() }}</span> pesanan
        </p>
        <nav class="flex items-center space-x-2">
            {{-- Previous Page Link --}}
            <a href="{{ $orders->previousPageUrl() }}"
               class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 @if($orders->onFirstPage()) disabled:opacity-50 pointer-events-none @endif">
                <i class="fas fa-chevron-left mr-1"></i>Previous
            </a>

            {{-- Pagination Elements --}}
            @foreach ($orders->links()->elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-sm font-medium text-gray-500">{{ $element }}</span>
                @endif

                {{-- Array of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <a href="{{ $url }}"
                           class="px-3 py-2 text-sm font-medium border rounded-md @if ($page == $orders->currentPage()) text-white bg-purple-600 border-purple-600 @else text-gray-700 bg-white border-gray-300 hover:bg-gray-50 @endif">
                            {{ $page }}
                        </a>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            <a href="{{ $orders->nextPageUrl() }}"
               class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 @if(!$orders->hasMorePages()) disabled:opacity-50 pointer-events-none @endif">
                Next<i class="fas fa-chevron-right ml-1"></i>
            </a>
        </nav>
    </div>
@endif
