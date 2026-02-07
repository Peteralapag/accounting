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
        Schema::create('binalot_classifications_records', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('item_location', 100)->nullable();
            $table->string('recipient', 100)->nullable();
            $table->string('item_code', 20)->nullable()->default('0');
            $table->string('item_description', 100)->nullable();
            $table->double('bad_order_qty')->nullable();
            $table->date('bo_transdate')->nullable();
            $table->double('damage_qty')->nullable();
            $table->date('damage_transdate')->nullable();
            $table->double('seconds_qty')->nullable()->default(0);
            $table->date('seconds_transdate')->nullable();
            $table->double('reclassify_qty')->nullable();
            $table->date('reclassify_transdate')->nullable();
            $table->double('disposal_qty')->nullable();
            $table->date('disposal_transdate')->nullable();
            $table->date('date_updated')->nullable();
            $table->boolean('flag')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binalot_classifications_records');
    }
};
