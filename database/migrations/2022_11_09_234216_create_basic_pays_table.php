<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_pays', function (Blueprint $table) {
            $table->id();
            $table->double('basic_pay_amount');
            $table->date('start_date');
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
        Schema::dropIfExists('basic_pays');
    }
}
