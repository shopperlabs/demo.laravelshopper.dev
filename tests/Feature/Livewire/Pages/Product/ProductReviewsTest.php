<?php

declare(strict_types=1);

use App\Actions\Product\AddProductReviewAction;
use App\Livewire\Modals\Product\AddProductReview;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;
use Shopper\Core\Models\Review;

beforeEach(function () {
    $this->product = Product::query()->create(['name' => 'Matanga 1']);
    $this->user = User::query()->create(['email' => 'john@shopper.com', 'last_name' => 'John']);
    $this->actingAs($this->user);
});

describe(AddProductReviewAction::class, function (): void {
    it('allows users to add a review', function () {
        $rating = [
            'rating' => 5,
            'content' => 'Excellent!',
        ];

        app(AddProductReviewAction::class)->execute($this->product, $rating, $this->user);

        expect(Product::query()->count())->toBe(1)
            ->and($this->product->ratings()->count())->toBe(1)
            ->and($this->product->ratings->first())->toBeInstanceOf(Review::class);
    });
});

describe(AddProductReview::class, function (): void {
    it('saves a review with the component', function () {
        Livewire::test(AddProductReview::class, ['product' => $this->product])
            ->set('form.rating', 5)
            ->set('form.content', 'Excellent produit!')
            ->call('save');

        expect(Product::query()->count())->toBe(1)
            ->and($this->product->ratings()->count())->toBe(1)
            ->and($this->product->ratings->first())->toBeInstanceOf(Review::class);
    });
});
