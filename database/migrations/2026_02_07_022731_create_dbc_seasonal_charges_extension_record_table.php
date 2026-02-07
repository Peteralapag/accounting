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
        Schema::create('dbc_seasonal_charges_extension_record', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('chargecodeno', 50)->nullable()->default('');
            $table->string('report_date', 20)->nullable()->default('');
            $table->string('idcode', 100)->nullable()->default('');
            $table->string('employee_name', 100)->nullable();
            $table->string('employee_type', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('item_code', 20)->nullable()->default('0');
            $table->double('quantity')->nullable();
            $table->double('unit_price')->nullable()->default(0);
            $table->double('total')->nullable()->default(0);
            $table->timestamp('created_date')->useCurrentOnUpdate()->nullable();
            $table->string('created_by', 100)->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->timestamp('void_date')->useCurrentOnUpdate()->nullable();
            $table->string('void_by', 100)->nullable();
            $table->longText('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_seasonal_charges_extension_record');
    }
};
