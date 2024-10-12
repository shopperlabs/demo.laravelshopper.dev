<x-layouts.templates.app :title="$title ?? null">
    <x-container class="relative py-8 sm:py-12 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-5 lg:gap-x-12">
            <div class="lg:col-span-1">
                <h2 class="hidden text-xl font-medium leading-6 font-heading text-gray-900 lg:block">
                    {{ __('My account') }}
                </h2>
                <div class="hidden mt-10 space-y-8 lg:block">
                    <nav role="navigation" class="flex flex-col space-y-4 lg:pr-12">
                        <x-nav.account-link
                            :href="route('dashboard')"
                            :title="__('Overview')"
                            :active="request()->routeIs('dashboard')"
                        />
                        <x-nav.account-link
                            :href="route('dashboard')"
                            :title="__('Profile')"
                            :active="request()->routeIs('dashboard.profile')"
                        />
                        <x-nav.account-link
                            :href="route('dashboard.addresses')"
                            :title="__('Adresses')"
                            :active="request()->routeIs('dashboard.addresses')"
                        />
                        <x-nav.account-link
                            href="#"
                            :title="__('Orders')"
                            :active="request()->routeIs('dashboard.orders*')"
                        />
                    </nav>
                </div>
            </div>
            <div class="lg:col-span-4">{{ $slot }}</div>
        </div>
    </x-container>
</x-layouts.templates.app>
