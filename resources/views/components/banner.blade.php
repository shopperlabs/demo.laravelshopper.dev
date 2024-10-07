<div class="bg-primary-600">
    <x-container class="flex items-center justify-center py-2">
        <p class="text-sm font-medium text-white">
            {{ __('Get free delivery on orders over :amount', ['amount' => shopper_money_format(config('starter-kit.free_shipping'))]) }}
        </p>
    </x-container>
</div>
