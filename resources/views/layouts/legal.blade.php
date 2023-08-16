@props(['legal', 'title' => null])

<x-layout.shop :title="$title">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16">
        <div class="sm:grid sm:grid-cols-7 sm:gap-10">
            <aside class="hidden lg:block lg:col-span-2">
                <nav class="sticky top-4 flex flex-col space-y-1">
                    <x-legal-link href="{{ route('legal', ['slug' => 'privacy-policy']) }}">
                        {{ __('Privacy') }}
                    </x-legal-link>
                    <x-legal-link href="{{ route('legal', ['slug' => 'terms-of-use']) }}">
                        {{ __('Terms of uses') }}
                    </x-legal-link>
                    <x-legal-link href="{{ route('legal', ['slug' => 'refund-policy']) }}">
                        {{ __('Refund') }}
                    </x-legal-link>
                    <x-legal-link href="{{ route('legal', ['slug' => 'shipping-privacy']) }}">
                        {{ __('Shipping') }}
                    </x-legal-link>
                </nav>
            </aside>
            <div class="lg:col-span-5">
                <div>
                    <h2 class="text-2xl font-bold uppercase text-dark tracking-wider font-heading sm:text-3xl">
                        {{ $legal->title }}
                    </h2>
                    <span class="text-sm leading-5 text-secondary-500">
                        {{ __('Last updated: :date', ['date' => $legal->created_at->format('d, F Y')]) }}
                    </span>
                </div>
                <div class="mt-10 prose prose-sm sm:prose-lg text-secondary-500 max-w-none">
                    {!! $legal->content  !!}
                </div>
            </div>
        </div>
    </div>
</x-layout.shop>
