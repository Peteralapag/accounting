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
        Schema::create('tbl_sidebar', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('button_order')->nullable()->default(0);
            $table->string('nav_buttons', 50)->nullable();
            $table->string('memo_prefix', 20)->nullable();
            $table->string('icons', 80)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sidebar');
    }
};
