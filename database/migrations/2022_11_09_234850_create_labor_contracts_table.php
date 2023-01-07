<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaborContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labor_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->integer('period');
            $table->date('signed_date');
            $table->date('start_date');
            $table->date('expected_end_date');
            $table->date('actual_end_date');
            $table->date('termination_date');
            $table->boolean('is_active')->default(true);
            $table->foreignIdFor(\App\Models\Employee::class, 'employee_id');
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
        Schema::dropIfExists('labor_contracts');
    }
}
