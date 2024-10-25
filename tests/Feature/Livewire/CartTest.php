<?php

declare(strict_types=1);

use App\Livewire\VariantsSelector;
use App\Models\Product;
use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->product = Product::factory()->create();
    $this->actingAs($this->user);
});

describe(VariantsSelector::class, function (): void {})
    ->group('cart');
