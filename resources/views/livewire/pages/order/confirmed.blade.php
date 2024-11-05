<?php

declare(strict_types=1);

use Shopper\Core\Models\Order;

use function Livewire\Volt\mount;
use function Livewire\Volt\state;

state(['order' => null]);

mount(function (string $number): void {
        $this->order = Order::with(['items', 'shippingOption', 'shippingAddress', 'paymentMethod'])
            ->where('number', $number)
            ->firstOrFail();
});

?>

<x-container class="py-16 sm:pb-32 sm:pt-24 lg:max-w-4xl">
    <!-- Session Status -->
    <x-alert.success class="mb-4" :status="session('status')" />
    <x-alert.error class="mb-4" :status="session('error')" />

    <div class="max-w-xl">
        <p class="text-2xl font-medium tracking-tight text-gray-900">
            {{ __('Thank you!') }}
        </p>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            {{ __('Your order has been placed successfully') }}
        </h1>
        <p class="mt-2 text-gray-500 text">
            {{ __('The details of your order have been sent to you by email.') }}
        </p>
    </div>

    <div class="mt-10 space-y-10 sm:mt-14 sm:space-y-14">
        <div>
            <h3 class="sr-only">
                {{ __('Order placed on') }}
                <time datetime="{{ $order->created_at->format('Y-m-d') }}" class="capitalize">
                    {{ $order->created_at->translatedFormat('j F Y') }}
                </time>
            </h3>
            <div class="px-4 py-6 bg-gray-50/50 ring-1 ring-gray-100 sm:p-6 md:flex md:items-center md:justify-between md:space-x-6 lg:space-x-8">
                <dl class="flex-auto space-y-4 text-sm text-gray-500 divide-y divide-gray-200 md:grid md:grid-cols-3 md:gap-x-6 md:space-y-0 md:divide-y-0 lg:w-1/2 lg:flex-none lg:gap-x-8">
                    <div class="flex justify-between md:block">
                        <dt class="font-medium text-gray-900">
                            {{ __('Order number') }}
                        </dt>
                        <dd class="uppercase md:mt-1">{{ $order->number }}</dd>
                    </div>
                    <div class="flex justify-between pt-4 md:block md:pt-0">
                        <dt class="font-medium text-gray-900">
                            {{ __('Passed the') }}
                        </dt>
                        <dd class="capitalize md:mt-1">
                            <time datetime="{{ $order->created_at->format('Y-m-d') }}">
                                {{ $order->created_at->translatedFormat('j F Y') }}
                            </time>
                        </dd>
                    </div>
                    <div class="flex justify-between pt-4 font-medium text-gray-900 lg:block md:pt-0">
                        <dt class="font-semibold">{{ __('Total') }}</dt>
                        <dd class="md:mt-1">
                            {{ shopper_money_format($order->total() + $order->shippingOption->price, $order->currency_code) }}
                        </dd>
                    </div>
                </dl>
                <div class="mt-6 space-y-4 sm:flex sm:space-x-4 sm:space-y-0 md:mt-0">
                    <x-buttons.default :href="route('dashboard.orders.detail', ['number' => $order->number])" class="flex w-full px-4 py-2 text-sm md:w-auto">
                        {{ __('Detail') }}
                        <span class="sr-only">{{ $order->number }}</span>
                    </x-buttons.default>
                    <x-buttons.default class="flex w-full px-4 py-2 text-sm md:w-auto">
                        {{ __('View invoice') }}
                        <span class="sr-only">
                            {{ __('To order :number', ['number' => $order?->number]) }}
                        </span>
                    </x-buttons.default>
                </div>
            </div>
        </div>
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
            <div class="space-y-10 ">
                <div class="flow-root px-4 sm:px-0">
                    <div class="-my-6 divide-y divide-gray-200 sm:-my-10">
                        @foreach($order->items as $item)
                            <x-order.item :item="$item" :currency_code="$order->currency_code" />
                        @endforeach
                    </div>
                </div>
                <div class="p-4 rounded bg-gray-50">
                    <div class="flex">
                        <div class="shrink-0">
                            <x-untitledui-info-circle class="w-5 h-5 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                        </div>
                        <div class="flex-1 ml-3 md:flex md:justify-between">
                            <p class="text-sm text-gray-700">
                                {{ __("You can follow the progress and processing of your order from your profile.") }}
                            </p>
                        </div>
                    </div>
                    <p class="pl-8 mt-3 text-sm">
                        <x-link :href="route('dashboard.orders')" class="font-medium text-gray-700 whitespace-nowrap hover:text-gray-600">
                            {{ __('My orders') }}
                            <span aria-hidden="true"> &rarr;</span>
                        </x-link>
                    </p>
                </div>
            </div>
            <div>
                <div class="flex items-end justify-end">
                    <h6 class="bg-brand inline-flex w-auto px-2.5 py-1 text-sm leading-6 text-white">
                        {{ __('Order summary') }}
                    </h6>
                </div>
                <x-order.summary :order="$order" />
            </div>
        </div>
    </div>
</x-container>
