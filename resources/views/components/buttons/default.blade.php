@props(['href' => null, 'whiteBorder' => false])

@if ($href)
    <x-link
        :href="$href"
        {{ $attributes->twMerge(['class' => 'group relative block py-2.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-500 focus:outline-none']) }}
    >
        <span
            @class([
                'absolute inset-0 z-0 transform border rounded-lg p-1 transition-transform group-hover:translate-x-1 group-hover:translate-y-1 group-focus:-translate-y-1 group-focus:translate-x-1',
                'border-white' => $whiteBorder,
                'border-gray-300' => ! $whiteBorder,
            ])
        ></span>
        <span class="absolute inset-0 bg-white rounded-lg z-0"></span>
        <span class="relative w-full inline-flex items-center justify-center">
            {{ $slot }}
        </span>
    </x-link>
@else
    <button
        {{ $attributes->twMerge(['class' => 'group relative block py-2.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-500 focus:outline-none']) }}
    >
        <span
            @class([
                'absolute inset-0 z-0 transform rounded-lg border p-1 transition-transform group-hover:translate-x-1 group-hover:translate-y-1 group-focus:-translate-y-1 group-focus:translate-x-1',
                'border-white' => $whiteBorder,
                'border-gray-300' => ! $whiteBorder,
            ])
        ></span>
        <span class="absolute inset-0 bg-white rounded-lg z-0"></span>
        <span class="relative w-full inline-flex items-center justify-center">
            {{ $slot }}
        </span>
    </button>
@endif
