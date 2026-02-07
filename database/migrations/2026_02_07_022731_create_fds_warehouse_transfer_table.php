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
        Schema::create('fds_warehouse_transfer', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('transaction_type', 100)->nullable();
            $table->string('item_code', 20)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('itemcode', 20)->nullable();
            $table->string('item_description', 123)->nullable();
            $table->double('on_hand_before')->nullable();
            $table->double('takeout_amount')->nullable();
            $table->string('takeout_uom', 30)->nullable();
            $table->double('amount_per_uom')->nullable();
            $table->string('amount_uom', 30)->nullable();
            $table->double('on_hand_after')->nullable()->default(0);
            $table->string('on_hand_uom', 30)->nullable();
            $table->double('transfer_amount')->nullable();
            $table->string('transfer_uom', 30)->nullable();
            $table->date('transaction_date')->nullable();
            $table->double('convert_amount')->nullable();
            $table->string('convert_uom', 30)->nullable();
            $table->string('created_by', 123)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->string('status', 30)->nullable()->default('Open');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fds_warehouse_transfer');
    }
};
