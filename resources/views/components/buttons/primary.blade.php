@props(['link' => false, 'type' => 'button'])

@if($link)
    <a href="{{ $link }}" class="group relative inline-flex items-center text-sm font-medium focus:outline-none">
        <span {{ $attributes->merge(['class' => 'z-10 text-white bg-black shadow-sm']) }}>
            {{ $slot }}
        </span>
        <span class="absolute z-0 inset-0 border-2 border-black p-1 transform transition-transform group-hover:translate-y-1 group-hover:translate-x-1 group-focus:-translate-y-1 group-focus:translate-x-1"></span>
    </a>
@else
    <button type="{{ $type }}" class="group relative inline-flex items-center text-sm font-medium focus:outline-none">
        <span {{ $attributes->merge(['class' => 'z-10 text-white bg-black shadow-sm']) }}>
            {{ $slot }}
        </span>
        <span class="absolute z-0 inset-0 border-2 border-black p-1 transform transition-transform group-hover:translate-y-1 group-hover:translate-x-1 group-focus:-translate-y-1 group-focus:translate-x-1"></span>
    </button>
@endif
