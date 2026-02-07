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
        Schema::create('tbl_archived_memo', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('company', 80)->nullable();
            $table->string('organization', 80)->nullable();
            $table->string('subfolder', 80)->nullable();
            $table->longText('file_name')->nullable();
            $table->longText('file_description')->nullable();
            $table->string('uploaded_by', 20)->nullable();
            $table->string('username', 30)->nullable();
            $table->dateTime('date_uploaded')->nullable();
            $table->integer('file_views')->nullable()->default(0);
            $table->integer('file_downloaded')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_archived_memo');
    }
};
