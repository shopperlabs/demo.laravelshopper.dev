<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Shopper\Core\Models\Attribute;
use Shopper\Core\Models\AttributeValue;
use Shopper\Core\Models\Channel;
use Shopper\Core\Models\Currency;
use Shopper\Core\Models\Inventory;
use Shopper\Core\Models\ProductTag;
use Shopper\Core\Models\ProductVariant;

class ProductSeeder extends AbstractSeeder
{
    public function run(): void
    {
        $products = $this->getSeedData('products');
        $variantsData = collect($this->getSeedData('variants'))
            ->keyBy('product_slug');
        $thumbnailCollection = config('shopper.media.storage.thumbnail_collection', 'thumbnail');
        $uploadsCollection = config('shopper.media.storage.collection_name', 'uploads');
        $defaultInventory = Inventory::query()->where('is_default', true)->first();
        $defaultChannel = Channel::query()->first();

        $adminId = User::query()->role(config('shopper.core.roles.admin'))->value('id');

        $this->command->warn(PHP_EOL . 'Creating products...');

        DB::transaction(function () use ($products, $variantsData, $thumbnailCollection, $uploadsCollection, $defaultInventory, $defaultChannel, $adminId): void {
            foreach ($products as $product) {
                $productModel = $this->createProduct($product);

                $this->attachRelations($productModel, $product, $defaultChannel);
                $this->addMedia($productModel, $product, $thumbnailCollection, $uploadsCollection);
                $this->createPrices($productModel, $product->prices ?? []);

                if (isset($product->stock) && $product->stock && $defaultInventory) {
                    $productModel->mutateStock($defaultInventory->id, $product->stock, [
                        'event' => 'Initial inventory',
                        'old_quantity' => $product->stock,
                        'user_id' => $adminId,
                    ]);
                }

                if (! empty($product->tags)) {
                    $this->attachTags($productModel, $product->tags);
                }

                if (isset($product->attributes)) {
                    $this->attachProductAttributes($productModel, $product->attributes);
                }

                $variantEntry = $variantsData->get($product->slug);

                if ($variantEntry) {
                    $this->createVariants(
                        $productModel,
                        $variantEntry->variants,
                        $thumbnailCollection,
                        $uploadsCollection,
                        $defaultInventory,
                        $adminId,
                    );
                }
            }
        });

        $this->command->info('Products created successfully.');
    }

    private function createProduct(object $product): Product
    {
        return Product::query()->create([
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'description' => $product->description,
            'summary' => $product->summary ?? null,
            'security_stock' => $product->security_stock ?? 0,
            'featured' => $product->featured ?? false,
            'is_visible' => $product->is_visible ?? true,
            'type' => $product->type,
            'published_at' => now(),
            'seo_title' => $product->seo_title ?? null,
            'seo_description' => $product->seo_description ?? null,
            'weight_value' => $product->weight_value ?? 0,
            'height_value' => $product->height_value ?? 0,
            'width_value' => $product->width_value ?? 0,
            'depth_value' => $product->depth_value ?? 0,
            'brand_id' => Brand::query()->where('slug', $product->brand_slug)->value('id'),
        ]);
    }

    private function attachRelations(Product $productModel, object $product, ?Channel $defaultChannel): void
    {
        if (! empty($product->categories)) {
            $categoryIds = Category::query()
                ->whereIn('slug', $product->categories)
                ->pluck('id');
            $productModel->categories()->attach($categoryIds);
        }

        if (! empty($product->collections)) {
            $collectionIds = Collection::query()
                ->whereIn('slug', $product->collections)
                ->pluck('id');
            $productModel->collections()->attach($collectionIds);
        }

        if ($defaultChannel) {
            $productModel->channels()->attach($defaultChannel->id);
        }
    }

    private function addMedia(Product|ProductVariant $model, object $data, string $thumbnailCollection, string $uploadsCollection): void
    {
        if (! empty($data->thumbnail)) {
            $model->addMedia($this->imagePath('products', $data->thumbnail))
                ->preservingOriginal()
                ->toMediaCollection($thumbnailCollection);
        }

        foreach ($data->images ?? [] as $image) {
            $model->addMedia($this->imagePath('products', $image))
                ->preservingOriginal()
                ->toMediaCollection($uploadsCollection);
        }
    }

    /**
     * @param  array<int, object>  $prices
     */
    private function createPrices(Product|ProductVariant $model, array $prices): void
    {
        foreach ($prices as $price) {
            $currencyId = Currency::query()->where('code', $price->currency_code)->value('id');

            if ($currencyId) {
                $model->prices()->create([
                    'amount' => $price->amount,
                    'compare_amount' => $price->compare_amount ?? null,
                    'cost_amount' => $price->cost_amount ?? null,
                    'currency_id' => $currencyId,
                ]);
            }
        }
    }

    /**
     * @param  array<int, string>  $tags
     */
    private function attachTags(Product $productModel, array $tags): void
    {
        $tagIds = [];

        foreach ($tags as $tagSlug) {
            $tag = ProductTag::query()->firstOrCreate(
                ['slug' => $tagSlug],
                ['name' => str($tagSlug)->replace('-', ' ')->title()->toString()],
            );

            $tagIds[] = $tag->id;
        }

        $productModel->tags()->attach($tagIds);
    }

    /**
     * @param  Product  $productModel
     * @param  object  $attributes
     */
    private function attachProductAttributes(Product $productModel, object $attributes): void
    {
        foreach ($attributes as $attributeSlug => $valueKeys) {
            $attribute = Attribute::query()->where('slug', $attributeSlug)->first();

            if (! $attribute) {
                continue;
            }

            foreach ($valueKeys as $valueKey) {
                $valueId = AttributeValue::query()
                    ->where('attribute_id', $attribute->id)
                    ->where('key', $valueKey)
                    ->value('id');

                DB::table(shopper_table('attribute_product'))->insert([
                    'product_id' => $productModel->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => $valueId,
                    'attribute_custom_value' => null,
                ]);
            }
        }
    }

    /**
     * @param  array<int, object>  $variants
     */
    private function createVariants(
        Product $productModel,
        array $variants,
        string $thumbnailCollection,
        string $uploadsCollection,
        ?Inventory $defaultInventory,
        ?int $adminId,
    ): void {
        foreach ($variants as $variant) {
            $variantModel = $productModel->variants()->create([
                'name' => $variant->name,
                'sku' => $variant->sku,
                'barcode' => $variant->barcode ?? null,
                'ean' => $variant->ean ?? null,
                'upc' => $variant->upc ?? null,
                'allow_backorder' => $variant->allow_backorder ?? false,
                'position' => $variant->position ?? 1,
            ]);

            if (isset($variant->attributes)) {
                $this->attachVariantAttributes($variantModel, $variant->attributes);
            }

            $this->createPrices($variantModel, $variant->prices ?? []);

            if (isset($variant->stock) && $variant->stock && $defaultInventory) {
                $variantModel->mutateStock($defaultInventory->id, $variant->stock, [
                    'event' => 'Initial inventory',
                    'old_quantity' => $variant->stock,
                    'user_id' => $adminId,
                ]);
            }

            if (! empty($variant->thumbnail) || ! empty($variant->images)) {
                $this->addMedia($variantModel, $variant, $thumbnailCollection, $uploadsCollection);
            }
        }
    }

    private function attachVariantAttributes(ProductVariant $variantModel, object $attributes): void
    {
        foreach ($attributes as $attributeSlug => $valueKey) {
            $valueId = AttributeValue::query()
                ->whereHas('attribute', fn ($q) => $q->where('slug', $attributeSlug))
                ->where('key', $valueKey)
                ->value('id');

            if ($valueId) {
                $variantModel->values()->attach($valueId);
            }
        }
    }
}
