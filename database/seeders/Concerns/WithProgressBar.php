<?php

declare(strict_types=1);

namespace Database\Seeders\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

trait WithProgressBar
{
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
