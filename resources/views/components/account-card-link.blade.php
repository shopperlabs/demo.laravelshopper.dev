@props(['href', 'icon', 'title', 'description'])

<div class="relative border border-primary-200 p-4 hover:bg-gray-50">
    <div class="flex items-start space-x-4">
        <div class="flex h-8 w-8 items-center justify-center text-primary-600">
            @svg($icon, 'h-6 w-6', ['aria-hidden' => true, 'stroke-width' => '1'])
        </div>
        <div class="leading-5">
            <h2 class="font-heading text-primary-900">
                <x-wire-link :href="$href">
                    {{ $title }}
                    <span class="absolute inset-0"></span>
                </x-wire-link>
            </h2>
            <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
        </div>
    </div>
</div>
