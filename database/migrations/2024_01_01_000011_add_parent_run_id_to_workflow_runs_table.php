<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('workflow-automation.tables.runs', 'workflow_runs'), function (Blueprint $table): void {
            $table->unsignedBigInteger('parent_run_id')->nullable()->after('trigger_node_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table(config('workflow-automation.tables.runs', 'workflow_runs'), function (Blueprint $table): void {
            $table->dropColumn('parent_run_id');
        });
    }
};
