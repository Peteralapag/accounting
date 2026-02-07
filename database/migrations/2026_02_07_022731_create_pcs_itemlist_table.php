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
        Schema::create('pcs_itemlist', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('item_code', 20)->nullable();
            $table->string('item_category_name', 123)->nullable()->unique('item description');
            $table->string('category', 123)->nullable();
            $table->smallInteger('active')->nullable()->default(1);
            $table->string('added_by', 123)->nullable();
            $table->dateTime('date_added')->nullable();
            $table->string('updated_by', 123)->nullable();
            $table->dateTime('date_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs_itemlist');
    }
};
