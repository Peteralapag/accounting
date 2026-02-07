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
        Schema::create('purchase_bill_payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('bill_id')->index('bill_id');
            $table->date('payment_date');
            $table->string('payment_account', 100)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('pdc_number', 50)->nullable();
            $table->string('reference_no', 50)->nullable();
            $table->decimal('amount_paid', 12);
            $table->decimal('balance_after_payment', 12)->nullable();
            $table->enum('status', ['pending', 'partial', 'paid'])->nullable()->default('pending');
            $table->string('currency', 10)->nullable();
            $table->decimal('exchange_rate', 12, 4)->nullable();
            $table->timestamp('posted_at')->useCurrentOnUpdate()->nullable();
            $table->string('posted_by', 100)->nullable();
            $table->string('deleted_at', 100)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_bill_payments');
    }
};
