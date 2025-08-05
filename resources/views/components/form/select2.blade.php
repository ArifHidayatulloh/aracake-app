@props([
    'name',
    'label',
    'options',
    'id',
    'selected' => null, // Default value if not provided
    'placeholder' => 'Pilih...', // Default value if not provided
    'required' => false, // <-- INI YANG PALING PENTING DITAMBAHKAN
    'error' => null // Opsional, untuk handling error dari form
])

<div class="form-group">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
        @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <select
        name="{{ $name }}"
        id="{{ $id }}"
        class="mt-1 block w-full border border-purple-200 rounded-md shadow-sm sm:text-sm bg-white/50"
        @if($required) required @endif
        x-data="{
            selectedOption: '{{ $selected }}',
            init() {
                // Pastikan jQuery dan Select2 sudah dimuat
                if (typeof jQuery === 'undefined' || typeof jQuery.fn.select2 === 'undefined') {
                    console.error('jQuery or Select2 not loaded!');
                    return;
                }

                this.$nextTick(() => {
                    $('#{{ $id }}').select2({
                        placeholder: '{{ $placeholder }}',
                        allowClear: true,
                        theme: 'default' // Atau tema custom Anda
                    });

                    // Sinkronisasi Select2 -> Alpine.js
                    $('#{{ $id }}').on('select2:select', (e) => {
                        this.selectedOption = e.params.data.id;
                        // Dispatch event untuk memberitahu parent component/form
                        this.$dispatch('input', this.selectedOption); // Penting untuk validasi Laravel
                    });
                    $('#{{ $id }}').on('select2:unselect', (e) => {
                        this.selectedOption = '';
                        this.$dispatch('input', this.selectedOption); // Penting untuk validasi Laravel
                    });

                    // Set nilai awal Select2
                    if (this.selectedOption) {
                        $('#{{ $id }}').val(this.selectedOption).trigger('change');
                    } else if ('{{ $placeholder }}' && !'{{ $selected }}' && !this.required) { // Handle placeholder default behavior
                        $('#{{ $id }}').val(null).trigger('change');
                    }
                });

                // Sinkronisasi Alpine.js -> Select2
                this.$watch('selectedOption', (value) => {
                    if ($('#{{ $id }}').val() !== value) {
                        $('#{{ $id }}').val(value).trigger('change');
                    }
                });
            }
        }"
    >
        {{-- Opsi placeholder - hanya jika tidak required atau jika ada placeholder yang disetel --}}
        @if (!$required || $placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $option)
            <option value="{{ $option['id'] }}" {{ ((string)$selected === (string)$option['id']) ? 'selected' : '' }}>
                {{ $option['name'] }}
            </option>
        @endforeach
    </select>

    {{-- Error handling for the specific field --}}
    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
