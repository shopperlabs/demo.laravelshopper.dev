@props([
    'order',
])

<div class="py-6 lg:py-8 lg:max-w-4xl">
    <x-order.header :$order class="py-2.5 space-y-1.5 lg:space-y-0" />
    <div class="mt-6 grid grid-cols-1 gap-y-5 lg:grid-cols-4 lg:gap-x-12">
        <div class="flex items-center space-x-2 lg:col-span-3">
            @foreach ($order->items->take(5) as $item)
                <div class="relative overflow-hidden">
                    @if ($order->items->count() > 5 && $loop->index === 4)
                        <div class="absolute inset-0 z-50 flex items-center justify-center bg-black/70">
                          <span class="text-lg font-medium text-white">
                            + {{  $order->items->count() - 5 }}
                          </span>
                        </div>
                    @endif
                    <x-products.thumbnail :product="$item->product" class="aspect-none size-24" />
                </div>
            @endforeach
        </div>
        <div class="grid grid-cols-2 gap-x-5 lg:flex lg:flex-col lg:items-end lg:justify-end lg:space-y-2 lg:pl-4">
            <flux:button variant="primary" class="w-full" :href="route('dashboard.orders.detail', ['number' => $order->number])">
                {{ __('Show details') }}
            </flux:button>
            <flux:button class="w-full">
                {{ __('Invoice') }}
                <x-filament::badge size="sm" color="gray" class="ml-2">
                    {{ __('Soon') }}
                </x-filament::badge>
            </flux:button>
        </div>
    </div>
</div>
