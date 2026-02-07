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
        Schema::create('tbl_system_user', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('company', 80)->nullable();
            $table->string('cluster', 100)->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->bigInteger('idcode')->nullable()->default(0);
            $table->string('firstname', 100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->string('acctname', 80)->nullable();
            $table->string('username', 100)->nullable()->unique('user name');
            $table->string('password')->nullable();
            $table->string('role', 100)->nullable()->default('User');
            $table->integer('level')->nullable()->default(10);
            $table->integer('login_status')->nullable()->default(0);
            $table->integer('void_access')->nullable()->default(0);
            $table->string('assign_cluster', 100)->nullable();
            $table->tinyInteger('dbc_online')->nullable()->default(0);
            $table->tinyInteger('dbc_seasonal_online')->nullable()->default(0);
            $table->tinyInteger('fds_online')->nullable()->default(0);
            $table->tinyInteger('binalot_online')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_system_user');
    }
};
