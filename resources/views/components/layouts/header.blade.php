<x-banner />
<header class="sticky top-0 z-10 py-3 bg-white border-b border-gray-200 bg-opacity-80 backdrop-blur-xl backdrop-filter">
    <x-container class="flex items-center justify-between px-4">
        <nav role="navigation" class="flex items-center">
            <x-link :href="route('home')" class="relative text-sm">
                <x-brand class="w-auto h-10" />
            </x-link>
            <div class="items-center lg:gap-x-4 ml-10 gap-x-6 hidden md:flex">
                @foreach ($categories as $category)
                    <x-nav.item :href="route('category.products', $category->slug)">
                        {{ $category->name }}
                    </x-nav.item>
                @endforeach
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
