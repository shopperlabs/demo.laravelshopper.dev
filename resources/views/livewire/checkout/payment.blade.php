<div class="flex flex-col justify-between space-y-10">
    @include('components.checkout-steps')

    @include('components.checkout-summary')

    <form wire:submit="save" class="flex-1 space-y-3">
        <flux:error name="currentSelected" />

        <div class="max-w-lg mx-auto lg:max-w-none">
            <div>
                <flux:heading size="lg">{{ __('Payment method') }}</flux:heading>
                <flux:subheading>{{ __('All transactions are secure and encrypted.') }}</flux:subheading>
            </div>

            <flux:radio.group wire:model="currentSelected" variant="cards" class="flex-col mt-5">
                @foreach ($methods as $method)
                    <flux:radio value="{{ $method['id'] }}" class="w-full">
                        <div class="flex items-center justify-between gap-6 w-full">
                            <div class="flex items-center gap-3">
                                <div
                                    :class="$wire.currentSelected == {{ $method['id'] }} ? 'border-primary-600 bg-primary-600' : 'border-zinc-300'"
                                    class="flex items-center justify-center size-5 rounded-full border-2 shrink-0"
                                >
                                    <svg x-show="$wire.currentSelected == {{ $method['id'] }}" x-cloak class="size-3 text-white" viewBox="0 0 12 12" fill="currentColor">
                                        <path d="M3.707 5.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L5 6.586 3.707 5.293z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium font-heading">{{ $method['title'] }}</span>
                            </div>
                            @if ($method['logo'])
                                <img src="{{ $method['logo'] }}" alt="{{ $method['title'] }}" class="h-5 w-auto object-cover" />
                            @endif
                        </div>
                    </flux:radio>
                @endforeach
            </flux:radio.group>

            <div class="mt-8">
                <p class="text-sm leading-5 text-zinc-500">
                    {{ __("By clicking on the 'Place my order' button, you confirm that you have read, understood and accepted our terms of use, our terms of sale and our returns policy, and you acknowledge that you have read our privacy policy.") }}
                </p>
            </div>

            <div class="pt-6 mt-6 border-t border-zinc-200 sm:flex sm:items-center sm:justify-end">
                <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                    {{ __('Place my order') }}
                </flux:button>
            </div>
        </div>
    </form>
</div>
