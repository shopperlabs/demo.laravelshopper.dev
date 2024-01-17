@props(['href' => '#', 'text'])

<a href="{{ $href }}" class="text-sm leading-6 text-secondary-600 hover:text-secondary-900 group group-link-underline">
    <span class="link link-underline link-underline-black">{{ $text }}</span>
</a>
