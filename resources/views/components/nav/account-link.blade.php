@props([
    'href',
    'title',
    'active' => false,
])

<x-link :href="$href" aria-current="{{ $active ? 'page' : '' }}" @class([
    'inline-block text-sm text-gray-500 hover:underline hover:decoration-2',
    'font-semibold text-primary-600' => $active
])>
    {{ $title }}
</x-link>
