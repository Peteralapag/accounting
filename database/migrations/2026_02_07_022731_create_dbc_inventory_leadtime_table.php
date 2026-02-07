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
        Schema::create('dbc_inventory_leadtime', function (Blueprint $table) {
            $table->bigInteger('leadtime_id', true);
            $table->integer('average_leadtime')->nullable();
            $table->integer('max_leadtime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_inventory_leadtime');
    }
};
