@props([
    'image',
    'product',
    'index'
])

<button id="tabs-2-tab-{{ $index }}"
    class="relative flex items-center justify-center h-24 text-sm font-medium text-gray-900 uppercase bg-white rounded-md cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4"
    aria-controls="tabs-2-panel-1" role="tab" type="button">
    <span class="sr-only">{{ $product->name }} </span>
    <span class="absolute inset-0 overflow-hidden rounded-md">
        <img src="{{ $image->getFullUrl() }}"  alt="{{ $image->file_name }} thumbnail" class="object-cover object-center w-full h-full">
    </span>
    <span class="absolute inset-0 rounded-md pointer-events-none"
        aria-hidden="true"></span>
</button>
