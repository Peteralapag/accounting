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
        Schema::create('wms_item_mapping', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('store_item_id')->unique('store_item_id');
            $table->string('wms_item_code', 20);
            $table->dateTime('date_mapped')->nullable()->useCurrent();
            $table->string('mapped_by', 100)->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_item_mapping');
    }
};
