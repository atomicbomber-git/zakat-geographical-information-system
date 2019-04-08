<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsFromDonations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn("name");
            $table->dropColumn("nik");
            $table->dropColumn("address");
            $table->dropColumn("kecamatan");
            $table->dropColumn("kelurahan");
            $table->dropColumn("phone");
            $table->dropColumn("gender");
            $table->dropColumn("occupation");
            $table->dropColumn("ansaf");
            $table->dropColumn("help_program");
            $table->dropColumn("latitude");
            $table->dropColumn("longitude");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string("name");
            $table->string("nik");
            $table->string("address");
            $table->string("kecamatan");
            $table->string("kelurahan");
            $table->string("phone")->nullable();
            $table->string("gender");
            $table->string("occupation");
            $table->string("ansaf");
            $table->string("help_program");
            $table->double("latitude");
            $table->double("longitude");
        });
    }
}
