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
        Schema::create('fds_branch_inventory_stock', function (Blueprint $table) {
            $table->bigInteger('inventory_id', true);
            $table->bigInteger('supplier_id')->nullable();
            $table->string('item_code', 50)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->double('stock_in_hand')->nullable()->default(0);
            $table->string('uom', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fds_branch_inventory_stock');
    }
};
