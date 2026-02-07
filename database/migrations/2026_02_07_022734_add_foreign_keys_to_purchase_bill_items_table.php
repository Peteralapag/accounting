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
        Schema::table('purchase_bill_items', function (Blueprint $table) {
            $table->foreign(['bill_id'], 'purchase_bill_items_ibfk_1')->references(['id'])->on('purchase_bills')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['receipt_item_id'], 'purchase_bill_items_ibfk_2')->references(['id'])->on('purchase_receipt_items')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_bill_items', function (Blueprint $table) {
            $table->dropForeign('purchase_bill_items_ibfk_1');
            $table->dropForeign('purchase_bill_items_ibfk_2');
        });
    }
};
