<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard'), navigate: true);
    }
}; ?>

<div class="relative">
    <div class="mb-4 text-sm text-gray-500">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form wire:submit="confirmPassword">
        <!-- Password -->
        <div>
            <x-forms.label for="password" :value="__('Password')" />

            <x-forms.input wire:model="password"
                          id="password"
                          class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-forms.errors :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-buttons.primary type="submit" class="w-full px-4 text-base">
                <span class="absolute left-0 pl-2" wire:loading>
                    <x-loading-dots class="bg-white" />
                </span>
                {{ __('Confirm') }}
            </x-buttons.primary>
        </div>
    </form>
</div>
