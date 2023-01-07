<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payoffs', function (Blueprint $table) {
            $table->id();
            $table->string('year_month', 7);
            $table->boolean('is_bonus');
            $table->double('payoff_amount');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('payoffs');
    }
}
