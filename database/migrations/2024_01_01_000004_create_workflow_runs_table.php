<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $workflowsTable = config('workflow-automation.tables.workflows', 'workflows');
        $nodesTable = config('workflow-automation.tables.nodes', 'workflow_nodes');

        Schema::create(config('workflow-automation.tables.runs', 'workflow_runs'), function (Blueprint $table) use ($workflowsTable, $nodesTable): void {
            $table->id();
            $table->foreignId('workflow_id')->constrained($workflowsTable);
            $table->string('status', 20)->default('pending');
            $table->foreignId('trigger_node_id')->nullable()->constrained($nodesTable)->nullOnDelete();
            $table->json('initial_payload')->nullable();
            $table->json('context')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index(['workflow_id', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('workflow-automation.tables.runs', 'workflow_runs'));
    }
};
