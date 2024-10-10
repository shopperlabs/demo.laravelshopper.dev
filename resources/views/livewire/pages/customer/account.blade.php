<?php

declare(strict_types=1);

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.templates.account')] class extends Component {
    #[Computed]
    public function links(): array
    {
        return [
            [
                'title' => __('Mes commandes'),
                'description' => __('Suivez vos commandes, retournez-les ou achetez-les à nouveau'),
                'href' => route('account.orders'),
                'icon' => 'untitledui-shopping-bag-03'
            ],
            [
                'title' => __('Données personnelles'),
                'description' => __("Changement d'adresse e-mail, de nom et de numéro de téléphone"),
                'href' => route('account.show'),
                'icon' => 'untitledui-shield-tick'
            ],
            [
                'title' => __('Mes adresses'),
                'description' => __('Préférences de facturation et de livraison pour les commandes'),
                'href' => route('account.addresses'),
                'icon' => 'untitledui-globe-05'
            ],
            [
                'title' => __('Contactez-nous'),
                'description' => __('Contacter notre service clientèle par téléphone ou e-mail'),
                'href' => route('account.show'),
                'icon' => 'untitledui-phone'
            ],
        ];
    }
}; ?>

<div class="space-y-10">
    <x-page-heading
        :title="__('Aperçu')"
        :description="__('Dans votre espace client, vous pouvez gérer vos commandes et vos retours, ainsi que vos informations personnelles.')"
    />

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:max-w-5xl lg:grid-cols-3">
        @foreach($this->links as $link)
            <x-account-card-link
                :href="$link['href']"
                :title="$link['title']"
                :description="$link['description']"
                :icon="$link['icon']"
            />
        @endforeach
    </div>
</div>
