<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Database\Seeders\Concerns\WithProgressBar;
use Illuminate\Database\Seeder;
use Shopper\Core\Enum\OrderStatus;
use Shopper\Core\Models\Order;
use Shopper\Core\Models\OrderAddress;
use Shopper\Core\Models\OrderItem;
use Shopper\Core\Models\PaymentMethod;
use Shopper\Core\Models\Zone;

class OrderSeeder extends Seeder
{
    use WithProgressBar;

    public function run(): void
    {
        $customers = User::query()
            ->scopes('customers')
            ->get();

        if ($customers->isEmpty()) {
            $this->command->warn('No customers found. Please run CustomerSeeder first.');

            return;
        }

        $products = Product::query()->whereHas('prices')->with('prices')->get();
        $variants = ProductVariant::query()
            ->withWhereHas('prices')
            ->with('product')
            ->get();

        if ($products->isEmpty() && $variants->isEmpty()) {
            $this->command->warn('No products or variants with prices found.');

            return;
        }

        $zoneCountryNames = Zone::query()
            ->where('is_enabled', true)
            ->with('countries')
            ->get()
            ->flatMap(fn (Zone $zone) => $zone->countries->pluck('name'))
            ->unique()
            ->values();

        $channel = Channel::query()->first();
        $paymentMethod = PaymentMethod::query()->first();
        $currencyCode = shopper_currency();

        $this->command->warn(PHP_EOL.'Creating orders...');

        $this->withProgressBar(50, function () use ($customers, $products, $variants, $channel, $paymentMethod, $currencyCode, $zoneCountryNames) {
            /** @var User $customer */
            $customer = $customers->random();
            $countryName = $zoneCountryNames->random();

            $shippingAddress = OrderAddress::query()->create([
                'customer_id' => $customer->id,
                'last_name' => $customer->last_name,
                'first_name' => $customer->first_name,
                'street_address' => fake()->streetAddress(),
                'street_address_plus' => fake()->address(),
                'postal_code' => fake()->postcode(),
                'city' => fake()->city(),
                'country_name' => $countryName,
                'phone' => fake()->optional(0.7)->phoneNumber(),
            ]);

            $useSameAddress = fake()->boolean(70);
            $billingAddress = $useSameAddress
                ? $shippingAddress
                : OrderAddress::query()->create([
                    'customer_id' => $customer->id,
                    'last_name' => $customer->last_name,
                    'first_name' => $customer->first_name,
                    'company' => fake()->optional(0.4)->company(),
                    'street_address' => fake()->streetAddress(),
                    'postal_code' => fake()->postcode(),
                    'city' => fake()->city(),
                    'country_name' => $countryName,
                    'phone' => fake()->optional(0.5)->phoneNumber(),
                ]);

            $status = fake()->randomElement(OrderStatus::cases());
            $createdAt = fake()->dateTimeBetween('-1 year');

            $order = Order::query()->create([
                'number' => generate_number(),
                'status' => $status,
                'currency_code' => $currencyCode,
                'customer_id' => $customer->id,
                'channel_id' => $channel?->id,
                'payment_method_id' => $paymentMethod?->id,
                'shipping_address_id' => $shippingAddress->id,
                'billing_address_id' => $billingAddress->id,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $itemCount = fake()->numberBetween(2, 5);
            $totalAmount = 0;

            $availableItems = collect();

            if ($variants->isNotEmpty()) {
                $availableItems = $availableItems->merge(
                    $variants->map(fn ($v): array => ['type' => 'variant', 'item' => $v])
                );
            }

            if ($products->isNotEmpty()) {
                $availableItems = $availableItems->merge(
                    $products->map(fn ($p): array => ['type' => 'product', 'item' => $p])
                );
            }

            $selectedItems = $availableItems->random(min($itemCount, $availableItems->count()));

            foreach ($selectedItems as $selected) {
                if ($selected['type'] === 'variant') {
                    /** @var ProductVariant $variant */
                    $variant = $selected['item'];
                    $price = $variant->prices->first();
                    $unitPrice = $price?->amount ?? fake()->numberBetween(5000, 150000);

                    $quantity = fake()->numberBetween(1, 3);
                    $totalAmount += $unitPrice * $quantity;

                    OrderItem::query()->create([
                        'order_id' => $order->id,
                        'name' => $variant->product->name.' - '.$variant->name,
                        'sku' => $variant->sku ?? $variant->product->sku ?? fake()->unique()->numerify('SKU-######'),
                        'product_type' => config('shopper.models.variant'),
                        'product_id' => $variant->id,
                        'quantity' => $quantity,
                        'unit_price_amount' => $unitPrice,
                    ]);
                } else {
                    /** @var Product $product */
                    $product = $selected['item'];
                    $price = $product->prices->first();
                    $unitPrice = $price?->amount ?? fake()->numberBetween(5000, 100000);

                    $quantity = fake()->numberBetween(1, 3);
                    $totalAmount += $unitPrice * $quantity;

                    OrderItem::query()->create([
                        'order_id' => $order->id,
                        'name' => $product->name,
                        'sku' => $product->sku ?? fake()->unique()->numerify('SKU-######'),
                        'product_type' => config('shopper.models.product'),
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price_amount' => $unitPrice,
                    ]);
                }
            }

            $order->update(['price_amount' => $totalAmount]);

            return collect([$order]);
        });

        $this->command->info('Orders created successfully.');
    }
}
