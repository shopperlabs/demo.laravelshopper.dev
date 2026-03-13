<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('workflow-automation.tables.workflows', 'workflows'), function (Blueprint $table): void {
            $table->string('created_via')->nullable()->after('settings');
        });
    }

    public function down(): void
    {
        Schema::table(config('workflow-automation.tables.workflows', 'workflows'), function (Blueprint $table): void {
            $table->dropColumn('created_via');
        });
    }
};
