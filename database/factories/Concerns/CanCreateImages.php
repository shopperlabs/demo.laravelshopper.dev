<?php

declare(strict_types=1);

namespace Database\Factories\Concerns;

use Database\Seeders\LocalImages;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait CanCreateImages
{
    public function createImage(?string $size = LocalImages::SIZE_1280x720): ?string
    {
        $randomImage = LocalImages::getRandomFile($size);

        $image = file_get_contents($randomImage->getPathname());

        $filename = Str::uuid() . '.jpg';

        Storage::disk(config('shopper.core.storage.disk_name'))->put($filename, $image);

        return $filename;
    }
}
