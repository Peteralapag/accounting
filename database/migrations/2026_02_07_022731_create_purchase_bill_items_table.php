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
        Schema::create('purchase_bill_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('bill_id')->index('bill_id');
            $table->integer('receipt_item_id')->index('receipt_item_id');
            $table->decimal('qty', 12)->default(0);
            $table->decimal('unit_price', 12)->default(0);
            $table->decimal('amount', 12)->default(0);
            $table->decimal('tax_amount', 12)->nullable();
            $table->decimal('discount', 12)->nullable();
            $table->softDeletes()->useCurrentOnUpdate();
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
        Schema::dropIfExists('purchase_bill_items');
    }
};
