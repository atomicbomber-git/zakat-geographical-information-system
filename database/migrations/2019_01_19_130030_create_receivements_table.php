<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivements', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->integer('collector_id')->unsigned();
            $table->string("name");
            $table->string("NIK");
            $table->string("kecamatan");
            $table->string("kelurahan");
            $table->string("phone");
            $table->string("gender");
            $table->string("npwz");
            $table->decimal('zakat', 19, 4);
            $table->decimal('fitrah', 19, 4);
            $table->decimal('infak', 19, 4);
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
        Schema::dropIfExists('receivements');
    }
}
