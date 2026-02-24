@props([
    'items',
    'currency_code',
])

@php
    use Shopper\Core\Enum\FulfillmentStatus;

    $allDelivered = $items->every(fn ($item) => $item->fulfillment_status === FulfillmentStatus::Delivered);
    $grouped = $allDelivered ? null : $items->groupBy(fn ($item) => $item->fulfillment_status ?? FulfillmentStatus::Pending);
@endphp

@if ($allDelivered)
    <div class="gap-6 sm:grid sm:grid-cols-2 sm:gap-x-8 lg:grid-cols-3">
        @foreach ($items as $item)
            <div class="relative flex gap-3">
                <x-products.thumbnail
                    :product="$item->product"
                    class="size-28"
                />
                <div class="flex-1 space-y-0.5">
                    <h4 class="text-sm font-medium leading-5 font-heading text-brand">
                        {{ $item->name }}
                    </h4>
                    <p class="text-sm text-zinc-700">
                        <span class="text-zinc-500">{{ __('Unit price') }}</span> : {{ shopper_money_format($item->unit_price_amount, $currency_code) }}
                    </p>
                    <p class="text-sm text-zinc-700">
                        <span class="text-zinc-500">{{ __('Quantity') }}</span> : {{ $item->quantity }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="space-y-8">
        @foreach ($grouped as $status => $groupItems)
            @php
                $fulfillmentStatus = FulfillmentStatus::from($status);
            @endphp

            <div>
                <div class="flex items-center gap-3 pb-3 mb-4 border-b border-zinc-200">
                    <x-order.status :status="$fulfillmentStatus" />
                    <span class="text-sm text-zinc-500">
                        {{ $groupItems->count() }} {{ trans_choice(__('item|items'), $groupItems->count()) }}
                    </span>
                </div>

                <div class="gap-6 sm:grid sm:grid-cols-2 sm:gap-x-8 lg:grid-cols-3">
                    @foreach ($groupItems as $item)
                        <div class="relative flex gap-3">
                            <x-products.thumbnail
                                :product="$item->product"
                                class="size-28"
                            />
                            <div class="flex-1 space-y-0.5">
                                <h4 class="text-sm font-medium leading-5 font-heading text-brand">
                                    {{ $item->name }}
                                </h4>
                                <p class="text-sm text-zinc-700">
                                    <span class="text-zinc-500">{{ __('Unit price') }}</span> : {{ shopper_money_format($item->unit_price_amount, $currency_code) }}
                                </p>
                                <p class="text-sm text-zinc-700">
                                    <span class="text-zinc-500">{{ __('Quantity') }}</span> : {{ $item->quantity }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endif
