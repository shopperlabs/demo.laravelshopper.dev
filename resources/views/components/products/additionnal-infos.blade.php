<div class="mt-10 space-y-10 border-t border-gray-200 pt-8">
    <div>
        <h2 class="text-sm font-medium text-gray-900">{{ __('Tissus et entretien') }}</h2>

        <div class="prose prose-sm mt-4 text-gray-500">
            <ul role="list">
                <li>{{ __('Les meilleurs matériaux') }}</li>
                <li>{{ __('Fabriqué de manière éthique et locale') }}</li>
                <li>{{ __('Prélavé et pré-rétréci') }}</li>
                <li>{{ __('Lavage à froid avec des couleurs similaires') }}</li>
            </ul>
        </div>
    </div>

    <!-- Policies -->
    <section aria-labelledby="policies-heading">
        <h2 id="policies-heading" class="sr-only">{{ __('Nos politiques') }}</h2>

        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
            <div class="border border-gray-200 bg-gray-50 p-6 text-center">
                <dt>
                    <x-untitledui-globe-05
                        class="mx-auto size-6 text-gray-400"
                        stroke-width="1.5"
                        aria-hidden="true"
                    />
                    <span class="mt-4 text-sm font-medium text-gray-900">{{ __('Livraison internationale') }}</span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500">
                    {{ __('Obtenez votre commande en 2 semaines') }}
                </dd>
            </div>
            <div class="border border-gray-200 bg-gray-50 p-6 text-center">
                <dt>
                    <x-untitledui-gift-02 class="mx-auto size-6 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                    <span class="mt-4 text-sm font-medium text-gray-900">{{ __('Récompenses de fidélité') }}</span>
                </dt>
                <dd class="mt-1 text-sm text-gray-500">
                    {{ __('Obtenez des réductions et des bonus pour votre fidélité.') }}
                </dd>
            </div>
        </dl>
    </section>
</div>
