<?php

declare(strict_types=1);

use function Livewire\Volt\{layout, title};

layout('components.layouts.templates.account');
title(__('Profile'));

?>

<div class="space-y-10">
    <x-page-heading :title="__('Profile')" />

    <div class="space-y-6 divide-y divide-gray-200">
        <livewire:profile.update-profile-information-form />
        <livewire:profile.update-password-form />
        <livewire:profile.delete-user-form />
    </div>
</div>
