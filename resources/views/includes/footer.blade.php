<footer aria-labelledby="footer-heading" class="bg-secondary-900">
    <h2 id="footer-heading" class="sr-only">{{ __('Footer') }}</h2>
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="py-20">
            <div class="md:flex md:justify-center">
                <x-shopper::brand class="h-12 w-auto sm:h-16" />
            </div>
            <div class="mt-14 xl:grid xl:grid-cols-2 xl:gap-8">
                <div class="grid grid-cols-2 gap-8 xl:col-span-2">
                    <div class="space-y-12 md:grid md:grid-cols-2 md:gap-8 md:space-y-0">
                        <div>
                            <h3 class="text-sm font-medium text-white font-heading">Products</h3>
                            <ul role="list" class="mt-6 space-y-6">
                                <li>
                                    <x-footer-link href="#" text="{{ __('Bags') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Tees') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Objects') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Home Goods') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Accessories') }}" />
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-white font-heading">Customer Service</h3>
                            <ul role="list" class="mt-6 space-y-6">
                                <li>
                                    <x-footer-link href="#" text="{{ __('Contact') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Shipping') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Returns') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Warranty') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Secure Payments') }}" />
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="space-y-12 md:grid md:grid-cols-2 md:gap-8 md:space-y-0">
                        <div>
                            <h3 class="text-sm font-medium text-white font-heading">Company</h3>
                            <ul role="list" class="mt-6 space-y-6">
                                <li>
                                    <x-footer-link href="#" text="{{ __('Who we are') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Sustainability') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Press') }}" />
                                    <a href="#" class="text-gray-500 hover:text-gray-600"></a>
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Careers') }}" />
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-white font-heading">Legal</h3>
                            <ul role="list" class="mt-6 space-y-6">
                                <li>
                                    <x-footer-link href="#" text="{{ __('Terms of Service') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Return Policy') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Privacy Policy') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Shipping Policy') }}" />
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-6 xl:gap-x-8">
            <div class="flex items-center rounded-lg bg-secondary-800 p-6 sm:p-10">
                <div class="mx-auto max-w-sm">
                    <h3 class="font-semibold text-lg text-white font-heading">
                        {{ __('Sign up for our newsletter') }}
                    </h3>
                    <p class="mt-2 text-sm text-secondary-400">
                        {{ __('The latest news, articles, and resources, sent to your inbox weekly.') }}
                    </p>
                    <form class="mt-4 sm:mt-6 sm:flex">
                        <label for="email-address" class="sr-only">{{ __('Email address') }}</label>
                        <input id="email-address" type="text" autocomplete="email" required class="w-full min-w-0 appearance-none rounded-md border border-secondary-300 bg-white px-4 py-2 text-base text-secondary-900 placeholder-secondary-500 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                        <div class="mt-3 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
                            <x-primary-button type="submit" class="text-base font-medium focus:ring-offset-secondary-800">
                                {{ __('Sign up') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="relative mt-6 flex items-center px-6 py-12 sm:px-10 sm:py-16 lg:mt-0">
                <div class="absolute inset-0 overflow-hidden rounded-lg">
                    <img src="https://tailwindui.com/img/ecommerce-images/footer-02-exclusive-sale.jpg" alt="" class="h-full w-full object-cover object-center saturate-0 filter">
                    <div class="absolute inset-0 bg-primary-600 bg-opacity-90"></div>
                </div>
                <div class="relative mx-auto max-w-sm text-center">
                    <h3 class="text-2xl font-bold tracking-tight text-white font-heading">
                        {{ __('Get early access') }}
                    </h3>
                    <p class="mt-2 text-secondary-200">
                        {{ __('Did you sign up to the newsletter? If so, use the keyword we sent you to get access.') }}
                        <a href="#" class="whitespace-nowrap font-bold text-white hover:text-primary-200">{{ __('Go now') }}<span aria-hidden="true"> →</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <div class="flex flex-col items-center sm:flex-row sm:justify-between">
            <p class="text-sm text-secondary-400">© {{ date('Y') }} Shopper Labs, Inc. All rights reserved.</p>
            <div class="mt-5 divide-x divide-secondary-700 sm:mt-0">
                <a href="#" class="inline-flex px-3 text-sm leading-5 text-white hover:text-primary-500 hover:underline">
                    {{ __('Privacy') }}
                </a>
                <a href="#" class="inline-flex px-3 text-sm leading-5 text-white hover:text-primary-500 hover:underline">
                    {{ __('Terms & Conditions') }}
                </a>
                <a href="#" class="inline-flex px-3 text-sm leading-5 text-white hover:text-primary-500 hover:underline">
                    {{ __('FAQs') }}
                </a>
            </div>
        </div>
    </div>
</footer>
