<div class="bg-secondary-100">
    <div class="flex items-center justify-between h-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <p class="flex-1 text-sm font-medium text-center text-secondary-700 lg:flex-none">
            {{ __('Get free delivery on orders over $100') }}
        </p>

        <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}" class="text-sm font-medium text-secondary-700 hover:text-secondary-900 hover:underline"
                       onclick="event.preventDefault();
                         this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-secondary-700 hover:text-secondary-900">
                    {{ __('Sign in') }}
                </a>
                <span class="w-px h-6 bg-secondary-300" aria-hidden="true"></span>
                <a href="{{ route('register') }}" class="text-sm font-medium text-secondary-700 hover:text-secondary-900">
                    {{ __('Create an account') }}
                </a>
            @endauth
        </div>
    </div>
</div>
