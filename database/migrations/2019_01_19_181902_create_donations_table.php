<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->integer('collector_id')->unsigned();
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
            $table->decimal("amount", 19, 4);
            $table->double("latitude");
            $table->double("longitude");
            $table->foreign('collector_id')->references('id')->on('collectors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
