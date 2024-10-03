@props([
    'link',
])

<x-wire-link
    :href="$link"
    {{ $attributes->twMerge(['class' => 'text-sm text-gray-400 hover:text-white group group-link-underline']) }}
>
    <span class="link link-underline link-underline-white">
        {{ $slot }}
    </span>
</x-wire-link>
