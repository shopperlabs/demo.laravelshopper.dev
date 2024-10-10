@props(['item', 'currency_code'])

<div class="flex py-6 sm:py-8">
    <div class="min-w-0 flex-1">
        <div class="lg:flex-1">
            <div>
                <h4 class="font-medium font-heading text-gray-950">{{ $item->name }}</h4>
                <div class="mt-1 gap-2 text-sm sm:flex sm:items-center">
                    <p class="font-medium text-gray-700">
                        {{ shopper_money_format($item->total(), $currency_code) }}
                    </p>
                    <p class="text-gray-500">
                        ({{ $item->quantity }}x {{ shopper_money_format($item->unit_price_amount, $currency_code) }})
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="ml-4 shrink-0 sm:order-first sm:m-0 sm:mr-6">
        <div class="col-start-2 col-end-3 sm:col-start-1 sm:row-span-2 sm:row-start-1">
            <x-products.thumbnail :product="$item->product" class="size-20" />
        </div>
    </div>
</div>
