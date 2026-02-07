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
        Schema::create('purchase_canvassing_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('canvass_no', 30)->nullable()->index('canvass_no');
            $table->string('item_code', 50)->nullable();
            $table->string('item_description')->nullable();
            $table->decimal('quantity', 10)->nullable();
            $table->string('unit', 20)->nullable();
            $table->decimal('estimated_cost', 11)->nullable();
            $table->integer('selected_supplier_id')->nullable();
            $table->decimal('selected_price', 11)->nullable();
            $table->integer('po_created')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_canvassing_items');
    }
};
