<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNomorKkFieldToMustahiqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mustahiqs', function (Blueprint $table) {
            $table->string("nomor_kk")->nullable();
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
            $table->dropColumn("nomor_kk");
        });
    }
}
