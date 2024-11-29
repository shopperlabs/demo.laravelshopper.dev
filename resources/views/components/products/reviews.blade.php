@props([
    'rating' => 0,
    'count' => 0
])
<div class="flex items-center">
    <x-rate-stars :rating="$rating" />
    <p class="sr-only">{{ __('shopper::pages.products.reviews.rating_count', ['rating' => $rating, 'count' => $count]) }}</p>
</div>
