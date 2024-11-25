<?php

declare(strict_types=1);

namespace App\Livewire\Modals\Product;

use App\Actions\Product\AddProductReviewAction;
use App\Livewire\Forms\ProductReviewsForm;
use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LivewireUI\Modal\ModalComponent;

final class AddProductReview extends ModalComponent
{
    public ProductReviewsForm $form;

    public function mount(Product $product): void
    {
        $this->form->product = $product;
    }

    /**
     * @throws ValidationException
     */
    public function save(): void
    {
        $this->form->validate();

        app(AddProductReviewAction::class)
            ->execute($this->form->product, $this->form->toArray(), Auth::user());

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
        $this->form->rating = $rate;
    }

    public function render(): View
    {
        return view('livewire.modals.product.add-product-review', [
            'title' => __('Add new review'),
        ]);
    }
}
