@props([
    'item',
])

@php
    $price = shopper_money_format(
        amount: $item->price * $item->quantity,
        currency: current_currency(),
    );

    $model = $item->associatedModel instanceof \App\Models\ProductVariant ? $item->associatedModel->product : $item->associatedModel;
@endphp

<li class="flex py-6">
    <x-products.thumbnail :product="$item->associatedModel" class="size-32 border border-zinc-200 rounded-lg aspect-none" />
    <div class="flex flex-col flex-1 ml-4">
        <div class="flex justify-between text-base">
            <div>
                <h3 class="font-medium font-heading text-primary-900">
                    <x-link :href="route('single-product', $model)">
                        {{ $item->name }}
                    </x-link>
                </h3>

                @if ($item->attributes->isNotEmpty())
                    <ul>
                        @foreach ($item->attributes as $name => $value)
                            <li class="text-sm">
                                <span class="text-zinc-700 font-medium">{{ $name }}</span>:
                                <span class="text-zinc-500">{{ $value }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <p class="ml-4 text-zinc-700">
                {{ $price }}
            </p>
        </div>
        <div class="flex items-end justify-between flex-1 text-sm">
            <p class="text-zinc-500">
                {{ __('Quantity: :qty', ['qty' => $item->quantity]) }}
            </p>

            <div class="flex">
                <flux:button
                    type="button"
                    variant="danger"
                    icon="trash"
                    size="xs"
                    wire:click="removeToCart({{ $item->id }})"
                >
                    {{ __('Remove') }}
                </flux:button>
            </div>
        </div>
    </div>
</li>
