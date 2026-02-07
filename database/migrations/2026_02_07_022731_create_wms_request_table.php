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
        Schema::create('wms_request', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('recipient', 100)->nullable();
            $table->string('control_no', 20)->nullable();
            $table->string('requested_by', 100)->nullable()->default('');
            $table->dateTime('request_date')->nullable()->default('0000-00-00 00:00:00');
            $table->string('granted_by', 100)->nullable();
            $table->dateTime('granted_date')->nullable();
            $table->boolean('flag')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_request');
    }
};
