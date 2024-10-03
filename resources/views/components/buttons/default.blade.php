@props(['link' => null, 'whiteBorder' => false])

@if ($link)
    <x-wire-link
        href="{{ $link }}"
        {{ $attributes->twMerge(['class' => 'group relative inline-flex items-center justify-center border border-gray-900 text-sm font-medium text-black bg-white shadow-sm hover:bg-gray-50 focus:outline-none']) }}
    >
        <span
            @class([
                'absolute inset-0 z-0 transform border-2 p-1 transition-transform group-hover:translate-x-1 group-hover:translate-y-1 group-focus:-translate-y-1 group-focus:translate-x-1',
                'border-white' => $whiteBorder,
                'border-gray-900' => ! $whiteBorder,
            ])
        ></span>
        {{ $slot }}
    </x-wire-link>
@else
    <button
        {{ $attributes->twMerge(['class' => 'group relative inline-flex items-center justify-center border border-gray-900 text-sm font-medium text-black bg-white shadow-sm hover:bg-gray-50 focus:outline-none']) }}
    >
        <span
            @class([
                'absolute inset-0 z-0 transform border-2 p-1 transition-transform group-hover:translate-x-1 group-hover:translate-y-1 group-focus:-translate-y-1 group-focus:translate-x-1',
                'border-white' => $whiteBorder,
                'border-gray-900' => ! $whiteBorder,
            ])
        ></span>
        {{ $slot }}
    </button>
@endif
