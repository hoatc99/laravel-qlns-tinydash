<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('expected_end_date');
            $table->date('actual_end_date');
            $table->boolean('is_parking_allowance')->default(false);
            $table->boolean('is_sleep_at_shop_allowance')->default(false);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('assignments');
    }
}
