@php
    $shippingAddress = session()->get(\App\CheckoutSession::SHIPPING_ADDRESS);
    $shippingOption = session()->get(\App\CheckoutSession::SHIPPING_OPTION);
    $stepsArray = collect($steps)->values();
@endphp

@if ($shippingAddress)
    <div class="rounded-lg border border-zinc-200 divide-y divide-zinc-200 text-sm">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-baseline gap-6">
                <span class="text-zinc-500 w-16 shrink-0">{{ __('Contact') }}</span>
                <span class="text-zinc-900">{{ auth()->user()->email }}</span>
            </div>
            @if ($stepsArray->get(0)?->complete)
                <button wire:click="{{ $stepsArray->get(0)->show() }}" class="text-primary-600 hover:text-primary-700 text-xs font-medium shrink-0">
                    {{ __('Change') }}
                </button>
            @endif
        </div>

        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-baseline gap-6">
                <span class="text-zinc-500 w-16 shrink-0">{{ __('Ship to') }}</span>
                <span class="text-zinc-900">
                    {{ $shippingAddress['street_address'] }}, {{ $shippingAddress['city'] }} {{ $shippingAddress['postal_code'] }}
                </span>
            </div>
            @if ($stepsArray->get(0)?->complete)
                <button wire:click="{{ $stepsArray->get(0)->show() }}" class="text-primary-600 hover:text-primary-700 text-xs font-medium shrink-0">
                    {{ __('Change') }}
                </button>
            @endif
        </div>

        @if ($shippingOption)
            <div class="flex items-center justify-between px-4 py-3">
                <div class="flex items-baseline gap-6">
                    <span class="text-zinc-500 w-16 shrink-0">{{ __('Method') }}</span>
                    <span class="text-zinc-900">
                        {{ $shippingOption[0]['name'] }} &middot;
                        {{ shopper_money_format($shippingOption[0]['price'], \App\Actions\ZoneSessionManager::getSession()->currencyCode) }}
                    </span>
                </div>
                @if ($stepsArray->get(1)?->complete)
                    <button wire:click="{{ $stepsArray->get(1)->show() }}" class="text-primary-600 hover:text-primary-700 text-xs font-medium shrink-0">
                        {{ __('Change') }}
                    </button>
                @endif
            </div>
        @endif
    </div>
@endif
