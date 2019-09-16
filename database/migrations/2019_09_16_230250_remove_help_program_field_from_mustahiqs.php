<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveHelpProgramFieldFromMustahiqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mustahiqs', function (Blueprint $table) {
            $table->dropColumn('help_program');
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
            $table->string('help_program');
        });
    }
}
