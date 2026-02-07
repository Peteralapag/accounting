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
        Schema::create('purchase_bills', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('receipt_id')->index('receipt_id');
            $table->string('bill_no', 50)->unique('bill_no');
            $table->date('bill_date');
            $table->date('due_date')->nullable();
            $table->date('goods_received_date')->nullable();
            $table->decimal('balance', 12)->default(0);
            $table->string('branch', 50);
            $table->text('remarks')->nullable();
            $table->string('tax_type', 50)->nullable();
            $table->decimal('vat_rate', 5)->nullable()->default(0);
            $table->decimal('withholding_rate', 5)->nullable()->default(0);
            $table->enum('status', ['draft', 'process', 'posted', 'paid'])->default('draft');
            $table->decimal('total_amount', 12)->default(0);
            $table->decimal('vat_amount', 12)->nullable()->default(0);
            $table->decimal('withholding_amount', 12)->nullable()->default(0);
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->nullable()->default('pending');
            $table->dateTime('processed_at')->nullable();
            $table->string('processed_by', 100)->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->string('created_by', 100)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('currency', 10)->nullable();
            $table->decimal('exchange_rate', 12, 4)->nullable();
            $table->string('supplier_invoice_no', 50)->nullable();
            $table->string('branch_remarks')->nullable();
            $table->integer('payment_terms')->nullable();
            $table->timestamp('posted_at')->useCurrentOnUpdate()->nullable();
            $table->string('posted_by', 100)->nullable();
            $table->softDeletes()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_bills');
    }
};
