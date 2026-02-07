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
        Schema::create('tbl_branch', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('branch', 123)->nullable();
            $table->string('branchcode', 123)->nullable();
            $table->string('location', 123)->nullable();
            $table->string('address', 123)->nullable();
            $table->string('latitude', 100)->nullable()->default('');
            $table->string('longitude', 100)->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_branch');
    }
};
