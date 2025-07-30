<div class="mb-4">
    @if ($label ?? false)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    @php
        $baseClass =
            'mt-1 block w-full px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm bg-white/50';
        $additionalAttributes = [];

        if ($readonly ?? false) {
            $additionalAttributes['readonly'] = true;
        }

        if ($disabled ?? false) {
            $additionalAttributes['disabled'] = true;
        }

        if ($required ?? false) {
            $additionalAttributes['required'] = true;
        }

        $additionalAttributes['class'] = $baseClass;
    @endphp

    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}"
        value="{{ old($name, $value ?? '') }}" {{ $attributes->merge($additionalAttributes) }}>

    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
