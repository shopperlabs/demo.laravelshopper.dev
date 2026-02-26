<?php

declare(strict_types=1);

use App\Actions\Cart\AddToCart;
use App\Models\Channel;
use App\Models\Product;
use App\Models\User;
use Shopper\Cart\CartSessionManager;
use Shopper\Core\Enum\ProductType;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Inventory;

beforeEach(function (): void {
    Channel::factory()->create(['is_default' => true]);

    $this->product = Product::factory()->create([
        'name' => 'Test Product',
        'type' => ProductType::Standard,
    ]);

    $this->actingAs(User::factory()->create());

    $this->inventory = Inventory::factory()->create(['is_default' => true]);

    $this->currency = Currency::query()->firstOrCreate(
        ['code' => shopper_currency()],
        ['name' => 'XAF', 'symbol' => 'FCFA', 'format' => '{symbol}{amount}', 'exchange_rate' => 1],
    );
});

describe(AddToCart::class, function (): void {
    it('adds product to cart with correct price', function (): void {
        $this->product->prices()->create([
            'currency_id' => $this->currency->id,
            'amount' => 29.99,
        ]);

        $this->product->mutateStock($this->inventory->id, 10);

        $this->product->refresh();
        $this->product->load('prices.currency');

        $line = resolve(AddToCart::class)->handle($this->product);

        expect($line)
            ->quantity->toBe(1)
            ->unit_price_amount->toBe(2999);

        $cart = app(CartSessionManager::class)->current();

        expect($cart->lines)->toHaveCount(1);
    });

    it('increments quantity when adding same product twice', function (): void {
        $this->product->prices()->create([
            'currency_id' => $this->currency->id,
            'amount' => 50,
        ]);

        $this->product->mutateStock($this->inventory->id, 10);

        $this->product->refresh();
        $this->product->load('prices.currency');

        resolve(AddToCart::class)->handle($this->product);
        $line = resolve(AddToCart::class)->handle($this->product);

        expect($line)->quantity->toBe(2);

        $cart = app(CartSessionManager::class)->current();

        expect($cart->lines)->toHaveCount(1);
    });

    it('stores zero price when product has no price configured', function (): void {
        $this->product->mutateStock($this->inventory->id, 10);

        $this->product->refresh();

        $line = resolve(AddToCart::class)->handle($this->product);

        expect($line)->unit_price_amount->toBe(0);
    });
});
