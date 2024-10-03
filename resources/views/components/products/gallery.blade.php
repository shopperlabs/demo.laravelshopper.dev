@props([
    'images',
    'product',
])

@foreach ($images as $image)
    <img src="{{ $image->getFullUrl() }}" alt="{{ $image->file_name }}" class="hidden lg:block" />
@endforeach
