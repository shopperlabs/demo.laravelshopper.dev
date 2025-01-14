@props(['item'])

@php
    $price = shopper_money_format(
        amount: $item->price * $item->quantity,
        currency: current_currency(),
    );

    $model = $item->associatedModel instanceof \App\Models\ProductVariant ? $item->associatedModel->product : $item->associatedModel;
@endphp

<li class="flex items-start py-6 space-x-4">
    <x-products.thumbnail :product="$item->associatedModel" class="size-20 border aspect-none border-primary-700" />
    <div class="flex-auto">
        <h3 class="font-medium font-heading text-white">
            <x-link :href="route('single-product', $model)">
                {{ $item->name }}
            </x-link>
        </h3>

        <p class="mt-1 text-gray-300">
            {{ __(':qty x :price', ['qty' => $item->quantity, 'price' => shopper_money_format($item->price, current_currency())]) }}
        </p>

        @if($item->attributes->isNotEmpty())
            <ul class="mt-2">
                @foreach($item->attributes as $name => $value)
                    <li class="text-xs text-white">
                        <span class="font-medium text-gray-400">{{ $name }}</span>:
                        <span>{{ $value }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <p class="flex-none text-base font-medium">
        {{ $price }}
    </p>
</li>
