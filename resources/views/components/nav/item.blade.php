@props([
    'href',
])

<x-link :$href {{ $attributes->twMerge(['class' => 'flex items-center text-sm text-zinc-500 hover:text-zinc-900']) }}>
    {{ $slot }}
</x-link>
