<x-modal
    header-classes="p-4 border-b border-gray-100 sm:px-6 sm:py-4"
    content-classes="relative p-4 flex-1 sm:max-h-[500px] sm:px-6 sm:px-5"
    footer-classes="px-4 py-3 border-t border-gray-100 sm:px-6 sm:flex sm:flex-row-reverse"
    form-action="save"
>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <div class="space-y-4 pb-5">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-forms.label for="form.rating" :value="__('Rate')" required />
                <x-forms.input wire:model="form.rating" id="form.rating" name="form.rating" type="text"/>
                <x-forms.errors :messages="$errors->get('form.rating')" />
            </div>

            <div class="space-y-2">
                <x-forms.label for="form.title" :value="__('Title')" required />
                <x-forms.input wire:model="form.title" id="form.title" name="form.title" type="text"/>
                <x-forms.errors :messages="$errors->get('form.title')" />
            </div>
        </div>
        <div class="space-y-2">
            <x-forms.label for="form.content" :value="__('Content')" required />
            <x-forms.text-area wire:model="form.content" id="form.content" name="form.content" type="text"> </x-forms.text-area>
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
