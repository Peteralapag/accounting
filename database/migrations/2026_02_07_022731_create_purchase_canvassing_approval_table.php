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
        Schema::create('purchase_canvassing_approval', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('pr_no', 50)->nullable();
            $table->string('canvass_no', 50)->nullable();
            $table->string('approver_name', 100)->nullable();
            $table->enum('approver_role', ['HEAD', 'OWNER'])->nullable();
            $table->enum('action', ['REVIEWED', 'APPROVED', 'REJECTED'])->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('action_date')->nullable()->useCurrent();

            $table->unique(['canvass_no', 'approver_role'], 'uniq_canvass_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_canvassing_approval');
    }
};
