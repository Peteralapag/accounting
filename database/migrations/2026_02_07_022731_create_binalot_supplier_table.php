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
        Schema::create('binalot_supplier', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name', 123)->nullable()->default('0');
            $table->longText('address')->nullable();
            $table->string('tin', 50)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('cellphone', 30)->nullable();
            $table->string('email', 123)->nullable();
            $table->dateTime('date_added')->nullable();
            $table->string('added_by', 123)->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->string('updated_by', 123)->nullable();
            $table->string('contact_person', 123)->nullable();
            $table->string('person_contact', 30)->nullable();
            $table->integer('active')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binalot_supplier');
    }
};
