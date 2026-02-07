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
        Schema::create('dbc_dbc_production', function (Blueprint $table) {
            $table->bigInteger('receiving_detail_id', true);
            $table->integer('in_stock')->nullable()->default(0);
            $table->bigInteger('receiving_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->string('po_no', 20)->nullable();
            $table->string('si_no', 20)->nullable();
            $table->string('transaction_type', 20)->nullable();
            $table->string('created_time', 20)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->string('item_code', 20)->nullable()->default('0');
            $table->double('batch_received')->nullable();
            $table->double('quantity_received')->nullable();
            $table->double('actual_received')->nullable()->default(0);
            $table->double('charge')->nullable()->default(0);
            $table->double('over_yield')->nullable();
            $table->string('uom', 20)->nullable();
            $table->string('received_by', 100)->nullable();
            $table->date('received_date')->nullable();
            $table->date('report_date')->nullable();
            $table->string('shift', 20)->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('control_no', 20)->nullable();
            $table->timestamp('date_created')->useCurrentOnUpdate()->nullable();
            $table->double('unit_price')->nullable()->default(0);
            $table->string('posted_by', 100)->nullable();
            $table->string('confirmed_by', 100)->nullable();
            $table->double('total_cost')->nullable()->default(0);
            $table->string('status', 100)->nullable()->default('No');

            $table->index(['receiving_id', 'item_code', 'report_date'], 'idx_dbc_production');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_dbc_production');
    }
};
