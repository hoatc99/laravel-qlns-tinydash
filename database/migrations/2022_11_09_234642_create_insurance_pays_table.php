<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_pays', function (Blueprint $table) {
            $table->id();
            $table->string('year_month', 7);
            $table->double('health_insurance_pay_amount');
            $table->double('social_insurance_pay_amount');
            $table->double('unemployment_insurance_pay_amount');
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
        Schema::dropIfExists('insurance_pays');
    }
}
