<div class="flex flex-col justify-between space-y-10">
    @include('components.checkout-steps')

    @include('components.checkout-summary')

    @if(count($options) === 0)
        <div class="flex items-center p-4 space-x-4 rounded-lg ring-1 ring-zinc-200">
            <x-untitledui-shopping-bag class="size-5 text-primary-800" stroke-width="1.5" aria-hidden="true" />
            <p class="text-sm text-zinc-500">
                {{ __('No delivery option available for your address.') }}
            </p>
        </div>
        <div class="pt-6 border-t border-zinc-200">
            <button wire:click="previousStep" type="button" class="text-sm text-primary-600 hover:text-primary-700">
                <span>&larr;</span> {{ __('Return to information') }}
            </button>
        </div>
    @else
        <form wire:submit="save" class="flex-1 space-y-3">
            <flux:error name="currentSelected" />

            <div class="max-w-lg mx-auto lg:max-w-none">
                <flux:radio.group wire:model.live.debounce="currentSelected" variant="cards" class="flex-col">
                    @foreach ($options as $option)
                        <flux:radio value="{{ $option->id }}" class="w-full">
                            <div class="flex items-center justify-between w-full">
                                <div class="flex items-start gap-3">
                                    <div @class([
                                        'flex items-center mt-0.5 justify-center size-5 rounded-full border-2 shrink-0',
                                        'border-primary-600 bg-primary-600' => $currentSelected === $option->id,
                                        'border-zinc-300' => $currentSelected !== $option->id,
                                    ])>
                                        @if ($currentSelected === $option->id)
                                            <svg class="size-3 text-white" viewBox="0 0 12 12" fill="currentColor">
                                                <path d="M3.707 5.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L5 6.586 3.707 5.293z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium font-heading">{{ $option->name }}</span>
                                        <span class="text-sm text-zinc-500">{{ $option->description }}</span>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-zinc-900">
                                    {{ shopper_money_format($option->price, \App\Actions\ZoneSessionManager::getSession()->currencyCode) }}
                                </span>
                            </div>
                        </flux:radio>
                    @endforeach
                </flux:radio.group>

                <div class="pt-6 mt-10 border-t border-zinc-200 sm:flex sm:items-center sm:justify-end">
                    <flux:button variant="primary" type="submit" class="w-full sm:w-auto">
                        {{ __('Continue to payment') }}
                    </flux:button>
                </div>
            </div>
        </form>
    @endif
</div>
