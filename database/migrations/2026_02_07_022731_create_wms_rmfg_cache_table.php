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
        Schema::create('wms_rmfg_cache', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('branch', 100)->nullable()->default('0');
            $table->string('report_date', 20)->nullable();
            $table->double('beginning')->nullable()->default(0);
            $table->double('stock_in')->nullable()->default(0);
            $table->double('transfer_in')->nullable()->default(0);
            $table->double('transfer_out')->nullable()->default(0);
            $table->double('ending')->nullable()->default(0);
            $table->double('begining_amount')->nullable()->default(0);
            $table->double('in_amount')->nullable()->default(0);
            $table->double('out_amount')->nullable()->default(0);
            $table->double('ending_amount')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_rmfg_cache');
    }
};
