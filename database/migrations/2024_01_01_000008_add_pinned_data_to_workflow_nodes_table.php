<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('workflow-automation.tables.nodes', 'workflow_nodes'), function (Blueprint $table): void {
            $table->json('pinned_data')->nullable()->after('config');
        });
    }

    public function down(): void
    {
        Schema::table(config('workflow-automation.tables.nodes', 'workflow_nodes'), function (Blueprint $table): void {
            $table->dropColumn('pinned_data');
        });
    }
};
