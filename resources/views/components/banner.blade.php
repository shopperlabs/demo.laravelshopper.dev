<div class="bg-gray-900">
    <div class="mx-auto flex h-10 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <p class="flex-1 text-center text-sm font-medium text-white lg:flex-none">
            {{ __('Get free delivery on orders over $100') }}
        </p>

        <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
            @auth()
                <a href="{{ route('register') }}" class="text-sm font-medium text-white hover:text-gray-100">
                    {{ __('Create an account') }}
                </a>
                <span class="h-6 w-px bg-gray-600" aria-hidden="true"></span>
                <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-gray-100">
                    {{ __('Sign in') }}
                </a>
            @else

            @endauth
        </div>
    </div>
</div>
