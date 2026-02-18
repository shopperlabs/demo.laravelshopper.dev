<?php

declare(strict_types=1);

use Shopper\Core\Models\Order;

use function Livewire\Volt\mount;
use function Livewire\Volt\state;
use function Livewire\Volt\title;
use function Livewire\Volt\layout;

layout('components.layouts.templates.account');
state(['order' => null]);

mount(function (string $number): void {
    $this->order = Order::with(['items.product', 'shippingOption', 'shippingAddress', 'paymentMethod'])
        ->where('number', $number)
        ->firstOrFail();
});

title(__('Details of your order'));

?>

<div>
    <h1 class="text-xl font-semibold text-zinc-900 font-heading lg:text-2xl">
        {{ __('Details of your order') }}
    </h1>
    <div class="flex flex-col mt-6 space-y-10 lg:space-y-14">
        <x-order.header :$order class="lg:max-w-5xl" />

        <x-order.items :items="$order->items" :currency_code="$order->currency_code" />

        <div class="max-w-xl">
            <div class="flex items-end justify-end">
                <h6 class="bg-brand inline-flex w-auto px-2.5 py-1 text-sm leading-6 text-white">
                    {{ __('order summary') }}
                </h6>
            </div>
            <x-order.summary :order="$order" />
        </div>
    </div>
    <div class="max-w-md mt-10 lg:mt-20">
        <p class="mt-5 text-sm leading-5 text-zinc-500">
            {{ __('Do you have a problem with your order? Our customer service is here to help') }}
        </p>
        <div class="mt-4">
            <flux:button href="/">
                {{ __('Contact us') }}
            </flux:button>
        </div>
    </div>
</div>

