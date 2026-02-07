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
        Schema::create('tbl_user_wallpaper', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('company', 123)->nullable();
            $table->string('username', 123)->nullable()->unique('username');
            $table->string('desktop', 123);
            $table->string('login', 123)->nullable();
            $table->string('wp_name', 123)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user_wallpaper');
    }
};
