@blaze

@props([
    'line',
])

@php
    $purchasable = $line->purchasable;
    $product = $purchasable instanceof \App\Models\ProductVariant ? $purchasable->product : $purchasable;
    $price = format_cents($line->unit_price_amount * $line->quantity);
@endphp

<li class="flex py-6">
    <x-products.thumbnail :product="$purchasable" class="size-32 border border-zinc-200 rounded-lg aspect-none" />
    <div class="flex flex-col flex-1 ml-4">
        <div class="flex justify-between text-base">
            <div>
                <h3 class="font-medium font-heading text-primary-900">
                    <x-link :href="route('single-product', $product)">
                        {{ $product->name }}
                    </x-link>
                </h3>

                @if ($purchasable instanceof \App\Models\ProductVariant)
                    @php
                        $purchasable->loadMissing('values.attribute');
                    @endphp
                    <ul>
                        @foreach ($purchasable->values as $value)
                            <li class="text-sm">
                                <span class="text-zinc-700 font-medium">{{ $value->attribute->name }}</span>:
                                <span class="text-zinc-500">{{ $value->value }}</span>
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
                {{ __('Quantity: :qty', ['qty' => $line->quantity]) }}
            </p>

            <div class="flex">
                <flux:button
                    type="button"
                    variant="danger"
                    icon="trash"
                    size="xs"
                    wire:click="removeFromCart({{ $line->id }})"
                >
                    {{ __('Remove') }}
                </flux:button>
            </div>
        </div>
    </div>
</li>
