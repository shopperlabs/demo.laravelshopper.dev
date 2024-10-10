@props(['href', 'title', 'active' => false])

<x-wire-link :href="$href" aria-current="{{ $active ? 'page' : '' }}" @class([
    'inline-block text-sm text-gray-500 hover:underline hover:decoration-2',
    'font-semibold text-brand-800' => $active
])>
    {{ $title }}
</x-wire-link>
