<div class="bg-white">
    <div class="fixed top-0 left-0 hidden w-1/2 h-full bg-white lg:block" aria-hidden="true"></div>
    <div class="fixed top-0 right-0 hidden w-1/2 h-full bg-zinc-50 border-l border-zinc-200 lg:block" aria-hidden="true"></div>

    <header class="relative border-b border-zinc-200 bg-white">
        <x-container class="py-4">
            <div class="relative flex items-center justify-between">
                <x-link :href="route('home')">
                    <span class="sr-only">{{ shopper_setting('legal_name') }}</span>
                    <x-brand class="w-auto h-10 text-primary-700" aria-hidden="true" />
                </x-link>
                <x-link :href="route('store')" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-600 hover:text-zinc-900">
                    <x-untitledui-arrow-narrow-left class="size-5 text-zinc-400" aria-hidden="true" stroke-width="1.5" />
                    {{ __('Back to Shopping Cart') }}
                </x-link>
            </div>
        </x-container>
    </header>

    <h1 class="sr-only">{{ __('Order information') }}</h1>

    <x-container class="relative grid grid-cols-1 gap-x-16 lg:grid-cols-2 xl:gap-x-48">
        <section
            aria-labelledby="summary-heading"
            class="px-4 pt-16 pb-10 bg-zinc-50 sm:px-6 lg:col-start-2 lg:row-start-1 lg:bg-transparent lg:px-0 lg:pb-16"
        >
            <div class="max-w-lg mx-auto lg:max-w-none">
                <h2 id="summary-heading" class="text-lg font-medium text-zinc-900">
                    {{ __('Cart summary') }}
                </h2>

                <ul role="list" class="text-sm font-medium divide-y divide-zinc-200">
                    @foreach ($items as $line)
                        <x-cart.element :$line />
                    @endforeach
                </ul>

                <div class="hidden py-6 border-t border-zinc-200 lg:block">
                    <h3 class="text-sm font-medium text-zinc-900">{{ __('Discount code') }}</h3>
                    <div class="mt-2">
                        <livewire:components.coupon-code />
                    </div>
                </div>

                <dl class="hidden pt-6 space-y-4 text-sm font-medium border-t border-zinc-200 lg:block">
                    <div class="flex items-center justify-between">
                        <dt class="text-zinc-500">{{ __('Subtotal') }} {{ current_tax_label() }}</dt>
                        <dd class="text-zinc-900">
                            {{ format_cents($subtotal) }}
                        </dd>
                    </div>

                    <livewire:components.discount-total />

                    <div class="flex items-center justify-between">
                        <dt class="text-zinc-500">{{ __('Shipping') }}</dt>
                        <dd class="text-zinc-900">
                            <livewire:components.shipping-price />
                        </dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-zinc-500">{{ __('Tax') }}</dt>
                        <dd class="text-zinc-900">
                            <livewire:components.tax-price />
                        </dd>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-zinc-200">
                        <dt class="text-base text-zinc-900">{{ __('Total') }}</dt>
                        <dd class="text-base text-zinc-900">
                            <livewire:components.cart-total />
                        </dd>
                    </div>
                </dl>

                <div class="lg:hidden">
                    <div
                        x-data="{ open: false }"
                        @keydown.escape="open = false"
                        class="fixed inset-x-0 bottom-0 flex flex-col-reverse text-sm font-medium lg:hidden"
                    >
                        <div class="relative z-10 px-4 bg-white border-t border-zinc-200 sm:px-6">
                            <div class="max-w-lg mx-auto">
                                <button
                                    type="button"
                                    class="flex items-center w-full py-6 font-medium text-zinc-900"
                                    aria-expanded="false"
                                    @click="open = !open"
                                >
                                    <span class="mr-auto text-base">{{ __('Total') }}</span>
                                    <span class="mr-2 text-base">
                                        <livewire:components.cart-total />
                                    </span>
                                    <svg class="size-5 text-zinc-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <div
                                x-show="open"
                                x-transition:enter="transition-opacity duration-300 ease-linear"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-300 ease-linear"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="fixed inset-0 bg-black/25"
                                @click="open = !open"
                                aria-hidden="true"
                                style="display: none"
                            ></div>

                            <div
                                x-show="open"
                                x-transition:enter="transform transition duration-300 ease-in-out"
                                x-transition:enter-start="translate-y-full"
                                x-transition:enter-end="translate-y-0"
                                x-transition:leave="transform transition duration-300 ease-in-out"
                                x-transition:leave-start="translate-y-0"
                                x-transition:leave-end="translate-y-full"
                                class="relative px-4 py-6 bg-white sm:px-6"
                                x-ref="panel"
                                @click.away="open = false"
                                style="display: none"
                            >
                                <div class="max-w-lg mx-auto mb-6">
                                    <h3 class="text-sm font-medium text-zinc-900">{{ __('Discount code') }}</h3>
                                    <div class="mt-2">
                                        <livewire:components.coupon-code />
                                    </div>
                                </div>

                                <dl class="max-w-lg mx-auto space-y-6">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-zinc-500">{{ __('Subtotal') }} {{ current_tax_label() }}</dt>
                                        <dd class="text-zinc-900">
                                            {{ format_cents($subtotal) }}
                                        </dd>
                                    </div>

                                    <livewire:components.discount-total />

                                    <div class="flex items-center justify-between">
                                        <dt class="text-zinc-500">{{ __('Shipping') }}</dt>
                                        <dd class="text-zinc-900">
                                            <livewire:components.shipping-price />
                                        </dd>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <dt class="text-zinc-500">{{ __('Tax') }}</dt>
                                        <dd class="text-zinc-900">
                                            <livewire:components.tax-price />
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="flex flex-col gap-10 justify-between px-4 py-10 sm:px-6 lg:col-start-1 lg:row-start-1 lg:px-0 h-full">
            <livewire:checkout-wizard />
        </div>
    </x-container>
</div>
