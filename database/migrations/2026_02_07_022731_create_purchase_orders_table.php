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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('po_number', 50);
            $table->string('pr_number', 50);
            $table->integer('supplier_id');
            $table->string('source', 100)->nullable();
            $table->string('branch', 100)->nullable();
            $table->date('order_date');
            $table->date('expected_delivery')->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'PARTIAL_RECEIVED', 'RECEIVED', 'CANCELLED'])->nullable()->default('PENDING');
            $table->decimal('subtotal', 12)->nullable()->default(0);
            $table->decimal('vat', 12)->nullable()->default(0);
            $table->decimal('total_amount', 12)->nullable()->default(0);
            $table->enum('vat_type', ['VAT', 'NON-VAT'])->nullable();
            $table->decimal('vat_rate', 10)->nullable();
            $table->string('remarks', 200)->nullable();
            $table->string('created_by', 100);
            $table->string('prepared_by', 100)->nullable();
            $table->dateTime('prepared_date')->nullable();
            $table->string('reviewed_by', 100)->nullable();
            $table->dateTime('reviewed_date')->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->dateTime('approved_date')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('updated_by', 100)->nullable();
            $table->boolean('closed_po')->nullable()->default(false);
            $table->string('closed_by', 100)->nullable();
            $table->dateTime('closed_date')->nullable();

            $table->unique(['po_number', 'status'], 'po_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
