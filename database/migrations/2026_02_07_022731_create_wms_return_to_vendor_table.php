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
        Schema::create('wms_return_to_vendor', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('details_id')->nullable()->default(0);
            $table->integer('supplier_id')->nullable()->default(0);
            $table->string('po_no', 100)->nullable()->default('');
            $table->string('item_code', 20)->nullable();
            $table->string('description', 100)->nullable()->default('');
            $table->double('quantity_received')->nullable()->default(0);
            $table->double('return_quantity')->nullable()->default(0);
            $table->string('requested_by', 100)->nullable();
            $table->dateTime('requested_date')->nullable();
            $table->longText('remarks')->nullable();
            $table->boolean('approved')->nullable()->default(false);
            $table->string('approved_by', 100)->nullable();
            $table->dateTime('approved_date')->nullable();
            $table->string('status', 10)->nullable()->default('Pending');
            $table->string('updated_by', 100)->nullable()->default('');
            $table->dateTime('date_updated')->nullable();
            $table->string('committed_by', 100)->nullable();
            $table->boolean('committed')->nullable()->default(false);
            $table->dateTime('date_committed')->nullable();
            $table->double('stock_after_return')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_return_to_vendor');
    }
};
