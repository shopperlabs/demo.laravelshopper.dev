<x-link {{ $attributes->twMerge([
    'class' => 'group relative inline-flex px-8 py-3 text-base ring-1 ring-white rounded-lg backdrop-blur-sm text-white transition duration-200 ease-in-out hover:ring-white hover:ring-2'
]) }}>
    {{ $slot }}
</x-link>
