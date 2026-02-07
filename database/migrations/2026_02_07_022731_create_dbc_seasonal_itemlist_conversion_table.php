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
        Schema::create('dbc_seasonal_itemlist_conversion', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('item_code', 11)->nullable()->default('0');
            $table->string('category', 50)->nullable();
            $table->string('item_description', 50)->nullable();
            $table->integer('yield_perbatch')->nullable();
            $table->float('milligram', 50)->nullable();
            $table->float('centigram', 50)->nullable();
            $table->float('decigram', 50)->nullable();
            $table->float('kilogram', 50)->nullable();
            $table->float('gram', 50)->nullable();
            $table->string('added_by', 100)->nullable();
            $table->dateTime('date_added')->nullable();
            $table->integer('active')->nullable()->default(1);
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('date_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_seasonal_itemlist_conversion');
    }
};
