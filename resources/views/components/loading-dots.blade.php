@php
    $dots = 'mx-[1px] inline-block h-1 w-1 animate-blink';
@endphp

<span class="inline-flex items-center px-2">
    <span {{ $attributes->twMerge(['class' => $dots]) }}></span>
    <span {{ $attributes->twMerge(['class' => $dots . ' animation-delay-[200ms]']) }}></span>
    <span {{ $attributes->twMerge(['class' => $dots . ' animation-delay-[400ms]']) }}></span>
</span>
