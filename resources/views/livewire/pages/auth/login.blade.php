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
            <h2 class="text-xl font-semibold text-gray-900 font-heading">
                {{ __('I already have an account') }}
            </h2>
            <div class="my-6 space-y-4">
                <!-- Session Status -->
                <x-alert.success :status="session('status')" />

                <form wire:submit="login" class="space-y-4">
                    <!-- Email Address -->
                    <div>
                        <x-forms.label for="email" :value="__('E-mail')" />
                        <x-forms.input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="email" />
                        <x-forms.errors :messages="$errors->get('form.email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-forms.label for="password" :value="__('Password')" />
                        <x-forms.input wire:model="form.password" id="password" class="block mt-1 w-full"
                                       type="password"
                                       name="password"
                                       required autocomplete="current-password" />

                        <x-forms.errors :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block">
                        <label for="remember" class="inline-flex items-center">
                            <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-primary-500 focus:ring-primary-500" name="remember">
                            <span class="ms-2 text-sm text-gray-500">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="space-y-5">
                        <x-link class="underline text-sm text-gray-500 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </x-link>

                        <x-buttons.primary type="submit" class="w-full px-4 text-sm">
                            <span class="absolute left-0 pl-2" wire:loading>
                                <x-loading-dots class="bg-white" />
                            </span>
                            {{ __('Log in') }}
                        </x-buttons.primary>
                    </div>
                </form>
            </div>
            <x-auth-oauth />
        </div>
        <div class="sm:mx-auto sm:w-full sm:max-w-md py-8">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 font-heading">
                    {{ __('New customer') }}
                </h2>
                <p class="mt-3 text-sm leading-5 text-gray-500">
                    {{ __('Create your own space for an enhanced shopping experience.') }}
                </p>
            </div>
            <div class="mt-6">
                <x-buttons.default :href="route('register')" class="w-full px-4 text-sm">
                    {{ __('Create account') }}
                </x-buttons.default>
            </div>
        </div>
    </div>
</div>
