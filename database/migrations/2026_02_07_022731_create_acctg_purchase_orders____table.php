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
        Schema::create('acctg_purchase_orders___', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('po_number', 50);
            $table->string('vendor_name', 100);
            $table->date('po_date');
            $table->decimal('total_amount', 10);
            $table->enum('status', ['Pending', 'Approved', 'Received', 'Cancelled'])->nullable()->default('Pending');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acctg_purchase_orders___');
    }
};
