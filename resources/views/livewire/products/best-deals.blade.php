@if($products->isNotEmpty())
    <div class="py-10 lg:pb-12">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-secondary-900 font-heading">
                    {{ __('Best deals') }}
                </h2>
                <p class="text-sm text-secondary-500">{{ __('Check out our latest offers. Limited quantities available, shop now and save big!') }}</p>
            </div>
            <a href="#" class="hidden text-sm font-medium text-secondary-900 hover:text-secondary-700 md:block">
                {{ __('See all products') }}
                <span aria-hidden="true"> &rarr;</span>
            </a>
        </div>
        <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
            @foreach($products as $product)
                <x-products.deal-card :product="$product" />
            @endforeach
        </div>
    </div>
@endif
