<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVehicleDetailFieldsToVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('bpkb_number', 100)->after('user_name');
            $table->string('chassis_number', 100)->after('bpkb_number');
            $table->string('engine_number', 100)->after('chassis_number');
            $table->integer('cc_amount')->after('engine_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['bpkb_number', 'chassis_number', 'engine_number', 'cc_amount']);
        });
    }
}