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
        Schema::create('tbl_wd_subfolder', function (Blueprint $table) {
            $table->bigInteger('application_id', true);
            $table->string('subfolder', 80)->nullable()->default('');
            $table->integer('void_access')->nullable()->default(0);
            $table->dateTime('void_date')->nullable();

            $table->index(['application_id', 'subfolder'], 'module_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_wd_subfolder');
    }
};
