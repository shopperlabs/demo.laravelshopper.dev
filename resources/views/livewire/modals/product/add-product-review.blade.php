<x-modal
    header-classes="p-4 border-b border-zinc-100 sm:px-6 sm:py-4"
    content-classes="relative p-4 flex-1 sm:max-h-[500px] sm:px-6 sm:px-5"
    footer-classes="px-4 py-3 border-t border-zinc-100 sm:px-6 sm:flex sm:flex-row-reverse"
    form-action="save"
    @saved="$refresh"
>
    <x-slot name="title">
        {{ __('Add new review') }}
    </x-slot>
    <div class="space-y-4 pb-5">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <input wire:model="rating" type="hidden" />
                <div class="mt-1 flex items-center hover:cursor-pointer">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg wire:click="update('{{$i}}')"
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
        </div>

        <flux:field>
            <flux:label>{{ __('Content') }}</flux:label>
            <flux:textarea wire:model="content" />
            <flux:error name="content" />
        </flux:field>
    </div>

    <x-slot name="buttons">
        <flux:button variant="primary" type="submit" class="w-full sm:ml-3 sm:w-auto">
            {{ __('shopper::forms.actions.save') }}
        </flux:button>
        <flux:button
            type="button"
            wire:click="$dispatch('closeModal')"
            class="w-full mt-3 sm:mt-0 sm:w-auto"
        >
            {{ __('shopper::forms.actions.cancel') }}
        </flux:button>
    </x-slot>

</x-modal>

