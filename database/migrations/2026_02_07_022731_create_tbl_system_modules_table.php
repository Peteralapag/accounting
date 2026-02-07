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
        Schema::create('tbl_system_modules', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('application_id')->nullable()->default(0);
            $table->string('modules', 60)->nullable()->default('');
            $table->integer('ordering')->nullable();
            $table->string('application_name', 100)->nullable();

            $table->index(['id', 'application_id', 'modules'], 'function_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_system_modules');
    }
};
