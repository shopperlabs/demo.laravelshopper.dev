<x-banner />
<header class="sticky top-0 z-10 py-3 bg-white border-b border-gray-200 bg-opacity-80 backdrop-blur-xl backdrop-filter">
    <x-container class="flex items-center justify-between px-4">
        <nav role="navigation" class="flex items-center">
            <x-link :href="route('home')" class="relative text-sm">
                <x-brand class="w-auto h-10" />
            </x-link>
            <div class="flex items-center lg:gap-x-4 ml-10 gap-x-6">
                @foreach ($categories as $category)
                    <x-nav.item link="{{ route('category.products', $category->slug) }}">{{ $category->name }}</x-nav.item>
                @endforeach

                <div class="relative group">
                    <x-buttons.default class="px-8 py-3 text-base font-medium text-center group">
                        {{ __('Collections') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </x-buttons.default>
        
                    <div class="absolute left-0 mt-2 w-48 bg-white border rounded shadow-lg hidden group-hover:block z-50">
                        @foreach ($collections as $collection)
                            <x-link :href="route('collection.products', $collection->slug)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                {{ $collection->name }}
                            </x-link>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>
        <div class="flex items-center ml-auto gap-x-6">
            <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                @auth
                    <livewire:components.account-menu />
                @else
                    <x-link :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-gray-800">
                        {{ __('Log in') }}
                    </x-link>
                    <span class="w-px h-6 bg-gray-200" aria-hidden="true"></span>
                    <x-link :href="route('register')" class="text-sm font-medium text-gray-700 hover:text-gray-800">
                        {{ __('Create account') }}
                    </x-link>
                @endauth
            </div>
            <!-- Search -->
            <livewire:global-search />

            <!-- Cart -->
            <livewire:shopping-cart-button />
        </div>
    </x-container>
</header>
