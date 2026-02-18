<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Shopper\Core\Enum\GenderType;

new #[Layout('components.layouts.templates.app')]
class extends Component {
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['gender'] = GenderType::Male;

        event(new Registered($user = User::query()->create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard'), navigate: true);
    }
}; ?>

<div class="relative">
    <svg
        class="absolute inset-0 -z-10 size-full stroke-zinc-100 mask-[radial-gradient(100%_100%_at_top_right,white,transparent)]"
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

    <div
        class="relative min-h-full flex flex-col justify-center py-12 divide-y divide-zinc-200 lg:max-w-2xl lg:mx-auto">
        <div class="sm:mx-auto sm:w-full sm:max-w-md py-8">
            <h2 class="text-xl font-semibold text-zinc-900 font-heading">
                {{ __('Create account') }}
            </h2>
            <div class="mt-6 space-y-6">
                <form wire:submit="register" class="space-y-4">
                    <!-- Last Name -->
                    <flux:field>
                        <flux:label>{{ __('Lastname') }}</flux:label>
                        <flux:input wire:model="last_name" type="text" required autofocus autocomplete="last_name" />
                        <flux:error name="last_name" />
                    </flux:field>

                    <!-- First Name -->
                    <flux:field>
                        <flux:label>{{ __('Firstname') }}</flux:label>
                        <flux:input wire:model="first_name" type="text" required autocomplete="first_name" />
                        <flux:error name="first_name" />
                    </flux:field>

                    <!-- Email Address -->
                    <flux:field>
                        <flux:label>{{ __('E-mail') }}</flux:label>
                        <flux:input wire:model="email" type="email" required autocomplete="username" />
                        <flux:error name="email" />
                    </flux:field>

                    <!-- Password -->
                    <flux:field>
                        <flux:label>{{ __('Password') }}</flux:label>
                        <flux:input wire:model="password" type="password" required autocomplete="new-password" />
                        <flux:error name="password" />
                    </flux:field>

                    <!-- Confirm Password -->
                    <flux:field>
                        <flux:label>{{ __('Confirm Password') }}</flux:label>
                        <flux:input wire:model="password_confirmation" type="password" required
                                    autocomplete="new-password" />
                        <flux:error name="password_confirmation" />
                    </flux:field>

                    <div class="space-y-3">
                        <x-link class="inline-block underline text-sm text-zinc-600 hover:text-zinc-900"
                                href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </x-link>

                        <flux:button variant="primary" type="submit" class="w-full">
                            {{ __('Register') }}
                        </flux:button>
                    </div>
                </form>

                <x-auth-oauth />

                <p class="text-sm text-center leading-6 text-zinc-500">
                    {{ __('By registering to create an account, you agree to our') }}
                    <x-link href="#" class="font-medium text-black group group-link-underline">
                        <span class="link link-underline link-underline-black">{{ __('terms & conditions') }}</span>
                    </x-link>
                    .
                    {{ __('Please read our') }}
                    <x-link href="#" class="font-medium text-black group group-link-underline">
                        <span class="link link-underline link-underline-black">{{ __('privacy policy') }}</span>
                    </x-link>
                    .
                </p>
            </div>
        </div>
    </div>
</div>
