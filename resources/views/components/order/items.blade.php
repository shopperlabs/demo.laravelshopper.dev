@props(['items', 'currency_code'])

<div class="gap-6 sm:grid sm:grid-cols-2 sm:gap-x-8 lg:grid-cols-3">
    @foreach($items as $item)
        <div class="relative flex gap-3">
            <x-products.thumbnail
                :product="$item->product"
                class="size-28" :ifCart=true
            />
            <div class="flex-1 space-y-0.5">
                <h4 class="text-sm font-medium leading-5 font-heading text-brand">
                    {{ $item->name }}
                </h4>
                <p class="text-sm text-gray-700">
                    <span class="text-gray-500">{{ __('Unit price') }}</span> : {{ shopper_money_format($item->unit_price_amount, $currency_code) }}
                </p>
                <p class="text-sm text-gray-700">
                    <span class="text-gray-500">{{ __('Quantity') }}</span> : {{ $item->quantity }}
                </p>
            </div>
        </div>
    @endforeach
</div>
