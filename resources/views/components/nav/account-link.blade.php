@props([
    'href',
    'title',
    'exact' => false,
])

@php
    $path = parse_url($href, PHP_URL_PATH);
@endphp

<a
    href="{{ $href }}"
    wire:navigate
    x-data="{
        path: '{{ $path }}',
        exact: {{ $exact ? 'true' : 'false' }},
        get active() {
            return this.exact
                ? window.location.pathname === this.path
                : window.location.pathname.startsWith(this.path)
        }
    }"
    x-bind:aria-current="active ? 'page' : null"
    x-bind:class="active ? 'font-medium text-primary-500' : 'text-zinc-500'"
    @navigate.window="$nextTick(() => $el.__x.$data.active)"
    class="inline-block text-sm hover:underline hover:decoration-2"
>
    {{ $title }}
</a>
