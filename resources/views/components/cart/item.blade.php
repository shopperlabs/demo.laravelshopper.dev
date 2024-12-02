@props([
    'item',
])

@php
    $price = shopper_money_format(
        amount: $item->price * $item->quantity,
        currency: \App\Actions\ZoneSessionManager::getSession()?->currencyCode
    );
@endphp

<li class="flex py-6">
    <x-products.thumbnail :product="$item->associatedModel" class="size-32 border border-gray-200 rounded-lg aspect-none" />
    <div class="flex flex-col flex-1 ml-4">
        <div class="flex justify-between text-base">
            <h3 class="font-medium font-heading text-primary-900">
                <x-link :href="route('single-product', $item->associatedModel)">
                    {{ $item->name }}
                </x-link>
            </h3>
            <p class="ml-4 text-gray-700">
                {{ $price }}
            </p>
        </div>
        <div class="flex items-end justify-between flex-1 text-sm">
            <p class="text-gray-500">
                {{ __('Quantity: :qty', ['qty' => $item->quantity]) }}
            </p>

            <div class="flex">
                <button
                    type="button"
                    wire:click="removeToCart('{{ $item->id }}')"
                    class="inline-flex items-center px-2 py-1.5 bg-red-50 rounded-md text-xs gap-2 font-medium text-red-700 hover:bg-red-100"
                >
                    <x-untitledui-trash-03 class="size-4" aria-hidden="true" />
                    {{ __('Remove') }}
                </button>
            </div>
        </div>
    </div>
</li>
