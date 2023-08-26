<x-layout.shop>
    <x-offers-banner />

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

    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <x-category-list />

        <livewire:products.best-deals />
    </div>

</x-layout.shop>
