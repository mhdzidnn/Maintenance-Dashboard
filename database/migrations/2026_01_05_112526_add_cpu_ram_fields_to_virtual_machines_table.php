<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('virtual_machines', function (Blueprint $table) {
            $table->integer('cpu_cores')->default(2)->after('usage_gb');
            $table->decimal('cpu_usage_percent', 5, 2)->default(0)->after('cpu_cores');
            $table->integer('memory_total_mb')->default(4096)->after('cpu_usage_percent');
            $table->integer('memory_used_mb')->default(0)->after('memory_total_mb');
            $table->decimal('memory_usage_percent', 5, 2)->default(0)->after('memory_used_mb');
            $table->bigInteger('uptime_seconds')->nullable()->after('memory_usage_percent');
            $table->string('status')->default('stopped')->after('is_running');
            $table->string('os_type')->default('windows')->after('status');
            $table->timestamp('last_synced_at')->nullable()->after('os_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('virtual_machines', function (Blueprint $table) {
            $table->dropColumn([
                'cpu_cores',
                'cpu_usage_percent',
                'memory_total_mb',
                'memory_used_mb',
                'memory_usage_percent',
                'uptime_seconds',
                'status',
                'os_type',
                'last_synced_at'
            ]);
        });
    }
};
