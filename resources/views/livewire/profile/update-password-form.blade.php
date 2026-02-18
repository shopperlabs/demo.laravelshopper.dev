<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('notify', title: 'Password update');
    }
}; ?>

<section class="py-10">
    <header>
        <h2 class="text-lg font-medium text-zinc-900 lg:text-xl">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-zinc-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-8 space-y-6 max-w-xl">
        <flux:field>
            <flux:label badge="required">{{ __('Current Password') }}</flux:label>
            <flux:input wire:model="current_password" type="password" autocomplete="current-password" required />
            <flux:error name="current_password" />
        </flux:field>

        <flux:field>
            <flux:label badge="required">{{ __('New Password') }}</flux:label>
            <flux:input wire:model="password" type="password" autocomplete="new-password" required />
            <flux:error name="password" />
        </flux:field>

        <flux:field>
            <flux:label badge="required">{{ __('Confirm Password') }}</flux:label>
            <flux:input wire:model="password_confirmation" type="password" autocomplete="new-password" required />
            <flux:error name="password_confirmation" />
        </flux:field>

        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">
                {{ __('Save') }}
            </flux:button>
        </div>
    </form>
</section>
