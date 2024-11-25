<x-modal
    header-classes="p-4 border-b border-gray-100 sm:px-6 sm:py-4"
    content-classes="relative p-4 flex-1 sm:max-h-[500px] sm:px-6 sm:px-5"
    footer-classes="px-4 py-3 border-t border-gray-100 sm:px-6 sm:flex sm:flex-row-reverse"
    form-action="save"
    @saved="$refresh"
>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <div class="space-y-4 pb-5">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-forms.input wire:model="form.rating" id="rate" name="rate" value="1" type="hidden"/>
                <div class="mt-1 flex items-center hover:cursor-pointer">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg wire:click="update('{{$i}}')" class="size-5 shrink-0 {{ $i <= $form->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                        </svg>
                    @endfor
                </div>
            </div>

        </div>

        <div class="space-y-2">
            <x-forms.label for="form.content" :value="__('Content')" />
            <x-forms.text-area wire:model="form.content" id="content" name="content" type="text"> </x-forms.text-area>
            <x-forms.errors :messages="$errors->get('form.content')" />
        </div>

    </div>

    <x-slot name="buttons">
        <x-buttons.submit
            :title="__('shopper::forms.actions.save')"
            wire:loading.attr="data-loading"
            class="w-full sm:ml-3 sm:w-auto"
        />
        <x-buttons.default
            type="button"
            wire:click="$dispatch('closeModal')"
            class="w-full px-4 py-2 mt-3 text-sm sm:mt-0 sm:w-auto"
        >
            {{ __('shopper::forms.actions.cancel') }}
        </x-buttons.default>
    </x-slot>

</x-modal>

