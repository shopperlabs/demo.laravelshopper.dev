<nav class="flex" aria-label="Breadcrumb">
    @unless ($breadcrumbs->isEmpty())
    <ol role="list" class="flex items-center space-x-4">
        @foreach ($breadcrumbs as $breadcrumb)
            @if($loop->first)
                <li>
                    <div>
                        <x-link :href="$breadcrumb->url"  class="text-gray-400 hover:text-gray-500">
                            <svg class="size-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">{{ $breadcrumb->title }}</span>
                        </x-link>
                    </div>
                </li>
            @else
                <li>
                    <div class="flex items-center">
                        <svg class="size-5 shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                        </svg>
                        <x-link :href="$breadcrumb->url"  class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $breadcrumb->title }}</x-link>
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
    @endunless
</nav>
