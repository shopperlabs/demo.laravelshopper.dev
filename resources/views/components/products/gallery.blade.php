@props([
    'images',
])

@foreach ($images as $image)
    {{-- <img src="{{ $image->getFullUrl() }}" alt="{{ $image->file_name }}" class="hidden lg:block" /> --}}
    <div id="tabs-2-panel-{{ $loop->index }}" aria-labelledby="tabs-2-tab-{{ $loop->index }}" role="tabpanel" tabindex="{{ $loop->index }}">
        <img
            src="{{ $image->getFullUrl() }}"
            alt="{{ $image->file_name }}" class="object-cover object-center w-full h-full sm:rounded-lg">
    </div>
@endforeach
