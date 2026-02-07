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
        Schema::create('wms_report_cache', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('user', 100)->nullable();
            $table->string('branch', 100)->nullable();
            $table->longText('report_date')->nullable();
            $table->double('beginning')->nullable()->default(0);
            $table->double('stock_in')->nullable()->default(0);
            $table->double('transfer_out')->nullable()->default(0);
            $table->double('ending')->nullable()->default(0);
            $table->double('beginning_amount')->nullable()->default(0);
            $table->double('stock_in_amount')->nullable()->default(0);
            $table->double('transfer_amount')->nullable()->default(0);
            $table->double('ending_amount')->nullable()->default(0);
            $table->date('date_created')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_report_cache');
    }
};
