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
        Schema::create('binalot_chat_data', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('sender')->nullable();
            $table->text('message')->nullable();
            $table->timestamp('timestamp')->useCurrentOnUpdate()->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binalot_chat_data');
    }
};
