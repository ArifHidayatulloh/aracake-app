<nav class="bg-white/70 backdrop-blur-sm border-b border-purple-100 py-3 px-6 shadow-sm" aria-label="Breadcrumb">
    <ol class="flex items-center">
        {{-- Home --}}
        <li>
            <a href="{{ $items[0]['url'] ?? '#' }}"
                class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-purple-800 transition-colors duration-200">
                <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
                    </path>
                </svg>
                {{ $items[0]['label'] ?? 'Dashboard' }}
            </a>
        </li>

        {{-- Items berikutnya --}}
        @foreach(array_slice($items, 1) as $item)
            <li class="flex items-center">
                <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>

                @if ($loop->last)
                    <span class="text-sm font-bold bg-gradient-to-r from-purple-500 to-purple-700 bg-clip-text text-transparent">
                        {{ $item['label'] }}
                    </span>
                @else
                    <a href="{{ $item['url'] }}"
                        class="text-sm font-medium text-gray-600 hover:text-purple-800 transition-colors duration-200">
                        {{ $item['label'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
