@props([
    'href',
])

<x-link :href="$href" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-900">
    {{ $slot }}
</x-link>
