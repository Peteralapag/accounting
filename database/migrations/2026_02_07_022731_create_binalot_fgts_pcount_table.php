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
        Schema::create('binalot_fgts_pcount', function (Blueprint $table) {
            $table->bigInteger('p_id', true);
            $table->string('item_code', 50)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->date('trans_date')->nullable()->default('0000-00-00');
            $table->double('unit_price')->nullable()->default(0);
            $table->double('pcount')->nullable()->default(0);
            $table->bigInteger('receiving_detail_id')->nullable();
            $table->string('uom', 30)->nullable();
            $table->string('remarks')->nullable();
            $table->timestamp('date_created')->nullable();
            $table->string('posted_by', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binalot_fgts_pcount');
    }
};
