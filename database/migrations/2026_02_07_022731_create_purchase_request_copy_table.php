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
        Schema::create('purchase_request_copy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pr_number', 40)->unique('uq_pr_number');
            $table->dateTime('request_date');
            $table->enum('source', ['WAREHOUSE', 'PROPERTY CUSTODIAN', 'BRANCH', 'OTHER'])->nullable();
            $table->string('department', 100);
            $table->string('destination_branch', 100)->nullable();
            $table->string('cost_center', 100)->nullable();
            $table->string('requested_by', 100);
            $table->text('purpose')->nullable();
            $table->enum('status', ['returned', 'pending', 'approved', 'rejected', 'for_canvassing', 'canvassing_reviewed', 'canvassing_approved', 'partial_conversion', 'converted', 'convert_rejected'])->nullable()->default('pending');
            $table->string('approved_by', 100)->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('updated_by', 100)->nullable();

            $table->unique(['pr_number', 'source', 'status'], 'pr_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_copy');
    }
};
