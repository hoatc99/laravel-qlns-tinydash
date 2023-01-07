<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_results', function (Blueprint $table) {
            $table->id();
            $table->string('year_month', 7);
            $table->double('shop_revenue');
            $table->double('online_revenue');
            $table->float('customer_service_five_stars_percent');
            $table->integer('business_trips_count');
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
        Schema::dropIfExists('business_results');
    }
}
