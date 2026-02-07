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
        Schema::create('tbl_company', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('company')->nullable();
            $table->string('code')->nullable();
            $table->string('main_company')->nullable();
            $table->string('company_sss')->nullable();
            $table->string('company_tin')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_owner')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_signatory')->nullable();
            $table->string('company_position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_company');
    }
};
