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
        Schema::create('pcs_asset_holder_records', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('ptf_number', 30)->nullable();
            $table->string('asset_holder', 123)->nullable();
            $table->string('item_code', 30)->nullable();
            $table->longText('unit_description')->nullable();
            $table->string('uom', 30)->nullable();
            $table->double('quantity')->nullable();
            $table->string('remarks', 100)->nullable();
            $table->dateTime('date_created')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->string('tag_number', 30)->nullable();
            $table->string('serial_number', 30)->nullable();
            $table->string('status', 30)->nullable()->default('None');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs_asset_holder_records');
    }
};
