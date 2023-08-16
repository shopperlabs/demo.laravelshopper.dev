<x-layout.guest :title="__('Create your account')">
    <div class="min-h-full flex flex-col justify-center py-12">
        <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">
            <div>
                <h2 class="mt-6 text-3xl font-extrabold text-black font-heading">
                    {{ __('Create your account') }}
                </h2>
            </div>

            <div class="mt-8 space-y-6">
                <div>
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-forms.label for="last_name" :value="__('Last name')" />
                            <x-forms.input id="last_name"
                                           class="block mt-1 w-full"
                                           type="text"
                                           name="last_name"
                                           :value="old('last_name')"
                                           required
                                           autofocus />
                            <x-forms.error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-forms.label for="first_name" :value="__('First name')" />
                            <x-forms.input id="first_name"
                                           class="block mt-1 w-full"
                                           type="text"
                                           name="first_name"
                                           :value="old('first_name')"
                                           required />
                            <x-forms.error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-forms.label for="email" :value="__('Email')" />

                            <x-forms.input id="email"
                                           class="block mt-1 w-full"
                                           type="email"
                                           name="email"
                                           :value="old('email')"
                                           required />
                            <x-forms.error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-forms.label for="password" :value="__('Password')" />

                            <x-forms.input id="password" class="block mt-1 w-full"
                                           type="password"
                                           name="password"
                                           required autocomplete="new-password" />
                            <x-forms.error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-forms.label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-forms.input id="password_confirmation" class="block mt-1 w-full"
                                           type="password"
                                           name="password_confirmation"
                                           required autocomplete="new-password" />
                            <x-forms.error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a class="underline text-sm text-secondary-600 hover:text-secondary-900" href="{{ route('login') }}">
                                {{ __('Already registered ?') }}
                            </a>

                            <x-buttons.primary class="py-2 px-4 w-full max-w-xs sm:max-w-[200px]">
                                {{ __('Register') }}
                            </x-buttons.primary>
                        </div>
                    </form>
                </div>

                <x-oauth />

                <p class="text-sm text-center leading-6 text-secondary-500">
                    {{ __('By registering for an account, you agree to our') }}
                    <a href="#" class="font-medium text-black group group-link-underline">
                        <span class="link link-underline link-underline-black">{{ __('terms and conditions') }}</span>
                    </a>.
                    {{ __('Please read our') }}
                    <a href="#" class="font-medium text-black group group-link-underline">
                        <span class="link link-underline link-underline-black">{{ __('privacy policy') }}</span>
                    </a>.
                </p>
            </div>
        </div>
    </div>
</x-layout.guest>
