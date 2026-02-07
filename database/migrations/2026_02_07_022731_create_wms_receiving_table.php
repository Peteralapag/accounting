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
        Schema::create('wms_receiving', function (Blueprint $table) {
            $table->bigInteger('receiving_id', true);
            $table->bigInteger('supplier_id')->nullable();
            $table->string('po_no', 50)->nullable();
            $table->string('si_no', 50)->nullable();
            $table->double('total_cost')->nullable()->default(0);
            $table->string('created_by', 100)->nullable();
            $table->dateTime('date_created')->nullable();
            $table->string('delivery_status', 10)->nullable();
            $table->string('status', 10)->nullable()->default('Open');
            $table->string('receiving_status', 10)->nullable()->default('Full');
            $table->string('closed_by', 100)->nullable();
            $table->date('close_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_receiving');
    }
};
