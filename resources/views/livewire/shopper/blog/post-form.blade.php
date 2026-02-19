<x-shopper::container class="py-5">
    <x-shopper::breadcrumb :back="route('shopper.blog.posts.index')" :current="$post->exists ? __('Edit post') : __('Create post')">
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" />
        <x-shopper::breadcrumb.link
            :link="route('shopper.blog.posts.index')"
            :title="__('Blog Posts')"
        />
    </x-shopper::breadcrumb>

    <x-shopper::heading
        class="my-6"
        :title="$post->exists ? $post->title : __('Create post')"
    />

    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-8 flex items-center gap-4">
            <x-filament::button type="submit">
                {{ __('Save') }}
            </x-filament::button>
            <x-filament::button
                color="gray"
                tag="a"
                :href="route('shopper.blog.posts.index')"
                wire:navigate
            >
                {{ __('Cancel') }}
            </x-filament::button>
        </div>
    </form>
</x-shopper::container>
