<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('workflow-automation.tables.credentials', 'workflow_credentials'), function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->text('data');
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('workflow-automation.tables.credentials', 'workflow_credentials'));
    }
};
