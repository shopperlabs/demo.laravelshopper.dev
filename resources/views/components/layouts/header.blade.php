<x-banner />
<header class="sticky top-0 z-10 py-3 bg-white/80 border-b border-zinc-200 backdrop-blur-xl">
    <x-container class="flex items-center justify-between px-4">
        <nav role="navigation" class="group/popover-group hidden lg:flex gap-4 lg:flex-1 lg:self-stretch">
            <x-nav.item :href="route('store')" @class(['font-medium text-zinc-900' => request()->routeIs('store')])>
                {{ __('Shop') }}
            </x-nav.item>
            <x-nav.item href="#">
                {{ __('Collections') }}
            </x-nav.item>
            <x-nav.item href="#">
                {{ __('About') }}
            </x-nav.item>
        </nav>
        <x-link :href="route('home')" class="relative flex items-center gap-2 text-sm">
            <x-brand class="w-auto h-8" aria-hidden="true" />
        </x-link>
        <div class="flex flex-1 items-center justify-end gap-x-6">
            <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                @auth
                    <livewire:components.account-menu />
                @else
                    <x-link :href="route('login')" class="text-sm font-medium text-zinc-700 hover:text-zinc-800">
                        {{ __('Log in') }}
                    </x-link>
                    <span class="w-px h-6 bg-zinc-200" aria-hidden="true"></span>
                    <x-link :href="route('register')" class="text-sm font-medium text-zinc-700 hover:text-zinc-800">
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
