<header class="relative z-20">
    <!-- Top navigation -->
    <x-banner />

    <!-- Secondary navigation -->
    <div class="bg-white">
        <div class="border-b border-secondary-200">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="hidden lg:flex lg:flex-1">
                        <div class="flex justify-center space-x-3">
                            <x-menu-link title="Men" />
                            <x-menu-link title="Women" />
                            <x-menu-link title="Child" />
                        </div>
                    </div>
                    <div class="hidden lg:flex lg:items-center">
                        <a href="#">
                            <span class="sr-only">{{ config('app.name') }}</span>
                            <x-brand class="w-auto h-8" />
                        </a>
                    </div>
                    <div class="flex items-center justify-end flex-1">
                        <div class="flex items-center space-x-1 lg:ml-8">
                            <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="inline-flex items-center p-2 transition text-secondary-500 hover:text-secondary-700">
                                <x-untitledui-user-02 class="w-6 h-6" stroke-width="1.5" />
                            </a>
                            <a href="#" class="inline-flex items-center p-2 transition text-secondary-500 hover:text-secondary-700">
                                <x-untitledui-shopping-bag-02 class="w-6 h-6" stroke-width="1.5" />
                            </a>
                            <a href="#" class="inline-flex items-center p-2 transition text-secondary-500 hover:text-secondary-700">
                                <x-untitledui-heart class="w-6 h-6" stroke-width="1.5" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
