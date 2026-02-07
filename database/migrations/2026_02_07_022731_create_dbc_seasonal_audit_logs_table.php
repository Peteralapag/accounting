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
        Schema::create('dbc_seasonal_audit_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->dateTime('log_date')->nullable();
            $table->longText('activity')->nullable();
            $table->string('log_by', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_seasonal_audit_logs');
    }
};
