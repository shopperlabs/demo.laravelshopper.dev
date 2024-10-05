<div class="hidden lg:flex">
    <button type="button" class="flex items-center text-gray-700 hover:text-gray-800">
        <img src="{{ $country_flag }}" alt="country flag" class="block h-auto w-5 shrink-0" />
        <span class="ml-2 block text-sm font-medium">{{ $currency_code }}</span>
        <span class="sr-only">, {{ __('change currency') }}</span>
    </button>
</div>
