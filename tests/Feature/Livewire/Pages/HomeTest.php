<?php

declare(strict_types=1);

use App\Livewire\Pages\Home;
use Livewire\Livewire;

use function Pest\Laravel\get;

describe(Home::class, function (): void {
    it('can render home page', function (): void {
        get(route('home'))->assertOk();

        Livewire::test(Home::class)
            ->assertSuccessful();
    });
});
