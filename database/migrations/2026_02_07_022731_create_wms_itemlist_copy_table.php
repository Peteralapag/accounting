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
        Schema::create('wms_itemlist_copy', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('supplier_id')->nullable();
            $table->string('recipient', 100)->nullable();
            $table->string('item_location', 100)->nullable();
            $table->string('item_code', 11)->nullable()->default('0');
            $table->string('qr_code', 50)->nullable();
            $table->string('category', 50)->nullable();
            $table->string('class', 10)->nullable();
            $table->string('item_description', 50)->nullable();
            $table->double('unit_price')->nullable()->default(0);
            $table->string('uom', 50)->nullable();
            $table->string('conversion', 50)->nullable();
            $table->string('added_by', 100)->nullable();
            $table->dateTime('date_added')->nullable();
            $table->integer('active')->nullable()->default(1);
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->integer('average_leadtime')->nullable()->default(0);
            $table->integer('max_leadtime')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_itemlist_copy');
    }
};
