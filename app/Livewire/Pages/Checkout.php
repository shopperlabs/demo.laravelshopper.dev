<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\CheckoutSession;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.templates.light')]
final class Checkout extends Component
{
    public ?string $sessionKey = null;

    public function mount(): void
    {
        $this->sessionKey = session()->getId();

        // @phpstan-ignore-next-line
        if (CartFacade::session($this->sessionKey)->isEmpty()) {
            if (session()->exists(CheckoutSession::KEY)) {
                session()->forget(CheckoutSession::KEY);
            }

            $this->redirect(route('home'), true);
        }
    }

    public function render(): View
    {
        return view('livewire.pages.checkout', [
            'items' => CartFacade::session($this->sessionKey)->getContent(), // @phpstan-ignore-line
            'subtotal' => CartFacade::session($this->sessionKey)->getSubTotal(), // @phpstan-ignore-line
        ])
            ->title(__('Proceed to checkout'));
    }
}
