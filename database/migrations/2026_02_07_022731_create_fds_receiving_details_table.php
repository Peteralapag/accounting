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
        Schema::create('fds_receiving_details', function (Blueprint $table) {
            $table->bigInteger('receiving_detail_id', true);
            $table->integer('in_stock')->nullable()->default(0);
            $table->bigInteger('receiving_id')->nullable()->index('receiving_id');
            $table->bigInteger('supplier_id')->nullable();
            $table->string('po_no', 20)->nullable();
            $table->string('si_no', 20)->nullable();
            $table->string('transaction_type', 20)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->string('item_code', 20)->nullable()->default('0');
            $table->double('quantity_received')->nullable();
            $table->string('uom', 20)->nullable();
            $table->string('received_by', 100)->nullable();
            $table->date('received_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('control_no', 20)->nullable();
            $table->timestamp('date_created')->useCurrentOnUpdate()->nullable();
            $table->double('unit_price')->nullable()->default(0);
            $table->double('total_cost')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fds_receiving_details');
    }
};
