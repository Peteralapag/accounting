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
        Schema::create('purchase_order_email_queue', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('po_id');
            $table->string('po_number', 50)->nullable();
            $table->string('supplier_email')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->nullable()->default('pending');
            $table->text('error_message')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_email_queue');
    }
};
