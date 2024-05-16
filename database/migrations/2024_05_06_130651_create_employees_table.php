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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('alias')->comment('card name alias');
            $table->date('dob')->comment('Date Of Birth');
            $table->string('phone');
            $table->string('role')->comment('role/position');
            $table->string('account_number');
            $table->string('legitimation_type')->comment('id,passport ,etc..');
            $table->string('legitimation_number');
            $table->string('bsn');
            $table->date('valid_until');
            $table->date('contract_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('salary', 8, 2);
            $table->string('salary_payment')->comment('weekly or monthly');
            $table->string('id_file');
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
        Schema::dropIfExists('employees');
    }
}
