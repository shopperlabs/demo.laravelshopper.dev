<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('workflow-automation.tables.tags', 'workflow_tags'), function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('color', 7)->nullable();
            $table->timestamps();

            $table->unique('name');
        });

        Schema::create(config('workflow-automation.tables.tag_pivot', 'workflow_tag_pivot'), function (Blueprint $table): void {
            $table->id();
            $table->foreignId('workflow_id')->constrained(
                config('workflow-automation.tables.workflows', 'workflows')
            )->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained(
                config('workflow-automation.tables.tags', 'workflow_tags')
            )->cascadeOnDelete();

            $table->unique(['workflow_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('workflow-automation.tables.tag_pivot', 'workflow_tag_pivot'));
        Schema::dropIfExists(config('workflow-automation.tables.tags', 'workflow_tags'));
    }
};
