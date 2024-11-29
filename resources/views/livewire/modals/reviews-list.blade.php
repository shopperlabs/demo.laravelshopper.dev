<div class="flex flex-col h-full divide-y divide-gray-200">
    <div class="flex-1 h-0 py-6 overflow-y-auto">
        <header class="px-4 sm:px-6">
            <div class="flex items-start justify-between">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Customer reviews') }}
                </h2>
                <div class="flex items-center ml-3 h-7">
                    <button type="button"
                        class="text-gray-400 bg-white rounded-md hover:text-gray-500"
                        wire:click="$dispatch('closePanel')">
                        <span class="sr-only">Close panel</span>
                        <x-untitledui-x class="size-6" stroke-width="1.5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </header>
        <div class="flex-1 px-4 mt-8 sm:px-6">
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
            @if ($reviews->isNotempty())
                <div class="flow-root">
                    <ul role="list" class="-my-6 divide-y divide-gray-200">
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
                    </ul>
                </div>
            @else
                <div class="space-y-5 text-center">
                    <div class="flex items-center justify-center shrink-0">
                        <x-icons.empty-cart class="w-auto h-40" aria-hidden="true" />
                    </div>
                    <div class="text-center">
                        <h1 class="text-2xl font-medium text-gray-900 font-heading">
                            {{ __('😱 This product has not yet been reviewed.') }}
                        </h1>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
