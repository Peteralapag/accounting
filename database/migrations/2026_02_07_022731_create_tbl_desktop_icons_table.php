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
        Schema::create('tbl_desktop_icons', function (Blueprint $table) {
            $table->integer('icon_id', true)->index('icon_id');
            $table->string('company', 123)->nullable();
            $table->string('username', 123)->nullable();
            $table->string('icon_name', 123);
            $table->string('icon_image', 123)->nullable();
            $table->string('icon_text', 123)->nullable();
            $table->string('icon_function', 123)->nullable();
            $table->integer('icon_active')->nullable()->default(1);

            $table->primary(['icon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_desktop_icons');
    }
};
