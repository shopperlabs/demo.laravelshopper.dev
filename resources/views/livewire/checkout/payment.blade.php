<div class="flex flex-col justify-between space-y-10">
    @include('components.checkout-steps')

    <form wire:submit="save" class="flex-1 space-y-3">
        <flux:error name="currentSelected" />

        <div class="max-w-lg mx-auto lg:max-w-none">
            <flux:radio.group wire:model.live.debounce="currentSelected" variant="cards" class="flex-col">
                @foreach ($methods as $method)
                    <flux:radio value="{{ $method->id }}" class="w-full">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-start gap-3">
                                <div @class([
                                    'flex items-center mt-0.5 justify-center size-5 rounded-full border-2 shrink-0',
                                    'border-primary-600 bg-primary-600' => $currentSelected === $method->id,
                                    'border-zinc-300' => $currentSelected !== $method->id,
                                ])>
                                    @if ($currentSelected === $method->id)
                                        <svg class="size-3 text-white" viewBox="0 0 12 12" fill="currentColor">
                                            <path d="M3.707 5.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L5 6.586 3.707 5.293z" />
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-sm font-medium font-heading">{{ $method->title }}</span>
                            </div>
                            <x-dynamic-component :component="'icons.payments.' . $method->slug" />
                        </div>
                    </flux:radio>
                @endforeach
            </flux:radio.group>

            <div class="mt-8 space-y-8">
                <p class="text-sm leading-5 text-zinc-500">
                    {{ __(" By clicking on the 'Place my order' button, you confirm that you have read,
                     understood and accepted our terms of use, our terms of sale and our returns policy,
                      and you acknowledge that you have read our privacy policy.") }}
                </p>
                <div class="pt-6 border-t border-zinc-200 sm:flex sm:items-center sm:justify-end">
                    <flux:button variant="primary" type="submit" class="w-full sm:w-auto">
                        {{ __('Place my order') }}
                    </flux:button>
                </div>
            </div>
        </div>
    </form>
</div>
