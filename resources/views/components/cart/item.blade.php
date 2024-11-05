@props(['item'])

@php
    $price = shopper_money_format(
        amount: $item->price * $item->quantity,
        currency: \App\Actions\ZoneSessionManager::getSession()?->currencyCode
    );
@endphp

<li class="flex py-6">
    <x-products.thumbnail :product="$item->associatedModel" class="w-32 h-32 border border-gray-200 aspect-none"  :ifCart=true/>
    <div class="flex flex-col flex-1 ml-4">
        <div>
            <div class="flex justify-between text-base">
                <h3 class="font-medium font-heading text-primary-900">
                    <x-link :href="route('single-product', ['slug' => $item->associatedModel->slug])">
                        {{ $item->name }}
                    </x-link>
                </h3>
                <p class="ml-4 text-gray-700">
                    {{ $price }}
                </p>
            </div>
        </div>
        <div class="flex items-end justify-between flex-1 text-sm">
            <p class="text-gray-500">
                {{ __('Quantity: :qty', ['qty' => $item->quantity]) }}
            </p>

            <div class="flex">
                <button type="button" wire:click="removeToCart('{{ $item->id }}')" class="relative inline-flex items-center gap-2 font-medium text-gray-600 group hover:text-gray-900">
                    <x-untitledui-trash-03 class="w-4 h-4 text-gray-400 group-hover:text-gray-500" />
                    {{ __('Remove') }}
                </button>
            </div>
        </div>
    </div>
</li>
