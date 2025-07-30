@props([
    'name',
    'label' => '', // Label untuk toggle
    'checked' => false, // Status awal, true jika aktif, false jika tidak aktif
    'disabled' => false, // Apakah toggle dinonaktifkan
    'error' => null, // Pesan error validasi
    'class' => '', // Kelas CSS tambahan untuk div pembungkus
])

<div class="{{ $class }}"
    x-data="{
        isOn: {{ json_encode((bool)$checked) }}, // Variabel Alpine.js untuk status toggle
        toggle() {
            if (!{{ json_encode($disabled) }}) {
                this.isOn = !this.isOn;
                // Opsional: Anda bisa memancarkan event di sini jika perlu
                // this.$dispatch('toggle-changed', { name: '{{ $name }}', value: this.isOn });
            }
        }
    }">
    <label for="{{ $name }}" class="flex items-center cursor-pointer">
        <input type="hidden" name="{{ $name }}" :value="isOn ? 1 : 0">

        <div class="relative">
            <div @click="toggle()"
                class="block w-10 h-6 rounded-full transition-colors duration-200 ease-in-out"
                :class="isOn ? 'bg-purple-600' : 'bg-gray-200'"
                role="checkbox"
                tabindex="0"
                :aria-checked="isOn.toString()"
                @keydown.space.prevent="toggle()"
                @keydown.enter.prevent="toggle()"
            ></div>
            <div @click="toggle()"
                class="dot absolute left-0 top-0.5 bg-white w-5 h-5 rounded-full shadow-md transform transition-transform duration-200 ease-in-out"
                :class="isOn ? 'translate-x-full' : 'translate-x-0'"
            ></div>
        </div>

        @if($label)
            <span class="ml-3 text-sm font-medium text-gray-700">{{ $label }}</span>
        @endif
    </label>

    {{-- @if ($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif --}}
</div>
