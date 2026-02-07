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
        Schema::create('binalot_form_numbering', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('mrs_number', 20)->nullable();
            $table->string('dr_number', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binalot_form_numbering');
    }
};
