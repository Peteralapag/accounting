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
        Schema::create('purchase_receipts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('po_id')->index('po_id');
            $table->string('receipt_no', 50)->unique('receipt_no');
            $table->date('received_date');
            $table->string('received_by', 100)->nullable();
            $table->string('checked_by', 100)->nullable();
            $table->string('branch', 50)->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'confirmed'])->nullable()->default('pending');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receipts');
    }
};
