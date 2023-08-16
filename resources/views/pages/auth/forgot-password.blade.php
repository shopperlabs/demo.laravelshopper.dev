<x-layout.guest>
    <div class="min-h-full flex flex-col justify-center py-32 lg:py-64">
        <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">
            <a href="{{ route('login') }}" class="group inline-flex items-center gap-x-2 text-secondary-500 hover:text-secondary-900 text-sm">
                <span class="flex items-center justify-center h-8 w-8 rounded-full shadow-md shadow-secondary-800/5 transition border border-secondary-200 bg-secondary-50 ring-0 ring-white/10 group-hover:border-secondary-300">
                    <svg viewBox="0 0 16 16" fill="none" aria-hidden="true" class="h-4 w-4 transition stroke-secondary-400 group-hover:stroke-secondary-500">
                        <path d="M7.25 11.25 3.75 8m0 0 3.5-3.25M3.75 8h8.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                {{ __('Return to Login') }}
            </a>

            <div class="mt-8 mb-4 text-sm text-secondary-500">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-forms.label for="email" :value="__('Email')" />
                    <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-forms.error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-buttons.primary class="px-4 py-2">
                        {{ __('Email Password Reset Link') }}
                    </x-buttons.primary>
                </div>
            </form>
        </div>
    </div>
</x-layout.guest>
