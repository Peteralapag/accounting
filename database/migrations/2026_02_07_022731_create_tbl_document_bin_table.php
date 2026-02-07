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
        Schema::create('tbl_document_bin', function (Blueprint $table) {
            $table->integer('id', true);
            $table->dateTime('application')->nullable()->default('0000-00-00 00:00:00');
            $table->string('path', 123)->nullable();
            $table->string('modules', 80)->nullable();
            $table->string('author', 80)->nullable();
            $table->longText('real_file_name')->nullable();
            $table->longText('file_name')->nullable();
            $table->string('username', 123)->nullable();
            $table->string('date_deleted', 123)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_document_bin');
    }
};
