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
        Schema::create('pcs_activity_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('date_time')->nullable();
            $table->longText('activity')->nullable();
            $table->string('log_by', 123)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs_activity_logs');
    }
};
