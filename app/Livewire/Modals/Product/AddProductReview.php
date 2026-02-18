<?php

declare(strict_types=1);

namespace App\Livewire\Modals\Product;

use App\Actions\Product\AddProductReviewAction;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class AddProductReview extends Component
{
    public Product $product;

    public bool $showModal = false;

    #[Validate('required|integer|min:1|max:5')]
    public int $rating = 1;

    #[Validate('nullable|string|max:255')]
    public ?string $content = null;

    public function openModal(): void
    {
        $this->showModal = true;
    }

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        resolve(AddProductReviewAction::class)
            ->execute($this->product, $this->validate(), Auth::user());

        $this->dispatch('notify', type: 'success', title: __('Review added'), message: __('The review has been added.'));

        $this->dispatch('reviewCreated');

        $this->showModal = false;

        $this->reset('rating', 'content');
    }

    public function update(int $rate): void
    {
        $this->rating = $rate;
    }

    public function render(): View
    {
        return view('livewire.modals.product.add-product-review');
    }
}
