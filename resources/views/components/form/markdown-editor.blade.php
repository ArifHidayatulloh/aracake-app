@props(['name', 'id' => null, 'value' => '', 'rows' => 10, 'label' => null])

@if ($label ?? false)
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
        @if ($attributes->has('required'))
            <span class="text-red-500">*</span>
        @endif
    </label>
@endif

<div {{ $attributes->merge(['class' => 'markdown-editor-wrapper']) }}>
    <textarea name="{{ $name }}" id="{{ $id ?? $name }}" rows="{{ $rows }}"
        class="easymde-editor border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ old($name, $value) }}</textarea>
</div>
