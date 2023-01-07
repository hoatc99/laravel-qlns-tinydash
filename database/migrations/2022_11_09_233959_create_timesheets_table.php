<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->string('year_month', 7);
            $table->integer('business_days_in_month');
            $table->integer('business_days');
            $table->float('leave_days');
            $table->float('unauthorized_leave_days');
            $table->float('working_days');
            $table->text('note')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->foreignIdFor(\App\Models\Assignment::class, 'assignment_id');
            $table->foreignIdFor(\App\Models\Employee::class, 'employee_id');
            $table->foreignIdFor(\App\Models\Department::class, 'department_id');
            $table->foreignIdFor(\App\Models\Position::class, 'position_id');
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
        Schema::dropIfExists('timesheets');
    }
}
