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
        Schema::create('purchase_bill_schedules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('bill_id')->index('bill_id');
            $table->date('scheduled_date');
            $table->decimal('scheduled_amount', 12)->nullable()->default(0);
            $table->enum('status', ['pending', 'paid', 'overdue'])->nullable()->default('pending');
            $table->string('created_by', 100)->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->timestamp('approved_at')->nullable();
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
        Schema::dropIfExists('purchase_bill_schedules');
    }
};
