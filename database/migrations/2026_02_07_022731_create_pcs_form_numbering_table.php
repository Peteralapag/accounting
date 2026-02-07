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
        Schema::create('pcs_form_numbering', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('curr_year', 6)->nullable();
            $table->string('item_code', 20)->nullable()->default('');
            $table->string('tag_number', 20)->nullable()->default('');
            $table->string('ptf_number', 20)->nullable();
            $table->string('accountability_number', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs_form_numbering');
    }
};
