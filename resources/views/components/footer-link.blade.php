@props(['href' => '#', 'text'])

<a href="{{ $href }}" class="text-sm text-secondary-400 hover:text-primary-500 group group-link-underline">
    <span class="link link-underline link-underline-primary">{{ $text }}</span>
</a>
