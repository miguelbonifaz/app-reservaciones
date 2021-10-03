<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationServiceTable extends Migration
{
    public function up()
    {
        Schema::create('location_service', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('service_id');
            $table->foreignId('location_id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_service');
    }
}
