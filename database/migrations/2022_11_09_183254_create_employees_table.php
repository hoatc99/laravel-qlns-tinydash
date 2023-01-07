<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 100);
            $table->date('date_of_birth');
            $table->boolean('gender');
            $table->string('place_of_permanent', 255);
            $table->string('identification_number', 20)->unique();
            $table->date('date_of_issue');
            $table->string('place_of_issue', 255);
            $table->string('phone_number', 15)->unique();
            $table->string('email', 255)->nullable();
            $table->date('date_of_employment');
            $table->boolean('is_marital');
            $table->boolean('is_working')->default(true);
            $table->string('academic_level', 50)->nullable();
            $table->string('qualification', 50)->nullable();
            $table->string('social_insurance_number', 10)->unique();
            $table->text('avatar_url')->nullable();
            $table->longText('additional_infomation')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
