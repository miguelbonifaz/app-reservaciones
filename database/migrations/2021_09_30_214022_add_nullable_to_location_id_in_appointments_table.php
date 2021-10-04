<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToLocationIdInAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('location_id');
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('service_id')->constrained();
        });
    }

    public function down()
    {
    }
}
