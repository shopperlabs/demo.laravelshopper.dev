<x-shopper::container class="py-5">
    <x-shopper::heading :title="__('Blog Posts')">
        <x-slot name="action">
            <x-filament::button
                tag="a"
                :href="route('shopper.blog.posts.create')"
                wire:navigate
            >
                {{ __('Create post') }}
            </x-filament::button>
        </x-slot>
    </x-shopper::heading>

    <div class="mt-8">
        {{ $this->table }}
    </div>
</x-shopper::container>
