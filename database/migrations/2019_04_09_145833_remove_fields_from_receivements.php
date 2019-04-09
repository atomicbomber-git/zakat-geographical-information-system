<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsFromReceivements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivements', function (Blueprint $table) {
            $table->dropColumn("name");
            $table->dropColumn("NIK");
            $table->dropColumn("kecamatan");
            $table->dropColumn("kelurahan");
            $table->dropColumn("phone");
            $table->dropColumn("gender");
            $table->dropColumn("npwz");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivements', function (Blueprint $table) {
            $table->string("name");
            $table->string("NIK");
            $table->string("kecamatan");
            $table->string("kelurahan");
            $table->string("phone");
            $table->string("gender");
            $table->string("npwz");
        });
    }
}
