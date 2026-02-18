@php $reviews = $this->productReviews->reviews @endphp

<div class="flex flex-col h-full divide-y divide-zinc-200">
    <div class="flex-1 h-0 py-6 overflow-y-auto">
        <header class="px-4 sm:px-6">
            <div class="flex items-start justify-between">
                <h2 class="text-lg font-medium text-zinc-900">
                    {{ __('Customer reviews') }}
                </h2>
                <x-livewire-slide-over::close-icon />
            </div>
        </header>

        <div class="flex-1 px-4 mt-8 sm:px-6">
            <div class="mt-3 flex items-center">
                <div>
                    <div class="flex items-center">
                        <x-products.reviews :rating="$this->productReviews->averageRating" />
                    </div>
                    <p class="sr-only">{{ $this->productReviews->averageRating }} out of 5 stars</p>
                </div>
                <p class="ml-2 text-sm text-zinc-900">Based on {{ $reviews->count() }} reviews</p>
            </div>

            @if ($reviews->isNotempty())
                <div class="flow-root">
                    <ul role="list" class="-my-6 divide-y divide-zinc-200">
                        @foreach ($reviews as $review)
                            <div class="py-12">
                                <div class="flex items-center">
                                    <img src="{{ $review->author->picture }}"
                                         alt="{{ $review->author->fullName }}"
                                         class="size-12 rounded-full">
                                    <div class="ml-4">
                                        <h4 class="text-sm font-bold text-zinc-900">{{ $review->author->fullName }}</h4>
                                        <div class="mt-1 flex items-center">
                                            <x-rate-stars :rating="$review->rating" />
                                        </div>
                                        <p class="sr-only">{{ $review->rating }} out of 5 stars</p>
                                    </div>
                                </div>

                                <div class="mt-2 space-y-6 text-base italic text-zinc-600">
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
                        <h1 class="text-2xl font-medium text-zinc-900 font-heading">
                            {{ __('😱 This product has not yet been reviewed.') }}
                        </h1>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
