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
        Schema::create('tbl_app_request', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('applications', 123)->nullable();
            $table->string('modules', 80)->nullable();
            $table->longText('file_name')->nullable();
            $table->string('account_name', 123)->nullable();
            $table->string('requested_by', 123)->nullable();
            $table->integer('request_type')->nullable()->default(0);
            $table->dateTime('requested_date')->nullable()->default('0000-00-00 00:00:00');
            $table->longText('request_reason')->nullable();
            $table->string('approved_by', 123)->nullable();
            $table->dateTime('approved_date')->nullable()->default('0000-00-00 00:00:00');
            $table->integer('approved')->nullable()->default(0);
            $table->longText('reject_reason')->nullable();
            $table->integer('executed')->nullable()->default(0);
            $table->dateTime('executed_date')->nullable()->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_app_request');
    }
};
