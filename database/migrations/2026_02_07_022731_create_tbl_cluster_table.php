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
        Schema::create('tbl_cluster', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('cluster')->nullable()->default('')->unique(' cluster_name');
            $table->string('cluster_code')->nullable()->default('');
            $table->string('added_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_cluster');
    }
};
