<div>
    <flux:button type="button" wire:click="openModal" class="w-full sm:w-auto lg:w-full">
        {{ __('Write a review') }}
    </flux:button>

    <flux:modal wire:model="showModal" class="md:w-lg">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Add new review') }}</flux:heading>
            </div>

            <div class="space-y-4">
                <div class="space-y-2">
                    <input wire:model="rating" type="hidden" />
                    <div class="mt-1 flex items-center hover:cursor-pointer">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg wire:click="update('{{ $i }}')"
                                 @class([
                                    'size-5 shrink-0',
                                    'text-yellow-400' => $i <= $rating,
                                    'text-zinc-300' => $i > $rating,
                                ])
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                            </svg>
                        @endfor
                    </div>
                </div>

                <flux:field>
                    <flux:label>{{ __('Content') }}</flux:label>
                    <flux:textarea wire:model="content" />
                    <flux:error name="content" />
                </flux:field>
            </div>

            <div class="flex gap-3 justify-end">
                <flux:button type="button" wire:click="$set('showModal', false)">
                    {{ __('shopper::forms.actions.cancel') }}
                </flux:button>
                <flux:button variant="primary" type="submit">
                    {{ __('shopper::forms.actions.save') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
