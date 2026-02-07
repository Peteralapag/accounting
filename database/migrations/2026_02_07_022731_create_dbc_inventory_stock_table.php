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
        Schema::create('dbc_inventory_stock', function (Blueprint $table) {
            $table->bigInteger('inventory_id', true);
            $table->bigInteger('supplier_id')->nullable();
            $table->string('item_code', 50)->nullable()->index('idx_dbc_inventory_stock');
            $table->string('category', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->double('stock_before_pcount')->default(0);
            $table->date('stock_before_pcount_date')->nullable();
            $table->double('stock_in_hand')->nullable()->default(0);
            $table->string('uom', 30)->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->string('updated_by', 100)->nullable();

            $table->primary(['inventory_id', 'stock_before_pcount']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_inventory_stock');
    }
};
