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
        Schema::create('dbc_seasonal_tbl_branch', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('branch_id')->nullable()->default('');
            $table->string('branch')->nullable()->default('');
            $table->integer('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_seasonal_tbl_branch');
    }
};
