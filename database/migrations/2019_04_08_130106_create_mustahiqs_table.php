<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMustahiqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mustahiqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("nik");
            $table->string("address");
            $table->string("kecamatan");
            $table->string("kelurahan");
            $table->string("phone")->nullable();
            $table->string("gender");
            $table->string("occupation");
            $table->string("asnaf");
            $table->string("help_program");
            $table->double("latitude");
            $table->double("longitude");
            $table->unsignedInteger('collector_id');
            $table->timestamps();

            $table->foreign('collector_id')
                ->references('id')
                ->on('collectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mustahiqs');
    }
}
