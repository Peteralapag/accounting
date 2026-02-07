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
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pr_id')->index('fk_pr');
            $table->string('item_type', 50)->nullable();
            $table->string('item_code', 50);
            $table->string('item_description')->nullable();
            $table->decimal('quantity', 10);
            $table->string('unit', 50)->nullable();
            $table->decimal('estimated_cost', 12);
            $table->decimal('total_estimated', 12);
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
