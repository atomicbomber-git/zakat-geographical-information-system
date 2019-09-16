<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('receivers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->increments('id');

            $table->string("name");
            $table->string("nik");
            $table->string("address");
            $table->string("kecamatan");
            $table->string("kelurahan");
            $table->string("phone")->nullable();
            $table->string("sex");
            $table->string("occupation");
            $table->string("asnaf");
            $table->string("help_program");
            $table->decimal("amount", 19, 4);
            $table->double("latitude");
            $table->double("longitude");

            $table->timestamps();
        });
    }
}
