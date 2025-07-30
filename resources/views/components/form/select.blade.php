@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
])

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full px-4 py-2 border border-purple-200 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm bg-white/50']) }}>
        @foreach ($options as $option)
            <option value="{{ $option['id'] }}" {{ ($selected == $option['id']) ? 'selected' : '' }}>
                {{ $option['name'] }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
