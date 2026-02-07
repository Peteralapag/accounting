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
        Schema::create('tbl_employees_', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('creator', 30)->nullable()->default('');
            $table->string('qrcode', 50)->nullable();
            $table->string('barcodeid', 50);
            $table->string('idcode', 50);
            $table->string('controlno', 50);
            $table->string('lastname', 50);
            $table->string('firstname', 50);
            $table->string('middlename', 50);
            $table->string('acctname', 50);
            $table->string('company', 50);
            $table->string('cluster', 50)->nullable()->default('');
            $table->string('branch', 50);
            $table->string('department', 50);
            $table->string('position', 50);
            $table->string('employment_status', 50);
            $table->date('date_applied');
            $table->date('date_hired');
            $table->date('date_regular');
            $table->date('date_resigned');
            $table->date('date_terminated')->nullable()->default('0000-00-00');
            $table->string('status', 20);
            $table->date('birth_date');
            $table->string('birth_place', 100);
            $table->string('gender', 20);
            $table->string('civil_status', 20);
            $table->string('country', 20);
            $table->string('nationality', 20);
            $table->string('religion', 60);
            $table->string('employee_photo', 123);
            $table->string('c_houseno', 20);
            $table->string('c_street', 100);
            $table->string('c_barangay', 100);
            $table->string('c_citytown', 50);
            $table->string('c_province_estate', 50);
            $table->string('p_houseno', 20);
            $table->string('p_street', 100);
            $table->string('p_barangay', 100);
            $table->string('p_citytown', 50);
            $table->string('p_province_estate', 20);
            $table->string('mobile', 20);
            $table->string('telephone', 20);
            $table->string('email_address', 60);
            $table->string('fb_address', 100);
            $table->string('incase_person', 80);
            $table->string('incase_contact', 20);
            $table->string('incase_address', 100);
            $table->string('fathername', 80)->nullable()->default('');
            $table->string('fatheroccupation', 123)->nullable();
            $table->string('fatheraddress', 123)->nullable();
            $table->string('fathercontact', 123)->nullable();
            $table->string('mothername', 123)->nullable();
            $table->string('motheroccupation', 123)->nullable();
            $table->string('motheraddress', 123)->nullable();
            $table->string('mothercontact', 123)->nullable();
            $table->integer('noofsiblings')->nullable();
            $table->integer('noofdependents')->nullable();
            $table->string('gov_sss_no');
            $table->string('gov_pagibig_no', 40);
            $table->string('gov_philhealth_no', 40);
            $table->string('gov_tin_no', 40);
            $table->string('bank', 40);
            $table->string('acctno', 40);
            $table->integer('included');
            $table->dateTime('date_created')->nullable()->default('0000-00-00 00:00:00');
            $table->string('created_by', 60)->nullable()->default('');
            $table->dateTime('date_updated')->nullable()->default('0000-00-00 00:00:00');
            $table->string('updated_by', 60)->nullable()->default('');
            $table->string('salary_type', 20)->nullable()->default('');
            $table->double('salary_monthly')->nullable()->default(0);
            $table->double('salary_daily')->nullable()->default(0);
            $table->double('salary_hourly')->nullable()->default(0);
            $table->double('night_diff')->nullable()->default(0);
            $table->double('nightdiff_amount')->nullable()->default(0);
            $table->double('allowance_daily')->nullable()->default(0);
            $table->double('vacation_leave')->nullable()->default(0);
            $table->double('vacation_leave_used')->nullable()->default(0);
            $table->double('vacation_leave_balance')->nullable()->default(0);
            $table->double('sick_leave')->nullable()->default(0);
            $table->double('sick_leave_used')->nullable()->default(0);
            $table->double('sick_leave_balance')->nullable()->default(0);
            $table->double('emergency_leave')->nullable()->default(0);
            $table->double('emergency_leave_balance')->nullable()->default(0);
            $table->double('emergency_leave_used')->nullable()->default(0);
            $table->integer('collect_sss_every')->nullable();
            $table->integer('collect_pagibig_every')->nullable();
            $table->integer('collect_phic_every')->nullable();
            $table->integer('collect_ps_every')->nullable();
            $table->integer('collect_tax_every')->nullable();
            $table->integer('collect_hmo_every')->nullable();
            $table->string('collect_sss', 5)->nullable();
            $table->string('collect_pagibig', 5)->nullable();
            $table->double('cola_perday')->nullable();
            $table->string('collect_phic', 5)->nullable();
            $table->string('collect_ps', 5)->nullable();
            $table->string('collect_tax', 5)->nullable();
            $table->string('collect_hmo', 5)->nullable();
            $table->double('pagibig_extra')->nullable()->default(0);
            $table->double('personal_savings')->nullable()->default(0);
            $table->double('hmo_amount')->nullable()->default(0);
            $table->string('username', 25)->nullable();
            $table->string('password', 50)->nullable();
            $table->double('allowance_load')->nullable()->default(0);
            $table->string('collect_load', 6)->nullable()->default('No');
            $table->string('collect_load_every', 5)->nullable();
            $table->double('allowance_mobility')->nullable()->default(0);
            $table->string('collect_mobility', 6)->nullable()->default('No');
            $table->string('collect_mobility_every', 5)->nullable();
            $table->boolean('mobile_user')->nullable()->default(false);
            $table->boolean('branch_reliever')->nullable()->default(false);
            $table->boolean('Administrator')->nullable()->default(false);
            $table->string('assigned_area', 100)->nullable();
            $table->longText('area_branches')->nullable();
            $table->boolean('roaming')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_employees_');
    }
};
