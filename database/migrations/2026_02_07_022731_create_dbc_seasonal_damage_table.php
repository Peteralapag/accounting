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
        Schema::create('dbc_seasonal_damage', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->date('report_date')->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('item_description', 100)->nullable();
            $table->string('item_code', 20)->nullable()->default('0');
            $table->double('quantity')->nullable();
            $table->timestamp('created_date')->useCurrentOnUpdate()->nullable();
            $table->string('created_by', 100)->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->timestamp('void_date')->useCurrentOnUpdate()->nullable();
            $table->string('void_by', 100)->nullable();
            $table->longText('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_seasonal_damage');
    }
};
