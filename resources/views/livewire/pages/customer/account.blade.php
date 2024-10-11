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
                'title' => __('My orders'),
                'description' => __('STrack your orders, return them or buy them again'),
                'href' => '#',
                'icon' => 'untitledui-shopping-bag-03'
            ],
            [
                'title' => __('Personal information'),
                'description' => __("Change of e-mail address, name and telephone number"),
                'href' => route('dashboard'),
                'icon' => 'untitledui-shield-tick'
            ],
            [
                'title' => __('My address'),
                'description' => __('Billing and delivery preferences for orders'),
                'href' => route('dashboard.addresses'),
                'icon' => 'untitledui-globe-05'
            ],
            [
                'title' => __('Contact us'),
                'description' => __('Contact our customer service department by telephone or e-mail'),
                'href' => route('dashboard'),
                'icon' => 'untitledui-phone'
            ],
        ];
    }
}; ?>

<div class="space-y-10">
    <x-page-heading
        :title="__('Overview')"
        :description="__('In your customer area, you can manage your orders and returns, as well as your personal information.')"
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
