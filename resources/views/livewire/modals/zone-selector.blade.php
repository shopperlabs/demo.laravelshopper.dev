<div class="flex flex-col h-full">
    <div class="flex-1 h-0 p-8 overflow-y-auto lg:pt-12">
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-2">
                <h2 class="text-2xl font-semibold text-gray-900 font-heading">
                    {{ __('Please select your Country / Zone') }}
                </h2>
                <div class="flex items-center ml-3 h-7">
                    <button
                        type="button"
                        class="text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none"
                        wire:click="$dispatch('closePanel')"
                    >
                        <span class="sr-only">{{ __('Close panel') }}</span>
                        <x-untitledui-x class="size-8" stroke-width="1.5" aria-hidden="true" />
                    </button>
                </div>
            </div>
            @if(\App\Actions\ZoneSessionManager::getSession())
                <p class="text-gray-600">
                    {{ __('Where you shop now') }} :
                    <span class="pl-1 font-semibold uppercase text-gray-950">
                        {{ \App\Actions\ZoneSessionManager::getSession()->countryName }}
                    </span>
                </p>
            @endif
            <p class="text-base leading-7 text-gray-600">
                {{ __("Please note that if you change zone / country while shopping, all the contents of your basket will be deleted.") }}
            </p>
        </div>
        <div class="mt-8 divide-y divide-gray-200">
            @foreach($this->countries->groupBy('zoneName') as $zone => $countries)
                <div class="py-6">
                    <h4 class="font-medium leading-6 text-gray-900">
                        {{ $zone }}
                    </h4>
                    <ul role="listbox" class="mt-4 -mx-3 space-y-1">
                        @foreach($countries as $country)
                            <li>
                                <button wire:click="selectZone({{ $country->countryId }})" type="button" class="flex items-center w-full px-3 py-2 rounded-md text-gray-600 bg-transparent group hover:text-gray-800 hover:bg-gray-50">
                                    <img src="{{ $country->countryFlag }}" alt="country flag" class="block w-5 h-auto shrink-0" />
                                    <span class="block ml-2 text-sm font-medium">{{ $country->countryName }}</span>
                                    <span class="sr-only">, {{ __('Select zone') }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
