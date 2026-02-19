<x-shopper::container class="py-5">
    <x-shopper::heading :title="__('Blog Categories')">
        <x-slot name="action">
            {{ $this->createAction }}
        </x-slot>
    </x-shopper::heading>

    <div class="mt-8">
        {{ $this->table }}
    </div>

    <x-filament-actions::modals />
</x-shopper::container>
