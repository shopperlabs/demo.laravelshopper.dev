<footer aria-labelledby="footer-heading" class="bg-white">
    <h2 id="footer-heading" class="sr-only">{{ __('Footer') }}</h2>
    <x-container class="pb-8 pt-20 sm:pt-24">
        <div class="lg:grid lg:grid-cols-2 lg:gap-10">
            <div>
                <div class="space-y-6">
                    <x-brand class="h-10" />
                    <p class="text-sm leading-6 text-secondary-600">
                        Making the world a better place through constructing elegant
                        hierarchies.
                    </p>
                </div>
            </div>
            <div class="mt-16 gap-8 space-y-6 lg:col-span-1 lg:mt-0 lg:grid lg:grid-cols-3 lg:space-y-0">
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-secondary-900">
                        Categories
                    </h3>
                    <ul role="list" class="mt-6 space-y-4">
                        <li>
                            <x-footer-link
                                :href="route('legal', ['slug' => 'terms-of-use'])"
                                :text="__('Furniture')"
                            />
                        </li>
                        <li>
                            <x-footer-link
                                :href="route('legal', ['slug' => 'terms-of-use'])"
                                :text="__('Electronic')"
                            />
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-secondary-900">
                        Support
                    </h3>
                    <ul role="list" class="mt-6 space-y-4">
                        <li>
                            <x-footer-link
                                href="#"
                                :text="__('FAQs')"
                            />
                        </li>
                        <li>
                            <x-footer-link
                                href="#"
                                :text="__('Delivery')"
                            />
                        </li>
                        <li>
                            <x-footer-link
                                href="#"
                                :text="__('Returns & Refunds')"
                            />
                        </li>
                        <li>
                            <x-footer-link
                                href="#"
                                :text="__('Collections')"
                            />
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold leading-6 text-secondary-900">
                        Laravel Shopper
                    </h3>
                    <ul role="list" class="mt-6 space-y-4">
                        <li>
                            <a href="https://github.com/shopperlabs"
                               target="_blank"
                               class="text-sm leading-6 text-secondary-600 hover:text-secondary-900">
                            Github
                            </a>
                        </li>
                        <li>
                            <a href="https://laravelshopper.dev/docs"
                               target="_blank"
                               class="text-sm leading-6 text-secondary-600 hover:text-secondary-900">
                                Documentation
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/laravelshopper"
                               target="_blank"
                               class="text-sm leading-6 text-secondary-600 hover:text-secondary-900">
                                Twitter
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-16 flex items-center justify-between border-t border-secondary-100 pt-6">
            <p class="text-sm text-secondary-500">
                {{ __('© :date Shopper Labs, Inc. All rights reserved.', ['date' => date('Y')]) }}
            </p>
            <a href="https://laravelshopper.dev" class="inline-flex items-center text-xs text-secondary-400" target="_blank">
                <span>{{ __('powered by') }}</span>
                <x-application-logo class="ml-2 h-6 w-auto" />
            </a>
        </div>
    </x-container>
</footer>
