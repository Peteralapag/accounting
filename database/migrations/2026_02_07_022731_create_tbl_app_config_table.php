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
        Schema::create('tbl_app_config', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('idle_timer')->nullable();
            $table->integer('idle_active')->nullable()->default(1);
            $table->boolean('maintenance')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_app_config');
    }
};
