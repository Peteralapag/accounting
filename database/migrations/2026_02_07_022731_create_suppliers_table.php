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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('supplier_code', 50)->nullable()->unique('supplier_code');
            $table->string('name', 123);
            $table->longText('address')->nullable();
            $table->string('tin', 50)->nullable();
            $table->integer('payment_terms')->nullable();
            $table->string('contact_person', 123)->nullable();
            $table->string('person_contact', 30)->nullable();
            $table->string('email', 123)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('website', 123)->nullable();
            $table->string('currency', 10)->nullable()->default('PHP');
            $table->string('supplier_type', 50)->nullable()->default('Goods');
            $table->string('gl_account_code', 50)->nullable();
            $table->string('tax_type', 50)->nullable();
            $table->decimal('vat_rate', 5)->nullable();
            $table->decimal('withholding_rate', 5)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->longText('remarks')->nullable();
            $table->dateTime('date_added')->nullable()->useCurrent();
            $table->string('added_by', 123)->nullable();
            $table->dateTime('date_updated')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('updated_by', 123)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
