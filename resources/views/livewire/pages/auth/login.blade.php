<?php

declare(strict_types=1);

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.templates.app')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard'), navigate: true);
    }
}; ?>

<div class="relative">
    <svg
        class="absolute inset-0 -z-10 h-full w-full stroke-zinc-100 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
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

    <div class="relative min-h-full flex flex-col justify-center py-12 divide-y divide-zinc-200 lg:max-w-2xl lg:mx-auto">
        <div class="sm:mx-auto sm:w-full sm:max-w-md py-8">
            <h2 class="text-xl font-semibold text-zinc-900 font-heading">
                {{ __('I already have an account') }}
            </h2>
            <div class="my-6 space-y-4">
                <!-- Session Status -->
                <x-alert.success :status="session('status')" />

                <form wire:submit="login" class="space-y-4">
                    <!-- Email Address -->
                    <flux:field>
                        <flux:label>{{ __('E-mail') }}</flux:label>
                        <flux:input wire:model="form.email" type="email" required autofocus autocomplete="email" />
                        <flux:error name="form.email" />
                    </flux:field>

                    <!-- Password -->
                    <flux:field>
                        <flux:label>{{ __('Password') }}</flux:label>
                        <flux:input wire:model="form.password" type="password" required autocomplete="current-password" />
                        <flux:error name="form.password" />
                    </flux:field>

                    <!-- Remember Me -->
                    <flux:checkbox wire:model="form.remember" label="{{ __('Remember me') }}" />

                    <div class="space-y-5">
                        <x-link class="inline-block underline text-sm text-zinc-500 hover:text-zinc-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </x-link>

                        <flux:button variant="primary" type="submit" class="w-full">
                            {{ __('Log in') }}
                        </flux:button>
                    </div>
                </form>
            </div>

            <x-auth-oauth />
        </div>
        <div class="sm:mx-auto sm:w-full sm:max-w-md py-8">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 font-heading">
                    {{ __('New customer') }}
                </h2>
                <p class="mt-3 text-sm leading-5 text-zinc-500">
                    {{ __('Create your own space for an enhanced shopping experience.') }}
                </p>
            </div>
            <div class="mt-6">
                <flux:button :href="route('register')" class="w-full">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </div>
    </div>
</div>
