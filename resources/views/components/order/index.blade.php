@props(['order'])

<div class="py-6 lg:py-8 lg:max-w-4xl">
    <div class="bg-gray-50 py-2.5 px-4 space-y-1.5 lg:grid lg:grid-cols-2 lg:gap-x-4 lg:space-y-0">
        <div class="grid grid-cols-2 gap-x-4">
            <div class="text-sm">
                <dt class="font-medium text-gray-900">
                    {{ __('N° de commande') }}
                </dt>
                <dd class="mt-1 text-gray-500 uppercase">
                    {{ $order->number }}
                </dd>
            </div>
            <div class="text-sm">
                <dt class="font-medium text-gray-900">
                    {{ __('Passée le') }}
                </dt>
                <dd class="mt-1 text-gray-500 capitalize">
                    <time datetime="{{ $order->created_at->format('Y-m-d') }}">
                        {{ $order->created_at->translatedFormat('j F Y') }}
                    </time>
                </dd>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-4">
            <div class="text-sm">
                <dt class="font-medium text-gray-900">
                    {{ __('Total') }}
                </dt>
                <dd class="mt-1 text-gray-500">
                    {{ shopper_money_format($order->total() + $order->shippingOption?->price, $order->currency_code) }}
                </dd>
            </div>
            <div class="text-sm">
                <dt class="font-medium text-gray-900">{{ __('Status') }}</dt>
                <dd class="mt-1 text-gray-500">
                    <x-order.status :status="$order->status" />
                </dd>
            </div>
        </div>
    </div>
    <div class="mt-6 grid grid-cols-1 gap-y-5 lg:grid-cols-4 lg:gap-x-12">
        <div class="flex items-center space-x-2 lg:col-span-3">
            @foreach($order->items->take(5) as $item)
                <div class="relative overflow-hidden">
                    @if($order->items->count() > 5 && $loop->index === 4)
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
            <x-buttons.primary class="w-full px-4" :link="route('account.orders.detail', ['number' => $order->number])">
                {{ __('Afficher les détails') }}
            </x-buttons.primary>
            <x-buttons.default class="w-full px-4">
                {{ __('Facture') }}
                <x-filament::badge size="sm" color="gray" class="ml-2">
                    {{ __('Bientôt') }}
                </x-filament::badge>
            </x-buttons.default>
        </div>
    </div>
</div>
