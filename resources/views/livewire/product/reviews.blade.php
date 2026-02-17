<?php

declare(strict_types=1);

use App\Models\Product;
use App\DTO\ProductReviewsData;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public Product $product;

    #[Computed]
    #[On('reviewCreated')]
    public function productReviews(): ProductReviewsData
    {
        return new ProductReviewsData(
            reviews: $this->product->getApprovedRatings($this->product->id),
            averageRating: floatval($this->product->averageRating(1)->first())
        );
    }
}
?>

<div>
    <div class="bg-white">
        <div
            class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-12 lg:gap-x-8 lg:px-8 lg:py-32">
            <div class="lg:col-span-4">
                <h2 class="text-2xl font-bold tracking-tight text-zinc-900"> {{ __('Customer Reviews') }} </h2>

                <div class="mt-3 flex items-center">
                    <x-products.reviews :rating="$this->productReviews->averageRating" />
                    <p class="ml-2 text-sm text-zinc-900">Based on {{ $this->productReviews->reviews->count() }}
                        reviews</p>
                </div>

                <livewire:review-stats :product="$product" />

                @auth
                    <div class="mt-10">
                        <h3 class="text-lg font-medium text-zinc-900"> {{ __('Share your thoughts')  }} </h3>
                        <p class="mt-1 text-sm text-zinc-600">
                            {{ __('If you’ve used this product, share your thoughts with other customers') }}
                        </p>

                        <flux:button
                            type="button"
                            wire:click="$dispatch('openModal', { component: 'modals.product.add-product-review', arguments: { product: {{ $product->id }} }})"
                            class="mt-6 w-full sm:w-auto lg:w-full"
                        >
                            {{ __('Write a review') }}
                        </flux:button>
                    </div>
                @endauth
            </div>

            @php $reviews = $this->productReviews->reviews @endphp

            @if($reviews->isNotEmpty())
                <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">
                    <h3 class="sr-only"> {{ __('Recent reviews')  }} </h3>

                    <div class="flow-root">
                        <div class="-my-12 divide-y divide-zinc-200">
                            @foreach ($reviews->take(3) as $review)
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
                        </div>
                    </div>

                    @if($reviews->count() > 3)
                        <div class="flex justify-center pt-6">
                            <flux:button
                                type="button"
                                wire:click="$dispatch('openPanel', { component: 'modals.reviews-list', arguments: { product: {{ $this->product->id }} }})"
                                class="mt-6 w-full sm:w-auto"
                            >
                                {{ __('Load more') }}
                            </flux:button>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>
