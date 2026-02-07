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
        Schema::table('purchase_bill_schedules', function (Blueprint $table) {
            $table->foreign(['bill_id'], 'purchase_bill_schedules_ibfk_1')->references(['id'])->on('purchase_bills')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_bill_schedules', function (Blueprint $table) {
            $table->dropForeign('purchase_bill_schedules_ibfk_1');
        });
    }
};
