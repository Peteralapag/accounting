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
        Schema::create('branch_inventory_log__', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('branch_code', 10);
            $table->string('item_code', 50);
            $table->decimal('change_qty', 10);
            $table->enum('action_type', ['PR Received', 'Issued', 'Adjustment']);
            $table->string('pr_number', 50)->nullable();
            $table->string('user', 50)->nullable();
            $table->dateTime('log_date')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_inventory_log__');
    }
};
