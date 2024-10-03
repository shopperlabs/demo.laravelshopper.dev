<div>
    <form class="space-y-8">
        <!-- Color picker -->
        <div>
            <h2 class="text-sm font-medium text-gray-900">Color</h2>

            <fieldset class="mt-2">
                <legend class="sr-only">Choose a color</legend>
                <div class="flex items-center space-x-3">
                    <!--
                      Active and Checked: "ring ring-offset-1"
                      Not Active and Checked: "ring-2"
                    -->
                    <label
                        class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 ring-gray-900 focus:outline-none"
                    >
                        <input
                            type="radio"
                            name="color-choice"
                            value="Black"
                            class="sr-only"
                            aria-labelledby="color-choice-0-label"
                        />
                        <span id="color-choice-0-label" class="sr-only">Black</span>
                        <span
                            aria-hidden="true"
                            class="h-8 w-8 rounded-full border border-black border-opacity-10 bg-gray-900"
                        ></span>
                    </label>
                    <!--
                      Active and Checked: "ring ring-offset-1"
                      Not Active and Checked: "ring-2"
                    -->
                    <label
                        class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 ring-gray-400 focus:outline-none"
                    >
                        <input
                            type="radio"
                            name="color-choice"
                            value="Heather Grey"
                            class="sr-only"
                            aria-labelledby="color-choice-1-label"
                        />
                        <span id="color-choice-1-label" class="sr-only">Heather Grey</span>
                        <span
                            aria-hidden="true"
                            class="h-8 w-8 rounded-full border border-black border-opacity-10 bg-gray-400"
                        ></span>
                    </label>
                </div>
            </fieldset>
        </div>

        <!-- Size picker -->
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-900">Size</h2>
                <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">See sizing chart</a>
            </div>

            <fieldset class="mt-2">
                <legend class="sr-only">Choose a size</legend>
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-primary-500 ring-offset-2"
                      Checked: "border-transparent bg-primary-600 text-white hover:bg-primary-700", Not Checked: "border-gray-200 bg-white text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="flex cursor-pointer items-center justify-center rounded-md border px-3 py-3 text-sm font-medium uppercase focus:outline-none sm:flex-1"
                    >
                        <input
                            type="radio"
                            name="size-choice"
                            value="XXS"
                            class="sr-only"
                            aria-labelledby="size-choice-0-label"
                        />
                        <span id="size-choice-0-label">XXS</span>
                    </label>
                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-primary-500 ring-offset-2"
                      Checked: "border-transparent bg-primary-600 text-white hover:bg-primary-700", Not Checked: "border-gray-200 bg-white text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="flex cursor-pointer items-center justify-center rounded-md border px-3 py-3 text-sm font-medium uppercase focus:outline-none sm:flex-1"
                    >
                        <input
                            type="radio"
                            name="size-choice"
                            value="XS"
                            class="sr-only"
                            aria-labelledby="size-choice-1-label"
                        />
                        <span id="size-choice-1-label">XS</span>
                    </label>
                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-primary-500 ring-offset-2"
                      Checked: "border-transparent bg-primary-600 text-white hover:bg-primary-700", Not Checked: "border-gray-200 bg-white text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="flex cursor-pointer items-center justify-center rounded-md border px-3 py-3 text-sm font-medium uppercase focus:outline-none sm:flex-1"
                    >
                        <input
                            type="radio"
                            name="size-choice"
                            value="S"
                            class="sr-only"
                            aria-labelledby="size-choice-2-label"
                        />
                        <span id="size-choice-2-label">S</span>
                    </label>
                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-primary-500 ring-offset-2"
                      Checked: "border-transparent bg-primary-600 text-white hover:bg-primary-700", Not Checked: "border-gray-200 bg-white text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="flex cursor-pointer items-center justify-center rounded-md border px-3 py-3 text-sm font-medium uppercase focus:outline-none sm:flex-1"
                    >
                        <input
                            type="radio"
                            name="size-choice"
                            value="M"
                            class="sr-only"
                            aria-labelledby="size-choice-3-label"
                        />
                        <span id="size-choice-3-label">M</span>
                    </label>
                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-primary-500 ring-offset-2"
                      Checked: "border-transparent bg-primary-600 text-white hover:bg-primary-700", Not Checked: "border-gray-200 bg-white text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="flex cursor-pointer items-center justify-center rounded-md border px-3 py-3 text-sm font-medium uppercase focus:outline-none sm:flex-1"
                    >
                        <input
                            type="radio"
                            name="size-choice"
                            value="L"
                            class="sr-only"
                            aria-labelledby="size-choice-4-label"
                        />
                        <span id="size-choice-4-label">L</span>
                    </label>
                    <!--
                      In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                      Active: "ring-2 ring-primary-500 ring-offset-2"
                      Checked: "border-transparent bg-primary-600 text-white hover:bg-primary-700", Not Checked: "border-gray-200 bg-white text-gray-900 hover:bg-gray-50"
                    -->
                    <label
                        class="flex cursor-not-allowed items-center justify-center rounded-md border px-3 py-3 text-sm font-medium uppercase opacity-25 sm:flex-1"
                    >
                        <input
                            type="radio"
                            name="size-choice"
                            value="XL"
                            disabled
                            class="sr-only"
                            aria-labelledby="size-choice-5-label"
                        />
                        <span id="size-choice-5-label">XL</span>
                    </label>
                </div>
            </fieldset>
        </div>

        <x-buttons.primary type="submit" class="w-full px-8 py-3 text-base">
            {{ __('Ajouter au panier') }}
        </x-buttons.primary>
    </form>
</div>
