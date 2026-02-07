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
        Schema::create('wms_cluster_settings', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('idcode', 50)->nullable();
            $table->string('username', 100)->nullable();
            $table->longText('cluster_list')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wms_cluster_settings');
    }
};
