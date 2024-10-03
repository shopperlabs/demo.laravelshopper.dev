<div class="relative isolate overflow-hidden">
    <svg
        class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
        aria-hidden="true"
    >
        <defs>
            <pattern
                id="0787a7c5-978c-4f66-83c7-11c213f99cb7"
                width="200"
                height="200"
                x="50%"
                y="-1"
                patternUnits="userSpaceOnUse"
            >
                <path d="M.5 200V.5H200" fill="none" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#0787a7c5-978c-4f66-83c7-11c213f99cb7)" />
    </svg>

    <x-container class="relative py-16 sm:pt-24 lg:py-40">
        <div class="sm:max-w-lg">
            <h1 class="font font-heading text-4xl font-extrabold tracking-tight text-black sm:text-6xl">
                {{ __("C'est la saison des Boubous") }}
            </h1>
            <p class="mt-4 text-xl text-gray-500">
                {{ __('Des pièces uniques simples colorées et chaleureuses pour les femmes spéciales que vous représentez pour nous 💓') }}
            </p>
        </div>
        <div class="py-10">
            <x-buttons.primary link="#" class="group px-8 py-3 text-center text-base font-medium">
                {{ __('Découvrez maintenant') }}
                <span
                    class="ml-2 translate-x-0 transform transition duration-200 ease-in-out group-hover:translate-x-1"
                >
                    <x-untitledui-arrow-narrow-right class="h-6 w-6" stroke-width="1.5" aria-hidden="true" />
                </span>
            </x-buttons.primary>
        </div>
    </x-container>

    <x-stats />

    <div class="bg-gray-50">
        <x-container class="py-16 lg:py-24">
            <div class="lg:grid lg:grid-cols-6 lg:gap-10">
                <div class="flex self-center sm:col-span-2">
                    <div>
                        <h1
                            class="font-heading text-3xl font-extrabold uppercase tracking-tight text-black sm:text-4xl sm:leading-[2.75rem]"
                        >
                            {{ __('Les produits les plus demandés') }}
                        </h1>
                        <p class="mt-4 text-xl text-gray-500">
                            {{ __('Découvrez notre magnifique Collection de t-shirts Ethniques 😍. Du rigide basique mettant en avant des motifs diversifiés sur de la douceur colorée.') }}
                        </p>
                        <div class="mt-8">
                            <x-buttons.primary link="#" class="px-8 py-3 font-medium uppercase tracking-wider">
                                {{ __('Voir la collection') }}
                                <x-untitledui-arrow-narrow-right class="ml-2 h-5 w-5" />
                            </x-buttons.primary>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-16 max-w-3xl lg:mt-32 lg:max-w-none">
                <h2 class="font-heading text-2xl font-semibold tracking-tight text-gray-900">Trending products</h2>

                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($products as $product)
                        <x-products.simple-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </x-container>
    </div>
</div>
