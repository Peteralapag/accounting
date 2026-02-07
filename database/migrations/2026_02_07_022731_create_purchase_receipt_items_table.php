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
        Schema::create('purchase_receipt_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('receipt_id')->index('receipt_id');
            $table->integer('po_item_id')->index('po_item_id');
            $table->decimal('received_qty', 12);
            $table->decimal('unit_price', 12)->nullable();
            $table->decimal('amount', 12)->nullable()->storedAs('(`received_qty` * `unit_price`)');
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receipt_items');
    }
};
