@props(['link' => null])

@if ($link)
    <x-wire-link
        href="{{ $link }}"
        {{ $attributes->twMerge(['class' => 'group relative inline-flex items-center justify-center border border-transparent text-sm font-medium text-white bg-black shadow-sm hover:bg-gray-900 focus:outline-none']) }}
    >
        <span
            class="absolute inset-0 z-0 transform border-2 border-gray-900 p-1 transition-transform group-hover:translate-x-1 group-hover:translate-y-1 group-focus:-translate-y-1 group-focus:translate-x-1"
        ></span>
        {{ $slot }}
    </x-wire-link>
@else
    <button
        {{ $attributes->twMerge(['class' => 'group relative inline-flex items-center justify-center border border-transparent text-sm font-medium text-white bg-black shadow-sm hover:bg-gray-900 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed']) }}
    >
        <span
            class="absolute inset-0 z-0 transform border-2 border-gray-900 p-1 transition-transform group-hover:translate-x-1 group-hover:translate-y-1 group-focus:-translate-y-1 group-focus:translate-x-1"
        ></span>
        {{ $slot }}
    </button>
@endif
