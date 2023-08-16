<x-layout.guest>
    <div class="min-h-screen flex flex-col justify-center py-12">
        <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">
            <div class="mb-4 text-sm text-secondary-500">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-buttons.primary class="px-4 py-2">
                            {{ __('Resend Verification Email') }}
                        </x-buttons.primary>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="underline text-sm text-secondary-500 hover:text-secondary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout.guest>
