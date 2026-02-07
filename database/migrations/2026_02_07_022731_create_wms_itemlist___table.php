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
        Schema::create('wms_itemlist__', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('item_code', 20)->nullable()->default('0');
            $table->string('sku', 30)->nullable();
            $table->string('item_description', 50)->nullable();
            $table->string('category', 50)->nullable();
            $table->string('class', 10)->nullable();
            $table->enum('item_type', ['INVENTORY', 'NON_INVENTORY', 'SERVICE'])->nullable()->default('INVENTORY');
            $table->double('unit_price')->nullable()->default(0);
            $table->decimal('cost_price', 11)->nullable()->default(0);
            $table->string('uom', 20)->nullable();
            $table->boolean('track_inventory')->nullable()->default(true);
            $table->boolean('allow_negative_stock')->nullable()->default(false);
            $table->string('recipient', 100)->nullable();
            $table->string('item_location', 100)->nullable();
            $table->integer('reorder_level')->nullable()->default(0);
            $table->integer('reorder_qty')->nullable()->default(0);
            $table->integer('average_leadtime')->nullable()->default(0);
            $table->integer('max_leadtime')->nullable()->default(0);
            $table->bigInteger('inventory_account_id')->nullable();
            $table->bigInteger('cogs_account_id')->nullable();
            $table->bigInteger('expense_account_id')->nullable();
            $table->bigInteger('sales_account_id')->nullable();
            $table->integer('active')->nullable()->default(1);
            $table->string('added_by', 100)->nullable();
            $table->dateTime('date_added')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('date_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_itemlist__');
    }
};
