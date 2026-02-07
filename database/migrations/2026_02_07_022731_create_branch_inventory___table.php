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
        Schema::create('branch_inventory__', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('branch_code', 10);
            $table->string('item_code', 50);
            $table->string('item_description')->nullable();
            $table->string('item_type', 50)->nullable();
            $table->decimal('quantity', 10)->nullable()->default(0);
            $table->string('unit', 20)->nullable();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['branch_code', 'item_code'], 'branch_item_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_inventory__');
    }
};
