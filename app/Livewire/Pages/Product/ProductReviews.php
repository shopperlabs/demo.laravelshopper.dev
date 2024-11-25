<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Product;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.templates.account')]
class ProductReviews extends Component
{
    public Product $product;

    public ?float $averageRating = 0;

    public ?float $reviewsCount = 0;

    public Collection $reviews;

    public function mount(): void
    {
        $this->reviewBasOn();
    }

    #[On('reviewCreated')]
    public function reviewBasOn(): void
    {
        // @phpstan-ignore-next-line
        $this->averageRating = floatval($this->product->averageRating()[0]) ?? $this->averageRating;
        $this->reviewsCount = $this->product->countRating();
        $this->reviews = $this->product->getRecentRatings($this->product->id, 3);
    }

    public function render(): View
    {
        return view('livewire.pages.product.product-reviews');
    }
}
