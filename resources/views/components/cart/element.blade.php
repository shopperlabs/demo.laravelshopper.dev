@props([
    'line',
])

@php
    $purchasable = $line->purchasable;
    $product = $purchasable instanceof \App\Models\ProductVariant ? $purchasable->product : $purchasable;
    $price = format_cents($line->unit_price_amount * $line->quantity);
@endphp

<li class="flex items-start py-4 gap-4">
    <div class="relative shrink-0">
        <x-products.thumbnail :product="$purchasable" class="size-16 rounded-lg border border-zinc-200" />
        @if ($line->quantity > 0)
            <span class="absolute -top-2 -right-2 flex items-center justify-center size-5 rounded-full bg-zinc-500 text-white text-xs font-medium">
                {{ $line->quantity }}
            </span>
        @endif
    </div>
    <div class="flex-auto min-w-0">
        <h3 class="text-sm font-medium text-zinc-900 truncate">
            {{ $product->name }}
        </h3>

        @if ($purchasable instanceof \App\Models\ProductVariant)
            @php
                $purchasable->loadMissing('values.attribute');
            @endphp
            <ul class="mt-1">
                @foreach ($purchasable->values as $value)
                    <li class="text-xs text-zinc-500">
                        <span class="font-medium text-zinc-400">{{ $value->attribute->name }}</span>:
                        <span>{{ $value->value }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <p class="shrink-0 text-sm font-medium text-zinc-900">
        {{ $price }}
    </p>
</li>
