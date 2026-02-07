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
        Schema::create('purchase_canvassing', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('canvass_no', 30)->nullable();
            $table->string('pr_no', 30)->nullable();
            $table->string('requested_by', 100)->nullable();
            $table->enum('status', ['OPEN', 'FOR_APPROVAL', 'APPROVED', 'REJECTED', 'PARTIAL_PO_CREATED', 'PO_CREATED'])->nullable()->default('OPEN');
            $table->string('source', 100)->nullable();
            $table->tinyInteger('min_suppliers')->nullable()->default(3);
            $table->tinyInteger('max_suppliers')->nullable()->default(5);
            $table->string('prepared_by', 100)->nullable();
            $table->dateTime('prepared_date')->nullable();
            $table->string('reviewed_by', 100)->nullable();
            $table->dateTime('reviewed_date')->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->dateTime('approved_date')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();

            $table->unique(['canvass_no', 'status', 'prepared_by'], 'idx_purchase_canvassing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_canvassing');
    }
};
