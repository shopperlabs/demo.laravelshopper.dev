<div class="space-y-10">
    <x-page-heading
        :title="__('My orders')"
        :description="__('Check the status of recent orders, manage returns and download invoices.')"
    />
    @if($orders->isEmpty())
        <div class="flex flex-col items-center py-6 space-y-5">
            <x-untitledui-shopping-bag
                class="w-12 h-12 text-gray-400"
                stroke-width="1"
                aria-hidden="true"
            />
            <p class="max-w-3xl mx-auto text-sm text-gray-500">
                {{ __("You haven't ordered anything from us yet. Is this the day to change that?") }}
            </p>
            <x-buttons.primary :href="route('store.products')" class="px-4 text-sm">
                {{ __('Continue shopping') }}
            </x-buttons.primary>
        </div>
    @else
        <div class="divide-y divide-gray-200">
            @foreach($orders as $order)
                <x-order :order="$order" />
            @endforeach
        </div>

        <div class="lg:max-w-4xl">
            {{ $orders->links() }}
        </div>
    @endif
</div>
