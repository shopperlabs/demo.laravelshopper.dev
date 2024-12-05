<?php

declare(strict_types=1);

namespace App\Livewire\Modals\Product;

use App\Actions\Product\AddProductReviewAction;
use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

final class AddProductReview extends ModalComponent
{
    public Product $product;

    #[Validate('required|integer|min:1|max:5')]
    public int $rating = 1;

    #[Validate('nullable|string|max:255')]
    public ?string $title = null;

    #[Validate('nullable|string|max:255')]
    public ?string $content = null;

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        app(AddProductReviewAction::class)
            ->execute($this->product, $this->validate(), Auth::user());

        Notification::make()
            ->title(__('Review added'))
            ->body(__('The review has been added.'))
            ->success()
            ->send();

        $this->dispatch('reviewCreated');

        $this->closeModal();
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
