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
        Schema::create('wms_branch_order', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('cluster', 100)->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('control_no', 20)->nullable();
            $table->string('item_code', 20)->nullable();
            $table->string('class', 20)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->double('unit_price')->nullable();
            $table->string('uom', 20)->nullable();
            $table->double('quantity')->nullable()->default(0);
            $table->double('wh_quantity')->nullable()->default(0);
            $table->double('actual_quantity')->nullable()->default(0);
            $table->double('inv_ending')->nullable()->default(0);
            $table->string('inv_ending_uom', 30)->nullable();
            $table->string('created_by', 100)->nullable()->default('');
            $table->date('trans_date')->nullable()->default('0000-00-00');
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->string('status', 20)->nullable()->default('Open');
            $table->timestamp('date_created')->useCurrentOnUpdate()->nullable();
            $table->longText('remarks')->nullable();
            $table->integer('cancelled')->nullable()->default(0);
            $table->integer('item_receipt')->nullable()->default(0);
            $table->dateTime('item_receipt_date')->nullable();
            $table->string('item_receipt_by', 100)->nullable();
            $table->date('delivery_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_branch_order');
    }
};
