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
            $table->string('email')->unique();
            $table->integer('employee_id')->unique();;
            $table->date('hiring_date');
            $table->date('end_date')->nullable();
            $table->string('CIN');
            $table->string('CIN_proof');
            $table->string('cell_1');
            $table->string('cell_2')->nullable();
            $table->longText('address');
            $table->string('contact_full_name');
            $table->string('contact_1_cell');
            $table->string('contact_1_cell2');
            $table->softDeletes();
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
