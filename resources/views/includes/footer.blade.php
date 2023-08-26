<footer aria-labelledby="footer-heading" class="bg-black">
    <h2 id="footer-heading" class="sr-only">{{ __('Footer') }}</h2>
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="py-20">
            <div class="md:flex md:justify-center">
                <x-brand class="h-12 w-auto sm:h-16 text-white" />
            </div>
            <div class="mt-14 xl:grid xl:grid-cols-2 xl:gap-8">
                <div class="grid grid-cols-2 gap-8 xl:col-span-2">
                    <div class="space-y-12 md:grid md:grid-cols-2 md:gap-8 md:space-y-0">
                        <div>
                            <h3 class="text-sm font-medium text-white font-heading">{{ __('Customer Service') }}</h3>
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
                        <div>
                            <h3 class="text-sm font-medium text-white font-heading">{{ __('Company') }}</h3>
                            <ul role="list" class="mt-6 space-y-6">
                                <li>
                                    <x-footer-link href="#" text="{{ __('Who we are') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Sustainability') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Press') }}" />
                                </li>
                                <li>
                                    <x-footer-link href="#" text="{{ __('Careers') }}" />
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="space-y-12 md:grid md:grid-cols-2 md:gap-8 md:space-y-0">
                        <div>
                            <h3 class="text-sm font-medium text-white font-heading">{{ __('Legal') }}</h3>
                            <ul role="list" class="mt-6 space-y-6">
                                <li>
                                    <x-footer-link :href="route('legal', ['slug' => 'terms-of-use'])" text="{{ __('Terms of Service') }}" />
                                </li>
                                <li>
                                    <x-footer-link :href="route('legal', ['slug' => 'refund-policy'])" text="{{ __('Return Policy') }}" />
                                </li>
                                <li>
                                    <x-footer-link :href="route('legal', ['slug' => 'privacy-policy'])" text="{{ __('Privacy Policy') }}" />
                                </li>
                                <li>
                                    <x-footer-link :href="route('legal', ['slug' => 'shipping-policy'])" text="{{ __('Shipping Policy') }}" />
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-8 lg:py-10 border-y border-secondary-800">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-lg text-white font-heading">
                        {{ __('Sign up for our newsletter') }}
                    </h3>
                    <p class="mt-2 text-sm text-secondary-400">
                        {{ __('The latest news, articles, and resources, sent to your inbox weekly.') }}
                    </p>
                </div>
                <form class="ml-4 sm:ml-6 sm:flex">
                    <x-forms.label for="email-address" class="sr-only">{{ __('Email address') }}</x-forms.label>
                    <x-forms.input id="email-address" type="text" autocomplete="email" required class="w-full min-w-0 appearance-none" />
                    <div class="mt-3 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
                        <x-buttons.default :white-border="true" type="submit" class="py-2 px-4 text-base font-medium focus:ring-offset-secondary-800">
                            {{ __('Sign up') }}
                        </x-buttons.default>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <div class="flex flex-col items-center sm:flex-row sm:justify-between">
            <p class="text-sm text-secondary-400">
                © {{ date('Y') }} Shopper Labs, Inc. All rights reserved.
            </p>
            <div class="mt-5 divide-x divide-secondary-700 sm:mt-0">
                <a href="{{ route('legal', ['slug' => 'privacy-policy']) }}" class="inline-flex px-3 text-sm leading-5 text-secondary-500 hover:text-secondary-300 hover:underline">
                    {{ __('Privacy') }}
                </a>
                <a href="{{ route('legal', ['slug' => 'terms-of-use']) }}" class="inline-flex px-3 text-sm leading-5 text-secondary-500 hover:text-secondary-300 hover:underline">
                    {{ __('Terms & Conditions') }}
                </a>
                <a href="#" class="inline-flex px-3 text-sm leading-5 text-secondary-500 hover:text-secondary-300 hover:underline">
                    {{ __('FAQs') }}
                </a>
            </div>
        </div>
    </div>
</footer>
