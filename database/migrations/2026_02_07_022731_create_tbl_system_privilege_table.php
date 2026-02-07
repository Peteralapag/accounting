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
        Schema::create('tbl_system_privilege', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('idcode', 123)->nullable()->default('');
            $table->string('acctname', 123)->nullable()->default('');
            $table->string('username', 123)->nullable();
            $table->integer('userlevel')->nullable()->default(10);
            $table->string('applications', 80)->nullable()->default('');
            $table->string('modules', 80)->nullable()->default('');
            $table->integer('p_view')->nullable()->default(0);
            $table->integer('p_read')->nullable()->default(0);
            $table->integer('p_add')->nullable();
            $table->integer('p_write')->nullable()->default(0);
            $table->integer('p_edit')->nullable()->default(0);
            $table->integer('p_delete')->nullable()->default(0);
            $table->integer('p_update')->nullable()->default(0);
            $table->integer('p_print')->nullable()->default(0);
            $table->integer('p_review')->nullable()->default(0);
            $table->integer('p_approver')->nullable()->default(0);
            $table->integer('p_locked')->nullable()->default(0);
            $table->integer('p_void')->nullable()->default(0);
            $table->dateTime('p_void_date')->nullable()->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_system_privilege');
    }
};
