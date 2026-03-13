<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $runsTable = config('workflow-automation.tables.runs', 'workflow_runs');
        $nodesTable = config('workflow-automation.tables.nodes', 'workflow_nodes');

        Schema::create(config('workflow-automation.tables.node_runs', 'workflow_node_runs'), function (Blueprint $table) use ($runsTable, $nodesTable): void {
            $table->id();
            $table->foreignId('workflow_run_id')->constrained($runsTable)->cascadeOnDelete();
            $table->foreignId('node_id')->constrained($nodesTable);
            $table->string('status', 20)->default('pending');
            $table->json('input')->nullable();
            $table->json('output')->nullable();
            $table->text('error_message')->nullable();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->unsignedInteger('attempts')->default(0);
            $table->timestamp('executed_at')->nullable();
            $table->timestamps();

            $table->index(['workflow_run_id', 'node_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('workflow-automation.tables.node_runs', 'workflow_node_runs'));
    }
};
