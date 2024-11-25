<div>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-12 lg:gap-x-8 lg:px-8 lg:py-32">
            <div class="lg:col-span-4">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900"> {{ __('Customer Reviews') }} </h2>

                <div class="mt-3 flex items-center">
                    <div>
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="size-5 shrink-0 {{ $i <= floor($averageRating) ? 'text-yellow-400' : ($i - $averageRating < 1 ? 'text-yellow-200' : 'text-gray-300') }}"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                                </svg>
                            @endfor
                        </div>
                        <p class="sr-only">{{ round($averageRating, 1) }} out of 5 stars</p>
                    </div>
                    <p class="ml-2 text-sm text-gray-900">Based on {{ $reviewsCount }} reviews</p>
                </div>

                <livewire:review-stats :product="$product" />

                @auth
                    <div class="mt-10">
                        <h3 class="text-lg font-medium text-gray-900"> {{ __('Share your thoughts')  }} </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('If you’ve used this product, share your thoughts with other customers') }}
                        </p>

                        <x-buttons.default
                            type="button"
                            wire:click="$dispatch('openModal', { component: 'modals.product.add-product-review', arguments: { product: {{ $product->id }} }})"
                            class="mt-6 inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 sm:w-auto lg:w-full"
                        >
                            {{ __('Write a review') }}
                        </x-buttons.default>
                    </div>
                @endauth
            </div>

          <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">
            <h3 class="sr-only"> {{ __('Recent reviews')  }} </h3>

              <div class="flow-root">
                  <div class="-my-12 divide-y divide-gray-200">
                      @foreach ($reviews as $review)
                          <div class="py-12">
                              <div class="flex items-center">
                                  <img src="{{ $review->author->profile_photo_url ?? '' }}"
                                       alt="{{ $review->author->fullName }}"
                                       class="size-12 rounded-full">
                                  <div class="ml-4">
                                      <h4 class="text-sm font-bold text-gray-900">{{ $review->author->fullName }}</h4>
                                      <div class="mt-1 flex items-center">
                                          @for ($i = 1; $i <= 5; $i++)
                                              <svg class="size-5 shrink-0 {{ $i <= floor($review->rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                   viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                  <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                                              </svg>
                                          @endfor
                                      </div>
                                      <p class="sr-only">{{ $review->rating }} out of 5 stars</p>
                                  </div>
                              </div>

                              <div class="mt-2 space-y-6 text-base italic text-gray-600">
                                  <p>{{ $review->content }}</p>
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>

              @if($reviews->isNotEmpty() && $reviewsCount > 3)
                  <div class="flex justify-center pt-6">
                      <x-buttons.default
                          type="button"
                          wire:click="$dispatch('openPanel', { component: 'modals.reviews-list', arguments: { product: {{ $product->id }} }})"
                          class="mt-6 inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 sm:w-auto"
                      >
                          {{ __('Load more') }}
                      </x-buttons.default>
                  </div>
              @endif

          </div>

        </div>
      </div>
</div>
