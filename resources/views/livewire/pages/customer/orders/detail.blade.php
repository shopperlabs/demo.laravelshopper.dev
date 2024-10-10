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
    $this->order = Order::with(['items', 'shippingOption', 'shippingAddress', 'paymentMethod'])
        ->where('number', $number)
        ->firstOrFail();
});

title('Détail de votre commande');

?>

<div>
    <h1 class="font-heading font-semibold text-xl text-gray-900 lg:text-2xl">
        {{ __('Détail de la commande') }}
    </h1>
    <div class="mt-6 flex flex-col space-y-10 lg:space-y-14">
        <div class="flex items-center bg-gray-50 px-4 py-2 justify-between lg:max-w-5xl">
            <div class="text-sm">
                <dt class="font-medium tracking-tighter text-gray-700">
                    {{ __('N° de commande') }}
                </dt>
                <dd class="ml-1.5 font-medium uppercase text-gray-500">
                    {{ $order->number }}
                </dd>
            </div>
            <div class="text-sm">
                <dt class="font-medium tracking-tighter text-gray-900">
                    {{ __('Passée le') }}
                </dt>
                <dd class="mt-1 text-gray-500 capitalize">
                    <time datetime="{{ $order->created_at->format('Y-m-d') }}">
                        {{ $order->created_at->translatedFormat('j F Y') }}
                    </time>
                </dd>
            </div>
            <div class="text-sm">
                <dt class="font-medium tracking-tighter text-gray-900">
                    {{ __('Total') }}
                </dt>
                <dd class="mt-1 text-gray-500">
                    {{ shopper_money_format($order->total() + $order->shippingOption->price, $order->currency_code) }}
                </dd>
            </div>
            <div class="text-sm">
                <dt class="font-medium tracking-tighter text-gray-900">{{ __('Status') }}</dt>
                <dd class="mt-1 text-gray-500">
                    <x-order.status :status="$order->status" />
                </dd>
            </div>
        </div>

        <x-order.items :items="$order->items" :currency_code="$order->currency_code" />

        <div class="max-w-xl">
            <div class="flex items-end justify-end">
                <h6 class="bg-brand inline-flex w-auto px-2.5 py-1 text-sm leading-6 text-white">
                    {{ __('Résumé de la commande') }}
                </h6>
            </div>
            <x-order.summary :order="$order" />
        </div>
    </div>
    <div class="mt-10 max-w-md lg:mt-20">
        <p class="mt-5 text-sm leading-5 text-gray-500">
            {{ __('Vous rencontrez un problème avec votre commande ? Notre service client est là pour vous aider') }}
        </p>
        <div class="mt-4">
            <x-buttons.default link="/" class="px-4">
                {{ __('Contactez-nous') }}
            </x-buttons.default>
        </div>
    </div>
</div>

