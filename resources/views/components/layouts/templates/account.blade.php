<x-layouts.templates.app :title="$title ?? null">
    <x-container class="relative pt-8 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 lg:gap-x-12">
            <div class="lg:col-span-1">
                <h2 class="hidden font-heading text-xl font-bold leading-6 text-primary-900 lg:block">
                    {{ __('Mon compte') }}
                </h2>
                <div class="mt-10 space-y-8 hidden lg:block">
                    <nav role="navigation" class="flex flex-col space-y-4 lg:pr-12">
                        <x-nav.account-link
                            :href="route('account.show')"
                            :title="__('Aperçu')"
                            :active="request()->routeIs('account.show')"
                        />
                        <x-nav.account-link
                            :href="route('account.show')"
                            :title="__('Données personnelles')"
                            :active="request()->routeIs('account.profile')"
                        />
                        <x-nav.account-link
                            :href="route('account.addresses')"
                            :title="__('Adresses')"
                            :active="request()->routeIs('account.addresses')"
                        />
                        <x-nav.account-link
                            :href="route('account.orders')"
                            :title="__('Commandes')"
                            :active="request()->routeIs('account.orders*')"
                        />
                    </nav>
                </div>
            </div>
            <div class="lg:col-span-4">{{ $slot }}</div>
        </div>
    </x-container>
</x-layouts.templates.app>
