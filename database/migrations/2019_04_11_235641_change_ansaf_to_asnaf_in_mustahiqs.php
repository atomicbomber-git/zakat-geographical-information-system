<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAnsafToAsnafInMustahiqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mustahiqs', function (Blueprint $table) {
            $table->renameColumn("ansaf", "asnaf");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mustahiqs', function (Blueprint $table) {
            $table->renameColumn("asnaf", "ansaf");
        });
    }
}
