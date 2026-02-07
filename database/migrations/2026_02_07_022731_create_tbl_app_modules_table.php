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
        Schema::create('tbl_app_modules', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('ordering')->nullable();
            $table->string('module_name', 100)->nullable()->default('')->unique(' cluster_name');
            $table->string('module_page', 100)->nullable();
            $table->string('module_icon', 100)->nullable()->default('');
            $table->string('icon_color', 100)->nullable();
            $table->integer('active')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_app_modules');
    }
};
