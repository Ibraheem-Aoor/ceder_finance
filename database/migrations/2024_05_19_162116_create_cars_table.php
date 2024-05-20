<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('trade_name');
            $table->string('color');
            $table->string('license_plate');
            $table->double('walked_distance' , 8 , 2);
            $table->json('extra_data')->nullable();
            $table->unique(['license_plate' , 'id']);
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('fuel_id');
            $table->foreign('brand_id')->references('id')->on('car_brands')->onDelete('cascade');
            $table->foreign('fuel_id')->references('id')->on('car_fuels')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->unsigned()->comment('Each Company Has Its\'s own Employees');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('cars');
    }
}
