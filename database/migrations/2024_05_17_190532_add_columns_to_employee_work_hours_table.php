<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEmployeeWorkHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_work_hours', function (Blueprint $table) {
            $table->string('location')->after('employee_id');
            $table->unsignedBigInteger('customer_id')->after('location');
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_work_hours', function (Blueprint $table) {
            $table->dropColumn(['location' , 'customer_id']);
        });
    }
}
