@props(['href' => '#', 'text'])

<a href="{{ $href }}" class="text-sm text-secondary-400 hover:text-white group group-link-underline">
    <span class="link link-underline link-underline-white">{{ $text }}</span>
</a>
