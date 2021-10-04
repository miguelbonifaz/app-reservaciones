<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationIdInServicesTable extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
        $table->string('place')->after('description')->nullable();
        });
    }

    public function down()
    {
    }
}
