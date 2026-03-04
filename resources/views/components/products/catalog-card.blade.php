@blaze

@props([
    'product',
])

@php
    $price = $product->getFormattedPrice();
    $colorValueIds = $product->relationLoaded('options')
        ? $product->options->where('slug', 'color')->pluck('pivot.attribute_value_id')->filter()
        : collect();
    $colorValues = $colorValueIds->isNotEmpty() && $product->options->first(fn ($attr) => $attr->slug === 'color')?->relationLoaded('values')
        ? $product->options->first(fn ($attr) => $attr->slug === 'color')->values->whereIn('id', $colorValueIds)
        : collect();
@endphp

<div {{ $attributes->twMerge(['class' => 'group relative']) }}>
    <x-link :href="route('single-product', $product)" class="block">
        <div class="relative">
            <x-products.thumbnail :$product class="aspect-square w-full rounded-xl bg-zinc-100 object-cover" />

            @if ($price && $price->percentage && $price->percentage > 0)
                <span class="absolute top-3 right-3 inline-flex items-center rounded-lg bg-primary-50 px-2 py-1 text-xs font-semibold text-primary-700 ring-1 ring-inset ring-primary-600/10">
                    {{ __('-:discount%', ['discount' => $price->percentage]) }}
                </span>
            @endif
        </div>

        <div class="mt-3 flex items-center gap-1.5">
            <x-rate-stars :rating="$product->ratings_avg_rating ?? 0" />
            @if (($product->ratings_count ?? 0) > 0)
                <span class="text-sm text-zinc-500">({{ $product->ratings_count }})</span>
            @endif
        </div>

        <h3 class="mt-2 text-sm font-semibold text-zinc-900 group-hover:text-zinc-700">
            {{ $product->name }}
        </h3>

        @if ($product->brand_id)
            <p class="mt-1 text-sm text-zinc-500 line-clamp-2">{{ $product->brand->name }}</p>
        @endif
    </x-link>

    <div class="mt-3 flex items-center justify-between lg:mt-5">
        @if ($price)
            <p class="inline-flex items-center gap-1.5 text-sm/4">
                <span class="font-medium text-zinc-900">{{ $price->amount->formatted }}</span>
                @if ($price->compare)
                    <span class="text-zinc-400 line-through text-xs">{{ $price->compare->formatted }}</span>
                @endif
            </p>
        @endif

        @if ($colorValues->isNotEmpty())
            <div class="flex items-center gap-1">
                @foreach($colorValues as $color)
                    <span
                        class="size-5 rounded-full ring ring-black/10"
                        style="background-color: {{ $color->key }}"
                        title="{{ $color->value }}"
                    ></span>
                @endforeach
            </div>
        @else
            <div></div>
        @endif
    </div>
</div>
