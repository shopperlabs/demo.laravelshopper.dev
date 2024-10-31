@props(['item'])

@php
    $price = shopper_money_format(
        amount: $item->price * $item->quantity,
        currency: \App\Actions\ZoneSessionManager::getSession()?->currencyCode
    );
@endphp

<li class="flex items-start py-6 space-x-4">
    <x-products.thumbnail :product="$item->associatedModel" class="w-20 h-20 border aspect-none border-primary-700" />
    <div class="flex-auto space-y-1">
        <h3>{{ $item->name }}</h3>
        <p class="text-gray-400">
            {{ __(':qty x :price', ['qty' => $item->quantity, 'price' => shopper_money_format($item->price, \App\Actions\ZoneSessionManager::getSession()?->currencyCode)]) }}
        </p>
    </div>
    <p class="flex-none text-base font-medium">
        {{ $price }}
    </p>
</li>
