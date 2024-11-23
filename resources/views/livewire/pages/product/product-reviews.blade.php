<div>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-12 lg:gap-x-8 lg:px-8 lg:py-32">
            <div class="lg:col-span-4">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Customer Reviews</h2>

                <div class="mt-3 flex items-center">
                    <div class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="size-5 shrink-0 {{ $i <= floor($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="..." clip-rule="evenodd" />
                            </svg>
                        @endfor
                    </div>
                    <p class="ml-2 text-sm text-gray-900">
                        Based on {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}
                    </p>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">Review data</h3>
                    <dl class="space-y-3">
                        @foreach ($reviewCounts as $review)
                            <div class="flex items-center text-sm">
                                <dt class="flex flex-1 items-center">
                                    <p class="w-3 font-medium text-gray-900">{{ $review->rating }}<span class="sr-only"> star reviews</span></p>
                                    <div aria-hidden="true" class="ml-1 flex flex-1 items-center">
                                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="..." clip-rule="evenodd" />
                                        </svg>
                                        <div class="relative ml-3 flex-1">
                                            <div class="h-3 rounded-full border border-gray-200 bg-gray-100"></div>
                                            <div style="width: calc({{ $review->count / $totalReviews * 100 }}%)" class="absolute inset-y-0 rounded-full border border-yellow-400 bg-yellow-400"></div>
                                        </div>
                                    </div>
                                </dt>
                                <dd class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900">{{ number_format($review->count / $totalReviews * 100, 0) }}%</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
                @auth
                    <div class="mt-10">
                        <h3 class="text-lg font-medium text-gray-900">Share your thoughts</h3>
                        <p class="mt-1 text-sm text-gray-600">If you’ve used this product, share your thoughts with other customers</p>

                        <x-buttons.default
                            type="button"
                            wire:click="$dispatch('openModal', { component: 'modals.product.modal-product' })"
                            class="mt-6 inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 sm:w-auto lg:w-full"
                        >
                            {{ __('Write a review') }}
                        </x-buttons.default>
                    </div>
                @endauth
            </div>



          <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">
            <h3 class="sr-only">Recent reviews</h3>

            <div class="flow-root">
              <div class="-my-12 divide-y divide-gray-200">
                <div class="py-12">
                  <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="Emily Selman." class="size-12 rounded-full">
                    <div class="ml-4">
                      <h4 class="text-sm font-bold text-gray-900">Emily Selman</h4>
                      <div class="mt-1 flex items-center">
                        <!-- Active: "text-yellow-400", Default: "text-gray-300" -->
                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                      </div>
                      <p class="sr-only">5 out of 5 stars</p>
                    </div>
                  </div>

                  <div class="mt-2 space-y-6 text-base italic text-gray-600">
                    <p>This is the bag of my dreams. I took it on my last vacation and was able to fit an absurd amount of snacks for the many long and hungry flights.</p>
                  </div>
                </div>

                <!-- More reviews... -->
              </div>
            </div>
          </div>
        </div>
      </div>
</div>


{{--<div>--}}
{{--    <div class="bg-white">--}}
{{--        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-12 lg:gap-x-8 lg:px-8 lg:py-32">--}}
{{--          <div class="lg:col-span-4">--}}
{{--            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Customer Reviews</h2>--}}

{{--            <div class="mt-3 flex items-center">--}}
{{--              <div>--}}
{{--                <div class="flex items-center">--}}
{{--                  <!-- Active: "text-yellow-400", Default: "text-gray-300" -->--}}
{{--                  <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                  </svg>--}}
{{--                  <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                  </svg>--}}
{{--                  <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                  </svg>--}}
{{--                  <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                  </svg>--}}
{{--                  <svg class="size-5 shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                  </svg>--}}
{{--                </div>--}}
{{--                <p class="sr-only">4 out of 5 stars</p>--}}
{{--              </div>--}}
{{--              <p class="ml-2 text-sm text-gray-900">Based on 1624 reviews</p>--}}
{{--            </div>--}}

{{--            <div class="mt-6">--}}
{{--              <h3 class="sr-only">Review data</h3>--}}
{{--                <dl class="space-y-3">--}}
{{--                  <div class="flex items-center text-sm">--}}
{{--                    <dt class="flex flex-1 items-center">--}}
{{--                      <p class="w-3 font-medium text-gray-900">5<span class="sr-only"> star reviews</span></p>--}}
{{--                      <div aria-hidden="true" class="ml-1 flex flex-1 items-center">--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}

{{--                        <div class="relative ml-3 flex-1">--}}
{{--                          <div class="h-3 rounded-full border border-gray-200 bg-gray-100"></div>--}}
{{--                          <div style="width: calc(1019 / 1624 * 100%)" class="absolute inset-y-0 rounded-full border border-yellow-400 bg-yellow-400"></div>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </dt>--}}
{{--                    <dd class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900">63%</dd>--}}
{{--                  </div>--}}
{{--                  <div class="flex items-center text-sm">--}}
{{--                    <dt class="flex flex-1 items-center">--}}
{{--                      <p class="w-3 font-medium text-gray-900">4<span class="sr-only"> star reviews</span></p>--}}
{{--                      <div aria-hidden="true" class="ml-1 flex flex-1 items-center">--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}

{{--                        <div class="relative ml-3 flex-1">--}}
{{--                          <div class="h-3 rounded-full border border-gray-200 bg-gray-100"></div>--}}
{{--                          <div style="width: calc(162 / 1624 * 100%)" class="absolute inset-y-0 rounded-full border border-yellow-400 bg-yellow-400"></div>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </dt>--}}
{{--                    <dd class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900">10%</dd>--}}
{{--                  </div>--}}
{{--                  <div class="flex items-center text-sm">--}}
{{--                    <dt class="flex flex-1 items-center">--}}
{{--                      <p class="w-3 font-medium text-gray-900">3<span class="sr-only"> star reviews</span></p>--}}
{{--                      <div aria-hidden="true" class="ml-1 flex flex-1 items-center">--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}

{{--                        <div class="relative ml-3 flex-1">--}}
{{--                          <div class="h-3 rounded-full border border-gray-200 bg-gray-100"></div>--}}
{{--                          <div style="width: calc(97 / 1624 * 100%)" class="absolute inset-y-0 rounded-full border border-yellow-400 bg-yellow-400"></div>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </dt>--}}
{{--                    <dd class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900">6%</dd>--}}
{{--                  </div>--}}
{{--                  <div class="flex items-center text-sm">--}}
{{--                    <dt class="flex flex-1 items-center">--}}
{{--                      <p class="w-3 font-medium text-gray-900">2<span class="sr-only"> star reviews</span></p>--}}
{{--                      <div aria-hidden="true" class="ml-1 flex flex-1 items-center">--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}

{{--                        <div class="relative ml-3 flex-1">--}}
{{--                          <div class="h-3 rounded-full border border-gray-200 bg-gray-100"></div>--}}
{{--                          <div style="width: calc(199 / 1624 * 100%)" class="absolute inset-y-0 rounded-full border border-yellow-400 bg-yellow-400"></div>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </dt>--}}
{{--                    <dd class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900">12%</dd>--}}
{{--                  </div>--}}
{{--                  <div class="flex items-center text-sm">--}}
{{--                    <dt class="flex flex-1 items-center">--}}
{{--                      <p class="w-3 font-medium text-gray-900">1<span class="sr-only"> star reviews</span></p>--}}
{{--                      <div aria-hidden="true" class="ml-1 flex flex-1 items-center">--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}

{{--                        <div class="relative ml-3 flex-1">--}}
{{--                          <div class="h-3 rounded-full border border-gray-200 bg-gray-100"></div>--}}
{{--                          <div style="width: calc(147 / 1624 * 100%)" class="absolute inset-y-0 rounded-full border border-yellow-400 bg-yellow-400"></div>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </dt>--}}
{{--                    <dd class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900">9%</dd>--}}
{{--                  </div>--}}
{{--                </dl>--}}
{{--            </div>--}}

{{--            <div class="mt-10">--}}
{{--              <h3 class="text-lg font-medium text-gray-900">Share your thoughts</h3>--}}
{{--              <p class="mt-1 text-sm text-gray-600">If you’ve used this product, share your thoughts with other customers</p>--}}

{{--              <a href="#" class="mt-6 inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 sm:w-auto lg:w-full">Write a review</a>--}}
{{--            </div>--}}
{{--          </div>--}}

{{--          <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">--}}
{{--            <h3 class="sr-only">Recent reviews</h3>--}}

{{--            <div class="flow-root">--}}
{{--              <div class="-my-12 divide-y divide-gray-200">--}}
{{--                <div class="py-12">--}}
{{--                  <div class="flex items-center">--}}
{{--                    <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="Emily Selman." class="size-12 rounded-full">--}}
{{--                    <div class="ml-4">--}}
{{--                      <h4 class="text-sm font-bold text-gray-900">Emily Selman</h4>--}}
{{--                      <div class="mt-1 flex items-center">--}}
{{--                        <!-- Active: "text-yellow-400", Default: "text-gray-300" -->--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}
{{--                        <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">--}}
{{--                          <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />--}}
{{--                        </svg>--}}
{{--                      </div>--}}
{{--                      <p class="sr-only">5 out of 5 stars</p>--}}
{{--                    </div>--}}
{{--                  </div>--}}

{{--                  <div class="mt-4 space-y-6 text-base italic text-gray-600">--}}
{{--                    <p>This is the bag of my dreams. I took it on my last vacation and was able to fit an absurd amount of snacks for the many long and hungry flights.</p>--}}
{{--                  </div>--}}
{{--                </div>--}}

{{--                <!-- More reviews... -->--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}

{{--      <div class="fixed z-50 grid gap-4 bg-overlay border-dark/5 dark:border-border text-overlay-fg shadow-lg transition ease-in-out entering:slide-in-from-bottom exiting:slide-out-to-bottom bottom-2 inset-x-2 rounded-xl ring-1 border-t-0 ring-dark/5 dark:ring-border mx-auto max-w-xl" data-rac="">--}}
{{--         <div style="border: 0px; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); height: 1px; margin: -1px; overflow: hidden; padding: 0px; position: absolute; width: 1px; white-space: nowrap;"><button id="react-aria1654575259-:rcr:" aria-label="Dismiss" tabindex="-1" style="width: 1px; height: 1px;"></button></div>--}}
{{--         <section id="react-aria1654575259-:rat:" aria-labelledby="react-aria1654575259-:rcs:" role="dialog" tabindex="-1" class="dlc relative flex max-h-[inherit] [&amp;::-webkit-scrollbar]:size-0.5 [scrollbar-width:thin] flex-col overflow-hidden outline-none sm:[&amp;:not(:has([data-slot=dialog-body]))]:px-6 sm:[&amp;:has([data-slot=dialog-body])_[data-slot=dialog-header]]:px-6 sm:[&amp;:has([data-slot=dialog-body])_[data-slot=dialog-footer]]:px-6 [&amp;:not(:has([data-slot=dialog-body]))]:px-4 [&amp;:has([data-slot=dialog-body])_[data-slot=dialog-header]]:px-4 [&amp;:has([data-slot=dialog-body])_[data-slot=dialog-footer]]:px-4 h-full" style="--dialog-footer-height: 72px;">--}}
{{--            <div class="relative" style="--dialog-header-height: 98px;">--}}
{{--               <div data-slot="dialog-header" class="relative flex flex-col pb-3 pt-4 sm:pt-6 text-left">--}}
{{--                  <h2 id="react-aria1654575259-:rcs:" slot="title" class="font-sans text-fg font-semibold text-lg sm:text-xl tracking-tight flex flex-1 items-center">Drop your thoughts</h2>--}}
{{--                  <div class="text-sm block text-muted-fg mt-0.5 sm:mt-1">Got something to say about this? Share your take with everyone.</div>--}}
{{--               </div>--}}
{{--               <span aria-labelledby=":rct: " data-slot="avatar" class="inline-grid shrink-0 bg-secondary align-middle [--avatar-radius:20%] [--ring-opacity:20%] *:col-start-1 *:row-start-1 loo2ppvkxrcah38e outline outline-1 -outline-offset-1 outline-fg/[--ring-opacity] rounded-full *:rounded-full absolute right-0 top-4 size-8">--}}
{{--                  <svg class="select-none fill-current text-[48px] font-medium uppercase" viewBox="0 0 100 100" aria-hidden="true">--}}
{{--                     <text x="50%" y="50%" alignment-baseline="middle" dominant-baseline="middle" text-anchor="middle" dy=".125em">IA</text>--}}
{{--                  </svg>--}}
{{--                  <img src="https://github.com/irsyadadl.png" alt="">--}}
{{--               </span>--}}
{{--            </div>--}}
{{--            <div>--}}
{{--               <div class="flex">--}}
{{--                  <button class="size-5 transition-colors duration-200 ease-linear text-muted">--}}
{{--                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" class="justd-icons size-5" data-slot="icon" aria-hidden="true">--}}
{{--                        <path fill="currentColor" d="M13.126 1.709c-.454-.945-1.8-.945-2.253 0L8.363 6.94l-5.777.757c-1.04.137-1.462 1.42-.695 2.144l4.222 3.987-1.06 5.695c-.193 1.036.903 1.822 1.822 1.326L12 18.082l5.124 2.767c.92.496 2.015-.29 1.822-1.326l-1.06-5.695 4.223-3.987c.767-.724.344-2.007-.696-2.144l-5.777-.757z"></path>--}}
{{--                     </svg>--}}
{{--                  </button>--}}
{{--                  <button class="size-5 transition-colors duration-200 ease-linear text-muted">--}}
{{--                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" class="justd-icons size-5" data-slot="icon" aria-hidden="true">--}}
{{--                        <path fill="currentColor" d="M13.126 1.709c-.454-.945-1.8-.945-2.253 0L8.363 6.94l-5.777.757c-1.04.137-1.462 1.42-.695 2.144l4.222 3.987-1.06 5.695c-.193 1.036.903 1.822 1.822 1.326L12 18.082l5.124 2.767c.92.496 2.015-.29 1.822-1.326l-1.06-5.695 4.223-3.987c.767-.724.344-2.007-.696-2.144l-5.777-.757z"></path>--}}
{{--                     </svg>--}}
{{--                  </button>--}}
{{--                  <button class="size-5 transition-colors duration-200 ease-linear text-muted">--}}
{{--                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" class="justd-icons size-5" data-slot="icon" aria-hidden="true">--}}
{{--                        <path fill="currentColor" d="M13.126 1.709c-.454-.945-1.8-.945-2.253 0L8.363 6.94l-5.777.757c-1.04.137-1.462 1.42-.695 2.144l4.222 3.987-1.06 5.695c-.193 1.036.903 1.822 1.822 1.326L12 18.082l5.124 2.767c.92.496 2.015-.29 1.822-1.326l-1.06-5.695 4.223-3.987c.767-.724.344-2.007-.696-2.144l-5.777-.757z"></path>--}}
{{--                     </svg>--}}
{{--                  </button>--}}
{{--                  <button class="size-5 transition-colors duration-200 ease-linear text-muted">--}}
{{--                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" class="justd-icons size-5" data-slot="icon" aria-hidden="true">--}}
{{--                        <path fill="currentColor" d="M13.126 1.709c-.454-.945-1.8-.945-2.253 0L8.363 6.94l-5.777.757c-1.04.137-1.462 1.42-.695 2.144l4.222 3.987-1.06 5.695c-.193 1.036.903 1.822 1.822 1.326L12 18.082l5.124 2.767c.92.496 2.015-.29 1.822-1.326l-1.06-5.695 4.223-3.987c.767-.724.344-2.007-.696-2.144l-5.777-.757z"></path>--}}
{{--                     </svg>--}}
{{--                  </button>--}}
{{--                  <button class="size-5 transition-colors duration-200 ease-linear text-muted">--}}
{{--                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" class="justd-icons size-5" data-slot="icon" aria-hidden="true">--}}
{{--                        <path fill="currentColor" d="M13.126 1.709c-.454-.945-1.8-.945-2.253 0L8.363 6.94l-5.777.757c-1.04.137-1.462 1.42-.695 2.144l4.222 3.987-1.06 5.695c-.193 1.036.903 1.822 1.822 1.326L12 18.082l5.124 2.767c.92.496 2.015-.29 1.822-1.326l-1.06-5.695 4.223-3.987c.767-.724.344-2.007-.696-2.144l-5.777-.757z"></path>--}}
{{--                     </svg>--}}
{{--                  </button>--}}
{{--               </div>--}}
{{--               <div class="group flex flex-col gap-1 mt-2" data-rac=""><textarea placeholder="Write your review here" id="react-aria1654575259-:rcu:" class="focus:outline-none forced-colors:outline-[Highlight] w-full min-w-0 rounded-md border border-input bg-bg px-2.5 py-2 text-base shadow-sm outline-none transition duration-200 disabled:bg-secondary disabled:opacity-50 sm:text-sm mt-2" data-rac="" title=""></textarea></div>--}}
{{--            </div>--}}
{{--            <div data-slot="dialog-footer" class="mt-auto gap-3 pb-4 sm:pb-6 pt-4 sm:flex-row flex flex-row items-center justify-between"><button type="button" class="outline outline-ring forced-colors:outline-[Highlight] outline-offset-2 kbt32x before:absolute after:absolute box-border relative no-underline isolate inline-flex items-center justify-center gap-x-2 border font-medium forced-colors:[--btn-icon:ButtonText] forced-colors:hover:[--btn-icon:ButtonText] [&amp;>[data-slot=icon]]:-mx-0.5 [&amp;>[data-slot=icon]]:my-1 [&amp;>[data-slot=icon]]:size-4 [&amp;>[data-slot=icon]]:shrink-0 [&amp;>[data-slot=icon]]:text-[--btn-icon] [--btn-bg:theme(colors.primary.DEFAULT)] [--btn-border:theme(colors.primary.DEFAULT)] [--btn-hover-overlay:theme(colors.white/10%)] border-border text-fg [--btn-icon:theme(colors.muted.fg)] hover:[--btn-icon:theme(colors.fg)] hover:bg-secondary/90 active:bg-secondary/90 active:[--btn-icon:theme(colors.fg)] h-10 px-[calc(theme(spacing.4)-1px)] py-[calc(theme(spacing.2)-1px)] text-base lg:text-sm/6 rounded-lg before:rounded-[calc(theme(borderRadius.lg)-1px)] after:rounded-[calc(theme(borderRadius.lg)-1px)] dark:after:rounded-lg forced-colors:disabled:text-[GrayText] outline-0" data-rac="">Cancel</button><button type="button" class="outline outline-ring forced-colors:outline-[Highlight] outline-offset-2 kbt32x before:absolute after:absolute box-border relative no-underline isolate inline-flex items-center justify-center gap-x-2 border font-medium forced-colors:[--btn-icon:ButtonText] forced-colors:hover:[--btn-icon:ButtonText] [&amp;>[data-slot=icon]]:-mx-0.5 [&amp;>[data-slot=icon]]:my-1 [&amp;>[data-slot=icon]]:size-4 [&amp;>[data-slot=icon]]:shrink-0 [&amp;>[data-slot=icon]]:text-[--btn-icon] text-primary-fg [--btn-bg:theme(colors.primary.DEFAULT)] [--btn-border:theme(colors.primary.DEFAULT)] [--btn-hover-overlay:theme(colors.white/10%)] [--btn-icon:theme(colors.primary.fg/60%)] active:[--btn-icon:theme(colors.primary.fg/80%)] hover:[--btn-icon:theme(colors.primary.fg/80%)] border-transparent bg-[--btn-border] before:inset-0 before:-z-10 before:bg-[--btn-bg] before:shadow before:data-[disabled]:shadow-none after:shadow-[shadow:inset_0_1px_theme(colors.white/15%)] after:active:bg-[--btn-hover-overlay] after:hover:bg-[--btn-hover-overlay] after:data-[disabled]:shadow-none after:inset-0 after:-z-10 dark:after:-inset-px dark:before:hidden dark:border-white/5 dark:bg-[--btn-bg] h-10 px-[calc(theme(spacing.4)-1px)] py-[calc(theme(spacing.2)-1px)] text-base lg:text-sm/6 rounded-lg before:rounded-[calc(theme(borderRadius.lg)-1px)] after:rounded-[calc(theme(borderRadius.lg)-1px)] dark:after:rounded-lg forced-colors:disabled:text-[GrayText] outline-0" data-rac="">Submit</button></div>--}}
{{--         </section>--}}
{{--      </div>--}}
{{--</div>--}}
