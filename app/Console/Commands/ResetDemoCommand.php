<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ResetDemoCommand extends Command
{
    protected $signature = 'app:reset-demo';

    protected $description = 'Reset the demo database and clean uploaded media files';

    public function handle(): int
    {
        $this->info('Starting demo reset...');

        Artisan::call('down', ['--secret' => 'shopper-reset']);
        $this->info('Application is now in maintenance mode.');

        $this->cleanUploadedMedia();

        Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        $this->info('Database has been reset and seeded.');

        Artisan::call('shopper:link', ['--force' => true]);
        $this->info('Shopper links recreated.');

        Artisan::call('cache:clear');
        $this->info('Cache cleared.');

        Artisan::call('up');
        $this->info('Application is back online.');

        $this->info('Demo reset completed successfully.');

        return self::SUCCESS;
    }

    private function cleanUploadedMedia(): void
    {
        $disk = config('media-library.disk_name', 'public');
        $directories = Storage::disk($disk)->directories();

        foreach ($directories as $directory) {
            Storage::disk($disk)->deleteDirectory($directory);
        }

        $this->info('Uploaded media files cleaned.');
    }
}
