<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.templates.app')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="relative">
    <svg
        class="absolute inset-0 -z-10 h-full w-full stroke-gray-100 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
        aria-hidden="true"
    >
        <defs>
            <pattern
                id="0787a7c5-978c-4f66-83c7-11c213f99cb7"
                width="200"
                height="200"
                x="50%"
                y="-1"
                patternUnits="userSpaceOnUse"
            >
                <path d="M.5 200V.5H200" fill="none" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#0787a7c5-978c-4f66-83c7-11c213f99cb7)" />
    </svg>

    <div class="relative min-h-full flex flex-col justify-center py-12 divide-y divide-gray-200 lg:max-w-2xl lg:mx-auto">
        <div class="sm:mx-auto sm:w-full sm:max-w-md py-8">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 font-heading">
                    {{ __('Forgot your password?') }}
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>
            <div class="mt-6 space-y-6">
                <!-- Session Status -->
                <x-alert.success :status="session('status')" />

                <form wire:submit="sendPasswordResetLink">
                    <!-- Email Address -->
                    <div>
                        <x-forms.label for="email" :value="__('Email')" />
                        <x-forms.input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
                        <x-forms.errors :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-buttons.primary type="submit" class="w-full px-4 text-base">
                            <span class="absolute left-0 pl-2" wire:loading>
                                <x-loading-dots class="bg-white" />
                            </span>
                            {{ __('Email Password Reset Link') }}
                        </x-buttons.primary>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
