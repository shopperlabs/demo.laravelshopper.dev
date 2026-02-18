<div>
    <div class="py-3 bg-white/80 border-b border-zinc-200">
        <x-container class="flex items-center justify-between px-4">
            {{ Breadcrumbs::render('collection', $collection) }}
        </x-container>
    </div>
    <div class="pt-10 pb-16 sm:pb-24 relative overflow-hidden isolate">
        <x-container>
            <div class="max-w-3xl lg:max-w-none">
                <h2 class="text-3xl font-bold tracking-tight text-zinc-900 font-heading">
                    {{ $collection->name }}
                </h2>

                <div class="grid grid-cols-1 mt-6 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-x-8 lg:mt-10">
                    @forelse ($products as $product)
                        <x-products.card :$product />
                    @empty
                        <p class="col-span-3 text-center text-zinc-500">
                            {{ __('No products found in this collection.') }}
                        </p>
                    @endforelse
                </div>

                @if ($products->hasPages())
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </x-container>
    </div>
</div>
