<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Shopper\Core\Enum\AddressType;

/**
 * @extends Factory<Address>
 */
final class AddressFactory extends \Shopper\Core\Database\Factories\AddressFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'company_name' => $this->faker->company(),
            'street_address' => $this->faker->streetAddress(),
            'street_address_plus' => $this->faker->streetSuffix(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'type' => $this->faker->randomElement(AddressType::names()),
            'shipping_default' => $this->faker->boolean,
            'billing_default' => $this->faker->boolean,
        ];
    }
}
