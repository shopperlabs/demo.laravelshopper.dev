<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
final class CountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->country(),
            'name_official' => $this->faker->country(),
            'region' => $this->faker->word(),
            'cca2' => $this->faker->countryCode(),
            'cca3' => $this->faker->countryCode(),
            'flag' => '🇨🇲',
            'phone_calling_code' => ['root' => '+2', 'suffixes' => ['44']],
            'currencies' => ['EUR' => ['name' => 'Euro', 'symbol' => '€']],
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
