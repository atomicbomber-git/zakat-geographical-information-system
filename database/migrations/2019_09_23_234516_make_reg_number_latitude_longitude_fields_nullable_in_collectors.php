<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeRegNumberLatitudeLongitudeFieldsNullableInCollectors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collectors', function (Blueprint $table) {
            $table->float("latitude")->nullable()->change();
            $table->float("longitude")->nullable()->change();
            $table->string("reg_number")->unique()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collectors', function (Blueprint $table) {
            $table->float("latitude")->change();
            $table->float("longitude")->change();
            $table->string("reg_number")->unique()->change();
        });
    }
}
