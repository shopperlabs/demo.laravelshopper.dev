<?php

declare(strict_types=1);

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.checkout')]
final class Checkout extends Component implements HasForms
{
    use InteractsWithForms;

    public array $data = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('address.street')
                            ->label(__('Adresse'))
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('address.street_plus')
                            ->label(__('Appartement, suite, etc.'))
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('address.city')
                            ->label(__('Ville'))
                            ->columnSpan(['lg' => 1]),
                        Forms\Components\TextInput::make('address.state')
                            ->label(__('Province / Région'))
                            ->columnSpan(['lg' => 1]),
                        Forms\Components\TextInput::make('address.postal_code')
                            ->label(__('Code postal'))
                            ->columnSpan(['lg' => 1]),
                    ])
                    ->columns(3),
            ])
            ->statePath('data');
    }

    public function createOrder(): void
    {
        dump($this->form->getState());
    }

    public function render(): View
    {
        return view('livewire.checkout')
            ->title(__('Procéder au paiement'));
    }
}
