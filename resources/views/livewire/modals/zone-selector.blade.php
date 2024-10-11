<div class="h-full flex flex-col">
    <div class="h-0 flex-1 overflow-y-auto p-8 lg:pt-12">
        <div class="space-y-6">
            <div class="flex items-start justify-between gap-2">
                <h2 class="font-heading text-2xl text-gray-900 font-semibold lg:text-3xl">
                    {{ __('Veuillez sélectionner votre Pays/Région') }}
                </h2>
                <div class="ml-3 flex h-7 items-center">
                    <button
                        type="button"
                        class="bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2"
                        wire:click="$dispatch('closePanel')"
                    >
                        <span class="sr-only">Close panel</span>
                        <x-untitledui-x class="h-8 w-8" stroke-width="1.5" aria-hidden="true" />
                    </button>
                </div>
            </div>
            @if(\App\Actions\ZoneSessionManager::getSession())
                <p class="text-gray-600">
                    {{ __('Où vous faites vos achats présentement') }} :
                    <span class="pl-1 uppercase font-semibold text-primary-950">
                        {{ \App\Actions\ZoneSessionManager::getSession()->countryName }}
                    </span>
                </p>
            @endif
            <p class="text-base text-gray-600 leading-7">
                {{ __("Sachez que si vous changez de région/pays pendant que vous faites vos achats, tout le contenu de votre panier sera supprimé.") }}
            </p>
        </div>
        <div class="mt-8 divide-y divide-gray-200">
            @foreach($this->countries->groupBy('zoneName') as $zone => $countries)
                <div class="py-6">
                    <h4 class="font-medium text-gray-900 leading-6">
                        {{ $zone }}
                    </h4>
                    <ul role="listbox" class="mt-4 space-y-1 -mx-3">
                        @foreach($countries as $country)
                            <li>
                                <button wire:click="selectZone({{ $country->countryId }})" type="button" class="group w-full flex items-center bg-transparent px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                                    <img src="{{ $country->countryFlag }}" alt="country flag" class="block h-auto w-5 shrink-0" />
                                    <span class="ml-2 block text-sm font-medium">{{ $country->countryName }}</span>
                                    <span class="sr-only">, {{ __('sélectionner la zone') }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
