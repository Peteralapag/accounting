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
        Schema::create('dbc_datelock_checker', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->date('report_date')->nullable()->index('idx_dbc_datelock_cheker');
            $table->integer('status')->nullable()->default(0);
            $table->string('created_by', 100)->nullable();
            $table->timestamp('date_created')->useCurrentOnUpdate()->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamp('updated_date')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_datelock_checker');
    }
};
