@props([
    'order',
])

<div {{ $attributes->twMerge(['class' => 'flex items-center justify-between px-4 py-2 rounded-lg ring-1 ring-zinc-200 bg-zinc-50']) }}>
    <div class="text-sm">
        <dt class="font-medium tracking-tighter text-zinc-900">
            {{ __('Order number') }}
        </dt>
        <dd class="mt-1 font-medium uppercase text-zinc-500">
            {{ $order->number }}
        </dd>
    </div>
    <div class="text-sm">
        <dt class="font-medium tracking-tighter text-zinc-900">
            {{ __('Passed the') }}
        </dt>
        <dd class="mt-1 text-zinc-500 capitalize">
            <time datetime="{{ $order->created_at->format('Y-m-d') }}">
                {{ $order->created_at->translatedFormat('j F Y') }}
            </time>
        </dd>
    </div>
    <div class="text-sm">
        <dt class="font-medium tracking-tighter text-zinc-900">
            {{ __('Total') }}
        </dt>
        <dd class="mt-1 text-zinc-500">
            {{ shopper_money_format($order->total() + ($order->shippingOption?->price ?? 0), $order->currency_code) }}
        </dd>
    </div>
    <div class="text-sm">
        <dt class="font-medium tracking-tighter text-zinc-900">{{ __('Status') }}</dt>
        <dd class="mt-1 text-zinc-500">
            <x-order.status :status="$order->status" />
        </dd>
    </div>
</div>
