<div class="flex flex-col h-full">
    <div class="flex-1 h-0 p-4 overflow-y-auto">
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-2">
                <h2 class="text-2xl font-semibold text-zinc-900 font-heading">
                    {{ __('Please select your Country / Zone') }}
                </h2>
                <x-livewire-slide-over::close-icon />
            </div>
            @if(\App\Actions\ZoneSessionManager::getSession())
                <p class="text-zinc-600">
                    {{ __('Where you shop now') }} :
                    <span class="pl-1 font-semibold uppercase text-zinc-950">
                        {{ \App\Actions\ZoneSessionManager::getSession()->countryName }}
                    </span>
                </p>
            @endif
            <p class="text-base leading-7 text-zinc-600">
                {{ __("Please note that if you change zone / country while shopping, all the contents of your basket will be deleted.") }}
            </p>
        </div>
        <div class="mt-8 divide-y divide-zinc-200">
            @foreach($this->countries->groupBy('zoneName') as $zone => $countries)
                <div class="py-6">
                    <h4 class="font-medium leading-6 text-zinc-900">
                        {{ $zone }}
                    </h4>
                    <ul role="listbox" class="mt-4 -mx-3 space-y-1">
                        @foreach($countries as $country)
                            <li>
                                <button wire:click="selectZone({{ $country->countryId }})" type="button" class="flex items-center w-full px-3 py-2 rounded-md text-zinc-600 bg-transparent group hover:text-zinc-800 hover:bg-zinc-50">
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
