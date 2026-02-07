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
        Schema::create('dbc_seasonal_branch_order_remarks', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('branch', 100)->nullable();
            $table->string('control_no', 20)->nullable();
            $table->longText('remarks')->nullable();
            $table->longText('preparator_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_seasonal_branch_order_remarks');
    }
};
