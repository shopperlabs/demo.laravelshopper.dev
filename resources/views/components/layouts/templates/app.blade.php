<x-layouts.base :title="$title ?? null">
    <x-layouts.header />

    <main>
        {{ $slot }}
    </main>

    <x-layouts.footer />
</x-layouts.base>
