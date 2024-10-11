@props(['href', 'icon', 'title', 'description'])

<div class="relative p-4 rounded-lg border border-gray-200 hover:bg-gray-50">
    <div class="flex items-start gap-4">
        <div class="flex items-center justify-center size-8 text-primary-600">
            @svg($icon, 'size-6', ['aria-hidden' => true, 'stroke-width' => '1.5'])
        </div>
        <div>
            <h2 class="text-base text-gray-900">
                <x-link :href="$href">
                    {{ $title }}
                    <span class="absolute inset-0"></span>
                </x-link>
            </h2>
            <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
        </div>
    </div>
</div>
