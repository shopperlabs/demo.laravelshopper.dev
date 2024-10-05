<x-banner />
<header class="sticky top-0 z-20 border-b border-gray-200 bg-white bg-opacity-80 py-3 backdrop-blur-xl backdrop-filter">
    <x-container class="flex items-center justify-between px-4">
        <nav role="navigation" class="flex items-center">
            <x-link :href="route('home')" class="relative text-sm">
                <x-brand class="h-10 w-auto" />
            </x-link>
            <div class="ml-10 flex items-center gap-x-6">
                @foreach ($categories as $category)
                    <x-nav.item link="#">{{ $category->name }}</x-nav.item>
                @endforeach
            </div>
        </nav>
        <div class="ml-auto flex items-center gap-x-4">
            <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-4">
                <x-link :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-gray-800">
                    {{ __('Log in') }}
                </x-link>
                <span class="h-6 w-px bg-gray-200" aria-hidden="true"></span>
                <x-link :href="route('register')" class="text-sm font-medium text-gray-700 hover:text-gray-800">
                    {{ __('Create account') }}
                </x-link>
            </div>

            <!-- Currency -->
            <livewire:currency-selector />

            <!-- Search -->
            <livewire:global-search />

            <!-- Cart -->
            <livewire:shopping-cart-button />
        </div>
    </x-container>
</header>
