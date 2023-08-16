<x-layout.guest>
    <div class="min-h-full flex flex-col justify-center py-12">
        <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">
            <div>
                <h2 class="mt-6 text-3xl font-extrabold text-black font-heading">
                    {{ __('Create your account') }}
                </h2>
            </div>

            <div class="mt-8">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-forms.label for="email" :value="__('Email')" />
                        <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-forms.error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-forms.label for="password" :value="__('Password')" />
                        <x-forms.input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-forms.error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-forms.label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-forms.input id="password_confirmation" class="block mt-1 w-full"
                                      type="password"
                                      name="password_confirmation" required autocomplete="new-password" />

                        <x-forms.error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-5">
                        <x-buttons.primary class="px-4 py-2">
                            {{ __('Reset Password') }}
                        </x-buttons.primary>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.guest>
