<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFitrahBerasFieldToReceivements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivements', function (Blueprint $table) {
            $table->decimal("fitrah_beras")
                ->comment("Zakat fitrah beras dalam satuan kilogram.")
                ->nullable();
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
            $table->dropColumn("fitrah_beras");
        });
    }
}
