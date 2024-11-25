<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ReviewStats extends Component
{
    public ?Product $product;

    // @phpstan-ignore-next-line
    public array $reviewsStats = [];

    public ?float $reviewsCount = 0;

    public function mount(): void
    {
        $this->reviewUpdated();
    }

    #[On('reviewCreated')]
    public function reviewUpdated(): void
    {
        $this->reviewsCount = $this->product->countRating();

        foreach (range(1, 5) as $rating) {
            $percentage = $this->reviewsCount ? $this->product->ratingPercent($rating) : 0;

            /**
             * reviewsStats array<mixed>
             */
            $this->reviewsStats[$rating] = [
                'count' => $this->product->ratings()->where('rating', $rating)->count(),
                'percentage' => round($percentage, 2),
            ];
        }

        krsort($this->reviewsStats);
    }

    public function render(): View
    {
        return view('livewire.review-stats');
    }
}
