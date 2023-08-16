<x-layout.shop>
    <nav aria-label="{{ __('Offers') }}" class="border-b border-secondary-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <ul role="list" class="grid grid-cols-1 divide-y divide-secondary-200 lg:grid-cols-3 lg:divide-x lg:divide-y-0">
                <li class="flex flex-col">
                    <a href="#" class="relative flex flex-1 flex-col justify-center bg-white px-4 py-6 text-center focus:z-10">
                        <p class="text-sm text-secondary-500">{{ __('Download the app') }}</p>
                        <p class="font-semibold text-secondary-900">{{ __('Get an exclusive $5 off code') }}</p>
                    </a>
                </li>
                <li class="flex flex-col">
                    <a href="#" class="relative flex flex-1 flex-col justify-center bg-white px-4 py-6 text-center focus:z-10">
                        <p class="text-sm text-secondary-500">{{ __('Return when you\'re ready') }}</p>
                        <p class="font-semibold text-secondary-900">{{ __('60 days of free returns') }}</p>
                    </a>
                </li>
                <li class="flex flex-col">
                    <a href="#" class="relative flex flex-1 flex-col justify-center bg-white px-4 py-6 text-center focus:z-10">
                        <p class="text-sm text-secondary-500">{{ __('Sign up for our newsletter') }}</p>
                        <p class="font-semibold text-secondary-900">{{ __('15% off your first order') }}</p>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="relative">
        <div aria-hidden="true" class="absolute inset-0 overflow-hidden">
            <img src="https://tailwindui.com/img/ecommerce-images/home-page-01-hero-full-width.jpg" alt="" class="h-full w-full object-cover object-center">
        </div>
        <div aria-hidden="true" class="absolute inset-0 bg-black opacity-70"></div>
        <div class="relative mx-auto flex max-w-3xl flex-col items-center px-6 py-24 text-center sm:py-40 lg:px-0">
            <h1 class="text-4xl font-bold tracking-tight text-white lg:text-6xl font-heading">{{ __('New arrivals are here') }}</h1>
            <p class="mt-4 mb-8 text-xl text-white">
                {{ __('The new arrivals have, well, newly arrived. Check out the latest options from our summer small-batch release while they\'re still in stock.') }}
            </p>
            <x-buttons.default href="#" class="px-8 py-3 text-base" :white-border="true">
                {{ __('Shop New Arrivals') }}
            </x-buttons.default>
        </div>
    </div>

    <x-category-list />
</x-layout.shop>
