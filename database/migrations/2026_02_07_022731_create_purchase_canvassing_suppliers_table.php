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
        Schema::create('purchase_canvassing_suppliers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('canvass_no', 30)->nullable();
            $table->integer('canvass_item_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->string('supplier_name', 150)->nullable();
            $table->string('brand', 150)->nullable();
            $table->decimal('price', 11)->nullable();
            $table->string('remarks', 200)->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('created_po')->nullable()->default(0);
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('token', 100)->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->tinyInteger('email_sent')->nullable()->default(0);
            $table->dateTime('email_sent_at')->nullable();
            $table->dateTime('token_expires_at')->nullable();
            $table->tinyInteger('token_used')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_canvassing_suppliers');
    }
};
