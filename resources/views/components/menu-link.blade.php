@props(['title', 'href' => '#'])

<a href="{{ $href }}" class="flex items-center px-3 py-2 rounded-md hover:tex text-sm font-medium text-secondary-700 hover:text-secondary-900 hover:bg-secondary-50">
    {{ $title }}
</a>
