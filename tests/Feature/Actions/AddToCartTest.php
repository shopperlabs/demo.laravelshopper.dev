<?php

declare(strict_types=1);

use App\Actions\Cart\AddToCart;
use App\Models\Product;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade;
use Shopper\Core\Enum\ProductType;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Inventory;

beforeEach(function (): void {
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
    it('throws when product has no price', function (): void {
        $this->product->mutateStock($this->inventory->id, 10, [
            'event' => 'Initial inventory',
            'old_quantity' => 0,
        ]);
        $this->product->refresh();

        resolve(AddToCart::class)->handle($this->product);
    })->throws(InvalidArgumentException::class, 'This product has no price configured.');

    it('throws when product is out of stock', function (): void {
        $this->product->prices()->create([
            'currency_id' => $this->currency->id,
            'amount' => 2999,
        ]);
        $this->product->load('prices.currency');

        resolve(AddToCart::class)->handle($this->product);
    })->throws(InvalidArgumentException::class, 'This product is out of stock.');

    it('adds product to cart successfully', function (): void {
        $this->product->prices()->create([
            'currency_id' => $this->currency->id,
            'amount' => 2999,
        ]);

        $this->product->mutateStock($this->inventory->id, 10, [
            'event' => 'Initial inventory',
            'old_quantity' => 0,
        ]);
        $this->product->refresh();
        $this->product->load('prices.currency');

        resolve(AddToCart::class)->handle($this->product);

        // @phpstan-ignore-next-line
        $cartContent = CartFacade::session(session()->getId())->getContent();

        expect($cartContent)->toHaveCount(1);
    });
});
