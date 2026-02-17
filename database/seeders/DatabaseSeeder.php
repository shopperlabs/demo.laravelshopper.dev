<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category as ShopCategory;
use App\Models\Collection as ShopCollection;
use App\Models\Product;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Shopper\Core\Database\Seeders\ShopperSeeder;
use Shopper\Core\Models\Address;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ShopperSeeder::class);

        // Admin
        $this->command->warn(PHP_EOL . 'Creating admin user...');
        $admin = User::factory()->create([
            'last_name' => 'Admin',
            'first_name' => 'Shopper',
            'email' => 'admin@laravelshopper.dev',
            'password' => Hash::make('demo.Shopper@2026!'),
        ]);

        $admin->assignRole(config('shopper.core.roles.admin'));
        $this->command->info('Admin user created.');

        // Shop
        $this->command->warn(PHP_EOL . 'Creating shop brands...');
        $brands = $this->withProgressBar(5, fn () => Brand::factory()->count(2)->create());
        $this->command->info('Shop brands created.');

        $this->command->warn(PHP_EOL . 'Creating shop categories...');
        $categories = $this->withProgressBar(20, fn () => ShopCategory::factory(1)
            ->has(
                ShopCategory::factory()->count(3),
                'children'
            )->create());
        $this->command->info('Shop categories created.');

        $this->command->warn(PHP_EOL . 'Creating shop customers...');
        $this->withProgressBar(10, function () {
            $customer = User::factory()
                ->has(Address::factory()->count(rand(1, 3)))
                ->create();

            $customer->assignRole(config('shopper.core.roles.user'));

            return collect([$customer]);
        });
        $this->command->info('Shop customers created.');

        $this->command->warn(PHP_EOL . 'Creating product...');

        $this->withProgressBar(10, fn () => Product::factory(1)
            ->sequence(fn ($sequence) => ['brand_id' => $brands->random(1)->first()?->id])
            ->hasAttached(ShopCollection::factory()->count(1))
            ->hasAttached($categories->random(rand(3, 6)))
            ->create()
        );

        $this->command->info('All products created.');

        $this->call(ReviewSeeder::class);

        $this->call(OrderSeeder::class);
    }

    protected function withProgressBar(int $total, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $total);

        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $total) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
