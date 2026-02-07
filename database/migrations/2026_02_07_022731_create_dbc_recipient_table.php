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
        Schema::create('dbc_recipient', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('recipient', 100)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('form_type', 10)->nullable();
            $table->integer('active')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbc_recipient');
    }
};
