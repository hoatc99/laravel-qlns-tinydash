<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->double('parking_allowance_amount');
            $table->double('sleep_at_shop_allowance_amount');
            $table->double('seniority_allowance_percent');
            $table->integer('days_for_timekeeping');
            $table->boolean('is_overdue_timesheet_timekeeping_open');
            $table->integer('days_for_payroll_calculate');
            $table->boolean('is_overdue_payroll_calculate_open');
            $table->double('init_basic_pay_amount');
            $table->date('virtual_today');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
