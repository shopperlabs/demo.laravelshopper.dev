@assets
<script src="https://js.stripe.com/v3/"></script>
@endassets

<div class="bg-white">
    <header class="relative border-b border-zinc-200 bg-white">
        <x-container class="py-4">
            <div class="relative flex items-center justify-between">
                <x-link :href="route('home')">
                    <span class="sr-only">{{ shopper_setting('legal_name') }}</span>
                    <x-brand class="w-auto h-10 text-primary-700" aria-hidden="true" />
                </x-link>
            </div>
        </x-container>
    </header>

    <x-container class="py-16 lg:max-w-lg">
        <div class="text-center">
            <h1 class="text-2xl font-bold font-heading tracking-tight text-zinc-900">
                {{ __('Complete your payment') }}
            </h1>
            <p class="mt-2 text-sm text-zinc-500">
                {{ __('Order #:number', ['number' => $order->number]) }}
            </p>
        </div>

        <div class="mt-10" x-data="stripePayment">
            <div id="payment-element" class="min-h-[200px]"></div>

            <p x-show="errorMessage" x-text="errorMessage" x-cloak class="mt-4 text-sm text-red-600"></p>

            <flux:button
                variant="primary"
                class="w-full mt-6"
                x-on:click="submitPayment"
                x-bind:disabled="processing"
            >
                <span x-show="!processing">{{ __('Pay now') }}</span>
                <span x-show="processing" x-cloak class="flex items-center justify-center gap-2">
                    <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    {{ __('Processing...') }}
                </span>
            </flux:button>
        </div>
    </x-container>
</div>

@script
<script>
Alpine.data('stripePayment', () => ({
    stripe: null,
    elements: null,
    paymentElement: null,
    processing: false,
    errorMessage: '',

    init() {
        this.stripe = Stripe($wire.publishableKey)
        this.elements = this.stripe.elements({
            clientSecret: $wire.clientSecret,
            appearance: {
                theme: 'stripe',
                variables: {
                    colorPrimary: '#155DFC',
                    borderRadius: '8px',
                },
            },
        })
        this.paymentElement = this.elements.create('payment')
        this.paymentElement.mount('#payment-element')
    },

    async submitPayment() {
        if (this.processing) return
        this.processing = true
        this.errorMessage = ''

        const { error } = await this.stripe.confirmPayment({
            elements: this.elements,
            confirmParams: {
                return_url: $wire.returnUrl,
            },
        })

        if (error) {
            this.errorMessage = error.message
            this.processing = false
        }
    },
}))
</script>
@endscript
