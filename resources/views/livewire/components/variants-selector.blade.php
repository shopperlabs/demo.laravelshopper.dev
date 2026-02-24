<form class="mt-6" wire:submit="addToCart">
    @if ($product->variants->isNotEmpty())
        @if ($hasStructuredAttributes)
            <!-- Per-attribute selectors (Amazon style) -->
            @foreach ($productOptions as $attribute)
                <fieldset class="mt-6 first:mt-0" wire:key="attr-{{ $attribute['id'] }}">
                    <legend class="text-sm font-medium text-zinc-900">
                        {{ $attribute['name'] }}
                        @if ($selectedOptions[$attribute['id']] ?? null)
                            @php
                                $selectedLabel = collect($attribute['values'])->firstWhere('id', $selectedOptions[$attribute['id']])['value'] ?? null;
                            @endphp
                            @if ($selectedLabel)
                                : <span class="font-normal text-zinc-500">{{ $selectedLabel }}</span>
                            @endif
                        @endif
                    </legend>

                    @if ($attribute['type'] === \Shopper\Core\Enum\FieldType::ColorPicker())
                        <!-- Color swatches -->
                        <div class="mt-3 flex flex-wrap gap-3">
                            @foreach ($attribute['values'] as $value)
                                @php
                                    $isSelected = ($selectedOptions[$attribute['id']] ?? null) === $value['id'];
                                    $isAvailable = $availabilityMap[$attribute['id']][$value['id']] ?? false;
                                @endphp
                                <button
                                    type="button"
                                    wire:click="selectOption({{ $attribute['id'] }}, {{ $value['id'] }})"
                                    wire:key="opt-{{ $attribute['id'] }}-{{ $value['id'] }}"
                                    @class([
                                        'relative flex items-center justify-center p-0.5 focus:outline-none',
                                        'rounded-lg' => $value['image'],
                                        'rounded-full' => ! $value['image'],
                                        'ring-2 ring-primary-600 ring-offset-2' => $isSelected,
                                        'opacity-40 cursor-not-allowed' => ! $isAvailable,
                                    ])
                                    @if (! $isAvailable) disabled @endif
                                    title="{{ $value['value'] }}"
                                >
                                    @if ($value['image'])
                                        <img
                                            src="{{ $value['image'] }}"
                                            alt="{{ $value['value'] }}"
                                            class="size-12 rounded-lg border border-black/10 object-cover"
                                        />
                                    @else
                                        <span
                                            aria-hidden="true"
                                            style="background-color: {{ $value['key'] }}"
                                            class="size-8 rounded-full border border-black/10"
                                        ></span>
                                    @endif
                                    <span class="sr-only">{{ $value['value'] }}</span>
                                    @if (! $isAvailable)
                                        <x-strikethrough-overlay
                                            :rounded="$value['image'] ? 'rounded-lg' : 'rounded-full'"
                                            :stroke-width="4"
                                            stroke-color="text-zinc-400"
                                        />
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @else
                        <!-- Text chips -->
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($attribute['values'] as $value)
                                @php
                                    $isSelected = ($selectedOptions[$attribute['id']] ?? null) === $value['id'];
                                    $isAvailable = $availabilityMap[$attribute['id']][$value['id']] ?? false;
                                @endphp
                                <button
                                    type="button"
                                    wire:click="selectOption({{ $attribute['id'] }}, {{ $value['id'] }})"
                                    wire:key="opt-{{ $attribute['id'] }}-{{ $value['id'] }}"
                                    @class([
                                        'relative inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md border focus:outline-none transition-colors',
                                        'border-transparent bg-primary-600 text-white hover:bg-primary-700' => $isSelected,
                                        'border-zinc-200 bg-white text-zinc-900 hover:bg-zinc-50' => ! $isSelected && $isAvailable,
                                        'border-zinc-200 bg-zinc-100 text-zinc-400 cursor-not-allowed' => ! $isAvailable,
                                    ])
                                    @if (! $isAvailable) disabled @endif
                                >
                                    {{ $value['value'] }}
                                    @if (! $isAvailable && ! $isSelected)
                                        <x-strikethrough-overlay rounded="rounded-md overflow-hidden" />
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            @endforeach
        @else
            <!-- Fallback: flat grid for variants without structured attributes -->
            <fieldset>
                <legend class="text-sm font-medium text-zinc-900">
                    {{ __('Variants') }}
                    @if ($selectedVariant)
                        : <span class="font-normal text-zinc-500">{{ $selectedVariant->name }}</span>
                    @endif
                </legend>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($product->variants as $variant)
                        @php
                            $isSelected = $selectedVariant && $selectedVariant->id === $variant->id;
                            $isOutOfStockVariant = $variant->stock < 1 && ! $variant->allow_backorder;
                            $hasNoPrice = is_null($variant->getFormattedPrice());
                            $isDisabled = $isOutOfStockVariant || $hasNoPrice;
                        @endphp
                        <button
                            type="button"
                            wire:click="selectVariantDirectly({{ $variant->id }})"
                            wire:key="variant-{{ $variant->id }}"
                            @class([
                                'relative inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md border focus:outline-none transition-colors',
                                'border-transparent bg-primary-600 text-white hover:bg-primary-700' => $isSelected,
                                'border-zinc-200 bg-white text-zinc-900 hover:bg-zinc-50' => ! $isSelected && ! $isDisabled,
                                'border-zinc-200 bg-zinc-100 text-zinc-400 cursor-not-allowed' => $isDisabled,
                            ])
                            @if ($isDisabled) disabled @endif
                        >
                            {{ $variant->name }}
                            @if ($isDisabled)
                                <x-strikethrough-overlay rounded="rounded-md overflow-hidden" />
                            @endif
                        </button>
                    @endforeach
                </div>
            </fieldset>
        @endif
    @endif

    @php
        $currentModel = $selectedVariant ?? $product;
        $hasNoPrice = is_null($currentModel->getFormattedPrice());
        $isOutOfStock = ($product->isVariant() && $selectedVariant && $selectedVariant->stock < 1 && ! $selectedVariant->allow_backorder)
            || (! $product->isVariant() && $product->stock < 1);
        $needsVariant = $product->isVariant() && ! $selectedVariant;
        $isStockLimitReached = ! $needsVariant && ! $isOutOfStock
            && ! ($currentModel->allow_backorder ?? false)
            && $this->getCartQuantityForModel() >= $currentModel->stock;
    @endphp

    <div class="flex items-center gap-2 mt-10">
        <flux:button
            variant="primary"
            type="submit"
            class="max-w-xs sm:w-full"
            :disabled="$hasNoPrice || $isOutOfStock || $needsVariant || $isStockLimitReached"
        >
            @if ($needsVariant)
                {{ __('Choose any variant') }}
            @elseif ($hasNoPrice)
                {{ __('Unavailable') }}
            @elseif ($isOutOfStock)
                {{ __('Out of stock') }}
            @elseif ($isStockLimitReached)
                {{ __('Stock limit reached') }}
            @else
                {{ __('Add to cart') }}
            @endif
        </flux:button>

        <flux:button type="button">
            <x-untitledui-heart class="size-5" aria-hidden="true" />
            <span class="sr-only">{{ __('Add to favorites') }}</span>
        </flux:button>
    </div>
</form>
