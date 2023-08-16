<x-layout.guest :title="__('Sign in to your account')">
    <div class="min-h-full flex flex-col justify-center py-12">
        <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">
            <div>
                <h2 class="mt-6 text-3xl font-extrabold text-black font-heading">
                    {{ __('Sign in to your account') }}
                </h2>
            </div>

            <div class="mt-8 space-y-6">
                <div>
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-forms.label for="email" :value="__('Email Address')" />
                            <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-forms.label for="Password" :value="__('Password')" />
                            <x-forms.input id="password" class="block mt-1 w-full"
                                           type="password"
                                           name="password"
                                           required />
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-secondary-500 hover:text-secondary-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot password ?') }}
                                </a>
                            @endif

                            <x-buttons.primary type="submit" class="py-2 px-4 w-full max-w-xs sm:max-w-[200px]">
                                {{ __('Login') }}
                            </x-buttons.primary>
                        </div>
                    </form>
                </div>

                <x-oauth />

                <p class="text-sm text-center leading-6 text-secondary-500">
                    {{ __('Don\'t have an account yet?') }}
                    <a href="{{ route('register') }}" class="font-medium text-black group group-link-underline">
                        <span class="link link-underline link-underline-black">
                            {{ __('Create my account') }}
                        </span>
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layout.guest>
