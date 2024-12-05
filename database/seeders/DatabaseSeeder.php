<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category as ShopCategory;
use App\Models\Collection as ShopCollection;
use App\Models\Product;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn(PHP_EOL . 'Creating product...');

        $this->withProgressBar(20, fn () => Product::factory()
            ->count(1)
            ->hasAttached(ShopCollection::factory()->count(1))
            ->hasAttached(ShopCategory::factory()->count(1))
            ->create()
        );

        $this->command->info('All products created.');

        $this->call(ReviewSeeder::class);
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
