<div class="space-y-10">
    <x-page-heading
        :title="__('Mes commandes')"
        :description="__('Vérifiez l\'état des commandes récentes, gérez les retours et téléchargez les factures.')"
    />
    @if($orders->isEmpty())
        <div class="flex flex-col items-center py-6 space-y-5">
            <x-untitledui-shopping-bag
                class="h-12 w-12 text-gray-400"
                stroke-width="1"
                aria-hidden="true"
            />
            <p class="mx-auto max-w-3xl text-sm text-gray-500">
                {{ __("Vous n'avez encore rien commandé chez nous. Est-ce le jour pour changer cela ?") }}
            </p>
            <x-buttons.primary link="/" class="text-sm px-4">
                {{ __('Continuez vos achats') }}
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
