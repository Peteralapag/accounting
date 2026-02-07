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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('po_id');
            $table->integer('pr_item_id');
            $table->string('item_code', 50)->nullable();
            $table->string('description')->nullable();
            $table->decimal('qty', 10);
            $table->string('uom', 20)->nullable();
            $table->decimal('unit_price', 12);
            $table->decimal('total_price', 12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
