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
        Schema::create('binalot_inventory_records', function (Blueprint $table) {
            $table->bigInteger('wid_id', true);
            $table->bigInteger('supplier_id')->nullable();
            $table->string('item_code', 50)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->double('unit_price')->nullable()->default(0);
            $table->string('year', 10)->nullable()->default('0');
            $table->string('month', 10)->nullable();
            $table->double('beginning')->nullable()->default(0);
            $table->double('day_01')->nullable()->default(0);
            $table->double('day_02')->nullable()->default(0);
            $table->double('day_03')->nullable()->default(0);
            $table->double('day_04')->nullable()->default(0);
            $table->double('day_05')->nullable()->default(0);
            $table->double('day_06')->nullable()->default(0);
            $table->double('day_07')->nullable()->default(0);
            $table->double('day_08')->nullable()->default(0);
            $table->double('day_09')->nullable()->default(0);
            $table->double('day_10')->nullable()->default(0);
            $table->double('day_11')->nullable()->default(0);
            $table->double('day_12')->nullable()->default(0);
            $table->double('day_13')->nullable()->default(0);
            $table->double('day_14')->nullable()->default(0);
            $table->double('day_15')->nullable()->default(0);
            $table->double('day_16')->nullable()->default(0);
            $table->double('day_17')->nullable()->default(0);
            $table->double('day_18')->nullable()->default(0);
            $table->double('day_19')->nullable()->default(0);
            $table->double('day_20')->nullable()->default(0);
            $table->double('day_21')->nullable()->default(0);
            $table->double('day_22')->nullable()->default(0);
            $table->double('day_23')->nullable()->default(0);
            $table->double('day_24')->nullable()->default(0);
            $table->double('day_25')->nullable()->default(0);
            $table->double('day_26')->nullable()->default(0);
            $table->double('day_27')->nullable()->default(0);
            $table->double('day_28')->nullable()->default(0);
            $table->double('day_29')->nullable()->default(0);
            $table->double('day_30')->nullable()->default(0);
            $table->double('day_31')->nullable()->default(0);
            $table->double('ending')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binalot_inventory_records');
    }
};
