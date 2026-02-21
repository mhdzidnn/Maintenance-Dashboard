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
        Schema::create('proxmox_nodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->index(); // ags, pusat, etc.
            $table->string('ip_address')->nullable();
            $table->string('status')->default('online');
            $table->float('cpu_usage')->default(0); // Persistent stats
            $table->float('memory_usage')->default(0);
            $table->float('disk_usage')->default(0);
            $table->string('uptime')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxmox_nodes');
    }
};
