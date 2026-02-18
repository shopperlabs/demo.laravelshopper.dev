<div>
    <x-page-heading
        :title="__('My orders')"
        :description="__('Check the status of recent orders, manage returns and download invoices.')"
    />

    <div class="mt-5">
        @if ($orders->isEmpty())
            <div class="flex flex-col items-center py-6 space-y-5">
                <x-untitledui-shopping-bag
                    class="size-12 text-zinc-400"
                    stroke-width="1"
                    aria-hidden="true"
                />
                <p class="max-w-3xl mx-auto text-sm text-zinc-500">
                    {{ __("You haven't ordered anything from us yet. Is this the day to change that?") }}
                </p>
                <flux:button variant="primary" :href="route('store')">
                    {{ __('Continue shopping') }}
                </flux:button>
            </div>
        @else
            <div class="divide-y divide-zinc-200">
                @foreach ($orders as $order)
                    <x-order :$order />
                @endforeach
            </div>

            <div class="mt-10 lg:max-w-4xl">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
