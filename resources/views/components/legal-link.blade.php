@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex text-secondary-500 bg-secondary-100 px-4 py-2 hover:text-secondary-900'
                : 'inline-flex text-secondary-500 px-4 py-2 hover:text-black group group-link-underline';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="link link-underline link-underline-black">{{ $slot }}</span>
</a>
