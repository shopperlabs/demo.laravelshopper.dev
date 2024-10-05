<div class="bg-white">
    <!-- Background color split screen for large screens -->
    <div class="fixed left-0 top-0 hidden h-full w-1/2 bg-white lg:block" aria-hidden="true"></div>
    <div class="fixed right-0 top-0 hidden h-full w-1/2 bg-gray-50 lg:block" aria-hidden="true"></div>

    <header class="relative border-b border-gray-200 bg-white text-sm font-medium text-gray-700">
        <x-container class="py-3">
            <div class="relative flex items-center">
                <x-link :href="route('home')">
                    <span class="sr-only">{{ shopper_setting('legal_name') }}</span>
                    <x-brand class="h-10 w-auto" aria-hidden="true" />
                </x-link>
                <p class="sm:hidden">Step 2 of 4</p>
            </div>
        </x-container>
    </header>

    <x-container class="relative grid grid-cols-1 gap-x-16 lg:grid-cols-2 xl:gap-x-48">
        <h1 class="sr-only">{{ __('Informations sur la commande') }}</h1>

        <section
            aria-labelledby="summary-heading"
            class="bg-gray-50 px-4 pb-10 pt-16 sm:px-6 lg:col-start-2 lg:row-start-1 lg:bg-transparent lg:px-0 lg:pb-16"
        >
            <div class="mx-auto max-w-lg lg:max-w-none">
                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">
                    {{ __('Résumé de la commande') }}
                </h2>

                <ul role="list" class="divide-y divide-gray-200 text-sm font-medium text-gray-900">
                    <li class="flex items-start space-x-4 py-6">
                        <img
                            src="https://tailwindui.com/img/ecommerce-images/checkout-page-04-product-01.jpg"
                            alt="Moss green canvas compact backpack with double top zipper, zipper front pouch, and matching carry handle and backpack straps."
                            class="h-20 w-20 flex-none rounded-md object-cover object-center"
                        />
                        <div class="flex-auto space-y-1">
                            <h3>Micro Backpack</h3>
                            <p class="text-gray-500">Moss</p>
                            <p class="text-gray-500">5L</p>
                        </div>
                        <p class="flex-none text-base font-medium">$70.00</p>
                    </li>

                    <!-- More products... -->
                </ul>

                <dl class="hidden space-y-6 border-t border-gray-200 pt-6 text-sm font-medium text-gray-900 lg:block">
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-600">{{ __('Sous total') }}</dt>
                        <dd>$320.00</dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-gray-600">{{ __('Livraison') }}</dt>
                        <dd>$15.00</dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-gray-600">{{ __('Taxes') }}</dt>
                        <dd>$26.80</dd>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                        <dt class="text-base">{{ __('Total') }}</dt>
                        <dd class="text-base">$361.80</dd>
                    </div>
                </dl>

                <div class="lg:hidden">
                    <div
                        x-data="{ open: false }"
                        @keydown.escape="open = false"
                        class="fixed inset-x-0 bottom-0 flex flex-col-reverse text-sm font-medium text-gray-900 lg:hidden"
                    >
                        <div class="relative z-10 border-t border-gray-200 bg-white px-4 sm:px-6">
                            <div class="mx-auto max-w-lg">
                                <button
                                    type="button"
                                    class="flex w-full items-center py-6 font-medium"
                                    aria-expanded="false"
                                    @click="open = !open"
                                >
                                    <span class="mr-auto text-base">{{ __('Total') }}</span>
                                    <span class="mr-2 text-base">$361.80</span>
                                    <svg
                                        class="size-5 text-gray-500"
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
                                class="relative bg-white px-4 py-6 sm:px-6"
                                x-ref="panel"
                                @click.away="open = false"
                                style="display: none"
                            >
                                <dl class="mx-auto max-w-lg space-y-6">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-600">{{ __('Sous total') }}</dt>
                                        <dd>$320.00</dd>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-600">{{ __('Livraison') }}</dt>
                                        <dd>$15.00</dd>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-600">{{ __('Taxes') }}</dt>
                                        <dd>$26.80</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <form wire:submit="createOrder" class="px-4 pb-36 pt-16 sm:px-6 lg:col-start-1 lg:row-start-1 lg:px-0 lg:pb-16">
            <nav aria-label="Progress" class="hidden sm:block">
                <ol role="list" class="flex space-x-4">
                    <li class="flex items-center">
                        <x-link href="#">{{ __('Panier') }}</x-link>
                        <svg
                            class="ml-4 size-5 text-gray-300"
                            aria-hidden="true"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="#" aria-current="page" class="text-primary-600">Billing Information</a>
                        <svg
                            class="ml-4 size-5 text-gray-300"
                            aria-hidden="true"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="#">Confirmation</a>
                    </li>
                </ol>
            </nav>

            <div class="mx-auto mt-10 max-w-lg lg:max-w-none">
                <section aria-labelledby="contact-info-heading">
                    <h2 id="contact-info-heading" class="text-lg font-medium text-gray-900">Contact information</h2>

                    <div class="mt-6">
                        <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
                        <div class="mt-1">
                            <input
                                type="email"
                                id="email-address"
                                name="email-address"
                                autocomplete="email"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                            />
                        </div>
                    </div>
                </section>

                <section aria-labelledby="payment-heading" class="mt-10">
                    <h2 id="payment-heading" class="text-lg font-medium text-gray-900">Payment details</h2>

                    <div class="mt-6 grid grid-cols-3 gap-x-4 gap-y-6 sm:grid-cols-4">
                        <div class="col-span-3 sm:col-span-4">
                            <label for="name-on-card" class="block text-sm font-medium text-gray-700">
                                Name on card
                            </label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="name-on-card"
                                    name="name-on-card"
                                    autocomplete="cc-name"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div class="col-span-3 sm:col-span-4">
                            <label for="card-number" class="block text-sm font-medium text-gray-700">Card number</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="card-number"
                                    name="card-number"
                                    autocomplete="cc-number"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div class="col-span-2 sm:col-span-3">
                            <label for="expiration-date" class="block text-sm font-medium text-gray-700">
                                Expiration date (MM/YY)
                            </label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    name="expiration-date"
                                    id="expiration-date"
                                    autocomplete="cc-exp"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div>
                            <label for="cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    name="cvc"
                                    id="cvc"
                                    autocomplete="csc"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>
                    </div>
                </section>

                <section aria-labelledby="shipping-heading" class="mt-10">
                    <h2 id="shipping-heading" class="text-lg font-medium text-gray-900">Shipping address</h2>

                    <div class="mt-6 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-3">
                        <div class="sm:col-span-3">
                            <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="company"
                                    name="company"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="address"
                                    name="address"
                                    autocomplete="street-address"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="apartment" class="block text-sm font-medium text-gray-700">
                                Apartment, suite, etc.
                            </label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="apartment"
                                    name="apartment"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    autocomplete="address-level2"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div>
                            <label for="region" class="block text-sm font-medium text-gray-700">State / Province</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="region"
                                    name="region"
                                    autocomplete="address-level1"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div>
                            <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal code</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="postal-code"
                                    name="postal-code"
                                    autocomplete="postal-code"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                />
                            </div>
                        </div>
                    </div>
                </section>

                <section aria-labelledby="billing-heading" class="mt-10">
                    <h2 id="billing-heading" class="text-lg font-medium text-gray-900">Billing information</h2>

                    <div class="mt-6 flex items-center">
                        <input
                            id="same-as-shipping"
                            name="same-as-shipping"
                            type="checkbox"
                            checked
                            class="size-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                        />
                        <div class="ml-2">
                            <label for="same-as-shipping" class="text-sm font-medium text-gray-900">
                                Same as shipping information
                            </label>
                        </div>
                    </div>
                </section>

                {{ $this->form }}

                <div class="mt-10 border-t border-gray-200 pt-6 sm:flex sm:items-center sm:justify-end">
                    <x-buttons.primary type="submit" class="w-full px-4 py-2 text-sm sm:w-auto">
                        {{ __('Continuer') }}
                    </x-buttons.primary>
                </div>
            </div>
        </form>
    </x-container>
</div>
