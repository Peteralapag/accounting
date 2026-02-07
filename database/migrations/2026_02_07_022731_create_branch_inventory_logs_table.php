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
        Schema::create('branch_inventory_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('branch', 50);
            $table->string('item_code', 50);
            $table->decimal('change_qty', 12);
            $table->string('reference', 50);
            $table->integer('reference_id');
            $table->string('created_by', 50);
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->text('remarks')->nullable();

            $table->index(['branch', 'item_code'], 'idx_branch_item');
            $table->index(['reference', 'reference_id'], 'idx_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_inventory_logs');
    }
};
