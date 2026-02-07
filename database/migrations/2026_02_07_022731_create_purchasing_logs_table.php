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
        Schema::create('purchasing_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('reference_type', ['PR', 'PO']);
            $table->string('reference_id', 100);
            $table->string('action', 50)->nullable();
            $table->string('action_by', 100)->nullable();
            $table->dateTime('action_date')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasing_logs');
    }
};
