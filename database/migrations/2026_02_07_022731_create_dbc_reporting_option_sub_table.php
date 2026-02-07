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
        Schema::create('dbc_reporting_option_sub', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('rid')->nullable()->default(0);
            $table->integer('ordering')->nullable()->default(0);
            $table->string('reporting_sub', 100)->nullable();
            $table->string('page_name', 100)->nullable();
            $table->string('table_name', 100)->nullable();
            $table->string('icon_class', 100)->nullable();
            $table->integer('active')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_reporting_option_sub');
    }
};
