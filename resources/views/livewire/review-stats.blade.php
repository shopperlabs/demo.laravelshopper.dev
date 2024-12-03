<?php

declare(strict_types=1);

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component
{
    public Product $product;

    #[Computed]
    public function reviewsStats(): array
    {
        $reviewsStats = [];

        foreach (range(1, 5) as $rating) {
            $reviewsStats[$rating] = [
                'count' => $this->product->ratings()->where('rating', $rating)->count(),
                'percentage' => round($this->product->ratingPercent($rating), 2),
            ];
        }

        krsort($reviewsStats);

        return $reviewsStats;
    }
}
?>

<div>
    <div class="mt-6">
        <h3 class="sr-only">Review data</h3>
        <dl class="space-y-3">
            @foreach ($this->reviewsStats as $rating => $stat)
                <div class="flex items-center text-sm">
                    <dt class="flex flex-1 items-center">
                        <p class="w-3 font-medium text-gray-900">{{ $rating }}<span class="sr-only"> star reviews</span>
                        </p>
                        <div aria-hidden="true" class="ml-1 flex flex-1 items-center">
                            <svg class="size-5 shrink-0 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"
                                 aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                      clip-rule="evenodd" />
                            </svg>

                            <div class="relative ml-3 flex-1">
                                <div class="h-3 rounded-full border border-gray-200 bg-gray-100"></div>
                                <div style="width: {{ $stat['percentage'] }}%"
                                     class="absolute inset-y-0 rounded-full border border-yellow-400 bg-yellow-400"></div>
                            </div>
                        </div>
                    </dt>
                    <dd class="ml-3 w-10 text-right text-sm tabular-nums text-gray-900">{{ $stat['percentage'] }}%</dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
