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
        Schema::create('dbc_seasonal_order_request_generate_dr', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('request_id')->nullable();
            $table->string('cluster', 80)->nullable();
            $table->string('branch', 80)->nullable();
            $table->string('form_type', 10)->nullable();
            $table->string('recipient', 80)->nullable();
            $table->string('control_no', 20)->nullable();
            $table->string('dr_number', 20)->nullable();
            $table->string('created_by', 100)->nullable()->default('');
            $table->date('trans_date')->nullable()->default('0000-00-00');
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->string('status', 20)->nullable()->default('Open');
            $table->string('checked', 20)->nullable();
            $table->string('checked_by', 100)->nullable();
            $table->date('checked_date')->nullable();
            $table->string('approved', 20)->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->date('approved_date')->nullable();
            $table->string('date_created', 20)->nullable();
            $table->string('priority', 20)->nullable()->default('Normal');
            $table->integer('order_received')->nullable()->default(0);
            $table->date('order_received_date')->nullable();
            $table->string('order_received_by', 100)->nullable();
            $table->integer('order_preparing')->nullable()->default(0);
            $table->date('order_preparing_date')->nullable();
            $table->string('order_preparing_by', 100)->nullable();
            $table->integer('logistics')->nullable()->default(0);
            $table->integer('order_transit')->nullable()->default(0);
            $table->date('order_transit_date')->nullable();
            $table->string('order_accepted_by', 100)->nullable();
            $table->integer('order_delivered')->nullable()->default(0);
            $table->dateTime('order_delivered_date')->nullable();
            $table->longText('order_remarks')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_driver', 20)->nullable();
            $table->string('plate_number', 20)->nullable();
            $table->string('void_by', 100)->nullable();
            $table->integer('finalize')->nullable()->default(0);
            $table->string('transaction_id', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_seasonal_order_request_generate_dr');
    }
};
