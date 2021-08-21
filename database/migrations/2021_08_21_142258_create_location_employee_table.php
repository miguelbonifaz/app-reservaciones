<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationEmployeeTable extends Migration
{
    public function up()
    {
        Schema::create('location_employee', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('employee_id')->constrained();
            $table->foreignId('location_id')->constrained();

            $table->timestamps();
        });
    }

    public function down()
    {
    }
}
