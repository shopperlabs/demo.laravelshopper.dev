<x-link
    {{ $attributes->twMerge(['class' => 'text-sm leading-6 text-gray-600 hover:text-gray-900 group group-link-underline']) }}
>
    <span class="link link-underline link-underline-black">
        {{ $slot }}
    </span>
</x-link>
