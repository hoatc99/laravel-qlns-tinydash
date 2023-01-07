<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('year_month', 7);
            $table->double('basic_pay_amount');
            $table->double('business_days_amount');
            $table->double('leave_days_amount');
            $table->double('unauthorized_leave_days_amount');
            $table->double('working_days_amount');
            $table->double('kpi');
            $table->double('kpi_bonus_amount');
            $table->double('position_allowance_amount');
            $table->double('parking_allowance_amount');
            $table->double('sleep_at_shop_allowance_amount');
            $table->double('seniority_allowance_amount');
            $table->double('sum_of_allowances_amount');
            $table->double('health_insurance_pay_amount');
            $table->double('social_insurance_pay_amount');
            $table->double('unemployment_insurance_pay_amount');
            $table->double('sum_of_insurances_amount');
            $table->double('payoff_amount');
            $table->double('sum_of_payrolls_amount');
            $table->double('advance_amount');
            $table->double('take_home_pay_amount');
            $table->text('note')->nullable();
            $table->foreignIdFor(\App\Models\Employee::class, 'employee_id');
            $table->foreignIdFor(\App\Models\Department::class, 'department_id');
            $table->foreignIdFor(\App\Models\Position::class, 'position_id');
            $table->foreignIdFor(\App\Models\Timesheet::class, 'timesheet_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
