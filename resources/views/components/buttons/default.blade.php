@props(['link' => false, 'whiteBorder' => false])

@if($link)
    <a href="{{ $link }}" {{ $attributes->merge(['class' => 'group relative inline-flex items-center justify-center border border-secondary-900 text-sm font-medium text-black bg-white shadow-sm hover:bg-secondary-50 focus:outline-none']) }}>
        <span @class([
            'absolute z-0 inset-0 border-2 p-1 transform transition-transform group-hover:translate-y-1 group-hover:translate-x-1 group-focus:-translate-y-1 group-focus:translate-x-1',
            'border-white' => $whiteBorder,
            'border-secondary-900' => ! $whiteBorder,
        ])></span>
        {{ $slot }}
    </a>
@else
    <button class="group relative inline-flex items-center text-sm font-medium focus:outline-none hover:z-10">
        <span {{ $attributes->merge(['class' => 'border border-secondary-900 z-10 text-black bg-white shadow-sm']) }}>
            {{ $slot }}
        </span>
        <span @class([
            'absolute z-0 inset-0 border-2 p-1 transform transition-transform group-hover:translate-y-1 group-hover:translate-x-1 group-focus:-translate-y-1 group-focus:translate-x-1',
            'border-white' => $whiteBorder,
            'border-secondary-900' => ! $whiteBorder,
        ])></span>
    </button>
@endif
