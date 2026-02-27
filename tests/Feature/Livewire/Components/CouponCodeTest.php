<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Livewire\Volt\Volt;
use Shopper\Cart\CartManager;
use Shopper\Cart\CartSessionManager;
use Shopper\Core\Enum\DiscountApplyTo;
use Shopper\Core\Enum\DiscountEligibility;
use Shopper\Core\Enum\DiscountRequirement;
use Shopper\Core\Enum\DiscountType;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Discount;

beforeEach(function (): void {
    $this->currency = Currency::query()->firstOrCreate(
        ['code' => 'USD'],
        ['name' => 'US Dollar', 'symbol' => '$', 'format' => '$1,234.56', 'exchange_rate' => 1],
    );

    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    $this->product = Product::factory()->standard()->create();
    $this->product->prices()->create([
        'currency_id' => $this->currency->id,
        'amount' => 5000,
    ]);

    $session = app(CartSessionManager::class);
    $this->cart = $session->create([
        'currency_code' => 'USD',
        'customer_id' => $this->user->id,
    ]);

    $this->cart->lines()->create([
        'purchasable_type' => $this->product->getMorphClass(),
        'purchasable_id' => $this->product->id,
        'quantity' => 2,
        'unit_price_amount' => 5000,
    ]);
});

describe('Coupon Code Component', function (): void {
    it('renders the coupon input form', function (): void {
        Volt::test('components.coupon-code')
            ->assertSee(__('Discount code'))
            ->assertSee(__('Apply'));
    });

    it('can apply a valid coupon code', function (): void {
        Discount::factory()->create([
            'code' => 'SAVE10',
            'is_active' => true,
            'type' => DiscountType::Percentage(),
            'value' => 10,
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'start_at' => now()->subDay(),
            'end_at' => now()->addMonth(),
        ]);

        Volt::test('components.coupon-code')
            ->set('code', 'SAVE10')
            ->call('applyCoupon')
            ->assertSet('appliedCode', 'SAVE10')
            ->assertHasNoErrors('code')
            ->assertDispatched('cart-price-update')
            ->assertSee('SAVE10');

        expect($this->cart->refresh()->coupon_code)->toBe('SAVE10');
    });

    it('shows error for invalid coupon code', function (): void {
        Volt::test('components.coupon-code')
            ->set('code', 'INVALID')
            ->call('applyCoupon')
            ->assertSet('appliedCode', null)
            ->assertHasErrors('code')
            ->assertNotDispatched('cart-price-update');

        expect($this->cart->refresh()->coupon_code)->toBeNull();
    });

    it('shows error for inactive coupon', function (): void {
        Discount::factory()->create([
            'code' => 'INACTIVE',
            'is_active' => false,
            'type' => DiscountType::Percentage(),
            'value' => 10,
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'start_at' => now()->subDay(),
            'end_at' => now()->addMonth(),
        ]);

        Volt::test('components.coupon-code')
            ->set('code', 'INACTIVE')
            ->call('applyCoupon')
            ->assertSet('appliedCode', null)
            ->assertHasErrors('code');

        expect($this->cart->refresh()->coupon_code)->toBeNull();
    });

    it('shows error for expired coupon', function (): void {
        Discount::factory()->create([
            'code' => 'EXPIRED',
            'is_active' => true,
            'type' => DiscountType::Percentage(),
            'value' => 10,
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'start_at' => now()->subMonths(2),
            'end_at' => now()->subDay(),
        ]);

        Volt::test('components.coupon-code')
            ->set('code', 'EXPIRED')
            ->call('applyCoupon')
            ->assertSet('appliedCode', null)
            ->assertHasErrors('code');

        expect($this->cart->refresh()->coupon_code)->toBeNull();
    });

    it('shows error when usage limit is reached', function (): void {
        Discount::factory()->create([
            'code' => 'LIMITED',
            'is_active' => true,
            'type' => DiscountType::Percentage(),
            'value' => 10,
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'usage_limit' => 5,
            'total_use' => 5,
            'start_at' => now()->subDay(),
            'end_at' => now()->addMonth(),
        ]);

        Volt::test('components.coupon-code')
            ->set('code', 'LIMITED')
            ->call('applyCoupon')
            ->assertSet('appliedCode', null)
            ->assertHasErrors('code');

        expect($this->cart->refresh()->coupon_code)->toBeNull();
    });

    it('can remove an applied coupon', function (): void {
        Discount::factory()->create([
            'code' => 'REMOVE_ME',
            'is_active' => true,
            'type' => DiscountType::Percentage(),
            'value' => 10,
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'start_at' => now()->subDay(),
            'end_at' => now()->addMonth(),
        ]);

        Volt::test('components.coupon-code')
            ->set('code', 'REMOVE_ME')
            ->call('applyCoupon')
            ->assertSet('appliedCode', 'REMOVE_ME')
            ->call('removeCoupon')
            ->assertSet('appliedCode', null)
            ->assertDispatched('cart-price-update')
            ->assertSee(__('Discount code'));

        expect($this->cart->refresh()->coupon_code)->toBeNull();
    });

    it('does nothing when submitting empty code', function (): void {
        Volt::test('components.coupon-code')
            ->set('code', '')
            ->call('applyCoupon')
            ->assertSet('appliedCode', null)
            ->assertHasNoErrors('code')
            ->assertNotDispatched('cart-price-update');
    });

    it('shows applied state on mount when cart has coupon', function (): void {
        Discount::factory()->create([
            'code' => 'PREMOUNTED',
            'is_active' => true,
            'type' => DiscountType::Percentage(),
            'value' => 15,
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'start_at' => now()->subDay(),
            'end_at' => now()->addMonth(),
        ]);

        app(CartManager::class)->applyCoupon($this->cart, 'PREMOUNTED');

        Volt::test('components.coupon-code')
            ->assertSet('appliedCode', 'PREMOUNTED')
            ->assertSee('PREMOUNTED');
    });
});

describe('Discount Total Component', function (): void {
    it('hides when no coupon is applied', function (): void {
        Volt::test('components.discount-total')
            ->assertDontSee(__('Discount'));
    });

    it('shows discount amount when coupon is applied', function (): void {
        Discount::factory()->create([
            'code' => 'SHOW_TOTAL',
            'is_active' => true,
            'type' => DiscountType::FixedAmount(),
            'value' => 10,
            'apply_to' => DiscountApplyTo::Order(),
            'min_required' => DiscountRequirement::None(),
            'eligibility' => DiscountEligibility::Everyone(),
            'start_at' => now()->subDay(),
            'end_at' => now()->addMonth(),
        ]);

        app(CartManager::class)->applyCoupon($this->cart, 'SHOW_TOTAL');

        Volt::test('components.discount-total')
            ->assertSee(__('Discount'));
    });
});
