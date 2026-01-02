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
        Schema::create('nextcloud_users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->decimal('quota_used_gb', 10, 2);
            $table->decimal('quota_total_gb', 10, 2);
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nextcloud_users');
    }
};
