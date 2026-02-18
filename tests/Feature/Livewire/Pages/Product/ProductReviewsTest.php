<?php

declare(strict_types=1);

use App\Actions\Product\AddProductReviewAction;
use App\Livewire\Modals\Product\AddProductReview;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;
use Shopper\Core\Models\Review;

beforeEach(function (): void {
    $this->product = Product::factory()->create(['name' => 'Matanga 1']);
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe(AddProductReviewAction::class, function (): void {
    it('allows users to add a review', function (): void {
        $rating = [
            'rating' => 5,
            'content' => 'Excellent!',
        ];

        resolve(AddProductReviewAction::class)->execute($this->product, $rating, $this->user);

        expect(Product::query()->count())->toBe(1)
            ->and($this->product->ratings()->count())->toBe(1)
            ->and($this->product->ratings->first())->toBeInstanceOf(Review::class);
    });
});

describe(AddProductReview::class, function (): void {
    it('saves a review with the component', function (): void {
        Livewire::test(AddProductReview::class, ['product' => $this->product])
            ->set('rating', 5)
            ->set('content', 'Excellent produit!')
            ->call('save');

        expect(Product::query()->count())->toBe(1)
            ->and($this->product->ratings()->count())->toBe(1)
            ->and($this->product->ratings->first())->toBeInstanceOf(Review::class);
    });
});
