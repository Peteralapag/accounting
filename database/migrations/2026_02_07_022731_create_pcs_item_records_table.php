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
        Schema::create('pcs_item_records', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('item_code', 30)->nullable();
            $table->date('date_received')->nullable();
            $table->double('quantity')->nullable();
            $table->string('uom', 30)->nullable();
            $table->string('brand_name', 123)->nullable();
            $table->longText('unit_description')->nullable();
            $table->longText('supplier')->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->string('po_number', 30)->nullable();
            $table->string('dr_number', 30)->nullable();
            $table->string('si_number', 30)->nullable();
            $table->string('mrs_number', 30)->nullable();
            $table->string('tag_number', 30)->nullable();
            $table->string('ptf_number', 30)->nullable();
            $table->string('accountability_number', 30)->nullable();
            $table->double('property_cost')->nullable()->default(0);
            $table->integer('depreciation_lenght')->nullable();
            $table->date('depreciate_date')->nullable();
            $table->double('yearly_depreciation')->nullable()->default(0);
            $table->double('depreciation_amount')->nullable()->default(0);
            $table->boolean('assigned')->nullable()->default(false);
            $table->string('asset_holder', 100)->nullable();
            $table->longText('remarks')->nullable();
            $table->string('status', 100)->nullable()->default('0');
            $table->boolean('flag')->nullable()->default(false);
            $table->dateTime('date_created')->nullable();
            $table->string('created_by', 123)->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->string('updated_by', 123)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs_item_records');
    }
};
