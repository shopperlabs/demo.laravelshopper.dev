<?php

declare(strict_types=1);

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex items-center space-x-6">
    <x-link :href="route('dashboard')"
        class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-700">
        <x-untitledui-user-circle class="size-5" stroke-width="1.5" aria-hidden="true" />
        {{ __('My account') }}
    </x-link>
    <button wire:click="logout" type="submit"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
        <x-untitledui-log-out class="size-5" stroke-width="1.5" aria-hidden="true" />
        {{ __('Logout') }}
    </button>
</div>
