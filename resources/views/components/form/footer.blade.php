@props([
    'cancelUrl', // URL untuk tombol Batal
    'submitLabel' => 'Simpan', // Label untuk tombol submit
    'submitIcon' => null, // SVG Path untuk ikon submit (opsional)
    'submitClass' => '', // Kelas CSS tambahan untuk tombol submit
])

<div class="flex justify-end gap-3">
    <a href="{{ $cancelUrl }}"
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150 {{ $submitClass }}">
        @if ($submitIcon)
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $submitIcon }}"></path>
            </svg>
        @else
            {{-- Default icon if none provided --}}
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"></path>
            </svg>
        @endif
        {{ $submitLabel }}
    </button>
</div>
