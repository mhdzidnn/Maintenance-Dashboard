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
        Schema::create('storage_health', function (Blueprint $table) {
            $table->id();
            $table->foreignId('node_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('usage_percentage', 5, 2);
            $table->decimal('local_percentage', 5, 2);
            $table->string('raid_status');
            $table->string('trend');
            $table->enum('alert_level', ['normal', 'warning', 'critical']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_health');
    }
};
