<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMuzakkisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muzakkis', function (Blueprint $table) {
            $table->increments('id');

            $table->string("name");
            $table->string("NIK");
            $table->text("address");
            $table->string("kecamatan");
            $table->string("kelurahan");
            $table->string("phone");
            $table->string("gender");
            $table->string("npwz");
            $table->double("latitude");
            $table->double("longitude");
            $table->unsignedInteger('collector_id');
            $table->foreign('collector_id')
                ->references('id')
                ->on('collectors');

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
        Schema::dropIfExists('muzakkis');
    }
}
