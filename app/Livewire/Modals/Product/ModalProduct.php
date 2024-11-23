<?php

declare(strict_types=1);

namespace App\Livewire\Modals\Product;

use App\Actions\Product\AddReview;
use App\Livewire\Forms\ProductReviewsForm;
use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

final class ModalProduct extends ModalComponent
{
    public ProductReviewsForm $form;

    public function mount(Product $product): void
    {
        $this->form->product = $product;
    }

    public function save(): void
    {
        //        dd( $this->form->toArray());
        $addReview = new AddReview;
        $addReview->execute($this->form->product, [
            $this->form->toArray(),
        ], Auth::user());

        Notification::make()
            ->title(__('Review added'))
            ->body(__('The review has been added.'))
            ->success()
            ->send();

        $this->dispatch('review-updated');
        $this->closeModal();
    }

    public function update(int $rate): void
    {
        $this->form->rating = $rate;
    }

    public function render(): View
    {
        return view('livewire.modals.product.modal-product', [
            'title' => __('Add new review'),
        ]);
    }
}
