<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Checkout\Delivery;
use App\Livewire\Checkout\Payment;
use App\Livewire\Checkout\Shipping;
use Spatie\LivewireWizard\Components\WizardComponent;

final class CheckoutWizard extends WizardComponent
{
    /**
     * @return string[]
     */
    public function steps(): array
    {
        return [
            Shipping::class,
            Delivery::class,
            Payment::class,
        ];
    }
}
