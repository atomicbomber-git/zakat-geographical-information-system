<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeNpwzFieldNullableInMuzakkis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('muzakkis', function (Blueprint $table) {
            $table->string("npwz")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('muzakkis', function (Blueprint $table) {
            $table->string("npwz")->nullable()->change();
        });
    }
}
