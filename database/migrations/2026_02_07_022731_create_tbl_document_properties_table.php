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
        Schema::create('tbl_document_properties', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('upload_type', 123)->nullable();
            $table->longText('file_name')->nullable();
            $table->string('username', 123)->nullable();
            $table->string('author', 123)->nullable();
            $table->dateTime('upload_date')->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->bigInteger('downloaded_count')->nullable()->default(0);
            $table->bigInteger('accessed_count')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_document_properties');
    }
};
