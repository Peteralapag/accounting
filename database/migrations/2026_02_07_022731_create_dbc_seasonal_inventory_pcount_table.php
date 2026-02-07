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
        Schema::create('dbc_seasonal_inventory_pcount', function (Blueprint $table) {
            $table->bigInteger('p_id', true);
            $table->string('item_code', 50)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->date('trans_date')->nullable()->default('0000-00-00');
            $table->double('p_count')->nullable()->default(0);
            $table->string('uom', 30)->nullable()->default('Piece(s)');
            $table->string('remarks')->nullable();
            $table->date('expiration_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_seasonal_inventory_pcount');
    }
};
