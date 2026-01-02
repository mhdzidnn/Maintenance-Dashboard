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
        Schema::create('nextcloud_stats', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['online', 'offline']);
            $table->integer('total_users');
            $table->decimal('storage_used_tb', 10, 2);
            $table->decimal('storage_total_tb', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nextcloud_stats');
    }
};
