<?php

declare(strict_types=1);

use Shopper\Core\Models\Collection;

use function Livewire\Volt\computed;
use function Livewire\Volt\title;

title(__('Collections'));

$collections = computed(fn () => Collection::query()
    ->whereNotNull('published_at')
    ->orderBy('name')
    ->get());

?>

<div class="pb-16 sm:pb-24">
    <div class="py-3 bg-white/80 border-b border-zinc-200">
        <x-container>
            {{ Breadcrumbs::render('collections') }}
        </x-container>
    </div>
    <x-container class="pb-24 pt-10">
        <div>
            <h1 class="text-4xl font-bold tracking-tight font-heading text-zinc-900">{{ __('Collections') }}</h1>
            <p class="mt-4 text-base text-zinc-500">
                {{ __('Explore our curated collections.') }}
            </p>
        </div>

        <div class="mt-10 flex flex-col">
            @foreach ($this->collections as $collection)
                <x-link class="flex items-center py-1.5 font-heading text-primary-600 text-md hover:text-primary-800" :href="route('collection.products', $collection->slug)">
                    {{ $collection->name }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 size-4" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                    </svg>
                </x-link>
            @endforeach
        </div>
    </x-container>
</div>
