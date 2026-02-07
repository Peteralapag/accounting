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
        Schema::create('wms_picklist', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('branch', 100)->nullable();
            $table->string('control_no', 20)->nullable()->default('0');
            $table->string('item_code', 20)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->double('quantity')->nullable();
            $table->date('trans_date')->nullable();
            $table->string('uom', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_picklist');
    }
};
