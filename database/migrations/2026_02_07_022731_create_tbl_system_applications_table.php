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
        Schema::create('tbl_system_applications', function (Blueprint $table) {
            $table->bigInteger('application_id', true);
            $table->string('application_name', 60)->nullable()->default('');

            $table->index(['application_id', 'application_name'], 'module_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_system_applications');
    }
};
