<div class="bg-white">
    <!-- Background color split screen for large screens -->
    <div class="fixed top-0 left-0 hidden w-1/2 h-full bg-white lg:block" aria-hidden="true"></div>
    <div class="fixed top-0 right-0 hidden w-1/2 h-full bg-primary-800 lg:block" aria-hidden="true"></div>

    <header class="relative text-sm font-medium text-gray-700 bg-white border-b border-gray-200">
        <x-container class="py-4">
            <div class="relative flex items-center gap-10">
                <x-link :href="route('home')">
                    <span class="sr-only">{{ shopper_setting('legal_name') }}</span>
                    <x-brand class="w-auto h-10 text-primary-700" aria-hidden="true" />
                </x-link>
                <x-link href="#" class="inline-flex items-center font-medium text-gray-600 hover:text-gray-900">
                    {{ __('Back to Shopping Cart') }}
                </x-link>
            </div>
         </x-container>
    </header>

    <x-container class="relative grid grid-cols-1 gap-x-16 lg:grid-cols-2 xl:gap-x-48">
        <h1 class="sr-only">{{ __('Order information') }}</h1>

        <section
            aria-labelledby="summary-heading"
            class="px-4 pt-16 pb-10 bg-primary-950 sm:px-6 lg:col-start-2 lg:row-start-1 lg:bg-transparent lg:px-0 lg:pb-16"
        >
            <div class="max-w-lg mx-auto lg:max-w-none">
                <h2 id="summary-heading" class="text-lg font-medium text-white">
                    {{ __('Cart summary') }}
                </h2>

                <ul role="list" class="text-sm font-medium text-white divide-y divide-white/10">
                    @foreach($items as $item)
                        <x-cart.element :item="$item" />
                    @endforeach
                </ul>

                <dl class="hidden pt-6 space-y-6 text-sm font-medium text-white border-t border-white/10 lg:block">
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-300">{{ __('Subtotal') }}</dt>
                        <dd>
                            {{ shopper_money_format(amount: $subtotal, currency: \App\Actions\ZoneSessionManager::getSession()?->currencyCode) }}
                        </dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-gray-300">{{ __('Delivery') }}</dt>
                        <livewire:components.shipping-price />
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-gray-300">{{ __('Tax') }}</dt>
                        <livewire:components.tax-price />
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-white/10">
                        <dt class="text-base">{{ __('Total') }}</dt>
                        <livewire:components.cart-total />
                    </div>
                </dl>

                <div class="lg:hidden">
                    <div
                        x-data="{ open: false }"
                        @keydown.escape="open = false"
                        class="fixed inset-x-0 bottom-0 flex flex-col-reverse text-sm font-medium text-white lg:hidden"
                    >
                        <div class="relative z-10 px-4 bg-white border-t border-white/10 sm:px-6">
                            <div class="max-w-lg mx-auto">
                                <button
                                    type="button"
                                    class="flex items-center w-full py-6 font-medium"
                                    aria-expanded="false"
                                    @click="open = !open"
                                >
                                    <span class="mr-auto text-base">{{ __('Total') }}</span>
                                    <span class="mr-2 text-base">
                                        <livewire:components.cart-total />
                                    </span>
                                    <svg
                                        class="w-5 h-5 text-gray-500"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z"
                                            clip-rule="evenodd"
                                        />
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
                                class="fixed inset-0 bg-black bg-opacity-25"
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
                                <dl class="max-w-lg mx-auto space-y-6">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-400">{{ __('SubTotal') }}</dt>
                                        <dd>
                                            {{ shopper_money_format(amount: $subtotal, currency: \App\Actions\ZoneSessionManager::getSession()?->currencyCode) }}
                                        </dd>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-400">{{ __('Delivery') }}</dt>
                                        <livewire:components.shipping-price />
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-400">{{ __('Tax') }}</dt>
                                        <livewire:components.tax-price />
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="px-4 pt-16 pb-36 sm:px-6 lg:col-start-1 lg:row-start-1 lg:px-0 lg:pb-16">
            <livewire:checkout-wizard />
        </div>
    </x-container>
</div>
