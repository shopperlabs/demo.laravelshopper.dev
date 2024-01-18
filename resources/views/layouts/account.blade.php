@props(['section' => __('Account')])

<x-layout.shop>
    <x-container class="py-12">
        <h2 class="font-heading text-2xl ml-4 leading-6 font-bold text-secondary-900 lg:text-4xl">
            {{ $section }}
        </h2>
        <div class="mt-10 grid grid-cols-1 lg:grid-cols-4 lg:gap-x-12">
            <div class="lg:col-span-1">
                <nav role="navigation" class="space-y-1 lg:pr-12">
                    <x-account-link :href="route('account')" :active="request()->routeIs('account')">
                        {{ __('Overview') }}
                    </x-account-link>
                    <x-account-link href="#">
                        {{ __('Profile') }}
                    </x-account-link>
                    <x-account-link href="#">
                        {{ __('Addresses') }}
                    </x-account-link>
                    <x-account-link href="#">
                        {{ __('Orders') }}
                    </x-account-link>
                </nav>
                <form class="ml-3 mt-6" method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="underline text-sm text-secondary-600 hover:text-secondary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
            <div class="lg:col-span-3">
                {{ $slot }}
            </div>
        </div>
    </x-container>
</x-layout.shop>
