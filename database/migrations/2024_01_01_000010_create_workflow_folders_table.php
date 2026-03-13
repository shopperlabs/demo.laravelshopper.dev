<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('workflow-automation.tables.folders', 'workflow_folders'), function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained(
                config('workflow-automation.tables.folders', 'workflow_folders')
            )->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table(config('workflow-automation.tables.workflows', 'workflows'), function (Blueprint $table): void {
            $table->foreignId('folder_id')->nullable()->after('settings')->constrained(
                config('workflow-automation.tables.folders', 'workflow_folders')
            )->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table(config('workflow-automation.tables.workflows', 'workflows'), function (Blueprint $table): void {
            $table->dropConstrainedForeignId('folder_id');
        });

        Schema::dropIfExists(config('workflow-automation.tables.folders', 'workflow_folders'));
    }
};
