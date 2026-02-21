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
        Schema::create('proxmox_vms', function (Blueprint $table) {
            $table->id();
            $table->integer('vm_id'); // Proxmox VM ID
            $table->foreignId('proxmox_node_id')->constrained('proxmox_nodes')->onDelete('cascade');
            $table->string('name');
            $table->string('type')->default('qemu'); // qemu, lxc
            $table->string('status')->default('stopped');
            $table->string('os_type')->default('unknown');
            $table->integer('cpu_cores')->default(1);
            $table->float('memory_total_gb')->default(1);
            $table->float('disk_total_gb')->default(10);
            $table->string('ip_address')->nullable();
            
            // Real-time stats (updated via scheduled task or whenever fetched)
            $table->float('cpu_usage_percent')->default(0);
            $table->float('memory_usage_percent')->default(0);
            $table->float('disk_usage_gb')->default(0);
            $table->string('formatted_uptime')->nullable();
            
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxmox_vms');
    }
};
