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
        Schema::create('pcs_asset_request', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('point_of_origin', 123)->nullable();
            $table->string('idcode', 20)->nullable();
            $table->string('asset_holder', 123)->nullable();
            $table->string('recipient', 50)->nullable();
            $table->string('ptf_number', 20)->nullable();
            $table->string('generated_by', 100)->nullable()->default('');
            $table->date('generated_date')->nullable()->default('0000-00-00');
            $table->string('prepared_by', 123)->nullable();
            $table->date('date_prepared')->nullable();
            $table->string('status', 30)->nullable()->default('Open');
            $table->string('approved_by', 123)->nullable();
            $table->date('date_approved')->nullable();
            $table->string('delivery_to', 123)->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('received_by', 123)->nullable();
            $table->date('date_received')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs_asset_request');
    }
};
