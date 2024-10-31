<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.templates.checkout')]
final class Checkout extends Component
{
    public ?string $sessionKey = null;

    public function mount(): void
    {
        $this->sessionKey = session()->getId();

        if (CartFacade::session($this->sessionKey)->isEmpty()) {
            if (session()->exists('checkout')) {
                session()->forget('checkout');
            }

            $this->redirect(route('home'), true);
        }
    }

    public function render(): View
    {
        return view('livewire.pages.checkout', [
            'items' => CartFacade::session($this->sessionKey)->getContent(),
            'subtotal' => CartFacade::session($this->sessionKey)->getSubTotal(),
        ])
            ->title(__('Proceed to checkout'));
    }
}
