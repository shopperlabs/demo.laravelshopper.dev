<?php

namespace App\Livewire\Modals\Product;

use App\Actions\Product\AddReview;
use App\Livewire\Forms\ProductReviewsForm;
use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

final class ModalProduct extends ModalComponent
{
    public ProductReviewsForm $form;

    public function save()
    {
        $validated = $this->validate();

        dd($validated);

        $addReview = new AddReview;
        $addReview->execute($this->form->product, [
            $validated,
        ], \Illuminate\Container\Attributes\Auth::user());



        Notification::make()
            ->title(__('Review added'))
            ->body(__('The review has been added.'))
            ->success()
            ->send();

        $this->dispatch('review-updated');
        $this->closeModal();
    }

    public function render(): View
    {
        return view('livewire.modals.product.modal-product', [
            'title' => __('Add new review'),
        ]);
    }

}
