<footer aria-labelledby="footer-heading" class="bg-white">
    <h2 id="footer-heading" class="sr-only">{{ __('Footer') }}</h2>
    <x-container>
        <div class="py-10 sm:py-20 lg:grid lg:grid-cols-2 lg:gap-10 lg:py-24">
            <div>
                <div class="space-y-6 max-w-sm">
                    <x-brand class="h-10" />
                    <p class="text-sm leading-6 text-gray-600">
                        {{ __('Build modern, scalable online stores. It includes essential features like product management, checkout, and order handling.') }}
                    </p>
                </div>
            </div>
            <div class="mt-16 gap-8 space-y-6 lg:col-span-1 lg:mt-0 lg:grid lg:grid-cols-3 lg:space-y-0">
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-gray-900">
                        {{ __('Categories') }}
                    </h3>
                    <ul role="list" class="mt-6 space-y-4">
                        <li>
                            <x-footer-link href="#">{{ __('Furniture') }}</x-footer-link>
                        </li>
                        <li>
                            <x-footer-link href="#">{{ __('Electronic') }}</x-footer-link>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-gray-900">
                        {{ __('Support') }}
                    </h3>
                    <ul role="list" class="mt-6 space-y-4">
                        <li>
                            <x-footer-link href="#">{{ __('FAQs') }}</x-footer-link>
                        </li>
                        <li>
                            <x-footer-link href="#">{{ __('Delivery') }}</x-footer-link>
                        </li>
                        <li>
                            <x-footer-link href="#">{{ __('Returns & Refunds') }}</x-footer-link>
                        </li>
                        <li>
                            <x-footer-link href="#">{{ __('Collections') }}</x-footer-link>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-gray-900">
                        Laravel Shopper
                    </h3>
                    <ul role="list" class="mt-6 space-y-4">
                        <li>
                            <a href="https://github.com/shopperlabs"
                               target="_blank"
                               class="text-sm leading-6 text-gray-600 hover:text-gray-900">
                                Github
                            </a>
                        </li>
                        <li>
                            <a href="https://laravelshopper.dev/docs"
                               target="_blank"
                               class="text-sm leading-6 text-gray-600 hover:text-gray-900">
                                Documentation
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/laravelshopper"
                               target="_blank"
                               class="text-sm leading-6 text-gray-600 hover:text-gray-900">
                                Twitter
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between border-t border-gray-100 py-6 lg:py-14">
            <p class="text-sm text-gray-500">
                {{ __('© :date Shopper Labs, Inc. All rights reserved.', ['date' => date('Y')]) }}
            </p>
            <a href="https://laravelshopper.dev" class="inline-flex items-center gap-x-2 text-sm font-medium text-gray-400" target="_blank">
                <span>{{ __('Powered by') }}</span>
                <x-brand class="size-5" aria-hidden="true" />
                <span>&</span>
                <x-brand.starter-kit class="size-5" aria-hidden="true" />
            </a>
        </div>
    </x-container>
</footer>
