@props(['item'])

@php
    $price = shopper_money_format(
        amount: $item->price * $item->quantity,
        currency: current_currency(),
    );

    $model = $item->associatedModel instanceof \App\Models\ProductVariant ? $item->associatedModel->product : $item->associatedModel;
@endphp

<li class="flex items-start py-4 gap-4">
    <div class="relative shrink-0">
        <x-products.thumbnail :product="$item->associatedModel" class="size-16 rounded-lg border border-zinc-200" />
        @if ($item->quantity > 0)
            <span class="absolute -top-2 -right-2 flex items-center justify-center size-5 rounded-full bg-zinc-500 text-white text-xs font-medium">
                {{ $item->quantity }}
            </span>
        @endif
    </div>
    <div class="flex-auto min-w-0">
        <h3 class="text-sm font-medium text-zinc-900 truncate">
            {{ $item->name }}
        </h3>

        @if ($item->attributes->isNotEmpty())
            <ul class="mt-1">
                @foreach ($item->attributes as $name => $value)
                    <li class="text-xs text-zinc-500">
                        <span class="font-medium text-zinc-400">{{ $name }}</span>:
                        <span>{{ $value }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <p class="shrink-0 text-sm font-medium text-zinc-900">
        {{ $price }}
    </p>
</li>
