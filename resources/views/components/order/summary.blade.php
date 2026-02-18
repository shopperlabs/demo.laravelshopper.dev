@props([
    'order',
])

<div class="py-4 rounded-xl border border-zinc-200 divide-y divide-zinc-200 divide-dashed">
    <dl class="px-4 pb-4 space-y-4">
        <div class="flex items-center justify-between text-sm">
            <dt class="text-zinc-700">{{ __('Subtotal') }}</dt>
            <dd class="font-medium text-zinc-900">
                {{ shopper_money_format($order->total(), $order->currency_code) }}
            </dd>
        </div>
        <div class="flex items-center text-sm justify-between">
            <dt class="text-zinc-700">{{ __('Delivery') }}</dt>
            <dd class="font-medium text-zinc-900">
                {{ shopper_money_format($order->shippingOption?->price ?? 0, $order->currency_code) }}
            </dd>
        </div>
        <div class="flex items-center justify-between text-sm">
            <dt class="text-zinc-700">{{ __('Tax') }}</dt>
            <dd class="font-medium text-zinc-900">
                {{ shopper_money_format(0, $order->currency_code) }}
            </dd>
        </div>
        <div class="flex items-center justify-between pt-4 border-t border-zinc-200">
            <dt class="font-medium font-heading text-primary-700">{{ __('Total') }}</dt>
            <dd class="text-base font-bold text-zinc-900">
                {{ shopper_money_format($order->total() + ($order->shippingOption?->price ?? 0), $order->currency_code) }}
            </dd>
        </div>
    </dl>
    <dl class="grid grid-cols-2 p-4 text-sm gap-x-6">
        <div>
            <dt class="font-medium text-zinc-900">
                {{ __('Delivery address') }}
            </dt>
            <dd class="mt-2 text-zinc-500">
                <span class="block">
                    {{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}
                </span>
                <span class="block">{{ $order->shippingAddress->street_address }}</span>
                <span class="block">
                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->postal_code }}
                </span>
                <span class="block">{{ $order->shippingAddress->country_name }}</span>
            </dd>
        </div>
        <div>
            <dt class="font-medium text-zinc-900">
                {{ __('Billing address') }}
            </dt>
            <dd class="mt-2 text-zinc-500">
                <span class="block">
                    {{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}
                </span>
                <span class="block">{{ $order->billingAddress->street_address }}</span>
                <span class="block">
                    {{ $order->billingAddress->city }}, {{ $order->billingAddress->postal_code }}
                </span>
                <span class="block">{{ $order->billingAddress->country_name }}</span>
            </dd>
        </div>
    </dl>
    <dl class="p-4 space-y-3">
        <dt class="text-sm font-medium leading-6 text-zinc-900">
            {{ __('Payment method') }}
        </dt>
        <dd class="flex items-center gap-2 text-sm text-zinc-500">
            <x-dynamic-component class="size-5" :component="'icons.payments.' . $order->paymentMethod->slug" />
            <span class="text-base font-medium leading-6">{{ $order->paymentMethod->title }}</span>
        </dd>
    </dl>
</div>
