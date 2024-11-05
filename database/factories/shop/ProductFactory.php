<?php

declare(strict_types=1);

namespace Database\Factories\shop;

use App\Models\Product;
use Database\Seeders\LocalImages;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Log;
use Shopper\Core\Enum\ProductType;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->title(),
            'slug' => Str::slug($name),
            'sku' => $this->faker->unique()->ean8(),
            'barcode' => $this->faker->ean13(),
            'description' => $this->faker->realText(),
            'security_stock' => $this->faker->randomDigitNotNull(),
            'featured' => $this->faker->boolean(),
            'is_visible' => $this->faker->boolean(),
            'old_price_amount' => $this->faker->randomFloat(min: 100, max: 500),
            'price_amount' => $this->faker->randomFloat(min: 80, max: 400),
            'cost_amount' => $this->faker->randomFloat(min: 50, max: 200),
            'type' => $this->faker->randomElement(ProductType::values()->toArray()),
            'published_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    public function configure(): ProductFactory
    {
        $file = LocalImages::getRandomFile();
        Log::info('File to be added:', ['file' => $file]);

        return $this->afterCreating(function (Product $product) {
            try {
                $product
                    ->addMedia(LocalImages::getRandomFile())
                    ->preservingOriginal()
                    ->toMediaCollection(config('shopper.core.storage.collection_name'));
            } catch (UnreachableUrl $exception) {
                return;
            }
        });
    }
}
