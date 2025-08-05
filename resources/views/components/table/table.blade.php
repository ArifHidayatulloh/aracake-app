@props(['headers', 'pagination' => null])
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach ($headers as $header)
                    <th
                        {{ $attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider', 'scope' => 'col']) }}>
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
@if ($pagination)
    <div class="mt-4 text-right">
        {!! $pagination !!}
    </div>
@endif
