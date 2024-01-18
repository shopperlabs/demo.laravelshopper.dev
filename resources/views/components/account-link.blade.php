@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block text-sm px-3 py-2.5 text-secondary-900 rounded-md bg-secondary-100/50 hover:bg-secondary-50 transition duration-150 ease-in-out'
                : 'block text-sm px-3 py-2.5 text-secondary-600 rounded-md hover:bg-secondary-50 hover:text-secondary-900 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->twMerge(['class' => $classes]) }}>
    {{ $slot }}
</a>
